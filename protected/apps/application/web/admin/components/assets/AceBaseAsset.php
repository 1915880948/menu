<?php
/**
 * @category AceBaseAsset
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/5/4 15:50
 * @since
 */
namespace application\web\admin\components\assets;

use yii\web\AssetBundle;

/**
 * Class AceBaseAsset
 * @package application\web\admin\components\assets
 */
class AceBaseAsset extends AssetBundle
{
    public $baseUrl = '@webstatic';
    public $css     = [
        'vendor/ace/assets/css/google-fonts.css',
        'vendor/ace/assets/css/ace.min.css',
        'vendor/ace/assets/css/ace-rtl.min.css',
        'vendor/ace/assets/css/ace-skins.min.css',
    ];
    public $js = [
        'vendor/ace/assets/js/ace-extra.min.js',
    ];
}
