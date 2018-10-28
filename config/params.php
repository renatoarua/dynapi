<?php

Yii::setAlias('@results', realpath(dirname(__FILE__).'/../web/uploads/results/'));

return [
    'frontendURL'   => 'http://localhost:4201/',
    'supportEmail'  =>  'admin@example.com',
    'adminEmail'    => 'admin@example.com',
    'jwtSecretCode' =>  'someSecretKey',
    'user.passwordResetTokenExpire' => 3600,
    'ratio' => 1000,
];
