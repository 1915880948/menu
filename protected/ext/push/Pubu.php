<?php
/**
 * @category Pubu
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 2017/10/2 17:15
 * @since
 */

namespace push;

use yii\helpers\Json;

class Pubu implements PushInterface
{
    use PushTraits;
    public static $channels = [
        'db'      => 'https://hooks.pubu.im/services/zvx3m4pkl77df2y',
        'web'     => 'https://hooks.pubu.im/services/n2eb13pev8vqur7',
        'default' => 'https://hooks.pubu.im/services/7yrxd87nq44rh1n',
    ];

    /**
     * @param        $title
     * @param        $msg
     * @param string $info
     * @return string
     */
    public static function toData($title, $msg, $info = '')
    {
        return Json::encode([
            'text'        => $title,
            'attachments' => [
                [
                    'title'       => $title,
                    'description' => is_string($msg) ? $msg : json_encode($msg, JSON_UNESCAPED_UNICODE),
                ]
            ]
        ]);
    }
}
