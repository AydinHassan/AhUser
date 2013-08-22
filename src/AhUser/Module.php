<?php

namespace AhUser;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\DependencyIndicatorInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

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
    public function onBootstrap(MvcEvent $e) 
    {
        $sm             = $e->getApplication()->getServiceManager();
        $entityManager  = $sm->get('Doctrine\ORM\EntityManager');
        
        /* Attatch to register event and give the user the 'user' role */
        $zfcServiceEvents = $sm->get('zfcuser_user_service')->getEventManager();
        $zfcServiceEvents->attach('register.post', function($e) use ($entityManager) {
            $user           = $e->getParam('user');  
            $userRole       = $entityManager->getRepository('AhUser\Entity\Role')->findOneBy(array('roleId' => 'user'));
            
            //give the user the 'user' role
            $user->addRole($userRole);
            $entityManager->flush();
        });
        
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $events = $eventManager->getSharedManager();
        
        /** Add elements to ZfcUser Registration form */
        $events->attach('ZfcUser\Form\Register', 'init', function($e) {
            $form = $e->getTarget();
            
            $form->add(array(
                'type'    => 'Zend\Form\Element\Text',
                'name'    => 'firstName',
                'options' => array(
                    'label' => 'First Name',
                ),
                'attributes' => array(
                    'required'  => 'required',
                )
            ));

            $form->add(array(
                'type'    => 'Zend\Form\Element\Text',
                'name'    => 'lastName',
                'options' => array(
                    'label' => 'Last Name',
                ),
                'attributes' => array(
                    'required'  => 'required',
                )
            ));
        });
        
        /** Add Filters & Validator Elements to ZfcUser Registration Form */ 
        $events->attach('ZfcUser\Form\RegisterFilter', 'init', function($e) {
            $filter = $e->getTarget();
            
            //Filters & Validators
            $stringFilters = array(array('name' => 'StripTags'), array('name' => 'StringTrim'));
            $standardStringValidators = array(array(
                'name'    => 'StringLength',
                'options' => array(
                    'encoding' => 'UTF-8',
                    'min'      => 3,
                    'max'      => 50,
                ),
            ));
            
            $filter->add(array(
                'name'          => 'firstName',
                'required'      => true,
                'validators'    => $standardStringValidators,
                'filters'       => $stringFilters,
            ));
            
            $filter->add(array(
                'name'          => 'lastName',
                'required'      => true,
                'validators'    => $standardStringValidators,
                'filters'       => $stringFilters,
            ));
        });
    }
    
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