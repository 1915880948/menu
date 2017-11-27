<?php
/**
 * @category AceAsset
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/5/4 15:52
 * @since
 */
namespace application\web\admin\components\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Class AceAsset
 * @package application\web\admin\components\assets
 */
class AceAsset extends AssetBundle
{
    public $baseUrl    = '@webstatic';
    public $css        = [
        'vendor/ace/assets/css/ace-ie.min.css',
    ];
    public $cssOptions = [
        'condition' => 'lte IE 8',
    ];
    public $js        = [
        'vendor/ace/assets/js/html5shiv.js',
        'vendor/ace/assets/js/respond.min.js',
    ];
    public $jsOptions = [
        'condition' => 'lte IE 9',
        'position'  => View::POS_HEAD
    ];
    public $depends = [
        'application\web\admin\components\assets\AceBaseAsset',
    ];
}
