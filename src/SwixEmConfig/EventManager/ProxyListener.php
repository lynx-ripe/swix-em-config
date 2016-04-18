<?php

namespace SwixEmConfig\EventManager;

use Zend\EventManager\EventInterface;
use Zend\ServiceManager;

/**
 * Class ProxyListener
 *
 * @package SwixEmConfig\EventManager
 */
class ProxyListener implements ServiceManager\ServiceLocatorAwareInterface
{
    use ServiceManager\ServiceLocatorAwareTrait;

    /**
     * @var string
     */
    protected $listener;

    /**
     * @param string $listener
     */
    public function __construct($listener)
    {
        $this->listener = $listener;
    }

    /**
     * @param EventInterface $event
     * @return mixed
     */
    public function __invoke(EventInterface $event)
    {
        $serviceLocator = $this->getServiceLocator();
        $listener = null;

        if ($serviceLocator->has($this->listener)) {
            $listener = $serviceLocator->get($this->listener);
        } elseif (class_exists($this->listener)) {
            $listener = new $this->listener;
        }

        return $listener ? $listener->__invoke($event) : null;
    }
}
