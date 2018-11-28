<?php

Yii::setAlias('@results', realpath(dirname(__FILE__).'/../web/uploads/results/'));
$paginationParams = [
    'pageParam',
    'pageSizeParam',
    'params',
    'totalCount',
    'defaultPageSize',
    'pageSizeLimit'
];

return [
    'name' => 'DYN Technologies',
    'frontendURL' => 'http://localhost/frontend/',
    'backendURL' => 'http://localhost/backend/',

    'adminEmail' => 'eduardo@dyntechnologies.com.br',
    'supportEmail' => 'brunoscholz@yahoo.de',
    'contactEmail' => 'contact@dyntechnologies.com.br',

    'jwtSecretCode' => 'someSecretKey',
    'user.passwordResetTokenExpire' => 3600,
    'paginationParams' => $paginationParams,
    'ratio' => 1000,

    'expireDepositPeriod' => 60 * 60 * 24 * 1, // Expire deposits period, add in seconds! 1 day: 60 * 60 * 24 * 1
    'payPassword' => "", // Password to get from cron pay methods
    'autoPay' => true, // Pay for deposits automatically
    'partnerPercent' => 0.1, // Pay to partners
    'BTC_IPN_PASSWORD'=>'', // Your IPN password to use a params in notification urls
    'BTC_GUID'=>'', // GUID of blockchain, for example: 9b0e0bf9-28fd-43b7-b743-895f49c594f3
    'BTC_PASSWORD'=>'', // Password of blockchain account
    'BTC_SECOND_PASSWORD'=>'', // second password, don't use this param in this application
];
