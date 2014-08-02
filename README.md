Swix Event Manager config
==============
Zend Framework 2 module which provides possibility to attach event listeners and aggregates to SharedEventManager via configuration.

Installation
--------------
Add this line to your composer `require` key: `"swix/swix-em-config": "dev-master"` and update Composer. Then enable `SwixEmConfig` module in your application config.

Example
--------------
In yout application or module config:
```php
<?php
use Zend\ModuleManager\ModuleEvent;

return [
    'service_manager' =>  [
        'invokables' => [
            'SomeAggregate' => 'SomeNamespaces\SomeAggregate',
            'LoadModulesPostListener' => 'SomeNamespaces\LoadModulesPostListener'
        ]
    ],
    'event_manager' => [
        'listeners' => [
            ['event' => ModuleEvent::EVENT_LOAD_MODULES_POST, 'listener' => 'LoadModulesPostListener']
        ],
        'aggregates' => [
            ['aggregate' => 'SomeAggregate']
        ]
    ]
]
```
