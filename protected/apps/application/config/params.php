<?php
/**
 * @category params.php
 * @author   gouki <gouki.xiao@gmail.com>
 * @created  6/24/15 10:22
 * @since
 */

return [
    /**
     * cookie settings
     */
    'cookie'  => [
        'domain' => env('COOKIE_DOMAIN'),
        'path'   => '/',
        'expire' => 86400 * 30
    ],
    'message' => [
        'layout'   => 'main-blank',
        'template' => '../layouts/message',
    ],
    'cache'   => [
        'expire' => 86400
    ],
    'pager'   => [
        'site' => [
            'index'   => 50,
            'list'    => 50,
            'comment' => 50,
        ],
    ],
    'wechat'  => [
        'debug'   => true,
        //小菜谱
        // 'app_id'  => 'wx5c6d42cbabf785aa',
        // 'secret'  => 'f8aa37de38cdfb93e23affb9b063953a',
        // 'token'   => 'wx6436c832cc5e5df6',
        // 'aes_key' => '',
        //优本科技
        'app_id'  => 'wxfaeaf536b3ccaccc',
        'secret'  => 'a39c7e21027845fc800991ef0e187bca',
        'token'   => 'V9hQMiP2TKpaRP',
        'aes_key' => 'L9h2kBa9WlDzY9ZLysfn5UvNDAM7gqTyfBUgbTdrbSb',

    ]
];

