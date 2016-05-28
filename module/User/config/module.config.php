<?php
namespace User;

use Zend\Crypt\Password\Bcrypt;

return array(
    'doctrine' => array(
        'authentication' => array(
            'orm_default' => array(
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'User\Entity\Users',
                'identity_property' => 'u_mobile_phone,u_email',
                'credential_property' => 'u_password',
                'credential_callable' => function(Entity\Users $user, $passwordGiven) {
                    $bcrypt = new Bcrypt();
                    $result = $bcrypt->verify($passwordGiven, $user->getUPassword());
                    return $result;
                },
            ),
        ),
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ),
            ),
        ),
    ),

    'doctrine_factories' => array(
        'authenticationadapter' => 'User\Auth\AdapterFactory',
    ),

    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
            'User\Mapper\UserMapperInterface' => 'User\Factory\ZendDbSqlMapperFactory',
            'User\Service\UserServiceInterface' => 'User\Factory\UserServiceFactory',
            'Zend\Authentication\AuthenticationService' => function($serviceManager) {
                return $serviceManager->get('doctrine.authenticationservice.orm_default');
            },
        ),
    ),
    'controllers' => array(
         'factories' => array(
             'User\Controller\User' => 'User\Factory\UserControllerFactory', 
         )
     ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'router' => array(
        'routes' => array(
            'user' => array(
                'type' => 'Literal',
                'priority' => 10000,
                'options' => array(
                    'route' => '/user',
                    'defaults' => array(
                        'controller' => 'User\Controller\User',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'login' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/login',
                            'defaults' => array(
                                'controller' => 'User\Controller\User',
                                'action' => 'login',
                            ),
                        ),
                    ),
                    'edit' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/edit[/:id]',
                            'constraints' => array(
                                'id' => '[0-9]+'
                            ),
                            'defaults' => array(
                                'controller' => 'User\Controller\User',
                                'action' => 'edit',
                            ),
                        ),
                    ),
                    'authenticate' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/authenticate',
                            'defaults' => array(
                                'controller' => 'User\Controller\User',
                                'action' => 'authenticate',
                            ),
                        ),
                    ),
                    'logout' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/logout',
                            'defaults' => array(
                                'controller' => 'User\Controller\User',
                                'action' => 'logout',
                            ),
                        ),
                    ),
                    'register' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/register/:account_type/:register_type',
                            'constraints' => array(
                                'account_type' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'register_type' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'User\Controller\User',
                                'action' => 'register',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
