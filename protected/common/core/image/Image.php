<?php
/**
 * @category Image
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/6/17 11:17
 * @since
 */
namespace common\core\image;

/**
 * Class Image
 * @package common\core\image
 */
class Image
{
    public static function url($path)
    {
        return \Yii::getAlias("@webuploads") . $path;
    }
}
