<?php

return array(
	///////Units Of Length///////
    "m" => array("base" => "m", "conversion" => 1), //meter - base unit for distance
    "mm" => array("base" => "m", "conversion" => 0.001), //milimeter
    "in" => array("base" => "m", "conversion" => 0.0254), //inch
    "ft" => array("base" => "m", "conversion" => 0.3048), //foot
    ///////Units Of Area///////
    "m2" => array("base" => "m2", "conversion" => 1), //meter square - base unit for area
    "mm2" => array("base" => "m2", "conversion" => 0.000001), //milimeter square
    "in2" => array("base" => "m2", "conversion" => 0.00064516), //inch
    "ft2" => array("base" => "m2", "conversion" => 0.092903), //foot square
    ///////Units Of Volume///////
    "l" => array("base" => "l", "conversion" => 1), //litre - base unit for volume
    "dm3" => array("base" => "l", "conversion" => 1), //cubic decimeter - litre
    "m3" => array("base" => "l", "conversion" => 1000), //meters cubed - kilolitre
    "ft3" => array("base" => "l", "conversion" => 28.316846592), //cubic feet
    "in3" => array("base" => "l", "conversion" => 0.016387064), //cubic inches
    ///////Units Of Weight///////
    "kg" => array("base" => "kg", "conversion" => 1), //kilogram - base unit for weight
    "g" => array("base" => "kg", "conversion" => 0.001), //gram
    "mg" => array("base" => "kg", "conversion" => 0.000001), //miligram
    "N" => array("base" => "kg", "conversion" => 1 / 9.80665002863885), //Newton (based on earth gravity)
    "st" => array("base" => "kg", "conversion" => 6.35029), //stone
    "lb" => array("base" => "kg", "conversion" => 0.453592), //pound
    "oz" => array("base" => "kg", "conversion" => 0.0283495), //ounce
    ///////Units Of Rotation///////
    "deg" => array("base" => "deg", "conversion" => 1), //degrees - base unit for rotation
    "rad" => array("base" => "deg", "conversion" => 57.2958), //radian
    ///////Units Of Pressure///////
    "pa" => array("base" => "Pa", "conversion" => 1), //Pascal - base unit for Pressure
    "psi" => array("base" => "Pa", "conversion" => 6894.76), //pound-force per square inch
    ///////Units Of Power///////
    "j" => array("base" => "j", "conversion" => 1), //joule - base unit for energy
    "Nm" => array("base" => "j", "conversion" => 1), //newton meter
    "ftlb" => array("base" => "j", "conversion" => 1.35582), //foot pound

);