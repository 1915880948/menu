<?php
/**
 * @category Weixin
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 2017/6/10 09:37
 * @since
 */

namespace wechat;

use EasyWeChat\Foundation\Application;

/**
 * Class Weixin
 * @package wechat
 */
class Weixin
{
    /**
     * @return Application
     */
    public static function getApp()
    {
        return new Application(self::getOptions());
    }

    protected static function getOptions()
    {
        return [
            'debug'   => env('WECHAT_DEBUG'),
            'app_id'  => env('WECHAT_APP_KEY'),
            'secret'  => env('WECHAT_APP_SECRET'),
            'token'   => env('WECHAT_APP_TOKEN'),
            'aes_key' => env('WECHAT_AES_KEY'), // 可选
            'log'     => [
                'level' => 'debug',
                'file'  => sys_get_temp_dir() . '/easywechat.log', // XXX: 绝对路径！！！！
            ],

        ];
    }
}
