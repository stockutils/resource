<?php

/** @var Router $router */
use Minute\Model\Permission;
use Minute\Routing\Router;

$router->get('/admin/stock/resources', null, 'admin', 'm_configs[type] as configs')
       ->setReadPermission('configs', 'admin')->setDefault('type', 'resource');
$router->post('/admin/stock/resources', null, 'admin', 'm_configs as configs')
       ->setAllPermissions('configs', 'admin');

$router->get('/stock/resource/info', 'Stock/Resource/Info', false)->setDefault('_noView', true);
$router->get('/stock/resources/{type}', 'Stock/Resource/Listing', false)->setDefault('_noView', true);

$router->get('/stock/resource/get/(.*)', 'Stock/Resource/S3Redirect', false)->setDefault('_noView', true);