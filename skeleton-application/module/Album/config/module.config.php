<?php
namespace Album;

use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'controllers' => [
        'factories' => [
            Controller\AlbumController::class => function($container){
                return new Controller\AlbumController($container);
            },
        ],
    ],

    // The following section is new and should be added to your file:
    'router' => [
        'routes' => [
            'album' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/album[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\AlbumController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml'
        ],
        'template_path_stack' => [
            'album' => __DIR__ . '/../view',
        ],
    ],

    //configuração do doctrine
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
              'class' =>  
                  'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                  'cache' => 'array',
                  'paths' => [
                      __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'
            ]
        ],
        'orm_default' => [
            'drivers' => [
                __NAMESPACE__ .'\\'.__NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
        ]
       ]
      ]
    ],
];