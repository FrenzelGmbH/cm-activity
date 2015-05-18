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
];
```

## Data Structure
