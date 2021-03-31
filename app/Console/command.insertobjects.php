<?php
/**
 * Created by PhpStorm.
 * User: ibojicic
 * Date: 8/1/2017
 * Time: 4:34 PM
 */
namespace HashPN\App\Console;

use HashPN\Models\MainGPN\objStatus;
use HashPN\Models\MainGPN\PNMain;
use HashPN\Models\MainGPN\ReferenceIDs;
use Illuminate\Support\Facades\Schema;
use MyPHP\MyArrays;
use MyPHP\MyAstroStuff;
use MyPHP\MyConfig;
use MyPHP\MyFunctions;
use MyPHP\MyLogger;
use MyPHP\MyPythons;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class insertobjects extends Command
{

    use MyPythons;

    public $mylogger;
    public $config;
    public $name;
    private $_required_fields;
    private $_test_errors = [];
    private $_user_items;
    private $_duplicates_check;
    private $_exclude_rad = false;

    public function __construct($name = null)
    {
        parent::__construct($name);
    }

    public function configure()
    {
        $this->setName('insertobjects')
            ->setDescription('Inserts a set of objects into HASH PN database from a file')
            ->addArgument('filename', InputArgument::REQUIRED,
                "Full path to the file with the data to be inserted.")
            ->addOption("exclude", "e", InputArgument::OPTIONAL,
                "Automatically exclude possible duplicates within range (arcsec).", 30);

    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->config = new MyConfig();
        $this->config->setLogFile(MyFunctions::getMethod($this));
        $this->mylogger = new MyLogger($this->config->getLogfile());
        $this->_setRequiredFields();

        if ($input->getOption("exclude") !== null) {
            $this->_exclude_rad = floatval($input->getOption("exclude"));
        }
        /*******************************/
        //** set styling objects */
        $io = new SymfonyStyle($input, $output);
        $io->title("Start.....");
        /*******************************/

        /*******************************/
        /** set table for output */
        $table = new Table($output);
        /*******************************/

        /*******************************/
        //** set mylogger */
        $symlogger = new ConsoleLogger($output);
        $this->mylogger->setSymlogger($symlogger);
        /*******************************/

        /*******************************/
        //** check and parse file */
        $parsedFile = MyArrays::parseCSVFile($input->getArgument('filename'), ",", 0);
        if (empty($parsedFile)) {
            die("No parsable objects in the " . $input->getArgument('filename') . ".");
        }
        /*******************************/

        /*******************************/
        //** check and parse headers  */
        $headers = array_keys($parsedFile[0]);
        $missing_headers = MyArrays::validateFields(array_flip($headers), array_keys($this->_required_fields));
        if (!empty($missing_headers['missing'])) {
            $io->error("Columns in header: " . implode(",", $missing_headers['missing']) . " are required.");
            exit();
        }
        $io->title("Parsing headers....ok.");
        /*******************************/

        /********************************/
        /** Testing and reformat inputs */
        $io->title("Start testing inputs.....");
        $references = new ReferenceIDs();
        $finalInputArray = [];
        $unique_ids = [];
        $row = 0;
        $io->progressStart(count($parsedFile));
        foreach ($parsedFile as $key => $item) {
            $row++;
            /*******************************/
            //** check missing columns */
            $check_columns = MyArrays::validateFields($item, array_keys($this->_required_fields));
            if (!$check_columns) {
                $io->error("Missing columns in the row: $row. Columns:" . implode(",",
                        $check_columns['missing']) . " are required.");
                exit();
            }
            /*******************************/

            /*******************************/
            //** unset extra key from the parsed array */
            foreach ($check_columns['extra'] as $extrakey) {
                unset ($item[$extrakey]);
            }
            /*******************************/

            /*******************************/
            //** test array fields, it will die on error */
            $this->_testFields($item, $row, $references,$unique_ids);
            /*******************************/

            /*******************************/
            //** test coords fields and return type of coords*/
            $coordFields = $this->_testCoords($item, $row);
            /*******************************/

            /*******************************/
            //** change coordfields to the required type */
            $item[$coordFields[0]] = $item['CoordX'];
            unset($item['CoordX']);
            $item[$coordFields[1]] = $item['CoordY'];
            unset($item['CoordY']);
            /*******************************/

            /*******************************/
            //** add other extra fields */
            $item = array_merge($item, $this->_user_items);
            array_push($finalInputArray, $item);
            /*******************************/
            $io->progressAdvance();
        }
        $io->progressFinish();
        /*******************************/
        //** if collected any errors in the file, display and stop*/
        if (!empty($this->_test_errors)) {
            foreach ($this->_test_errors as $error) {
                $io->error($error);
            }
            $io->warning("Please Fix All Errors Before Continuing.");
            exit();
        }
        /*******************************/

        $io->title("Finshed testing, all ok.....");


        //** add missing coords fields */
        $io->title("Start adding missing coordinates.....");
        $this->_addMissingCoords($finalInputArray, $io);

        //** calculate and add PNGs */
        $io->title("Start adding PNGs.....");
        $this->_setPNGs($finalInputArray);


        /*******************************/
        //** set and check possible duplicates agains PNMain table*/
        $io->title("Start checking duplicates with PNMain db.....");
        $this->_checkDuplicates($finalInputArray, $io, $table, 'main');
        /*******************************/

        /*******************************/
        //** set and check possible duplicates against itself */
        $io->title("Start checking duplicates with itself.....");
        $this->_checkDuplicates($finalInputArray, $io, $table, 'self');
        /*******************************/

        /*******************************/
        //** input results into database */
        $confirm_insert = $io->confirm("You are about to insert new " . count($finalInputArray) . " objects into the databse. Do you want to continue?",
            false);
        if (!$confirm_insert) {
            $io->title("Exiting without changes. Bye, bye....");
            exit();
        }

        $new_results = [['unique_id','idPNMain']];
        $io->title("Start inserting new objects into database.....");
        $PNMain = new PNMain();
        $io->progressStart(count($finalInputArray));
        foreach ($finalInputArray as $item) {
            $io->progressAdvance();
            $results = array_intersect_key($item, array_flip($PNMain->getFillable()));
            $ids = $PNMain->create($results);

            $new_id = $ids->idPNMain;

            if ($new_id && $new_id != null) {
                array_push($new_results,[$item['unique_id'],$new_id]);
            }
        }

        $ids_file = "ids_file_" . MyFunctions::genRandomString(5) . ".csv";
        $fp = fopen($ids_file,"w");
        foreach ($new_results as $result) {
            fwrite($fp,implode(",",$result) . "\n");
        }
        fclose($fp);

        $io->newLine();
        $io->title("CSV file with unique_id,idPNMain is created at:".$ids_file);

        $io->progressFinish();
        /*******************************/

        $io->newLine();
        $io->title("Finished inserting new objects into database.....");

        $io->newLine();
        $io->title("Bye, bye....");


    }

    /**
     * set internal variables
     * @return bool true if all ok
     */
    private function _setRequiredFields()
    {
        $objStatus = new objStatus();

        //** set required fields array to be checked against input array */
        $this->_required_fields = [
            'unique_id' => false,
            'CoordX' => false,
            'CoordY' => false,
            'CoordType' => ['fk4', 'fk5', 'gal'],
            'refCoord' => false,
            'Catalogue' => false,
            'domain' => ['Galaxy', 'LMC', 'SMC', 'Other'],
            'PNstat' => $objStatus->pluck('statusId')->toArray(),
            'show' => ['y', 'n']
        ];

        //** set references to the current user */
        //$user = trim(shell_exec('whoami'));
        $user = 'ivan';
        $this->_user_items = [
            'idPNMain' => 'na',
            'refCatalogue' => $user,
            'userRecord' => $user,
            'refDomain' => $user,
            'refPNstat' => $user
        ];

        //** set parameters for duplicates checking */
        $this->_duplicates_check = [
            'main' => [
                'columns' => ['col1' => 'original', 'col2' => 'new'],
                'options' => [
                    'n' => 'exclude new object',
                    'i' => 'ignore',
                    'h' => 'help',
                    'q' => 'quit'

                ]
            ],
            'self' => [
                'columns' => ['col1' => 'object_1', 'col2' => 'object_2'],
                'options' => [
                    'b' => 'exclude both objects',
                    '1' => 'exclude only object 1',
                    '2' => 'exclude only object 2',
                    'i' => 'ignore',
                    'h' => 'help',
                    'q' => 'quit'

                ]
            ]
        ];
        unset ($objStatus);
        return true;
    }

    /**
     * add missing coordinate columns
     * @param $finalInputArray array
     */
    private function _addMissingCoords(&$finalInputArray, SymfonyStyle $io)
    {
        $fullCoords = [
            'hmsdms' => ['x' => 'RAJ2000', 'y' => 'DECJ2000'],
            'radec' => ['x' => 'DRAJ2000', 'y' => 'DDECJ2000'],
            'gal' => ['x' => 'Glon', 'y' => 'Glat']
        ];
        $xcoord = 0;
        $ycoord = 0;
        $from = "dummy";
        $toCoordsParser = [];
        foreach ($finalInputArray as $key => $item) {
            $to = [];
            foreach ($fullCoords as $func => $coordset) {
                if (isset($item[$coordset['x']]) && isset($item[$coordset['y']])) {
                    $xcoord = $item[$coordset['x']];
                    $ycoord = $item[$coordset['y']];
                    $from = $func;
                } else {
                    array_push($to, $func);
                }
            }
            //TODO CHECK IF DEFINED
            foreach ($to as $tofunc) {
                array_push($toCoordsParser,
                    [
                        'id' => $key,
                        'X_val_in' => $xcoord,
                        'Y_val_in' => $ycoord,
                        'func' => $from . "2" . $tofunc,
                        'frame_in' => 'fk5',
                        'frame_out' => 'fk5',
                        'X_name_out' => $fullCoords[$tofunc]['x'],
                        'Y_name_out' => $fullCoords[$tofunc]['y'],
                    ]);
            }
        }

        $python_coords = MyFunctions::pathslash(PY_DRIVER_DIR) . "coord_transfer_driver.py";

        $io->note("Sending coordinates to python....");
        $results = $this->PythonToPhp($python_coords, $toCoordsParser, 'local', true);
        $io->note("Python: Done....");

        foreach ($results as $item) {
            foreach ($item as $key => $add) {
                $finalInputArray[$key] = array_merge($finalInputArray[$key], $add);
            }
        }

    }

    /**
     * @param $coordX string|float coordinate X (RA,dRA,Glon)
     * @param $coordY string"float coordinate Y (DEC, dDEC,Glat)
     * @param $type string type of coordinates (fk4,fk5,gal)
     * @return array|bool if ok returns the type of coords (e.g. ['RAJ2000','DECJ2000'])
     */
    private function _validateCoords($coordX, $coordY, $type)
    {
        switch ($type) {
            case 'fk4':
            case 'fk5':
                $testRA = MyAstroStuff::regex_coord($coordX, 'ra', 'only');
                $testDEC = MyAstroStuff::regex_coord($coordY, 'dec', 'only');
                if ($testRA && $testDEC) {
                    return [array_keys($testRA)[0], array_keys($testDEC)[0]];
                }
                break;
            case 'gal':
                $testGlon = MyAstroStuff::regex_coord($coordX, 'glon', 'only');
                $testGlat = MyAstroStuff::regex_coord($coordY, 'glat', 'only');
                if ($testGlon && $testGlat) {
                    return [array_keys($testGlon)[0], array_keys($testGlat)[0]];
                }
                break;
        }
        return false;

    }

    /**
     * @param $field_array array object data
     * @param $row integer row number
     * @return array|bool returns array of coords types (e.g. ['RAJ2000','DECJ2000']) or false on error
     */
    private function _testCoords($field_array, $row)
    {
        if (!in_array($field_array['CoordType'], $this->_required_fields['CoordType'])) {
            array_push($this->_test_errors,
                "Problem with 'CoordType' value:" . $field_array['CoordType'] . " in the row:" . $row . ".\n");
        } else { //do not check coordinates if there is an error in coordtype
            $valcoords = $this->_validateCoords($field_array['CoordX'], $field_array['CoordY'],
                $field_array['CoordType']);
            if (!$valcoords) {
                array_push($this->_test_errors,
                    "Problem with 'Coordinate(s)' value:" . $field_array['CoordX'] . "," . $field_array['CoordY'] . " in the row:" . $row . ".\n");
            } else {
                return $valcoords;
            }
        }
        return false;
    }

    /**
     * Validate fields, dies on error
     * @param $field_array array object data
     * @param $row integer row number
     * @param $references ReferenceIDs model for checking references
     */
    private function _testFields($field_array, $row, $references, &$unique_ids)
    {
        if (!in_array($field_array['domain'], $this->_required_fields['domain'])) {
            array_push($this->_test_errors,
                "Problem with 'domain' value:" . $field_array['domain'] . " in the row:" . $row . ".\n");
        }

        if (isset($field_array['show'])) {
            if (!in_array($field_array['show'], $this->_required_fields['show'])) {
                array_push($this->_test_errors,
                    "Problem with 'show' value:" . $field_array['show'] . " in the row:" . $row . ".\n");
            }
        }

        if (!in_array($field_array['PNstat'], $this->_required_fields['PNstat'])) {
            array_push($this->_test_errors,
                "Problem with 'PNstat' value:" . $field_array['PNstat'] . " in the row:" . $row . ".\n");
        }

        if (in_array($field_array['unique_id'],$unique_ids)) {
            array_push($this->_test_errors,
                "Problem with 'id' value:" . $field_array['id'] . " in the row:" . $row . ". It is not unique!\n");
        } else {
            array_push($unique_ids,$field_array['unique_id']);
        }

        if ($references->where('Identifier', $field_array['refCoord'])->count() != 1) {
            array_push($this->_test_errors,
                "Problem with 'refCoord' value:" . $field_array['refCoord'] . " in the row:" . $row . ".\n");
        }

        if ($references->where('Identifier', $field_array['Catalogue'])->count() != 1) {
            array_push($this->_test_errors,
                "Problem with 'Catalogue' value:" . $field_array['Catalogue'] . " in the row:" . $row . ".\n");
        }

    }


    /**
     * calculates PNGs and append 'PNG' field to each object
     * @param $finalInputArray array full array of objects, it must containg Glon and Glat columns
     */
    private function _setPNGs(&$finalInputArray)
    {
        $PNMain = new PNMain();
        $tmpParsedFile = $finalInputArray;
        foreach ($tmpParsedFile as $key => $item) {
            $newPNG = MyAstroStuff::calcPNG($item['Glon'], $item['Glat']);
            $testPNG = $PNMain->where('PNG', 'like', $newPNG . '%')->pluck('PNG')->toArray();
            if (!empty($testPNG)) {
                $newPNG = MyAstroStuff::calcPNG($item['Glon'], $item['Glat'], $testPNG);
            }
            $finalInputArray[$key]['PNG'] = $newPNG;
            $finalInputArray[$key]['refPNG'] = 'sys';
        }
        unset ($PNMain);
    }

    /**
     * find nearby objects in the PNMain table
     * @param $finalInputArray array of objects
     * @param $radius float radius in arcsec
     * @return array or possible duplicates
     */
    private function _findNearbyObjects($finalInputArray, $radius)
    {
        $duplicates = [];

        $PNMain = new PNMain();

        foreach ($finalInputArray as $key => $item) {

            $originals = $PNMain->nearbyObject($item['DRAJ2000'], $item['DDECJ2000'], $radius / 3600, 1);

            if (empty($originals)) {
                continue;
            }
            $db_object = array_intersect_key($originals[0], $item);
            $new_object = array_intersect_key($item, $originals[0]);

            ksort($db_object);
            ksort($new_object);

            if (!empty($originals)) {
                $duplicates[$key] = [
                    'original' => $db_object,
                    'new' => $new_object,
                    'distance' => $originals[0]['_r']
                ];
            }

        }
        unset($PNMain);
        return $duplicates;
    }

    /**
     * find nearby objects within input array
     * @param $finalInputArray array of objects
     * @param $radius float in arcsec
     * @return array of duplicates
     */
    private function _findPossDuplicates($finalInputArray, $radius)
    {
        $checked = [];
        $self_duplicates = [];
        foreach ($finalInputArray as $key_1 => $item_1) {
            array_push($checked, $key_1);
            foreach ($finalInputArray as $key_2 => $item_2) {
                if (!in_array($key_2, $checked)) {
                    $distance = round(3600 *
                        rad2deg(acos(sin(deg2rad($item_1['DDECJ2000'])) *
                            sin(deg2rad($item_2['DDECJ2000'])) + cos(deg2rad($item_2['DDECJ2000'])) *
                            cos(deg2rad($item_1['DDECJ2000'])) *
                            cos(deg2rad($item_1['DRAJ2000'] - $item_2['DRAJ2000'])))));

                    if ($distance < $radius) {
                        array_push($self_duplicates,
                            [
                                'object_1' => array_merge($item_1, ['id' => $key_1]),
                                'object_2' => array_merge($item_2, ['id' => $key_2]),
                                'distance' => $distance
                            ]
                        );
                    }
                }
            }
        }
        return $self_duplicates;
    }

    /**
     * @param $finalInputArray array of input objects
     * @param SymfonyStyle $io
     * @param Table $table
     * @param $type string of checking select between 'main' (compare with PNMain table) and 'self' (compare with self)
     * @return bool
     */
    private function _checkDuplicates(&$finalInputArray, SymfonyStyle $io, Table $table, $type)
    {
        $checks = $this->_duplicates_check[$type];

        //** exctracts col1 and col2 variables */
        $col1 = 0;
        $col2 = 0;
        extract($checks['columns']);

        $db_duplicates = [];

        if ($type == 'main') {
            $db_duplicates = $this->_findNearbyObjects($finalInputArray, 120);
        } elseif ($type == 'self') {
            $db_duplicates = $this->_findPossDuplicates($finalInputArray, 120);
        } else {
            die('Error in type. It must be self or main.');
        }

        if (empty($db_duplicates)) {
            $io->note("No duplicates.");
            return true;
        }
        $keys_array = array_combine(array_keys(array_values($db_duplicates)[0][$col1]),
            array_keys(array_values($db_duplicates)[0][$col1]));

        $excluded = [];

        foreach ($db_duplicates as $key => $item) {

            $io->title("Pair $key " . " distance: " . $item['distance'] . " arcsec");


            if ($type == 'main') {
                if (in_array($key, $excluded)) {
                    continue;
                }
            } elseif ($type == 'self') {
                if (in_array($item['object_1']['id'], $excluded) || in_array($item['object_2']['id'], $excluded)) {
                    continue;
                }
            }

            $printout = array_merge_recursive($keys_array, $item[$col1], $item[$col2]);
            $table
                ->setHeaders(['field', $col1, $col2])
                ->setRows($printout);

            $table->render();

            if ($this->_exclude_rad !== false && $this->_exclude_rad > 0 && $this->_exclude_rad > $item['distance']) {
                if ($type == 'self') {
                    array_push($excluded, $item['object_2']['id']);
                    $objexc = 'object 2';
                } elseif ($type = 'main') {
                    array_push($excluded, $key);
                    $objexc = 'new';
                }
                $io->warning("Object $objexc is automatically excluded since distance: " . $item['distance'] . " < " . $this->_exclude_rad);
                continue;
            }

            do {
                $choice = $io->choice('Select the the option to be applied to objects', $checks['options']);
            } while (!$this->_applyDuplicateOption($type, $choice, $excluded, $key, $item, $io));
        }

        $confirm_exclude = $io->confirm("You have found " . count($excluded) . " possible " .$type. "-duplicates. Please confirm that you want to exclude them from further processing.",
            false);
        if ($confirm_exclude) {
            foreach ($excluded as $exclude) {
                unset($finalInputArray[$exclude]);
            }
        }
    }

    /**
     * @param $type string 'self' or 'main'
     * @param $choice string selected choice
     * @param $excluded array of excluded objects
     * @param $current_key string current key of the objects
     * @param $current_item array current object
     * @param SymfonyStyle $io
     * @return bool true on success
     */
    private function _applyDuplicateOption($type, $choice, &$excluded, $current_key, $current_item, SymfonyStyle $io)
    {
        if ($type == 'main') {
            switch ($choice) {
                case 'n':
                    array_push($excluded, $current_key);
                    return true;
                case 'i':
                    return true;
                case 'h':
                    $io->note("n: exclude your object from further proccessing, i: leave your object for the further processing, q: quit script.");
                    return false;
                case 'q':
                    die();

            }
        } elseif ($type == 'self') {
            switch ($choice) {
                case 'b':
                    array_push($excluded, $current_item['object_1']['id']);
                    array_push($excluded, $current_item['object_2']['id']);
                    return true;
                case '1':
                case '2':
                    array_push($excluded, $current_item["object_" . $choice]['id']);
                    return true;
                case 'i':
                    return true;
                case 'h':
                    $io->note("b: both objects will be excluded from further proccessing, 1: exclude object 'object 1', 2: exclude object 'object 2', i: leave both objetcs for the further processing, q: quit script.");
                    return false;
                case 'q':
                    die();

            }
        }
        return false;
    }



}