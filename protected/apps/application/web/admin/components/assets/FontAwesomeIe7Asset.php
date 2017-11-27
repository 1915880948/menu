<?php
/**
 * @category FontAwesomeIe7Asset
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/5/4 15:47
 * @since
 */
namespace application\web\admin\components\assets;

use yii\web\AssetBundle;

/**
 * Class FontAwesomeIe7Asset
 * @package application\web\admin\components\assets
 */
class FontAwesomeIe7Asset extends AssetBundle
{
    public $baseUrl    = '@webstatic';
    public $css        = [
        'vendor/ace/assets/css/font-awesome-ie7.min.css',
    ];
    public $cssOptions = [
        'condition' => 'IE 7',
    ];
    public $depends    = [
        'application\web\admin\components\assets\FontAwesomeAsset',
    ];
}
