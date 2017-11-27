<?php
/**
 * @category Schema
 * @author   gouki <gouki.xiao@gmail.com>
 * @created  15/7/10 12:14
 * @since
 */
namespace common\core\base;

use qiqi\helper\ip\IpHelper;
use qiqi\helper\StringHelper;
use yii\base\Object;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * Class Schema
 *
 * @package common\core\response
 */
abstract class Schema extends Object
{
    const STATUS_NEED_LOGIN = -1;
    const STATUS_SUCCESS = 1;
    const STATUS_FAILED = 0;
    const STATUS_NOTIFY = 2;
    const STATUS_REDIRECT = 3;
    protected $data;
    private   $schemas;

    static public function FailureNotify($info, $data = null)
    {
        if($data === null && is_string($info)){
            $data = $info;
        }
        if(is_array($data)){
            if(!isset($data['info'])){
                $data['info'] = $info;
            }
        }

        return ArrayHelper::merge(self::Failure($data), ['info' => $info]);
    }

    static public function Failure($datas)
    {
        if(!is_array($datas)){
            $datas = ['info' => $datas];
        }
        $allowedStatus = [self::STATUS_FAILED, self::STATUS_NEED_LOGIN];
        if(!isset($datas['status']) || !in_array($datas['status'], $allowedStatus)){
            $datas['status'] = self::STATUS_FAILED;
        }
        $data = ArrayHelper::merge(self::_defaultResponse(), [
            'status' => $datas['status'],
            'errors' => [
                'code' => intval(isset($datas['code']) ? $datas['code'] : 900000),
                'info' => isset($datas['info']) ? $datas['info'] : '未知错误',
            ],
            'info'   => env('IS_LOCAL_DEV')
                ? (isset($datas['info']) ? $datas['info'] . "({$_SERVER['REQUEST_URI']})"
                    : $_SERVER['REQUEST_URI']) : (isset($datas['info']) ? $datas['info'] : "未知错误"),
            'items'=> isset($datas['items'])?$datas['items']:null,
        ], self::parseErrorDatas($datas));
        if(!$data['items']){
            unset($data['items']);
        }

        return $data;
    }

    public static function SuccessNotifyByClass($class, $code)
    {
        $cls = \Yii::createObject(['class' => $class]);
        $ret = $cls->toArray($code);
        if($code > 999000){
            $ret['status'] = self::STATUS_NEED_LOGIN;
        }

        return self::SuccessNotify($ret['info'], $ret);
    }

    static public function SuccessNotify($info, $datas = [])
    {
        return self::Success($datas, $info);
    }

    static public function Success($datas, $info = '')
    {
        return ArrayHelper::merge(self::_defaultResponse(), [
            'status' => self::STATUS_SUCCESS,
            'items'  => $datas,
            'info'   => $info,
        ], self::parseErrorDatas($datas));
    }

    static public function FailureNotifyByClass($class, $code)
    {
        $cls = \Yii::createObject(['class' => $class]);
        $ret = $cls->toArray($code);

        return ArrayHelper::merge(self::Failure($ret), ['info' => $ret['info']]);
    }

    static public function formatValue($data, $type = "string", $length = 2)
    {
        switch(strtolower($type)){
            case "int":
            case "integer":
            case "boolean":
                $data = intval($data);
                break;
            case "double":
            case "float":
                $data = (float) number_format($data, $length);
                break;
            case "string" :
            default:
                $data = strval($data);
                break;
        }

        return $data;
    }

    private static function _defaultResponse()
    {
        return [
            'status' => self::STATUS_FAILED,
            'items'  => [],
            'errors' => new \stdClass(),
            'info'   => "",
        ];
    }

