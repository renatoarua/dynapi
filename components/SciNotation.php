<?php

namespace app\components;
use Yii;
use yii\db\Query;

class SciNotation
{
    /**
     * set of functions to fix attributes from JSON objects to scientifc notation
     * and international unit system
    */

    // system imperial
    // Yii::$app->converter->from(1.0, 'm'); // 1 in = 2.540000e-2 m

    // system imperial
    // Yii::$app->converter->to(1.0, 'm'); // 1 m = 3.937008e+1 in

    /*
     *  FUNCTIONS FOR
     *    SECTIONS
    */

    public static function validateSections($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            // $dat[$i]['position'] = sprintf('%e', (float)$dat[$i]['position'] / 1000);
            $dat[$i]['position'] = Yii::$app->converter->from(+$dat[$i]['position'], 'm');
            $dat[$i]['externalDiameter'] = Yii::$app->converter->from(+$dat[$i]['externalDiameter'], 'm');
            $dat[$i]['internalDiameter'] = Yii::$app->converter->from(+$dat[$i]['internalDiameter'], 'm');
            $dat[$i]['young'] = Yii::$app->converter->from(+$dat[$i]['young'], 'pa');
            $dat[$i]['poisson'] = Yii::$app->converter->from(+$dat[$i]['poisson'], '1');
            $dat[$i]['density'] = Yii::$app->converter->from(+$dat[$i]['density'], 'kg_m3');
            $dat[$i]['axialForce'] = Yii::$app->converter->from(+$dat[$i]['axialForce'], 'N');
            $dat[$i]['magneticForce'] = Yii::$app->converter->from(+$dat[$i]['magneticForce'], 'N');
            
            if(isset($dat[$i]['ribs'])) {
                $dat[$i]['ribs'] = self::validateRibs($dat[$i]['ribs']);
            }
        }
        usort($dat, function ($a, $b) {
            return +$a['position'] > +$b['position'];
        });
        return $dat;
    }

    public static function afterFindSections($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            // $dat[$i]['position'] = sprintf('%e', (float)Yii::$app->converter->convert(+$dat[$i]['position']));
            $dat[$i]['position'] = Yii::$app->converter->to(+$dat[$i]['position'], 'm');
            $dat[$i]['externalDiameter'] = Yii::$app->converter->to(+$dat[$i]['externalDiameter'], 'm');
            $dat[$i]['internalDiameter'] = Yii::$app->converter->to(+$dat[$i]['internalDiameter'], 'm');
            $dat[$i]['young'] = Yii::$app->converter->to(+$dat[$i]['young'], 'pa');
            $dat[$i]['density'] = Yii::$app->converter->to(+$dat[$i]['density'], 'kg_m3');
            $dat[$i]['axialForce'] = Yii::$app->converter->to(+$dat[$i]['axialForce'], 'N');
            $dat[$i]['magneticForce'] = Yii::$app->converter->to(+$dat[$i]['magneticForce'], 'N');

            if(isset($dat[$i]['ribs'])) {
                $dat[$i]['ribs'] = self::afterFindRibs($dat[$i]['ribs']);
            }
        }

        usort($dat, function ($a, $b) {
            return +$a['position'] > +$b['position'];
        });
        return $dat;
    }

    /*
     *  FUNCTIONS FOR
     *      DISCS
    */
    public static function validateDiscs($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['position'] = Yii::$app->converter->from(+$dat[$i]['position'], 'm');
            $dat[$i]['externalDiameter'] = Yii::$app->converter->from(+$dat[$i]['externalDiameter'], 'm');
            $dat[$i]['internalDiameter'] = Yii::$app->converter->from(+$dat[$i]['internalDiameter'], 'm');
            $dat[$i]['thickness'] = Yii::$app->converter->from(+$dat[$i]['thickness'], 'm');
            $dat[$i]['density'] = Yii::$app->converter->from(+$dat[$i]['density'], 'kg_m3');
            $dat[$i]['length'] = Yii::$app->converter->from(+$dat[$i]['length'], 'm');
            $dat[$i]['mass'] = Yii::$app->converter->from(+$dat[$i]['mass'], 'kg');
            $dat[$i]['ix'] = Yii::$app->converter->from(+$dat[$i]['ix'], 'kgm2');
            $dat[$i]['iy'] = Yii::$app->converter->from(+$dat[$i]['iy'], 'kgm2');
            $dat[$i]['iz'] = Yii::$app->converter->from(+$dat[$i]['iz'], 'kgm2');
        }
        usort($dat, function ($a, $b) {
            return +$a['position'] > +$b['position'];
        });
        return $dat;
    }

    public static function afterFindDiscs($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            // $dat[$i]['position'] = sprintf('%e', (float)Yii::$app->converter->convert(+$dat[$i]['position']));
            $dat[$i]['position'] = Yii::$app->converter->to(+$dat[$i]['position'], 'm');
            $dat[$i]['externalDiameter'] = Yii::$app->converter->to(+$dat[$i]['externalDiameter'], 'm');
            $dat[$i]['internalDiameter'] = Yii::$app->converter->to(+$dat[$i]['internalDiameter'], 'm');
            $dat[$i]['thickness'] = Yii::$app->converter->to(+$dat[$i]['thickness'], 'm');
            $dat[$i]['density'] = Yii::$app->converter->to(+$dat[$i]['density'], 'kg_m3');
            $dat[$i]['length'] = Yii::$app->converter->to(+$dat[$i]['length'], 'm');
            $dat[$i]['mass'] = Yii::$app->converter->to(+$dat[$i]['mass'], 'kg');
            $dat[$i]['ix'] = Yii::$app->converter->to(+$dat[$i]['ix'], 'kgm2');
            $dat[$i]['iy'] = Yii::$app->converter->to(+$dat[$i]['iy'], 'kgm2');
            $dat[$i]['iz'] = Yii::$app->converter->to(+$dat[$i]['iz'], 'kgm2');
        }
        usort($dat, function ($a, $b) {
            return +$a['position'] > +$b['position'];
        });
        return $dat;
    }

    /*
     *  FUNCTIONS FOR
     *      RIBS
    */

    public static function validateRibs($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['position'] = Yii::$app->converter->from(+$dat[$i]['position'], 'm');
            $dat[$i]['number'] = Yii::$app->converter->from(+$dat[$i]['number'], '1');
            $dat[$i]['webThickness'] = Yii::$app->converter->from(+$dat[$i]['webThickness'], 'm');
            $dat[$i]['webDepth'] = Yii::$app->converter->from(+$dat[$i]['webDepth'], 'm');
            $dat[$i]['flangeWidth'] = Yii::$app->converter->from(+$dat[$i]['flangeWidth'], 'm');
            $dat[$i]['flangeThick'] = Yii::$app->converter->from(+$dat[$i]['flangeThick'], 'm');
        }
        usort($dat, function ($a, $b) {
            return +$a['position'] > +$b['position'];
        });
        return $dat;
    }

    public static function afterFindRibs($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['position'] = Yii::$app->converter->to(+$dat[$i]['position'], 'm');
            $dat[$i]['webThickness'] = Yii::$app->converter->to(+$dat[$i]['webThickness'], 'm');
            $dat[$i]['webDepth'] = Yii::$app->converter->to(+$dat[$i]['webDepth'], 'm');
            $dat[$i]['flangeWidth'] = Yii::$app->converter->to(+$dat[$i]['flangeWidth'], 'm');
            $dat[$i]['flangeThick'] = Yii::$app->converter->to(+$dat[$i]['flangeThick'], 'm');
        }
        usort($dat, function ($a, $b) {
            return +$a['position'] > +$b['position'];
        });
        return $dat;
    }

    /*
     *   FUNCTIONS FOR
     *   ROLLERBEARINGS
    */

    public static function validateRollerbearings($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['position'] = Yii::$app->converter->from(+$dat[$i]['position'], 'm');
            $dat[$i]['inertia'] = Yii::$app->converter->from(+$dat[$i]['inertia'], 'kgm2');
            $dat[$i]['mass'] = Yii::$app->converter->from(+$dat[$i]['mass'], 'kg');

            $dat[$i]['kxx'] = sprintf('%e', (float)$dat[$i]['kxx']);
            $dat[$i]['kxz'] = sprintf('%e', (float)$dat[$i]['kxz']);
            $dat[$i]['kzx'] = sprintf('%e', (float)$dat[$i]['kzx']);
            $dat[$i]['kzz'] = sprintf('%e', (float)$dat[$i]['kzz']);
            $dat[$i]['cxx'] = sprintf('%e', (float)$dat[$i]['cxx']);
            $dat[$i]['cxz'] = sprintf('%e', (float)$dat[$i]['cxz']);
            $dat[$i]['czx'] = sprintf('%e', (float)$dat[$i]['czx']);
            $dat[$i]['czz'] = sprintf('%e', (float)$dat[$i]['czz']);
            $dat[$i]['ktt'] = sprintf('%e', (float)$dat[$i]['ktt']);
            $dat[$i]['ktp'] = sprintf('%e', (float)$dat[$i]['ktp']);
            $dat[$i]['kpt'] = sprintf('%e', (float)$dat[$i]['kpt']);
            $dat[$i]['kpp'] = sprintf('%e', (float)$dat[$i]['kpp']);
            $dat[$i]['ctt'] = sprintf('%e', (float)$dat[$i]['ctt']);
            $dat[$i]['ctp'] = sprintf('%e', (float)$dat[$i]['ctp']);
            $dat[$i]['cpt'] = sprintf('%e', (float)$dat[$i]['cpt']);
            $dat[$i]['cpp'] = sprintf('%e', (float)$dat[$i]['cpp']);
        }
        usort($dat, function ($a, $b) {
            return +$a['position'] > +$b['position'];
        });
        return $dat;
    }

    public static function afterFindRollerbearings($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['position'] = Yii::$app->converter->to(+$dat[$i]['position'], 'm');
            $dat[$i]['mass'] = Yii::$app->converter->to(+$dat[$i]['mass'], 'kg');
            $dat[$i]['inertia'] = Yii::$app->converter->to(+$dat[$i]['inertia'], 'kgm2');
        }
        usort($dat, function ($a, $b) {
            return +$a['position'] > +$b['position'];
        });
        return $dat;
    }

    /*
     *   FUNCTIONS FOR
     *  JOURNALBEARINGS
    */

    public static function validateJournalbearings($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['position'] = Yii::$app->converter->from(+$dat[$i]['position'], 'm');
            $dat[$i]['rotations'] = self::validateRotation($dat[$i]['rotations']);
            $dat[$i]['optimization'] = self::validateJournalOpt($dat[$i]['optimization']);
        }
        usort($dat, function ($a, $b) {
            return +$a['position'] > +$b['position'];
        });
        return $dat;
    }

    public static function afterFindJournalbearings($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['position'] = Yii::$app->converter->to(+$dat[$i]['position'], 'm');

            $rot = $dat[$i]['rotations'];
            usort($rot, function ($a, $b) {
                return +$a['speed'] > +$b['speed'];
            });
            $dat[$i]['rotations'] = $rot;

            if(isset($dat[$i]['optimization'][0])) {
                // && $dat[$i]['optimization']['status'] != Journal::NOT_APPLICABLE
                $dat[$i]['optimization'][0]['viscosity'] = Yii::$app->converter->to(+$dat[$i]['optimization'][0]['viscosity'], 'pas');
                $dat[$i]['optimization'][0]['diameter'] = Yii::$app->converter->to(+$dat[$i]['optimization'][0]['diameter'], 'm');
                $dat[$i]['optimization'][0]['length'] = Yii::$app->converter->to(+$dat[$i]['optimization'][0]['length'], 'm');
                $dat[$i]['optimization'][0]['radio'] = Yii::$app->converter->to(+$dat[$i]['optimization'][0]['radio'], 'm');
                $dat[$i]['optimization'][0]['load'] = Yii::$app->converter->to(+$dat[$i]['optimization'][0]['load'], 'N');
                // $opt = $dat[$i]['optimization'];
                // $dat[$i]['optimization'] = $opt;
            }
        }
        usort($dat, function ($a, $b) {
            return +$a['position'] > +$b['position'];
        });
        return $dat;
    }

    public static function validateRotation($dat)
    {
        if(!is_array($dat))
            return [];
        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['speed'] = sprintf('%e', (float)$dat[$i]['speed']);

            $dat[$i]['kxx'] = sprintf('%e', (float)$dat[$i]['kxx']);
            $dat[$i]['kxz'] = sprintf('%e', (float)$dat[$i]['kxz']);
            $dat[$i]['kzx'] = sprintf('%e', (float)$dat[$i]['kzx']);
            $dat[$i]['kzz'] = sprintf('%e', (float)$dat[$i]['kzz']);
            $dat[$i]['cxx'] = sprintf('%e', (float)$dat[$i]['cxx']);
            $dat[$i]['cxz'] = sprintf('%e', (float)$dat[$i]['cxz']);
            $dat[$i]['czx'] = sprintf('%e', (float)$dat[$i]['czx']);
            $dat[$i]['czz'] = sprintf('%e', (float)$dat[$i]['czz']);
        }

        return $dat;
    }

    public static function validateJournalOpt($dat)
    {
        $dat['initialSpin'] = sprintf('%e', (float)$dat['initialSpin']);
        $dat['finalSpin'] = sprintf('%e', (float)$dat['finalSpin']);
        $dat['steps'] = sprintf('%e', (float)$dat['steps']);

        // $dat['properties'] = self::validateJournalProps($dat['properties']);
        $dat['viscosity'] = Yii::$app->converter->from(+$dat['viscosity'], 'pas');
        $dat['diameter'] = Yii::$app->converter->from(+$dat['diameter'], 'm');
        $dat['length'] = Yii::$app->converter->from(+$dat['length'], 'm');
        $dat['radio'] = Yii::$app->converter->from(+$dat['radio'], 'm');
        $dat['load'] = Yii::$app->converter->from(+$dat['load'], 'N');

        return $dat;
    }

    public static function validateJournalProps($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['viscosity'] = Yii::$app->converter->from(+$dat[$i]['viscosity'], 'pas');
            $dat[$i]['diameter'] = Yii::$app->converter->from(+$dat[$i]['diameter'], 'm');
            $dat[$i]['length'] = Yii::$app->converter->from(+$dat[$i]['length'], 'm');
            $dat[$i]['radio'] = Yii::$app->converter->from(+$dat[$i]['radio'], 'm');
            $dat[$i]['load'] = Yii::$app->converter->from(+$dat[$i]['load'], 'N');
        }
        return $dat;
    }

    /*
     *  FUNCTIONS FOR
     *   FOUNDATIONS
    */

    public static function validateFoundations($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['position'] = Yii::$app->converter->from(+$dat[$i]['position'], 'm');
            $dat[$i]['mass'] = Yii::$app->converter->from(+$dat[$i]['mass'], 'kg');

            $dat[$i]['kxx'] = sprintf('%e', (float)$dat[$i]['kxx']);
            $dat[$i]['kzz'] = sprintf('%e', (float)$dat[$i]['kzz']);
            $dat[$i]['cxx'] = sprintf('%e', (float)$dat[$i]['cxx']);
            $dat[$i]['czz'] = sprintf('%e', (float)$dat[$i]['czz']);
        }
        usort($dat, function ($a, $b) {
            return +$a['position'] > +$b['position'];
        });
        return $dat;
    }

    public static function afterFindFoundations($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['position'] = Yii::$app->converter->to(+$dat[$i]['position'], 'm');
            $dat[$i]['mass'] = Yii::$app->converter->to(+$dat[$i]['mass'], 'kg');
        }
        usort($dat, function ($a, $b) {
            return +$a['position'] > +$b['position'];
        });
        return $dat;
    }

    /*
     *  FUNCTIONS FOR
     *       VES
    */

    public static function validateVes($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['position'] = Yii::$app->converter->from(+$dat[$i]['position'], 'm');
            $dat[$i]['sheet'] = self::validateSheet($dat[$i]['sheet']);
            $dat[$i]['rollerbearings'] = self::validateRollerbearings($dat[$i]['rollerbearings']);
        }
        usort($dat, function ($a, $b) {
            return +$a['position'] > +$b['position'];
        });
        return $dat;
    }

    public static function afterFindVes($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['position'] = Yii::$app->converter->to(+$dat[$i]['position'], 'm');

            $dat[$i]['sheet']['rotations'] = self::afterFindSheetrotations($dat[$i]['sheet']['rotations']);
            $dat[$i]['sheet']['translations'] = self::afterFindSheettranslations($dat[$i]['sheet']['translations']);
            $dat[$i]['rollerbearings'] = self::afterFindRollerbearings($dat[$i]['rollerbearings']);
        }
        usort($dat, function ($a, $b) {
            return +$a['position'] > +$b['position'];
        });
        return $dat;
    }

    public static function validateSheet($dat)
    {
        if(!is_array($dat))
            return [];

        $dat[$i]['mass'] = Yii::$app->converter->from(+$dat[$i]['mass'], 'kg');
        $dat[$i]['inertia'] = Yii::$app->converter->from(+$dat[$i]['inertia'], 'kgm2');

        $dat['materials'] = self::validateSheetmaterial($dat['materials']);
        $dat['rotations'] = self::validateSheetrotation($dat['rotations']);
        $dat['translations'] = self::validateSheettranslation($dat['translations']);
        return $dat;
    }

    public static function validateSheetmaterial($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['go'] = sprintf('%e', (float)$dat[$i]['go']);
            $dat[$i]['goo'] = sprintf('%e', (float)$dat[$i]['goo']);
            $dat[$i]['beta'] = sprintf('%e', (float)$dat[$i]['beta']);
            $dat[$i]['b1'] = sprintf('%e', (float)$dat[$i]['b1']);
            $dat[$i]['theta1'] = sprintf('%e', (float)$dat[$i]['theta1']);
            $dat[$i]['theta2'] = sprintf('%e', (float)$dat[$i]['theta2']);
            $dat[$i]['temperature'] = sprintf('%e', (float)$dat[$i]['temperature']);
            $dat[$i]['temperatureRef'] = sprintf('%e', (float)$dat[$i]['temperatureRef']);
        }
        return $dat;
    }

    public static function validateSheetrotation($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['thickness'] = Yii::$app->converter->from(+$dat[$i]['thickness'], 'm');
            $dat[$i]['meanRadius'] = Yii::$app->converter->from(+$dat[$i]['meanRadius'], '1');
            $dat[$i]['radius'] = Yii::$app->converter->from(+$dat[$i]['radius'], '1');
        }
        return $dat;
    }

    public static function afterFindSheetrotations($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['thickness'] = Yii::$app->converter->to(+$dat[$i]['thickness'], 'm');
            $dat[$i]['meanRadius'] = Yii::$app->converter->to(+$dat[$i]['meanRadius'], '1');
            $dat[$i]['radius'] = Yii::$app->converter->to(+$dat[$i]['radius'], '1');
        }
        return $dat;
    }

    public static function validateSheettranslation($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['segments'] = Yii::$app->converter->from(+$dat[$i]['segments'], '1');
            $dat[$i]['thickness'] = Yii::$app->converter->from(+$dat[$i]['thickness'], 'm');
            $dat[$i]['diameter'] = Yii::$app->converter->from(+$dat[$i]['diameter'], 'm');
        }
        return $dat;
    }

    public static function afterFindSheettranslations($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['thickness'] = Yii::$app->converter->to(+$dat[$i]['thickness'], 'm');
            $dat[$i]['diameter'] = Yii::$app->converter->to(+$dat[$i]['diameter'], 'm');
        }
        return $dat;
    }

    /*
     *  FUNCTIONS FOR
     *       ABS
    */

    public static function validateAbs($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['position'] = Yii::$app->converter->from(+$dat[$i]['position'], 'm');
        }
        usort($dat, function ($a, $b) {
            return +$a['position'] > +$b['position'];
        });
        return $dat;
    }

    public static function afterFindAbs($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['position'] = Yii::$app->converter->to(+$dat[$i]['position'], 'm');
        }
        usort($dat, function ($a, $b) {
            return +$a['position'] > +$b['position'];
        });
        return $dat;
    }


    /*
     *
     *     RESULTS
     *
     *  FUNCTIONS FOR
     *    CAMPBELL
    */
    public static function validateCampbell($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['initialSpin'] = sprintf('%e', (float)$dat[$i]['initialSpin']);
            $dat[$i]['finalSpin'] = sprintf('%e', (float)$dat[$i]['finalSpin']);
            $dat[$i]['steps'] = sprintf('%e', (int)$dat[$i]['steps']);
            $dat[$i]['frequencies'] = sprintf('%e', (int)$dat[$i]['frequencies']);
        }
        return $dat;
    }

    /*
     *  FUNCTIONS FOR
     *    STIFFNESS
    */
    public static function validateStiffness($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['initialStiffness'] = sprintf('%e', (float)$dat[$i]['initialStiffness']);
            $dat[$i]['initialSpin'] = sprintf('%e', (float)$dat[$i]['initialSpin']);
            $dat[$i]['finalSpin'] = sprintf('%e', (float)$dat[$i]['finalSpin']);
            $dat[$i]['decades'] = sprintf('%e', (int)$dat[$i]['decades']);
            $dat[$i]['frequencies'] = sprintf('%e', (int)$dat[$i]['frequencies']);
        }
        return $dat;
    }

    /*
     *  FUNCTIONS FOR
     *     MODES
    */
    public static function validateModes($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['modes'] = sprintf('%e', (int)$dat[$i]['modes']);
            $dat[$i]['maxFrequency'] = sprintf('%e', (float)$dat[$i]['maxFrequency']);
        }
        return $dat;
    }

    /*
     *  FUNCTIONS FOR
     *    CONSTANT
    */
    public static function validateConstant($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['initialFrequency'] = sprintf('%e', (float)$dat[$i]['initialFrequency']);
            $dat[$i]['finalFrequency'] = sprintf('%e', (float)$dat[$i]['finalFrequency']);
            $dat[$i]['modes'] = sprintf('%e', (int)$dat[$i]['modes']);
            $dat[$i]['speed'] = sprintf('%e', (float)$dat[$i]['speed']);
            $dat[$i]['steps'] = sprintf('%e', (int)$dat[$i]['steps']);

            $dat[$i]['forces'] = self::validateForce($dat[$i]['forces']);
            $dat[$i]['responses'] = self::validateResponse($dat[$i]['responses']);
        }
        return $dat;
    }

    public static function afterFindConstant($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            
            $forces = self::afterFindPosition($dat[$i]['forces']);
            usort($forces, function ($a, $b) {
                return +$a['position'] > +$b['position'];
            });
            $dat[$i]['forces'] = $forces;

            $responses = self::afterFindPosition($dat[$i]['responses']);
            usort($responses, function ($a, $b) {
                return +$a['position'] > +$b['position'];
            });
            $dat[$i]['responses'] = $responses;
        }
        return $dat;
    }

    /*
     *  FUNCTIONS FOR
     *    UNBALANCE
    */
    public static function validateUnbalance($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['initialSpin'] = sprintf('%e', (float)$dat[$i]['initialSpin']);
            $dat[$i]['finalSpin'] = sprintf('%e', (float)$dat[$i]['finalSpin']);
            $dat[$i]['modes'] = sprintf('%e', (int)$dat[$i]['modes']);
            $dat[$i]['steps'] = sprintf('%e', (int)$dat[$i]['steps']);

            $dat[$i]['phases'] = self::validatePhase($dat[$i]['phases']);
            $dat[$i]['responses'] = self::validateResponse($dat[$i]['responses']);
        }
        return $dat;
    }

    public static function afterFindUnbalance($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $phases = self::afterFindPosition($dat[$i]['phases']);
            usort($phases, function ($a, $b) {
                return +$a['position'] > +$b['position'];
            });
            $phases = self::afterFindPhaseUnb($phases);
            $dat[$i]['phases'] = $phases;

            $responses = self::afterFindPosition($dat[$i]['responses']);
            usort($responses, function ($a, $b) {
                return +$a['position'] > +$b['position'];
            });
            $dat[$i]['responses'] = $responses;
        }
        return $dat;
    }

    /*
     *  FUNCTIONS FOR
     *    TORSIONAL
    */
    public static function validateTorsional($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['initialFrequency'] = sprintf('%e', (float)$dat[$i]['initialFrequency']);
            $dat[$i]['finalFrequency'] = sprintf('%e', (float)$dat[$i]['finalFrequency']);
            $dat[$i]['modes'] = sprintf('%e', (int)$dat[$i]['modes']);
            $dat[$i]['steps'] = sprintf('%e', (int)$dat[$i]['steps']);

            $dat[$i]['phases'] = self::validateTork($dat[$i]['phases']);
            $dat[$i]['responses'] = self::validateResponse($dat[$i]['responses']);
        }
        return $dat;
    }

    public static function afterFindTorsional($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $phases = self::afterFindPosition($dat[$i]['phases']);
            usort($phases, function ($a, $b) {
                return +$a['position'] > +$b['position'];
            });
            $dat[$i]['phases'] = $phases;

            $responses = self::afterFindPosition($dat[$i]['responses']);
            usort($responses, function ($a, $b) {
                return +$a['position'] > +$b['position'];
            });
            $dat[$i]['responses'] = $responses;
        }
        return $dat;
    }

    /*
     *  FUNCTIONS FOR
     *      TIME
    */
    public static function validateTime($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['initialSpin'] = sprintf('%e', (float)$dat[$i]['initialSpin']);
            $dat[$i]['finalSpin'] = sprintf('%e', (float)$dat[$i]['finalSpin']);
            $dat[$i]['modes'] = sprintf('%e', (int)$dat[$i]['modes']);
            $dat[$i]['steps'] = sprintf('%e', (int)$dat[$i]['steps']);

            $dat[$i]['phases'] = self::validatePhase($dat[$i]['phases']);
        }
        return $dat;
    }

    public static function afterFindTime($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $phases = self::afterFindPosition($dat[$i]['phases']);
            usort($phases, function ($a, $b) {
                return +$a['position'] > +$b['position'];
            });
            $phases = self::afterFindPhaseUnb($phases);
            $dat[$i]['phases'] = $phases;
        }
        return $dat;
    }

    public static function validateForce($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['position'] = Yii::$app->converter->from(+$dat[$i]['position'], 'm');
            $dat[$i]['force'] = Yii::$app->converter->from(+$dat[$i]['force'], 'N');
            // $dat[$i]['coord'] = Yii::$app->converter->from(+$dat[$i]['coord'], '1');
        }
        return $dat;
    }

    public static function validatePhase($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['position'] = Yii::$app->converter->from(+$dat[$i]['position'], 'm');
            $dat[$i]['unbalance'] = Yii::$app->converter->from(+$dat[$i]['unbalance'], 'kgm');
            $dat[$i]['phase'] = Yii::$app->converter->from(+$dat[$i]['phase'], '1');
        }
        return $dat;
    }

    public static function validateTork($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['position'] = Yii::$app->converter->from(+$dat[$i]['position'], 'm');
            $dat[$i]['tork'] = Yii::$app->converter->from(+$dat[$i]['tork'], 'Nm');
            $dat[$i]['phase'] = Yii::$app->converter->from(+$dat[$i]['phase'], '1');

        }
        return $dat;
    }

    public static function validateResponse($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['position'] = Yii::$app->converter->from(+$dat[$i]['position'], 'm');
            // $dat[$i]['coord'] = Yii::$app->converter->from(+$dat[$i]['coord'], '1');
        }
        return $dat;
    }

    public static function afterFindPosition($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['position'] = Yii::$app->converter->to(+$dat[$i]['position'], 'm');
        }
        return $dat;
    }

    public static function afterFindPhaseUnb($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['unbalance'] = Yii::$app->converter->to(+$dat[$i]['unbalance'], 'kgm');
        }
        return $dat;
    }
}