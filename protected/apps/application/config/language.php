<?php
/**
 * Configuration file for 'yii message/extract' command.
 * This file is automatically generated by 'yii message/config' command.
 * It contains parameters for source code messages extraction.
 * You may modify this file to suit your needs.
 * You can use 'yii message/config-template' command to create
 * template configuration file with detailed description for each parameter.
 */
return [
    'color'            => null,
    'interactive'      => true,
    'help'             => null,
    'sourcePath'       => '@application',
    'messagePath'      => '@application/messages',
    'languages'        => ['zh-CN', 'en'],
    'translator'       => ['Yii::t', 'yt'],
    'sort'             => false,
    'overwrite'        => true,
    'removeUnused'     => false,
    'markUnused'       => true,
    'except'           => [
        '.svn',
        '.git',
        '.gitignore',
        '.gitkeep',
        '.hgignore',
        '.hgkeep',
        '/messages',
        '/BaseYii.php',
    ],
    'only'             => [
        '*.php',
        '*.blade.php',
    ],
    'format'           => 'php',
    'ignoreCategories' => [],
];
