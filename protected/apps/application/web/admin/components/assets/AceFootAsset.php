<?php
/**
 * @category AceFootAsset
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 2016/10/8 20:10
 * @since
 */
namespace application\web\admin\components\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Class AceFootAsset
 * @package application\web\admin\components\assets
 */
class AceFootAsset extends AssetBundle
{
    public $baseUrl = '@webstatic';
    public $js = [
        'vendor/jquery/typeahead.jquery.min.js',
        'vendor/ace/assets/js/jquery-ui-1.10.3.custom.min.js',
        'vendor/ace/assets/js/jquery.ui.touch-punch.min.js',
        'vendor/ace/assets/js/jquery.slimscroll.min.js',
        'vendor/ace/assets/js/ace-elements.min.js',
        'vendor/ace/assets/js/ace.min.js',
        'vendor/ace/assets/js/bootbox.min.js'
    ];
    public $jsOptions = [
        'position' => View::POS_END,
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}
