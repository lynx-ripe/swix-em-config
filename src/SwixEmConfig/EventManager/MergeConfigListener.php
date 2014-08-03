<?php

namespace SwixEmConfig\EventManager;

use Zend\EventManager\SharedEventManager;
use Zend\ModuleManager\ModuleEvent;
use Zend\ServiceManager\ServiceManager;

/**
 * Class MergeConfigListener
 *
 * @package SwixEmConfig\EventManager
 */
class MergeConfigListener
{
    /**
     * Attach event listeners from 'event_manager' config section.
     * Provides easy way to attach listeners via SharedEventManager.
     * MergeConfig event is earliest place where we can get merged
     * configs and attach system events.
     *
     * @param ModuleEvent $event
     */
    public function __invoke(ModuleEvent $event)
    {
        /**
         * @var ServiceManager     $serviceManager
         * @var SharedEventManager $sem
         */
        $serviceManager = $event->getParam('ServiceManager');
        $sem = $event->getTarget()->getEventManager()->getSharedManager();
        $config = $event->getConfigListener()->getMergedConfig(false);

        if (!isset($config['event_manager'])) {
            return;
        }

        if (isset($config['event_manager']['listeners'])) {
            foreach ($config['event_manager']['listeners'] as $listener) {
                // by default attach to any target
                $listener['id'] = isset($listener['id']) ? $listener['id'] : '*';
                // by default use standard priority is 1
                $listener['priority'] = isset($listener['priority']) ? $listener['priority'] : 1;

                $sem->attach(
                    $listener['id'],
                    $listener['event'],
                    function () use ($serviceManager, $listener) {
                        return $serviceManager->get($listener['listener']);
                    }
                );
            }
        }

        if (isset($config['event_manager']['aggregates'])) {
            foreach ($config['event_manager']['aggregates'] as $aggregate) {
                $sem->attachAggregate(
                    function () use ($serviceManager, $aggregate) {
                        return $serviceManager->get($aggregate['aggregate']);
                    },
                    isset($aggregate['priority']) ? $aggregate['priority'] : 1
                );
            }
        }
    }
}
