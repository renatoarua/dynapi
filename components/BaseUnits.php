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
    // "N" => array("base" => "kg", "conversion" => 1 / 9.80665002863885), //Newton (based on earth gravity)
    "st" => array("base" => "kg", "conversion" => 6.35029), //stone
    "lb" => array("base" => "kg", "conversion" => 0.453592), //pound
    "oz" => array("base" => "kg", "conversion" => 0.0283495), //ounce
    ///////Units Of Rotation///////
    "deg" => array("base" => "deg", "conversion" => 1), //degrees - base unit for rotation
    "rad" => array("base" => "deg", "conversion" => 57.2958), //radian
    ///////Units Of Pressure///////
    "pa" => array("base" => "pa", "conversion" => 1), //Pascal - base unit for Pressure
    "psf" => array("base" => "pa", "conversion" => 47.8803), //pound-force per square foot
    "psi" => array("base" => "pa", "conversion" => 0.000145038), //pound-force per square inch

    "N" => array("base" => "N", "conversion" => 1),
    "lbf" => array("base" => "N", "conversion" => 0.2248090247),

    ///////Units Of Power///////
    // Energy is foot-pound, ft-lb
    "j" => array("base" => "j", "conversion" => 1), //joule - base unit for energy
    // Moment of a force; torque newton meter (N.m , lb-ft) pound-foot
    "ftlb" => array("base" => "j", "conversion" => 1.35582), //foot pound
    "inlb" => array("base" => "j", "conversion" => 0.112985), //inch pound
    
    "Nm" => array("base" => "Nm", "conversion" => 1), //newton meter Ktt, ktp, kpt, kpp
    "lbfin" => array("base" => "Nm", "conversion" => 8.850753785), //newton meter Ktt, ktp, kpt, kpp
    
    // surface tension
    // Force per unit length (Intensity of force) (N/m , lb/ft)
    "N_m" => array("base" => "N_m", "conversion" => 1), //newton meter Kxx, kxz, kzx, kzz
    "lbf_in" => array("base" => "N_m", "conversion" => 0.00571015), //175.127

    // viscosity
    "Ns_m" => array("base" => "Ns_m", "conversion" => 1), //newton meter Cxx, Cxz, Czx, Czz
    "lbfs_in" => array("base" => "Ns_m", "conversion" => 0.00571015), //newton meter Cxx, Cxz, Czx, Czz
    "pas" => array("base" => "pas", "conversion" => 1), //Pascal - base unit for Pressure

    // viscosity
    "Nsm" => array("base" => "Nsm", "conversion" => 1), //newton meter Cxx, Cxz, Czx, Czz
    "lbfsin" => array("base" => "Nsm", "conversion" => 8.850753785), //newton meter Cxx, Cxz, Czx, Czz

    ///////Units of Density ///////
    "kg_m3" => array("base" => "kg_m3", "conversion" => 1), //base unit for density
    "slug_ft3" => array("base" => "kg_m3", "conversion" => 515.379),
    "lb_ft3" => array("base" => "kg_m3", "conversion" => 0.06242797373),

    // moment of inertia kgm2 ,slug-ft2
    "kgm2" => array("base" => "kgm2", "conversion" => 1), //base unit for moment of inertia
    "slugft2" => array("base" => "kgm2", "conversion" => 1.35582),
    "lbft2" => array("base" => "kgm2", "conversion" => 23.73037976),

    "kgm" => array("base" => "kgm", "conversion" => 1),
    "gmm" => array("base" => "kgm", "conversion" => 0.000001),
    "ozin" => array("base" => "kgm", "conversion" => 1388.740542),
    "lbin" => array("base" => "kgm", "conversion" => 86.79628389),
);