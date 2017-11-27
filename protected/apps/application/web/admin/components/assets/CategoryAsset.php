<?php
/**
 * @category CategoryAsset
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/5/4 15:23
 * @since
 */
namespace application\web\admin\components\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Class CategoryAsset
 * @package application\web\admin\components\assets
 */
class CategoryAsset extends AssetBundle
{
    public $basePath   = '@webroot';
    public $baseUrl    = '@webstatic';
    public $css        = [
        'vendor/ace/assets/css/chosen.css',
        'vendor/ace/assets/css/datepicker.css',

    ];
    public $cssOptions = [
        'position' => View::POS_HEAD,
    ];
    public $js         = [
        'vendor/ace/assets/js/chosen.jquery.min.js',
        'vendor/ace/assets/js/date-time/bootstrap-datepicker.min.js',
        'vendor/ace/assets/js/jquery.autosize.min.js',
        'vendor/ace/assets/js/jquery.inputlimiter.1.3.1.min.js',
    ];
    public $jsOptions  = [
        'position' => View::POS_END,
    ];
    public $depends    = [
        /**  @see application\web\admin\components\AdminAsset */
        'application\web\admin\components\AdminAsset',

    ];
}
