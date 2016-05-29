<?php
namespace Product;

use Zend\Crypt\Password\Bcrypt;

return array(
    'doctrine' => array(
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
    'controllers' => array(
         'invokables' => array(
             'Product\Controller\Product' => 'Product\Controller\ProductController', 
         )
     ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'router' => array(
        'routes' => array(
            'product' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/product[/:action[/:id]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Product\Controller\Product',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
);
