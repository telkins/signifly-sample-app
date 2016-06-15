<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterServiceFactory;

return [
     'db' => [
        'driver'   => 'pdo_mysql',
        'charset'  => 'utf8mb4',
        'driver_options' => [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'utf8mb4\'',
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET CHARACTER SET \'utf8mb4\'',
            PDO::ATTR_EMULATE_PREPARES => false,
        ],
     ],
     'service_manager' => [
         'factories' => [
             Adapter::class => AdapterServiceFactory::class,
         ],
     ],
];
