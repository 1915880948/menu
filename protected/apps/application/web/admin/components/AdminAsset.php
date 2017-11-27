<?php
/**
 * @category AdminAsset
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/1/16 13:24
 * @since
 */
namespace application\web\admin\components;

use yii\web\AssetBundle;

/**
 * Class AdminAsset
 * @package apps\admin\base
 */
class AdminAsset extends AssetBundle
{
    public $depends = [
        'yii\web\YiiAsset',
        /**  @see \yii\web\YiiAsset */
        /** @see \yii\bootstrap\BootstrapPluginAsset */
        'yii\bootstrap\BootstrapPluginAsset',
        'application\web\admin\components\assets\FontAwesomeIe7Asset',
        'application\web\admin\components\assets\AceAsset',
        'application\web\admin\components\assets\AppAsset',
        'application\web\admin\components\assets\AceFootAsset',
        // 'UIAsset\asset\KindeditorAsset'
    ];
}
