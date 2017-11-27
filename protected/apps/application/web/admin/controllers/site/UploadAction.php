<?php
/**
 * @category UploadAction
 * @author   gouki <gouki.xiao@gmail.com>
 * @created  15/7/31 00:15
 * @since
 */
namespace application\web\admin\controllers\site;

use application\web\admin\components\AdminBaseAction;
use application\common\base\Attachments;
use common\assets\widgets\UploadWidget;
use yii\helpers\Json;

/**
 * Class UploadAction
 * @package backend\controllers\site
 */
class UploadAction extends AdminBaseAction
{
    public $responseType = 'json';

    /**
     * @param string $type
     * @param int $full
     * @return array
     * @throws \Exception
     */
    public function run($type = 'image', $full = 0)
    {
        $mode = Attachments::getInstance()
                           ->getSaveMode($type);
        $file = UploadWidget::widget([
            'savepath'  => '@uploads',
            'fieldname' => 'imgFile',
            'modePath'  => $mode,
        ]);

        if(!is_int($file) && !is_numeric($file)){
            $file = json_decode($file);
            $path = $file->savename;
            if($full){
                $path = \Yii::getAlias("@webuploads/{$path}");
            }

            return ['error' => 0, 'url' => $path];
        }

        $errinfo = [
            UPLOAD_ERR_INI_SIZE   => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
            UPLOAD_ERR_FORM_SIZE  => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
            UPLOAD_ERR_PARTIAL    => 'The uploaded file was only partially uploaded.',
            UPLOAD_ERR_NO_FILE    => 'No file was uploaded.',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder. Introduced in PHP 5.0.3.',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk. Introduced in PHP 5.1.0.',
            UPLOAD_ERR_EXTENSION  => 'A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop; examining the list of loaded extensions with phpinfo() may help. Introduced in PHP 5.2.0.'
        ];
        return ['error' => 1, 'msg' => $errinfo[$file]];
    }

    public function run2($type = 'image', $full = 0)
    {
        $mode = Attachments::getInstance()
                           ->getSaveMode($type);
        $file = UploadWidget::widget([
            'savepath'  => '@uploads',
            'fieldname' => 'imgFile',
            'modePath'  => $mode,
        ]);

        if(!is_int($file) && !is_numeric($file)){
            $file = json_decode($file);
            $filemd5 = $file->filemd5;
            /**
             * check file
             */
            $uploadInfo = CmsAttach::find()
                                   ->where(['filemd5' => $filemd5])
                                   ->one();
            if(!$uploadInfo){
                $uploadInfo = new CmsAttach();
                /**
                 *  * @property integer $attachmentid
                 * @property integer $articleid
                 * @property integer $dateline
                 * @property string $filename
                 * @property string $filetype
                 * @property integer $filesize
                 * @property integer $downloads
                 * @property string $filepath
                 * @property string $thumb_filepath
                 * @property integer $thumb_width
                 * @property integer $thumb_height
                 * @property integer $isimage
                 */
                $uploadInfo->setAttributes([
                    'downloads'  => 0,
                    'filemd5'    => $file->filemd5,
                    'filetype'   => $file->type,
                    'filename'   => basename($file->savename),
                    'filesize'   => $file->size,
                    'filepath'   => $file->savename,
                    'ref_counts' => 1,
                    'isimage'    => 1,
                    'dateline'   => time(),
                ]);
                if(!$uploadInfo->save()){
                    return [
                        'error' => 1,
                        'msg'   => Json::encode($uploadInfo->getErrors()),
                    ];
                }
            } else{
                $savedPath = Attachments::getInstance()
                                        ->getSavedPath($type, $uploadInfo->filepath);
                $tmpfile = Attachments::getInstance()
                                      ->getSavedPath($type, $file->savename);
                if(!file_exists($savedPath)){
                    @rename($tmpfile, $savedPath);
                    $uploadInfo->ref_counts += 1;
                    $uploadInfo->save();
                } else{
                    @unlink($tmpfile);
                    //@unlink($savedPath);//如果我返回的是已经有的，就删除本次上传图片
                }
            }
            $path = $uploadInfo->filepath;
            if($full){
                $path = \Yii::getAlias("@webuploads/{$path}");
            }

            return ['error' => 0, 'url' => $path];
        } else{
            $errinfo = [
                UPLOAD_ERR_INI_SIZE   => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
                UPLOAD_ERR_FORM_SIZE  => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
                UPLOAD_ERR_PARTIAL    => 'The uploaded file was only partially uploaded.',
                UPLOAD_ERR_NO_FILE    => 'No file was uploaded.',
                UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder. Introduced in PHP 5.0.3.',
                UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk. Introduced in PHP 5.1.0.',
                UPLOAD_ERR_EXTENSION  => 'A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop; examining the list of loaded extensions with phpinfo() may help. Introduced in PHP 5.2.0.'
            ];
            return ['error' => 1, 'msg' => $errinfo[$file]];
        }
    }
}
