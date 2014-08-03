Swix Event Manager config
==============
Zend Framework 2 module which provides possibility to attach event listeners and aggregates to SharedEventManager via configuration.

Installation
--------------
Add this line to your composer `require` key: `"swix/swix-em-config": "dev-master"` and update Composer. Then enable `SwixEmConfig` module in your application config.

Important note
--------------
Event listeners can be attached only after loading of all modules (ModuleEvent::EVENT_LOAD_MODULES_POST)

Example
--------------
In yout application or module config:
```php
<?php
use Zend\Mvc\MvcEvent;

return [
    'service_manager' =>  [
        'invokables' => [
            'SomeAggregate' => 'SomeNamespaces\SomeAggregate',
            'BootstrapListener' => 'SomeNamespaces\BootstrapListener'
        ]
    ],
    'event_manager' => [
        'listeners' => [
            ['event' => MvcEvent::EVENT_BOOTSTRAP, 'listener' => 'BootstrapListener']
        ],
        'aggregates' => [
            ['aggregate' => 'SomeAggregate']
        ]
    ]
]
```
