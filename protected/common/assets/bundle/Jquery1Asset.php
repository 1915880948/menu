<?php
/**
 * @category Jquery1Asset
 * @author   gouki <gouki.xiao@gmail.com>
 * @created  15/3/12 上午11:07
 * @since
 */
namespace common\assets\bundle;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Class Jquery1Asset
 *
 * @package common\base\bundle
 */
class Jquery1Asset extends AssetBundle
{
    public $baseUrl = '@webstatic';
    public $js = [
        'vendor/jquery/jquery.1.11.2.min.js',
    ];
    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];
    public function init(){
        parent::init();
        //echo "<script>var jq1 = $.noConflict(true);</script>";
        $view = \Yii::$app->getView();
        $view->registerJs('var jq1 = $.noConflict(true);',View::POS_HEAD);
    }
}
