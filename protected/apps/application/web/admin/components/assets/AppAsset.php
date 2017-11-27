<?php
/**
 * @category AppAsset
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/5/5 12:23
 * @since
 */
namespace application\web\admin\components\assets;

use yii\web\AssetBundle;

/**
 * Class AppAsset
 * @package application\web\admin\components\assets
 */
class AppAsset extends AssetBundle
{
//    public $baseUrl = '@';
    public $baseUrl = '@web';
    public $css = [
        'static/css/css.css'
    ];
}
