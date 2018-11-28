<?php

namespace app\components;

use app\components\ConvertorDifferentTypeException;
use app\components\ConvertorException;
use app\components\ConvertorInvalidUnitException;
use app\components\FileNotFoundException;

class Convertor
{
    private $value = null; //value to convert
    private $baseUnit = false; //base unit of value

    //array to hold unit conversion functions
    private $units = array();

    function defineUnits($unitFile)
    {
        $configDir = __DIR__ . DIRECTORY_SEPARATOR;
        //default to the newest Units.php file
        if (!isset($unitFile))
            $unitFile = $configDir . 'BaseUnits.php';
        //if only the filename is given and it exists in the config folder add the path to the file
        if (!is_array($unitFile)) {
            $configFiles = scandir($configDir);
            if (in_array($unitFile, $configFiles))
                $unitFile = $configDir . $unitFile;
        } //if an array is given, use the array.
        else {
            $this->units = $unitFile;
            return;
        }
        //lastly check if the file exists, then include or throw an error.
        if (file_exists($unitFile))
            $this->units = include $unitFile;
        else
            throw new FileNotFoundException("File could not be found. Given path='$unitFile'" .
                "either use the name of one of the pre defined configuration files or pass the complete path to the file.");
    }

    function __construct($value = null, $unit = null, $unitFile = null)
    {
        //create units array
        $this->defineUnits($unitFile);
        //unit optional
        if (!is_null($value) && !is_null($unit)) {
            //set from unit
            $this->from($value, $unit);
        }
    }

    public function from($value, $unit)
    {
        //check if value has been set
        if (is_null($value)) {
            throw new ConvertorException("Value Not Set");
        }
        if ($unit) {
            //check that unit exists
            if (array_key_exists($unit, $this->units)) {
                if (isset($this->units[$unit]))
                    $unitLookup = $this->units[$unit];
                if (isset($unitLookup)) {
                    //convert unit to base unit for this unit type
                    $this->baseUnit = $unitLookup["base"];
                    $this->value = $this->convertToBase($value, $unitLookup);
                }
            } else {
                throw new ConvertorInvalidUnitException("Conversion from Unit u=$unit not possible - unit does not exist.");
            }
        } else {
            $this->value = $value;
        }
    }

    public function to($unit, $decimals = null, $round = true)
    {
        //check if from value is set
        if (is_null($this->value)) {
            throw new ConvertorException("From Value Not Set.");
        }
        //check if to unit is set
        if (!$unit) {
            throw new ConvertorException("Unit Not Set");
        }
        //if unit is array, iterate through each unit
        if (is_array($unit)) {
            return $this->toMany($unit, $decimals, $round);
        } else {
            //check unit symbol exists
            if (array_key_exists($unit, $this->units)) {
                $unitLookup = $this->units[$unit];
                $result = 0;
                //if from unit not provided, assume base unit of to unit type
                if ($this->baseUnit) {
                    if ($unitLookup["base"] != $this->baseUnit) {
                        throw new ConvertorDifferentTypeException("Cannot Convert Between Units of Different Types");
                    }
                } else {
                    $this->baseUnit = $unitLookup["base"];
                }
                //calculate converted value
                if (is_callable($unitLookup["conversion"])) {
                    // if unit has a conversion function, run value through it
                    $result = $unitLookup["conversion"]($this->value, true);
                } else {
                    $result = $this->value / $unitLookup["conversion"];
                }
                //result precision and rounding
                if (!is_null($decimals)) {
                    if ($round) {
                        //round to the specifidd number of decimals
                        $result = round($result, $decimals);
                    } else {
                        //truncate to the nearest number of decimals
                        $shifter = $decimals ? pow(10, $decimals) : 1;
                        $result = floor($result * $shifter) / $shifter;
                    }
                }
                return $result;
            } else {
                throw new ConvertorInvalidUnitException("Conversion to Unit u=$unit not possible - unit does not exist.");
            }
        }
    }

    private function convertToBase($value, $unitArray)
    {
        if (is_callable($unitArray["conversion"])) {
            // if unit has a conversion function, run value through it
            return $unitArray["conversion"]($value, false);
        } else {
            return $value * $unitArray["conversion"];
        }
    }
}