<?php
/**
 * @category PushTraits
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 2017/10/2 17:39
 * @since
 */

namespace push;

use GuzzleHttp\Client;
use yii\helpers\ArrayHelper;

trait PushTraits
{
    public static function xSend($channel, $title, $msg, $info = '')
    {
        $client = new Client();
        $client->request('POST', self::getChannelUrl($channel), [
            'body'    => self::toData($title, $msg, $info),
            'headers' => ['Content-Type' => 'application/json']
        ]);
    }

    protected static function getChannelUrl($channel)
    {
        return ArrayHelper::getValue(self::$channels, $channel, self::$channels['default']);
    }
}
