<?php
return [
    'app' => [
        'debug'                => 0,
        'source_path'          => dirname(__DIR__) . '/uploads',
        'system_file_encoding' => 'UTF-8',
        'default_image'        => '',
        '404_image'            => __DIR__ . 'assets/404.jpg',
        'max_width'            => 1600,
        'max_height'           => 1000,
        'quality'              => 100,

        'allow_extensions' => [],

        'class_separator' => '!',
        'classes'         => [
            'cover' => 'w_120,h_200'
        ]
    ],
];
