<?php
/**
 * @category QiniuUploadAsset
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 2016/10/16 19:31
 * @since
 */
namespace application\web\admin\components\assets;

use yii\web\AssetBundle;

/**
 * Class QiniuUploadAsset
 * @package application\web\admin\components\assets
 */
class QiniuUploadAsset extends AssetBundle
{
    public $baseUrl = '@webstatic';
    public $js = [
        'plupload/plupload.full.min.js',
        // 'plupload/moxie.js',
        // 'plupload/plupload.dev.js',
        'plupload/progress.js',
        'vendor/qiniu/qiniu.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
