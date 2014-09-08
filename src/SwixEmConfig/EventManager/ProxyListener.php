<?php

namespace SwixEmConfig\EventManager;

use Zend\EventManager\EventInterface;
use Zend\ServiceManager\ServiceManager;

/**
 * Class ProxyListener
 * @package SwixEmConfig\EventManager
 */
class ProxyListener
{
    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * @var string
     */
    protected $listener;

    /**
     * @param ServiceManager $serviceManager
     * @param string $listener
     */
    public function __construct(ServiceManager $serviceManager, $listener)
    {
        $this->serviceManager = $serviceManager;
        $this->listener = $listener;
    }

    /**
     * @param EventInterface $event
     * @return mixed
     */
    public function __invoke(EventInterface $event)
    {
        return $this->serviceManager->get($this->listener)->__invoke($event);
    }
}