    private static function parseErrorDatas($datas)
    {
        if(env('IS_LOCAL_DEV') == false){
            return [];
        }

        return [
            'errors' => [
                'debug'         => array_merge(['error-data' => $datas], [
                    'post'         => $_POST,
                    'get'          => $_GET,
                    'files'        => $_FILES,
                    'post-content' => file_get_contents("php://input"),
                ]),
                'client'        => [
                    'ip'         => IpHelper::getRealIP(),
                    'user-agent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT']
                        : "no useragent????",
                    'uri'        => $_SERVER['REQUEST_URI'],
                    'platform'   => isset($_SERVER['HTTP_PLATFORM']) ? $_SERVER['HTTP_PLATFORM']
                        : "",
                ],
                'processedTime' => \Yii::getLogger()->getElapsedTime(),
                //'sql'=>\Yii::getLogger()->getDbProfiling()
            ],
        ];
    }

    public function processAudioValue($audioFile)
    {
        if($audioFile){
            return \Yii::getAlias("@webuploads" . $audioFile);
        }

        return "";
    }

    public function processImageValue($imageUrl)
    {
        if($imageUrl){
            if(strncasecmp($imageUrl, "http", 4) == 0){
                return $imageUrl;
            }

            return \Yii::getAlias("@webuploads" . $imageUrl);
        }

        return "";
    }

    /**
     * @todo 缩略图功能
     *
     * @param        $imageUrl
     * @param string $mode
     * @param string $type
     *  d 居中裁剪, h是从上往下裁
     *  t 按比例缩
     * @return bool|string
     */
    public function processImageThumbValue($imageUrl, $mode = '', $type = 'd')
    {
        if($imageUrl){
            if(strncasecmp($imageUrl, "http", 4) == 0){
                return $imageUrl;
            }
            if($mode){
                if(!$type){
                    $type = 'd';
                }
                $imageUrl = sprintf("%s/%s/%s/%s", \Yii::$app->params['thumb.dir'], $type, $mode, ltrim($imageUrl, "/"));

                return \Yii::getAlias("@webthumbs" . $imageUrl);
            }

            return \Yii::getAlias("@webuploads" . $imageUrl);
        }

        return "";
    }

    public function updateBySchema($data, $schema)
    {
        static $results;
        foreach($data as $k => $val){
            if(is_array($val) || is_object($val)){
                return $this->updateBySchema($val, $schema[$k]);
            }
            /**
             * "boolean"
             * "integer"
             * "double" (for historical reasons "double" is returned in case of a float, and not simply "float")
             * "string"
             * "array"
             * "object"
             * "resource"
             * "NULL"
             * "unknown type"
             */
            if(!$val || !gettype($val) == $schema[$k]){
                switch($schema[$k]){
                    case "integer":
                    case "boolean":
                        $results[$k] = intval($val);
                        break;
                    case "double":
                    case "float":
                        $results[$k] = number_format($val, 1);
                        break;
                    case "string" :
                    default:
                        $results[$k] = strval($val);
                        break;
                }
            }
        }

        return $results;
    }

    public function processPageInfo(ActiveDataProvider $provider)
    {
        $pageLinks = $provider->getPagination()->getLinks(true);

        return [
            'data_total'    => $provider->getTotalCount(),
            'page_current'  => $provider->getPagination()->getPage() + 1,
            'page_total'    => $provider->getPagination()->getPageCount(),
            'page_size'     => $provider->getPagination()->getPageSize(),
            'page_next_url' => isset($pageLinks['next']) ? $pageLinks['next'] : "",
        ];
    }

    public function processStringValue($data)
    {
        return strval($data);
    }

    public function processTextValue($data, $legnth = null)
    {
        $data = strip_tags(StringHelper::analyzeContent(strval($data)));
        if($legnth !== null && is_int($legnth)){
            $data = StringHelper::truncateWords($data, $legnth);
        }

        return $data;
    }

    public function processIntValue($data)
    {
        return intval($data);
    }

    public function processCoordinateValue($data)
    {
        return $this->processFloatValue($data, 6);
    }

    public function processFloatValue($data, $length = 2)
    {
        return (float) number_format($data, $length);
    }

    public function processValue($data, $type = "string", $length = 2)
    {
        return self::formatValue($data, $type, $length);
    }
}
