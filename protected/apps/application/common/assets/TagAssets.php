<?php
/**
 * @category TagAssets
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/5/10 15:22
 * @since
 */
namespace application\common\assets;

use yii\web\AssetBundle;

/**
 * Class TagAssets
 * @package application\common\assets
 */
class TagAssets extends AssetBundle
{
    public $baseUrl = '@webstatic';
    public $js = [
        'vendor/ace/assets/js/jquery.autosize.min.js',
        'vendor/ace/assets/js/bootstrap-tag.min.js',
    ];

    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}
