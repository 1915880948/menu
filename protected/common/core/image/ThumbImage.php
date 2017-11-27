<?php
/**
 * @category ThumbImage
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/6/17 11:19
 * @since
 */
namespace common\core\image;

use yii\helpers\Url;

/**
 * Class ThumbImage
 * @package common\core\image
 */
class ThumbImage extends Image
{
    public static $virtualDir = "thumb";
    public static $blankFile  = '';

    public static function thumb($file, $group)
    {
        if(!$file){
            return Url::to(\Yii::getAlias("@webthumb") . "/assets/error.png");
        }

        if(strpos($file, "http") !== false){
            return Url::to($file);
        }
        return \Yii::getAlias("@webthumb") . sprintf("/%s/%s", self::$virtualDir, $group) . $file;
    }

    public static function options($file, $options = [])
    {
        if(!$file){
            return false;
        }
        if(!$options){
            return $file;
        }
        //取得文件名
        $fileinfo = pathinfo($file);
        if(strtolower($fileinfo['extension']) == "webp"){
            return self::url($file);
        }
        ksort($options);
        $params = [];
        foreach($options as $k => $item){
            $params[] = sprintf("%s_%s", $k, $item);
        }
        return sprintf("%s/%s,%s.%s", $fileinfo['dirname'], $fileinfo['filename'], join(",", $params), $fileinfo['extension']);
    }
}
