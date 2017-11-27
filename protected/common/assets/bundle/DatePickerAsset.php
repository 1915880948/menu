<?php
/**
 * @category DatePickerAsset
 * @author   gouki <gouki.xiao@gmail.com>
 * @created  15/3/11 下午6:33
 * @since
 */
namespace common\assets\bundle;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Class DatePickerAsset
 * @package common\base\bundle
 */
class DatePickerAsset extends AssetBundle
{
    //   public $basePath = '@webroot';
    public $baseUrl = '@webstatic';
    public $css = [
        // 'vendor/datepicker/css/bootstrap-datetimepicker.min.css'
        'vendor/datepicker/datepicker.css'
    ];
    public $js = [
        // 'vendor/datepicker/js/bootstrap-datetimepicker.min.js',//=> View::POS_END,
        // 'vendor/datepicker/js/bootstrap-datetimepicker.zh-CN.js',//=> View::POS_END,
        'vendor/datepicker/datepicker.js',//=> View::POS_END,
    ];
    public $depends = [
        // 'common\assets\bundle\Jquery1Asset',
        'yii\bootstrap\BootstrapPluginAsset'
    ];
    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];
    //public function init()
    //{
    //    $this->jsOptions['position'] = View::POS_END;
    //    parent::init();
    //}
}
