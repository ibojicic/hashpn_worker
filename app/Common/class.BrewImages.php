<?php
/**
 * Created by PhpStorm.
 * User: ibojicic
 * Date: 18/2/2017
 * Time: 3:57 PM
 */

namespace HashPN\App\Common;


use HashPN\Models\MainGPN\PNMain;
use HashPN\Models\PNImages\Imagesets;
use HashPN\Models\PNImages\pngimages;
use HashPN\Models\PNImages\pngimagesinfo;
use MyPHP\MyFunctions;
use MyPHP\MyLogger;
use MyPHP\MyPythons;
use MyPHP\MyStandards;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as RV;


class BrewImages
{
    use MyStandards;
    use MyPythons;

    /**
     * @var array old results
     */
    private $_oldresults;

    /**
     * @var pngimages $_oldresultsmodel
     */
    private $_oldresultsmodel;

    /**
     * @var pngimages $_pngimages
     */
    private $_pngimages;

    /**
     * @var string $_outoptions ;
     */
    private $_outoptions = 'mto';

    /**
     * @var string $_set
     */
    private $_set;


    /**
     * @var array $_imagesets
     */
    private $_imagesets = [];


    /**
     * @var array $_outimages ;
     */
    private $_outimages = [];

    /**
     * @var array $_initoutimages ;
     */
    private $_initoutimages = [];

    /**
     * @var array $_commons
     */
    private $_commons;

    /**
     * @var MyLogger $mylogger
     */
    public $mylogger;


    /**
     * @var PNGMenu $_image
     */
    private $_image;

    /**
     * @var qObject $_qobject
     */
    private $_qobject;

    public function __construct()
    {
        $this->mylogger = new MyLogger(false);

        $this->setPngimages();
    }



    /**
     * @return string
     */
    public function getSet()
    {
        return $this->_set;
    }

    /**
     * @param $set string name of the set
     * @return $this
     */
    public function setSet($set)
    {
        $this->_set = $set;

        return $this;
    }


    /**
     * @return pngimages
     */
    public function getPngimages()
    {
        return $this->_pngimages;
    }

    /**
     */
    public function setPngimages()
    {
        $this->_pngimages = new pngimages();
    }

    /**
     * @return string
     */
    public function getOutoptions()
    {
        return $this->_outoptions;
    }

    /**
     * @param $outoptions
     * @return $this
     */
    public function setOutoptions($outoptions)
    {
        $this->_outoptions = $outoptions;

        return $this;
    }


    /**
     * @param MyLogger $myLogger
     * @return $this
     */
    public function setMyLogger(MyLogger $myLogger)
    {
        unset($this->mylogger);
        $this->mylogger = $myLogger;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->_image;
    }

