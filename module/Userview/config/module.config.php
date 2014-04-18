<?php 
	return array(
    'controllers' => array(
        'invokables' => array(
            'UserView\Controller\UserView' => 'UserView\Controller\UserViewController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'userview' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/userview[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'UserView\Controller\UserView',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'userview' => __DIR__ . '/../view',
        ),
    ),
);
 ?>