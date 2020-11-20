<?php
return [
    'backend' => [
        'frontName' => 'admin_lbn1wy'
    ],
    'queue' => [
        'consumers_wait_for_messages' => 1
    ],
    'crypt' => [
        'key' => 'a5370632376f58b2b600285b4c2d538f'
    ],
    'db' => [
        'table_prefix' => '',
        'connection' => [
            'default' => [
                'host' => 'localhost',
                'dbname' => 'magento',
                'username' => 'root',
                'password' => 'Urabus92078#',
                'model' => 'mysql4',
                'engine' => 'innodb',
                'initStatements' => 'SET NAMES utf8;',
                'active' => '1',
                'driver_options' => [
                    1014 => false
                ]
            ]
        ]
    ],
    'resource' => [
        'default_setup' => [
            'connection' => 'default'
        ]
    ],
    'x-frame-options' => 'SAMEORIGIN',
    'MAGE_MODE' => 'default',
    'session' => [
        'save' => 'files'
    ],
    'cache' => [
        'frontend' => [
            'default' => [
                'id_prefix' => '3df_'
            ],
            'page_cache' => [
                'id_prefix' => '3df_'
            ]
        ],
        'allow_parallel_generation' => false
    ],
    'lock' => [
        'provider' => 'db',
        'config' => [
            'prefix' => null
        ]
    ],
    'directories' => [
        'document_root_is_pub' => false
    ],
    'cache_types' => [
        'config' => 0,
        'layout' => 1,
        'block_html' => 1,
        'collections' => 0,
        'reflection' => 0,
        'db_ddl' => 0,
        'compiled_config' => 0,
        'eav' => 0,
        'customer_notification' => 0,
        'config_integration' => 0,
        'config_integration_api' => 0,
        'full_page' => 1,
        'config_webservice' => 0,
        'translate' => 0,
        'vertex' => 0
    ],
    'downloadable_domains' => [
        'james.magento2.local'
    ],
    'install' => [
        'date' => 'Wed, 04 Nov 2020 11:28:19 +0000'
    ]
];
