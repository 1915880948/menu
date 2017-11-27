<?php
/**
 * @category ${NAME}
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 2017/8/14 00:31
 * @since
 */
/**
 * @param $url
 * @return bool|string
 */
function gStatic($url)
{
    $url = ltrim($url, '/');
    return Yii::getAlias("@webstatic/{$url}");
}
