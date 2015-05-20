# Common Activity Module

This module manages all kind of activities that are assigned to a module and id.

## Installation

Add in 'composer.json':
```
{
    "require": {
        "frenzelgmbh/cm-activity": "*" 
    }
}
```

Pls. ensure that you add the dateControlOptions into the params section of your config

In config '/protected/config/main.php'
```php
<?php
return [
    // ...
    'modules' => [
        // ...
        'activity' => [
            'class' => 'net\frenzel\activity\Module',
            'userIdentityClass' => 'app\models\User',
        ]
    ],
    // ... //
    'params' => [
        // format settings for displaying each date attribute
        'dateControlDisplay' => [
            DateModule::FORMAT_DATE => 'php:d.m.Y',
            DateModule::FORMAT_TIME => 'php:H:i:s A',
            DateModule::FORMAT_DATETIME => 'php:d.m.Y H:i:s A',
        ],
        // format settings for saving each date attribute
        'dateControlSave' => [
            DateModule::FORMAT_DATE => 'php:U',
            DateModule::FORMAT_TIME => 'php:H:i:s',
            DateModule::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
        ],
    ]
];
```

## Data Structure
