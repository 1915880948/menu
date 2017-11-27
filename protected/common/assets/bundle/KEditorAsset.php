<?php
/**
 * @category KEditorAsset
 * @author   gouki <gouki.xiao@gmail.com>
 * @created  14/12/22 11:24
 * @since
 */

namespace common\assets\bundle ;

use yii\web\AssetBundle;

/**
 * Class KEditorAsset
 * @package common\base\bundle
 */
class KEditorAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@webstatic';
    public $css = [
        'vendor/kindeditor/themes/default/default.css'
    ];
    public $js = [
        'vendor/kindeditor/kindeditor-all-min.js',
        'vendor/kindeditor/lang/zh-CN.js',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}

