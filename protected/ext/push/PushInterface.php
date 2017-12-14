<?php
/**
 * @category SimpleImPushBase
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 2017/10/2 17:16
 * @since
 */

namespace push;

interface PushInterface
{
    /**
     * @param        $title
     * @param        $msg
     * @param string $info
     * @return string
     */
    public static function toData($title, $msg, $info = '');
}
