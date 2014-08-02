<?php

namespace SwixEmConfig;

use Zend\ModuleManager\Feature\InitProviderInterface;
use Zend\ModuleManager\ModuleEvent;
use Zend\ModuleManager\ModuleManagerInterface;

/**
 * Class Module
 *
 * @package SwixEmConfig
 */
class Module implements InitProviderInterface
{
    /**
     * Initialize workflow
     *
     * @param  ModuleManagerInterface $manager
     * @return void
     */
    public function init(ModuleManagerInterface $manager)
    {
        $manager->getEventManager()->getSharedManager()->attach(
            '*',
            ModuleEvent::EVENT_MERGE_CONFIG,
            new EventManager\MergeConfigListener
        );
    }
}