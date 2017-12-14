<?php
/**
 * @category FileHelper
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 2016/8/29 00:27
 * @since
 */
namespace qiqi\helper;

/**
 * Class FileHelper
 * @package qiqi\helper
 */
class FileHelper extends \yii\helpers\FileHelper
{
    /**
     * 将字节数转成相应的kb或者mb等
     * @param $size
     * @return string
     */
    static public function convertSize($size)
    {
        $unit = ['b', 'kb', 'mb', 'gb', 'tb', 'pb'];
        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
    }
}
