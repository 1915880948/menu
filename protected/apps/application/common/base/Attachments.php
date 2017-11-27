<?php
/**
 * @category Attachments
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/5/4 17:40
 * @since
 */
namespace application\common\base;

use qiqi\helper\base\InstanceTrait;
use yii\base\Object;

/**
 * Class Attachments
 * @package application\common\base
 */
class Attachments extends Object
{
    use InstanceTrait;
    public $savetype = [
        'image'   => 'image',
        'audio'   => 'audio',
        'default' => 'default',
    ];

    public function getSavedPath($mode, $file)
    {
        $mode = strtolower($mode);
        if($mode == 'image'){
            return $this->getImageSavedPath($file);
        }
        if($mode == "audio"){
            return $this->getAudioSavedPath($file);
        }
        return "";
    }

    public function getImageUrl($file)
    {
        if(strncasecmp(ltrim($file, "/"), $this->savetype['image'], strlen($this->savetype['image'])) == 0){
            return \Yii::getAlias("@webuploads/" . ltrim($file, "/"));
        }

        return "";
    }

    public function getImageSavedPath($file)
    {
        if(strncasecmp(ltrim($file, "/"), $this->savetype['image'], strlen($this->savetype['image'])) == 0){
            return \Yii::getAlias("@uploads/" . ltrim($file, "/"));
        }

        return "";
    }

    public function getAudioUrl($file)
    {
        if(strncasecmp(ltrim($file, "/"), $this->savetype['audio'], strlen($this->savetype['audio'])) == 0){
            return \Yii::getAlias("@webuploads/" . ltrim($file, "/"));
        }

        return "";
    }

    public function getAudioSavedPath($file)
    {
        if(strncasecmp(ltrim($file, "/"), $this->savetype['audio'], strlen($this->savetype['audio'])) == 0){
            return \Yii::getAlias("@uploads/" . ltrim($file, "/"));
        }

        return "";
    }

    public function getSaveMode($type)
    {
        if(!isset($this->savetype[$type])){
            $type = 'default';
        }

        return $this->savetype[$type];
    }
}