    /**
     * @param PNGMenu $image
     * @return $this
     */
    public function setImage(PNGMenu $image)
    {
        $this->_image = $image;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getQobject()
    {
        return $this->_qobject;
    }

    /**
     * @param qObject $object
     * @return $this
     */
    public function setQobject(qObject $object)
    {
        $this->_qobject = $object;

        return $this;
    }

    /**
     * @return bool|float|int get cutout size for the final image
     */
    private function _getCoutoutSize()
    {
        //****************************************************/
        //** set cutout size for the current survey & object */
        $cutoutSize = $this->getCutoutSize(
            max($this->_qobject->getMajDiam(), $this->_qobject->getMajExt()),
            $this->_image->getImageParams('minimDiam')
        );
        if (!is_numeric($cutoutSize) || $cutoutSize <= 0) {
            $this->mylogger->logMessage("Cutout size of " . $cutoutSize . " arcsec is not allowed!", $this, 'error');
        }
        $this->mylogger->logMessage("Set cutout size to:" . $cutoutSize . " arcsec", $this, 'info');
        return $cutoutSize;
        //****************************************************/
    }

    /**
     * @return float|int return the smallest image size for the current object
     *if the cutout size of the current imageset > boxsize plot a box
     */
    private function _getBoxSize()
    {
        $allsurveys = pngimagesinfo::pluck('minimDiam')->toArray();
        $allsizes = [];
        foreach ($allsurveys as $minimdiam) {
            array_push($allsizes, $this->getCutoutSize(
                max($this->_qobject->getMajDiam(), $this->_qobject->getMajExt()),
                $minimdiam
            ));
        }
        $result = min($allsizes);
        if (!is_numeric($result)) {
            $this->mylogger->logMessage("Box size of " . $result . " arcsec is not allowed!", $this, 'error');
        }
        $this->mylogger->logMessage("Set box size to:" . $result . " arcsec", $this, 'info');
        return $result;
    }

    /**
     * TODO BETTER LOGIC FOR STATISTICS
     * get box size for the statistics
     * @param bool $max if true find maximum statistics box
     * @return float|int|mixed
     */
    private function _getStatBoxSize($max = false)
    {
        $diam = $this->_qobject->getMajDiam();
        $psf = $this->_image->getImageParams('psf');
        $minimDiam = $this->_image->getImageParams('minimDiam');

        if ($max) {
            $statbox = $diam < $minimDiam ? $minimDiam : $diam;
        } else {
            $statbox = $diam / 2 < 10 * $psf ? 10 * $psf : $diam / 2;
        }

        if (!is_numeric($statbox)) {
            $this->mylogger->logMessage("Statistics box size of " . $statbox . " arcsec is not allowed!", $this,
                'error');
        }
        $this->mylogger->logMessage("Set statistics box size to:" . $statbox . " arcsec.", $this, 'info');

        return $statbox;
    }

    /**
     * Set array of markers
     * @param $filebase string base for the image file names
     * @return array|bool
     */
    private function _getMarkers($filebase)
    {
        $markers = [
            'centroid' => [
                'colour' => $this->_image->getImageParams('centroid_col'),
                'filename' => $filebase . '_centroid.png'
            ]
        ];

        if ($this->_image->getImageParams('resolution') <= $this->_qobject->getMajDiam()) {
            $markers['diameter'] = [
                'colour' => $this->_image->getImageParams('centroid_col'),
                'filename' => $filebase . '_diameter.png',
                'linetype' => $this->_qobject->getFlagMajDiam() ? 'dashed' : 'solid'
            ];
        }

//        if ($this->_image->getImageParams('resolution') <= $this->_qobject->getMajDiam()) {
//            $markers['diameter'] = [
//                'colour' => $this->_image->getImageParams('centroid_col'),
//                'filename' => $filebase . '_diameter.png'
//            ];
//        }

        if ($this->_qobject->getCS_DRAJ2000() != null && $this->_qobject->getCS_DDECJ2000() != null) {
            $markers['CS_pos'] = [
                'colour' => $this->_image->getImageParams('CS_pos_col'),
                'filename' => $filebase . '_CS_pos.png'
            ];

        }

        $this->mylogger->logMessage("Set markers to:" . json_encode($markers), $this, 'info');

        return $markers;

    }

    /**
     * get image levels for a given colour (R,G,B)
     * @param $colour string (from R,G,B)
     * @return array|bool false on error
     */
    private function _getLevels($colour)
    {
        $pngset = $this->_image->getImageParameters();

        $survey = Imagesets::where('set', $pngset->{$colour . "_srv"})->first();

        if (!$survey || $survey == null) {
            return false;
        }

        $levels = [
            'imlev' => $this->_nullOnError($pngset, 'imlev'),
            'r' => [
                'min' => $this->_nullOnError($pngset, "min_" . strtolower($colour) . "_imLevel"),
                'max' => $this->_nullOnError($pngset, strtolower($colour) . "_imLevel")
            ],
            'v' => [
                'min' => $this->_nullOnError($survey, "minval"),
                'max' => $this->_nullOnError($survey, "maxval")
            ]
        ];

        $this->mylogger->logMessage("Set image levels to:" . json_encode($levels), $this, 'info');

        return $levels;

    }

    /**
     * Return value for $object->$property
     * @param $object mixed
     * @param $property string
     * @return mixed
     */
    private function _nullOnError($object, $property)
    {
        if ($object == null || !is_object($object) || !isset($object->{$property})) {
            return null;
        }
        return $object->{$property};
    }

    /**
     * Options for creating main image (m), thumbnail image (t) and overlay (o)
     * @param $filebase
     * @return array in the form ['option' => 'y' ot 'n',...]
     */
    private function _setOutimages($filebase)
    {
        if (trim($filebase) == "") {
            $this->mylogger->logMessage("Empty file base?", $this, 'error');
        }

        $vals = str_split($this->getOutoptions());

        foreach ($vals as $val) {
            switch ($val) {
                case 'm':
                    $this->_outimages['main'] = [
                        'filename' => $filebase . '.png'
                    ];
                    break;
                case 't':
                    $this->_outimages['thumb'] = [
                        'filename' => $filebase . '_thumb.jpg'
                    ];
                    break;
                case 'o':
                    $this->_outimages = array_merge($this->_outimages, $this->_getMarkers($filebase));
                    break;
                case 'f':
                    $this->_outimages['fchart'] = [
                        'filename' => $filebase . '_fchart.png'
                    ];
                    break;
            }
        }

        $tmpoutimages = $this->_outimages;

        foreach ($tmpoutimages as $key => $val) {
            if (is_file($val['filename'])) {
                unset($this->_outimages[$key]);
                $this->_initoutimages[$key] = $val['filename'];
            }
        }

        return $this->_outimages;

    }

    /**
     * @return array
     */
    public function getOutimages()
    {
        return $this->_outimages;
    }


    /**
     * @return array
     */
    public function getInitOutimages()
    {
        return $this->_initoutimages;
    }


    /**
     * @return array
     */
    public function getImagesets()
    {
        return $this->_imagesets;
    }


    /**
     * set values for $this->_imagesets
     * to:
     * [ 'run_id' =>
     *    ['type' => 'rgb/int',
     *     'run_id' => 'run_id',
     *     'OutImage' => name of the out image file,
     *     'rgb_cube' => name of the rgb image file,
     *     'colour (RGB)' =>
     *         ['inimage' => full path to the colour image
     *          'levels' =>
     *             ['imlev' => 'v/r',
     *              'v' => ['min' => minimum level, 'max' => maximum level],
     *              'r' => ['min' => minimum level, 'max' => maximum level]
     *  .
     *  .
     *  . ]
     */
    public function setImagesets()
    {
        $this->_imagesets = [];
        try {
            $pnmain = $this->_qobject->getPNMainTable();
            $type = $this->_image->getImageParams('type');
            if ($type == 'rgb') {
                $model = $this->_image->getImageParams('R_model');
            } else {
                $model = $this->_image->getImageParams('in_model');
            }

            if (!$model || $model == null) {
                return $this->mylogger->logMessage("Model for the parameter 'run_id' is not defined.", $this, 'warning',
                    false);
            }
            $runs = $pnmain->{$model}()
                ->where('found', 'y')
                ->distinct('run_id')
                ->pluck('run_id')
                ->toArray();

            if (!$runs || $runs == null || empty($runs)) {
                return $this->mylogger->logMessage("No results.", $this, 'warning', false);
            }

//            $old_base_file_names = array_column($this->_oldresults, 'OutImage');

            foreach ($runs as $run_id) {
                $run_id = ($run_id == null || !$run_id) ? "-1" : $run_id;

                $base_file_name = $this->pngName($this->_qobject->getIdPNMain(),
                    $this->_image->getImageParams('name_out'), $run_id);

                $full_file_name = MyFunctions::pathslash($this->_getOutDir()) . $base_file_name;

                $outimages = $this->_setOutimages($full_file_name);
                if (empty($outimages)) {
                    continue;
                }

                $metadata = [
                    'type' => $type,
                    'run_id' => $run_id,
                    'OutImage' => $base_file_name,
                    "rgb_cube" => ($type == 'rgb') ? $this->getRGBcubeName($this->_qobject->getIdPNMain(),
                        $this->_image->getImageParams('name_out'),
                        $run_id) : null,
                    "out_images" => $outimages,
                ];


//                if (in_array($base_file_name, $old_base_file_names)) {
//                    continue;
//                }

                $rgb_components = $this->_getRGBComponents($pnmain, $run_id);

                if ($rgb_components) {
                    $this->_imagesets[$run_id] = array_merge($metadata, $rgb_components);
                } else {
                    $this->mylogger->logMessage("Missing fits image(s).", $this, 'warning', false);
                }
            }
        } catch (\Exception $e) {
            $this->_imagesets = [];
            return $this->mylogger->logMessage("Problem with setting imagesets: " . $e . ".", $this, 'warning', false);
        }
        if (empty($this->_imagesets)) {
            return false;
        }
        return true;

    }


    /**
     * @param PNMain $pnmain model
     * @param bool|string $run_id identifier
     * @return array|bool
     */
    private function _getRGBComponents(PNMain $pnmain, $run_id = false)
    {
        $components = [];
        foreach ($this->_image->getColours() as $colour) {
            $inimage = $this->_getColourFits($pnmain, $colour, $run_id);
            $levels = $this->_getLevels($colour);
            if (!$inimage || !$levels) {
                return false;
            }
            $components[$colour] = [
                'inimage' => $inimage['full'],
                'colour' => $inimage['colour'],
                'levels' => $levels
            ];
        }

        return $components;
    }


    /**
     * @param $pnmain PNMain
     * @param $colour string (RGB)
     * @param $run_id string run indentifier
     * @return bool|string filename of false on fail
     */
    private function _getColourFits(PNMain $pnmain, $colour, $run_id)
    {
        $set = $this->_image->getImageParams($colour . "_srv");
        /**
         * @var PNMain $basic_model
         */
        $basic_model = $pnmain->{$this->_image->getImageParams($colour . "_model")}();

        if ($basic_model == null) {
            return false;
        }

        /**
         * @var PNMain $basic_band
         */
        $basic_band = $basic_model->where('band', $this->_image->getImageParams($colour . "_band"));

        if ($basic_band == null) {
            return false;
        }
        if ($run_id != null && $run_id != '-1') {
            $basic_band = $basic_band->where('run_id', $run_id);
        }
        $basic_image = $basic_band->where('found', 'y')
            ->pluck('filename')
            ->first();

        if ($basic_image == null) {
            return false;
        }
        $basic_folder = Imagesets::where('set', $set)->pluck('folder')->first();
        $colour_image = sprintf("%s/%s", $basic_folder, $basic_image);
        $fits_image = $this->getFullPathFITS($this->_qobject->getIdPNMain(), $basic_folder, $basic_image);
        if (!is_file($fits_image)) {
            return false;
        }
        $result = ['full' => $fits_image, 'colour' => $colour_image];
        return $result;
    }

    /**
     * @return string path of the out folder for the png images
     */
    private function _getOutDir()
    {
        return $this->getOutDirPNG($this->_qobject->getIdPNMain(), $this->_image->getImageParams('outDir'), true);
    }


    public function setRecipes()
    {
        if (!$this->_imagesets || empty($this->_imagesets)) {
            return $this->mylogger->logMessage("Imagesets are empty.", $this, 'warning', false);
        }

        $this->_commons = [
            "idPNMain" => $this->_qobject->getIdPNMain(),
            "Set" => $this->getSet(),
            "DRAJ2000" => $this->_qobject->getPNMainTable()->DRAJ2000,
            "DDECJ2000" => $this->_qobject->getPNMainTable()->DDECJ2000,
            "CS_DRAJ2000" => $this->_qobject->getCS_DRAJ2000(),
            "CS_DDECJ2000" => $this->_qobject->getCS_DDECJ2000(),
            "MajDiam" => $this->_qobject->getMajDiam(),
            "MinDiam" => $this->_qobject->getMinDiam(),
            "PA" => $this->_qobject->getPAdiam(),
            "TEMP_DIR" => $this->getTempDir("/tmp/", "brewer", true, true),
            "OUT_DIR" => $this->_getOutDir(),
            "RGB_CUBE_DIR" => MyFunctions::pathslash(RGB_CUBES),
            "ImageSize" => $this->_getCoutoutSize(),
            "BoxSize" => $this->_getBoxSize(),
            "statbox" => $this->_getStatBoxSize(),
            "maxstatbox" => $this->_getStatBoxSize(true),
            "DrawBeam" => $this->_image->getImageParams('drawbeam'),
            "extracomm" => null, // extra command fror FITScutout
            "setaxlabsize" => 'x-small',
            "redorgb" => "y",
            "type" => $this->_image->getImageParams('type'),
            "colours" => $this->_image->getColours(),
        ];

        $full_recipe = array_merge($this->_commons, ['imagesets' => $this->_imagesets]);
        //dd($full_recipe);

        $validate = $this->_validateRecipe($full_recipe);
        //dd($validate);

        if (!empty($validate)) {
            return $this->mylogger->logMessage("Problem with recipe:" . json_encode($validate), $this,
                'warning', false);
        }

        return $full_recipe;
    }

    /**
     * run brewery
     * @param $full_recipe array of parameters
     * @return array of results from the python script
     */
    public function brew($full_recipe)
    {
        $this->mylogger->logMessage("Start brewing....", $this,'info');
        $python_filler = MyFunctions::pathslash(PY_DRIVER_DIR) . "make_rgbs_driver.py";
        $results = $this->PythonToPhp($python_filler, $full_recipe, 'local', true);
        $this->mylogger->logMessage("...finished brewing.", $this,'info');
        return $results;
    }

    /**
     * validate input parameters for the brewery
     * @param $recipe array of parameters
     * @return array of errors [] if no everything ok
     */
    private function _validateRecipe($recipe)
    {
        $validation_results = [];

        /*******************************/
        //** validate required fields */
        try {
            //** must haves */
            RV::key('idPNMain', RV::intType())->assert($recipe);
            RV::key('DRAJ2000', RV::floatVal())->assert($recipe);
            RV::key('DDECJ2000', RV::floatVal())->assert($recipe);
            RV::key('ImageSize', RV::floatVal())->assert($recipe);
            RV::key('statbox', RV::floatVal())->assert($recipe);
            RV::key('maxstatbox', RV::floatVal())->assert($recipe);
            RV::key('BoxSize', RV::floatVal())->assert($recipe);
            RV::key('OUT_DIR', RV::directory())->assert($recipe);
            RV::key('RGB_CUBE_DIR', RV::directory())->assert($recipe);
            RV::key('TEMP_DIR', RV::directory())->assert($recipe);

            //** optional */
            RV::key('CS_DRAJ2000', RV::optional(RV::floatVal()), false)->assert($recipe);
            RV::key('CS_DDECJ2000', RV::optional(RV::floatVal()), false)->assert($recipe);
            RV::key('MajDiam', RV::optional(RV::floatVal()), false)->assert($recipe);
            RV::key('MinDiam', RV::optional(RV::floatVal()), false)->assert($recipe);
            RV::key('PA', RV::optional(RV::floatVal()), false)->assert($recipe);

            RV::key('DrawBeam', RV::in(['y', 'n']), false)->assert($recipe);
            RV::key('redorgb', RV::in(['y', 'n']), false)->assert($recipe);

            RV::key('setaxlabsize', RV::in(['x-small']), false)->assert($recipe);

            foreach ($recipe['imagesets'] as $run_id => $imagesets) {
                RV::key('type', RV::in(['rgb', 'intensity']))->assert($imagesets);
                RV::key('run_id')->assert($imagesets);
                RV::key('out_images', RV::arrayType())->assert($imagesets);
                //RV::key('rgb_cube',RV::stringType(), false)->assert($imagesets);

                foreach ($imagesets['out_images'] as $type => $out_images) {
                    RV::in(['main', 'thumb', 'centroid', 'diameter', 'CS_pos', 'limdiam', 'fchart'])->assert($type);
                    RV::key('filename', RV::notEmpty())->assert($out_images);
                }

                foreach ($this->_image->getColours() as $colour) {
                    RV::keySet(
                        RV::key('inimage', RV::file()),
                        RV::key('colour', RV::notEmpty()),
                        RV::key('levels', RV::keySet(
                            RV::key('imlev', RV::in(['v', 'r'])),
                            RV::key('r', RV::keySet(
                                RV::key('min', RV::floatVal()),
                                RV::key('max', RV::floatVal())
                            )),
                            RV::key('v', RV::keySet(
                                RV::key('min', RV::floatVal()),
                                RV::key('max', RV::floatVal())
                            )
                            )
                        )
                        )
                    )->assert($imagesets[$colour]);
                }
            }
        } catch (NestedValidationException $exception) {
            array_push($validation_results, $exception->getMessages());
        }
        /*******************************/

        return $validation_results;
    }

    /**
     * prepare (flatten) results for the input to the db
     * @return array 1d of parameters
     */
    public function prepareResults()
    {
        $final_imageset = $this->_imagesets;
        foreach ($this->_imagesets as $run_id => $imageset) {
            if (!$this->_validateOutFiles($imageset['out_images'])) {
                unset($final_imageset[$run_id]);
                break;
            }
            $final_imageset[$run_id]['recordtodb'] = isset($imageset['out_images']['main']);
//            unset ($final_imageset[$run_id]['out_images']);
            foreach ($this->_image->getColours() as $colour) {
                $tmp_colour = $imageset[$colour];
                $final_imageset[$run_id][$colour] = $tmp_colour['colour'];
                $final_imageset[$run_id]['imlev'] = $tmp_colour['levels']['imlev'];
                foreach (['r', 'v'] as $levtype) {
                    foreach (['min', 'max'] as $minmax) {
                        $minkey = sprintf("%s%s_%s", $minmax, $colour, $levtype);
                        $final_imageset[$run_id][$minkey] = $tmp_colour['levels'][$levtype][$minmax];
                    }
                }
            }
            $final_imageset[$run_id] = array_merge($final_imageset[$run_id], $this->_commons);
        }
        return $final_imageset;
    }

    /**
     * check if out files exists, if not log the error messages
     * @param $out_images array
     * @return bool always true
     */
    private function _validateOutFiles($out_images)
    {
        $validation_results = [];
        try {
            foreach ($out_images as $type => $data) {
                RV::file()->assert($data['filename']);
            }
        } catch (NestedValidationException $exception) {
            array_push($validation_results, $exception->getMessages());
        }
        if (!empty($validation_results)) {
            return $this->mylogger->logMessage("Problem with additional images :" . json_encode($validation_results),
                $this, 'warning', true);
        }
        return true;
    }


    /**
     * Record imaged results to the database (images have been checked already)
     * @param $results
     * @return mixed
     */
    public function recImagingResultsToDB($results)
    {
        $created = [];
        //** No results */
        if (empty($results)) {
            return $this->mylogger->logMessage('Empty inputs', $this, 'critical', []);
        }

        foreach ($results as $run_id => $result) {
            if ($result['recordtodb']) {
                $founddata = array_intersect_key($result, array_flip($this->_pngimages->getFillable()));
                $inserted = $this->_pngimages
                    ->create($founddata);
                $created[$run_id] = $result['out_images'];
            }
        }
        return $created;
    }

    /**
     * Delete old files and db entries
     * @param $results array from the brewery (prepared for the db input)
     * @return number of deleted objects
     */
    public function deleteOldResults($results = [])
    {
        $options = str_split($this->_outoptions);
        $todelete = [
            'm' => ['.png'],
            't' => ['_thumb.jpg'],
            'o' => ['_centroid.png', '_diameter.png', '_CS_pos.png'],
            'f' => ['_fchart.png']
        ];

        $newimages = array_column($results, 'OutImage');
        //** TEMPORARY SOLUTION USE ALL POSSIBLE EXTENSION*/
        $oldFiles = $this->getOldresultsmodel()
                ->whereNotIn('OutImage', $newimages)
                ->get(['OUT_DIR', 'OutImage'])
                ->toArray();
        //** if no old file return 0 (0 deleted) */
        if (empty($oldFiles)) {
            return 0;
        }

        $this->mylogger->logMessage("Deleting old files....", $this, 'info');
        //** delete old files */
        foreach ($oldFiles as $file) {
            foreach ($options as $opt) {
                foreach ($todelete[$opt] as $ext) {
                    $file_path = MyFunctions::pathslash($file['OUT_DIR']) . $file['OutImage'] . $ext;
                    if (trim($file['OutImage']) != "" && trim($file['OutImage']) != "*" && is_file($file_path)) {
                        unlink($file_path);
                    }
                }
            }
        }

        $this->mylogger->logMessage("Deleting old db entries....", $this, 'info');
        //** delete old results from the db */
        if (in_array("m",$options)) {
            $noDeleted = $this->getOldresultsmodel()
                ->whereNotIn('OutImage', $newimages)
                ->delete();
        } else $noDeleted = 0;

        return $noDeleted;
    }

    /**
     * set model for old results
     * @return $this
     */
    public function setOldresultsmodel()
    {
        $this->_oldresultsmodel = $this->_pngimages
            ->where('idPNMain', $this->_qobject->getIdPNMain())
            ->where('Set', $this->_set);

        return $this;
    }

    /**
     * @return pngimages
     */
    public function getOldresultsmodel()
    {
        return $this->_oldresultsmodel;
    }

    /**
     * set old results for comparison
     * @return BrewImages
     */
    public function setOldresults()
    {
        $this->_oldresults = $this->_oldresultsmodel
            ->get()
            ->toArray();

        return $this;
    }

    /**
     * @return array
     */
    public function getOldresults()
    {
        return $this->_oldresults;
    }


    //** TODO CHECK THIS!!!! */
//    private function _checkextracomm() {
//        switch ($this->_set) {
//            case "msxACE":
//            case "msxACD":
//            case "msxADE":
//            case "msxCDE":
//                $this->_extracomm = "msxcheckoffset";
//                break;
//        }
//    }


}