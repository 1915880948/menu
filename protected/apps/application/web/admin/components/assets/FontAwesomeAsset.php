<?php
/**
 * @category FontAwesomeAsset
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/5/4 15:38
 * @since
 */
namespace application\web\admin\components\assets;

use yii\web\AssetBundle;

/**
 * Class FontAwesomeAsset
 * @package application\web\admin\components\assets
 */
class FontAwesomeAsset extends AssetBundle
{
    public $baseUrl = '@webstatic';
    public $css     = [
        'vendor/ace/assets/css/font-awesome.min.css',
    ];

}
