<?php
/**
 * @category Cookie
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/3/27 10:48
 * @since
 */
namespace qiqi\helper;

use yii\base\Object;
use yii\web\Cookie;

/**
 * Class Cookie
 * @package common\core\base
 */
class CookieHelper extends Object
{
    /**
     * set cookie
     * @param $key
     * @param $value
     * @param int $expire
     * @param null $domain
     * @param null $path
     * @param bool $httpOnly
     * @param bool $secure
     */
    static public function set($key, $value, $expire = 0, $domain = null, $path = null, $httpOnly = true, $secure = false)
    {
        if(!$expire){
            if(isset(\Yii::$app->params['cookie']['expire'])){
                $expire = \Yii::$app->params['cookie']['expire'];
            } else{
                $expire = 0;
            }
        }
        if(!$domain && isset(\Yii::$app->params['cookie']['domain'])){
            $domain = \Yii::$app->params['cookie']['domain'];
        }
        if(!$path && isset(\Yii::$app->params['cookie']['path'])){
            $path = \Yii::$app->params['cookie']['path'];
        }
        $data = [
            'name'     => $key,
            'value'    => $value,
            'expire'   => time() + $expire,
            'domain'   => $domain,
            'path'     => $path,
            'httpOnly' => $httpOnly,
            'secure'   => $secure
        ];
        $cookies = \Yii::$app->response->cookies;
        $cookies->add(new Cookie($data));
    }

    /**
     * @param $key
     * @param null $defaultValue
     * @return mixed|null
     */
    static public function get($key, $defaultValue = null)
    {
        $val = \Yii::$app->request->cookies->getValue($key);
        if(!$val){//跨大域。只能从$_COOKIE里读
            $val = isset($_COOKIE[$key]) ? $_COOKIE[$key] : $defaultValue;
        }

        return $val;
    }

    static public function remove($key)
    {
        $cookies = \Yii::$app->response->cookies;
        $cookies->remove($key);
    }

    static public function removeAll()
    {
        $cookies = \Yii::$app->response->cookies;
        $cookies->removeAll();
    }
}
