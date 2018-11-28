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

    /*
     *  FUNCTIONS FOR
     *    SECTIONS
    */

    public static function validateSections($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['position'] = sprintf('%e', (float)$dat[$i]['position'] / 1000);
            $dat[$i]['externalDiameter'] = sprintf('%e', (float)$dat[$i]['externalDiameter'] / 1000);
            $dat[$i]['internalDiameter'] = sprintf('%e', (float)$dat[$i]['internalDiameter'] / 1000);
            $dat[$i]['young'] = sprintf('%e', (float)$dat[$i]['young']);
            $dat[$i]['poisson'] = sprintf('%e', (float)$dat[$i]['poisson']);
            $dat[$i]['density'] = sprintf('%e', (float)$dat[$i]['density']);
            $dat[$i]['axialForce'] = sprintf('%e', (float)$dat[$i]['axialForce']);
            $dat[$i]['magneticForce'] = sprintf('%e', (float)$dat[$i]['magneticForce']);
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

        // $conv = Yii::$app->converter->Convertor;
        // $conv->to(+$dat[$i]['position'], 'length'))

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['position'] = sprintf('%e', (float)Yii::$app->converter->convert(+$dat[$i]['position']));
            $dat[$i]['externalDiameter'] = sprintf('%e', (float)Yii::$app->converter->convert(+$dat[$i]['externalDiameter']));
            $dat[$i]['internalDiameter'] = sprintf('%e', (float)Yii::$app->converter->convert(+$dat[$i]['internalDiameter']));
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
            $dat[$i]['position'] = sprintf('%e', (float)$dat[$i]['position'] / 1000);
            $dat[$i]['externalDiameter'] = sprintf('%e', (float)$dat[$i]['externalDiameter'] / 1000);
            $dat[$i]['internalDiameter'] = sprintf('%e', (float)$dat[$i]['internalDiameter'] / 1000);
            $dat[$i]['thickness'] = sprintf('%e', (float)$dat[$i]['thickness'] / 1000);
            $dat[$i]['density'] = sprintf('%e', (float)$dat[$i]['density']);
            $dat[$i]['ix'] = sprintf('%e', (float)$dat[$i]['ix']);
            $dat[$i]['iy'] = sprintf('%e', (float)$dat[$i]['iy']);
            $dat[$i]['iz'] = sprintf('%e', (float)$dat[$i]['iz']);
            $dat[$i]['length'] = sprintf('%e', (float)$dat[$i]['length'] / 1000);
            $dat[$i]['mass'] = sprintf('%e', (float)$dat[$i]['mass']);
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
            $dat[$i]['position'] = sprintf('%e', (float)Yii::$app->converter->convert(+$dat[$i]['position']));
            $dat[$i]['externalDiameter'] = sprintf('%e', (float)Yii::$app->converter->convert(+$dat[$i]['externalDiameter']));
            $dat[$i]['internalDiameter'] = sprintf('%e', (float)Yii::$app->converter->convert(+$dat[$i]['internalDiameter']));
            $dat[$i]['thickness'] = sprintf('%e', (float)Yii::$app->converter->convert(+$dat[$i]['thickness']));
            $dat[$i]['length'] = sprintf('%e', (float)Yii::$app->converter->convert(+$dat[$i]['length']));
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
            $dat[$i]['position'] = sprintf('%e', (float)$dat[$i]['position'] / 1000);
            $dat[$i]['number'] = sprintf('%e', (int)$dat[$i]['number']);
            $dat[$i]['webThickness'] = sprintf('%e', (float)$dat[$i]['webThickness'] / 1000);
            $dat[$i]['webDepth'] = sprintf('%e', (float)$dat[$i]['webDepth'] / 1000);
            $dat[$i]['flangeWidth'] = sprintf('%e', (float)$dat[$i]['flangeWidth'] / 1000);
            $dat[$i]['flangeThick'] = sprintf('%e', (float)$dat[$i]['flangeThick'] / 1000);
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
            $dat[$i]['position'] = sprintf('%e', (float)Yii::$app->converter->convert(+$dat[$i]['position']));
            $dat[$i]['webThickness'] = sprintf('%e', (float)Yii::$app->converter->convert(+$dat[$i]['webThickness']));
            $dat[$i]['webDepth'] = sprintf('%e', (float)Yii::$app->converter->convert(+$dat[$i]['webDepth']));
            $dat[$i]['flangeWidth'] = sprintf('%e', (float)Yii::$app->converter->convert(+$dat[$i]['flangeWidth']));
            $dat[$i]['flangeThick'] = sprintf('%e', (float)Yii::$app->converter->convert(+$dat[$i]['flangeThick']));
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
            $dat[$i]['position'] = sprintf('%e', (float)$dat[$i]['position'] / 1000);
            $dat[$i]['inertia'] = sprintf('%e', (float)$dat[$i]['inertia']);
            $dat[$i]['mass'] = sprintf('%e', (float)$dat[$i]['mass']);
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
            $dat[$i]['position'] = sprintf('%e', (float)Yii::$app->converter->convert(+$dat[$i]['position']));
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
            $dat[$i]['position'] = sprintf('%e', (float)$dat[$i]['position'] / 1000);
            $dat[$i]['rotations'] = self::validateRotation($dat[$i]['rotations']);
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
            $dat[$i]['position'] = sprintf('%e', (float)Yii::$app->converter->convert(+$dat[$i]['position']));
            $rot = $dat[$i]['rotations'];
            usort($rot, function ($a, $b) {
                return +$a['speed'] > +$b['speed'];
            });
            $dat[$i]['rotations'] = $rot;
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

    /*
     *  FUNCTIONS FOR
     *   FOUNDATIONS
    */

    public static function validateFoundations($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['position'] = sprintf('%e', (float)$dat[$i]['position'] / 1000);
            $dat[$i]['mass'] = sprintf('%e', (float)$dat[$i]['mass']);
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
            $dat[$i]['position'] = sprintf('%e', (float)Yii::$app->converter->convert(+$dat[$i]['position']));
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
            $dat[$i]['position'] = sprintf('%e', (float)$dat[$i]['position'] / 1000);
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
            $dat[$i]['position'] = sprintf('%e', (float)Yii::$app->converter->convert(+$dat[$i]['position']));
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

        $dat['mass'] = sprintf('%e', (float)$dat['mass']);
        $dat['inertia'] = sprintf('%e', (float)$dat['inertia']);

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
            $dat[$i]['thickness'] = sprintf('%e', (float)$dat[$i]['thickness'] / 1000);
            $dat[$i]['meanRadius'] = sprintf('%e', (float)$dat[$i]['meanRadius'] / 1000);
            $dat[$i]['radius'] = sprintf('%e', (float)$dat[$i]['radius'] / 1000);
        }
        return $dat;
    }

    public static function afterFindSheetrotations($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['thickness'] = sprintf('%e', (float)Yii::$app->converter->convert(+$dat[$i]['thickness']));
            $dat[$i]['meanRadius'] = sprintf('%e', (float)Yii::$app->converter->convert(+$dat[$i]['meanRadius']));
            $dat[$i]['radius'] = sprintf('%e', (float)Yii::$app->converter->convert(+$dat[$i]['radius']));
        }
        return $dat;
    }

    public static function validateSheettranslation($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['segments'] = sprintf('%e', (int)$dat[$i]['segments']);
            $dat[$i]['thickness'] = sprintf('%e', (float)$dat[$i]['thickness'] / 1000);
            $dat[$i]['diameter'] = sprintf('%e', (float)$dat[$i]['diameter'] / 1000);
        }
        return $dat;
    }

    public static function afterFindSheettranslations($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['segments'] = sprintf('%e', (float)Yii::$app->converter->convert(+$dat[$i]['segments']));
            $dat[$i]['thickness'] = sprintf('%e', (float)Yii::$app->converter->convert(+$dat[$i]['thickness']));
            $dat[$i]['diameter'] = sprintf('%e', (float)Yii::$app->converter->convert(+$dat[$i]['diameter']));
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
            $dat[$i]['position'] = sprintf('%e', (float)$dat[$i]['position'] / 1000);
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
            $dat[$i]['position'] = sprintf('%e', (float)Yii::$app->converter->convert(+$dat[$i]['position']));
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
            $dat[$i]['initialSpeed'] = sprintf('%e', (float)$dat[$i]['initialSpeed']);
            $dat[$i]['finalSpeed'] = sprintf('%e', (float)$dat[$i]['finalSpeed']);
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
            $dat[$i]['initialFrequency'] = sprintf('%e', (float)$dat[$i]['initialFrequency']);
            $dat[$i]['finalFrequency'] = sprintf('%e', (float)$dat[$i]['finalFrequency']);
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
            $dat[$i]['position'] = sprintf('%e', (float)$dat[$i]['position'] / 1000);
            $dat[$i]['force'] = sprintf('%e', (float)$dat[$i]['force']);
            $dat[$i]['coord'] = sprintf('%e', (float)$dat[$i]['coord']);
        }
        return $dat;
    }

    public static function validatePhase($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['phase'] = sprintf('%e', (float)$dat[$i]['phase']);
            $dat[$i]['position'] = sprintf('%e', (float)$dat[$i]['position'] / 1000);
            $dat[$i]['unbalance'] = sprintf('%e', (float)$dat[$i]['unbalance'] / 1e6);
        }
        return $dat;
    }

    public static function validateTork($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['position'] = sprintf('%e', (float)$dat[$i]['position'] / 1000);
            $dat[$i]['phase'] = sprintf('%e', (float)$dat[$i]['phase'] / 1e6);
            $dat[$i]['tork'] = sprintf('%e', (float)$dat[$i]['tork']);
        }
        return $dat;
    }

    public static function validateResponse($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['position'] = sprintf('%e', (float)$dat[$i]['position'] / 1000);
            $dat[$i]['coord'] = sprintf('%e', (float)$dat[$i]['coord']);
        }
        return $dat;
    }

    public static function afterFindPosition($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['position'] = sprintf('%e', (float)Yii::$app->converter->convert(+$dat[$i]['position']));
        }
        return $dat;
    }

    public static function afterFindPhaseUnb($dat)
    {
        if(!is_array($dat))
            return [];

        for ($i=0; $i < count($dat); $i++) {
            $dat[$i]['unbalance'] = sprintf('%e', (float)(+$dat[$i]['unbalance']*1e6));
        }
        return $dat;
    }
}