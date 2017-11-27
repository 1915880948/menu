<?php
/**
 * @category UploadWidget
 * @author   gouki <gouki.xiao@gmail.com>
 * @created  15/4/8 下午3:05
 * @since
 */
namespace common\assets\widgets;

use yii\base\Widget;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\web\UploadedFile;

/**
 * Class UploadWidget
 *
 * @package common\base\widgets
 */
class UploadWidget extends Widget
{
    public $savepath  = "@uploads";
    public $modePath  = "attachments";
    public $fieldname = 'imgFile';

    public function run()
    {
        $file = UploadedFile::getInstanceByName($this->fieldname);
        if(!$file){
            return UPLOAD_ERR_NO_FILE;
        }
        //@file_put_contents(\Yii::getAlias("@root/upload.log"),var_export($file,true),FILE_APPEND);
        if($file->hasError){
            return $file->error;
        }
        $basePath = \Yii::getAlias($this->savepath);
        $date = date("Y/m/d", $_SERVER['REQUEST_TIME']);
        $uploadPath = "{$this->modePath}/{$date}";
        if(!is_dir($basePath . "/" . $uploadPath)){
            FileHelper::createDirectory($basePath . "/" . $uploadPath);
        }
        $filemd5 = md5_file($file->tempName);
        if(($extension = $file->getExtension()) != ""){
            $filename = $filemd5 . "." . $extension;
        } else{
            $extension = FileHelper::getExtensionsByMimeType(FileHelper::getMimeType($file->tempName));

            if($extension){
                $filename = $filemd5 . "." . $extension[0];
            } else{
                return UPLOAD_ERR_EXTENSION;
            }
        }
        // if (preg_match('/(\.[\S\s]+)$/', $file->name, $match)) {
        //     $filename = md5(uniqid(rand())).$match[1];
        // } else {
        //     $filename = $file->name;;
        // }
        $savedName = $basePath . '/' . $uploadPath . '/' . $filename;
        if($file->saveAs($savedName)){
            $files = (array) $file;
            $files['savename'] = "/" . $uploadPath . '/' . $filename;
            $files['savepath'] = $uploadPath;
            $files['filemd5'] = $filemd5;

            return Json::encode($files);
        }

        return $file->error;
    }
}
