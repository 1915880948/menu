<?php
/**
 * @category KindeditorAsset
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/4/7 19:54
 * @since
 */

namespace UIAsset\asset;

use yii\web\AssetBundle;

/**
 * Class KindeditorAsset
 * @package UIAsset
 */
class KindeditorAsset extends AssetBundle
{
    public $sourcePath = '@UIAsset/plugins';
    public $js         = [
        'kindeditor/kindeditor-all-min.js'
    ];
}
