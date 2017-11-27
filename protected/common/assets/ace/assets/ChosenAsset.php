<?php
/**
 * @category ChosenAsset
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/5/18 10:38
 * @since
 */
namespace common\assets\ace\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Class ChosenAsset
 * @package common\assets\ace\assets
 */
class ChosenAsset extends AssetBundle
{
    public $baseUrl = '@webstatic';

    public $css = [
        'vendor/ace/assets/css/chosen.css'
    ];
    public $js = [
        'vendor/ace/assets/js/chosen.jquery.min.js',
    ];

    public $jsOptions = [
        'position' => View::POS_END
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}
