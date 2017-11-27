<?php
use application\common\base\traits\OptionTrait;
use application\common\widget\YLinkPager;
use application\models\service\GlobalSettingService;
use application\models\service\SettingService;
use common\core\base\Configure;
use common\core\image\ThumbImage;
use qiqi\helper\StringHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\log\Logger;
use yii\web\Cookie;
use yii\widgets\Pjax;

/**
 * @param string $url
 * @param bool $scheme
 * @return string
 */
function yUrl($url = '', $scheme = false)
{
    return Url::to($url, $scheme);
}

/**
 * @param $route
 * @param bool $scheme
 * @return string
 */
function yUrlRoute($route, $scheme = false)
{
    return yRoute($route, $scheme);
}

function yRoute($route, $scheme = false)
{
    return Url::toRoute($route, $scheme);
}

function yJsFileVer($url, $ver, $options = [])
{
    if(strpos($url, '?') !== false){
        $url .= '&v=' . $ver;
    } else{
        $url .= '?v=' . $ver;
    }
    return yJsFile($url, $options);
}

function yJsFile($url, $options = [])
{
    return Html::jsFile($url, $options);
}

function yCssFileVer($url, $ver, $options = [])
{
    if(strpos($url, '?') !== false){
        $url .= '&v=' . $ver;
    } else{
        $url .= '?v=' . $ver;
    }
    return yCssFile($url, $options);
}

function yCssFile($url, $options = [])
{
    return Html::cssFile($url, $options);
}

/**
 * @return \yii\console\Request|\yii\web\Request
 */
function yRequest()
{
    return Yii::$app->request;
}

/**
 * @return \yii\web\User
 */
function yUser()
{
    return Yii::$app->getUser();
}

/**
 * @param $message
 * @param string $category
 * @param int $type
 */
function yLog($message, $category = 'application', $type = Logger::LEVEL_ERROR)
{
    Yii::getLogger()
       ->log($message, $type, $category);
}

function ySession($key, $value = null)
{
    $session = Yii::$app->getSession();
    if($value === null){
        return $session->get($key);
    }
    return $session->set($key, $value);
}

function yCookieRemove($key = null)
{
    $cookies = Yii::$app->request->getCookies();
    if($key !== null){
        return $cookies->remove($key);
    }
    return $cookies->removeAll();
}

function yCookie($key, $value = null)
{
    $cookies = Yii::$app->request->getCookies();
    if($value === null){
        return $cookies->get($key);
    }
    $cookies->add(new Cookie([
        'name'   => $key,
        'value'  => $value,
        'domain' => env('COOKIE_DOMAIN'),
        'path'   => env('COOKIE_PATH'),
        'expire' => time() + env('COOKIE_EXPIRE')
    ]));
}

function ySecurity()
{
    return Yii::$app->getSecurity();
}

function yCsrfTag()
{
    return Html::csrfMetaTags();
}

/**
 * @param $type
 * @param null $name
 * @param null $value
 * @param array $options
 * @return string
 */
function yInput($type, $name = null, $value = null, $options = [])
{
    return Html::input($type, $name, $value, $options);
}

/**
 * @param $name
 * @param null $selection
 * @param array $items
 * @param array $options
 * @return string
 */
function ySelect($name, $selection = null, $items = [], $options = [])
{
    return Html::dropDownList($name, $selection, $items, $options);
}

function yCheckBoxList($name, $selection = null, $items = [], $options = [])
{
    return Html::checkboxList($name, $selection, $items, $options);
}

function yRadioBoxList($name, $selection = null, $items = [], $options = [])
{
    return Html::radioList($name, $selection, $items, $options);
}
function yCheckBox($name, $checked=false, $options = [])
{
    return Html::checkbox($name, $checked, $options);
}

function yRadioBox($name, $checked=false, $options = [])
{
    return Html::radio($name, $checked, $options);
}

function yText($name, $content = '', $options = [])
{
    return Html::textarea($name, $content, $options);
}

function yLabel($content, $for = null, $options = [])
{
    return Html::label($content, $for, $options);
}

function yTag($name, $content = '', $options = [])
{
    return Html::tag($name, $content, $options);
}

function yBeginTag($name, $options = [])
{
    return Html::beginTag($name, $options);
}

function yEndTag($name)
{
    return Html::endTag($name);
}

/**
 * @param string $action
 * @param string $method
 * @param array $options
 * @return string
 */
function yBeginForm($action = '', $method = 'post', $options = [])
{
    return Html::beginForm($action, $method, $options);
}

/**
 * @return string
 */
function yEndForm()
{
    return Html::endForm();
}

/**
 * @param $text
 * @param null $url
 * @param array $options
 * @return string
 */
function yLink($text, $url = null, $options = [])
{
    return Html::a($text, $url, $options);
}

/**
 * @param $src
 * @param array $options
 * @return string
 */
function yImg($src, $options = [])
{
    return Html::img($src, $options);
}

/**
 * @param $src
 * @param array $options
 * @return string
 */
function yImage($src, $options = [])
{
    return Html::img($src, $options);
}

/**
 * @param $file
 * @param $group
 * @return string
 */
function yThumb($file, $group)
{
    return ThumbImage::thumb($file, $group);
}

/**
 * @param $file
 * @param array $options
 * @return bool|string
 */
function yThumbOption($file, $options = [])
{
    return ThumbImage::options($file, $options);
}

/**
 * @param $path
 * @return string
 */
function yImageUrl($path)
{
    return ThumbImage::url($path);
}

/**
 * @param $url
 * @return bool|string
 */
function yStatic($url)
{
    $url = ltrim($url, '/');
    return Yii::getAlias("@web/static/{$url}");
}

/**
 * @param array $options
 * @return string
 */
function yLinkPager($options = [])
{
    return YLinkPager::widget($options);
}

/**
 * @param $key
 * @param null $defaultValue
 * @return null
 */
function yParams($key, $defaultValue = null)
{
    return Configure::get($key, $defaultValue);
}

/**
 * @param $key
 * @param null $defaultValue
 * @return mixed
 */
function ySetting($key, $defaultValue = null)
{
    return SettingService::getInstance()
                         ->get($key, $defaultValue);
}

/**
 * @param $key
 * @param null $defaultValue
 * @return mixed
 */
function yGlobal($key, $defaultValue = null)
{
    return GlobalSettingService::getInstance()
                               ->get($key, $defaultValue);
}

function yEncode($data)
{
    return Json::encode($data);
}

function yDecode($data)
{
    return Json::decode($data);
}

/**
 * @param $alias
 * @return bool|string
 */
function yAlias($alias)
{
    return Yii::getAlias($alias);
}

/**
 * @param $str
 * @param $length
 * @param int $havedot
 * @return string
 */
function ySubstr($str, $length, $havedot = 0)
{
    return StringHelper::substring($str, $length, $havedot);
}

function yOptions($className)
{
    try{
        /** @var OptionTrait $options */
        $options = Yii::createObject($className)
                      ->getOptions();
    } catch(Exception $e){
        $options = [];
    }
    return $options;
}

function yPjaxStart()
{
    Pjax::begin();
}

function yPjaxEnd()
{
    Pjax::end();
}
/**
 * @param $name
 * @param array $params
 * @return mixed|null
 */
function yApp($name,$params = []){
    if(isset(Yii::$app->$name)){
        return Yii::$app->$name;
    }
    if(is_callable([Yii::$app,$name])){
        return call_user_func_array([Yii::$app,$name],$params);
    }
    return null;
}

function app($name,$params = []){
    return Yii::createObject($name,$params);
}
