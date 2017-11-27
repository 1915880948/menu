<?php
/**
 * @category DatetimePickerAsset
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/5/9 16:02
 * @since
 */
namespace application\web\admin\components\assets;

use yii\web\AssetBundle;

/**
 * Class DatetimePickerAsset
 * @package application\web\admin\components\assets
 */
class DatetimePickerAsset extends AssetBundle
{
    public $baseUrl = '@webstatic';
    public $css     = [
        'vendor/ace/assets/css/bootstrap-datetimepicker.min.css'
    ];
    public $js      = [
        'vendor/ace/assets/js/date-time/bootstrap-datetimepicker.min.js',
        'vendor/ace/assets/js/date-time/locales/bootstrap-datetimepicker.zh-CN.js'
    ];
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}
