<?php
/**
 * @category MessageHelper
 * @author   gouki <gouki.xiao@gmail.com>
 * @created  11/21/14 23:39
 * @since
 */

namespace qiqi\helper;

use qiqi\helper\base\AppHelper;
use yii\base\Module;
use yii\base\Object;
use yii\helpers\ArrayHelper;

/**
 * Class MessageHelper
 * @package helper
 */
class MessageHelper extends Object
{
    static public $variables = [];

    static public function assign($key, $value)
    {
        self::$variables[$key] = $value;
    }

    static public function show($title, $message, $url = '', $time = 3)
    {
        return self::showmessage('success', $title, $message, $url, $time);
    }

    /**
     * @param $message
     * @param string $url
     * @param int $time
     * @return string
     */
    public static function success($message, $url = '', $time = 3)
    {
        return self::show(env('SUCCESS_TITLE'), $message, $url, $time);
    }

    /**
     * @param $message
     * @param string $url
     * @param int $time
     * @return string
     */
    public static function error($message, $url = '', $time = 3)
    {
        return self::errorShow(env('ERROR_TITLE'), $message, $url, $time);
    }

    static public function errorShow($title, $message, $url = '', $time = 3)
    {
        return self::showmessage('warning', $title, $message, $url, $time);
    }

    static protected function showmessage($mode, $title, $message, $url = '', $time = 3)
    {
        $controller = AppHelper::getController();
        $controller->layout = isset(\Yii::$app->params['message']['layout']) ? \Yii::$app->params['message']['layout'] : 'blank';
        $currentViewPath = $controller->getViewPath();
        $viewPath = '';
        // echo \Yii::getAlias('@app');
        // exit;
        if($controller->module instanceof Module && isset($controller->module->module)){//证明是module，需要创建一个标准的site/index的controller
            // $viewPath = str_replace(\Yii::getAlias('@root'),'',$controller->module->module->getViewPath()."/site/");
            $baseViewPath = \Yii::getAlias('@app/views/site');
            //$viewPath = '../../../../views/site/';
            // $viewPath = \Yii::getAlias('@app/views/site');
            $viewPath = self::relativePath($baseViewPath, $currentViewPath);
        }
        $templae = ($viewPath . (isset(\Yii::$app->params['message']['template']) ? \Yii::$app->params['message']['template'] : '../layouts/message'));
        return $controller->render($templae, ArrayHelper::merge([
            'title'      => $title,
            'message'    => $message,
            'url'        => is_array($url) ? $url : ($url ? [$url] : \Yii::$app->request->getReferrer()),
            'time'       => $time,
            'mode'       => $mode,
            'controller' => $controller,
        ], self::$variables));
    }

    /**
     * relativePath 计算两个文件的相对路径
     * @param file1 参作为考路径
     * @param file2 相对于$file1的路径
     */
    protected static function relativePath($file1, $file2)
    {
        $aArr = explode('/', $file1); //explode函数用于切分字符串,返回切分后的数组,此处用'/'切分字符串
        $bArr = explode('/', $file2);
        $aDiffToB = array_diff_assoc($aArr, $bArr); //array_diff_assoc()用于获取A数组于B数组之间元素的差集,key和value都不相同视为不同元素,此处返回在A数组中且于B数组不相同的元素。
        $bDiffToa = array_diff_assoc($bArr, $aArr);
        $count = count($bDiffToa);
        $path = '';
        for($i = 0; $i <= $count - 1; $i++){
            $path .= '../';
        }
        $path .= implode('/', $aDiffToB);//implode()用于使用指定字符串连接数组元素,此处返回用'/'连接数组元素后的字符串
        return $path . "/";
    }
}
