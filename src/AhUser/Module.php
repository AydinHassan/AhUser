<?php

namespace AhUser;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\DependencyIndicatorInterface;

/**
 * AhUser Module
 * 
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class Module implements 
    ConfigProviderInterface,
    AutoloaderProviderInterface,
    DependencyIndicatorInterface 
{
    
    /**
     * {@inheritDoc}
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }
 
    /**
     * {@inheritDoc}
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/../../src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    /**
     * {@inheritDoc}
     */
    public function getModuleDependencies() {
        return array(
            'DoctrineModule',
            'DoctrineORMModule',
            'ZfcBase',
            'ZfcUser',
            'ZfcUserDoctrineORM',
            'BjyAuthorize',
        );
    }
}