<?php
/**
 * @category DataHelper
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 10/21/15 11:37
 * @since
 */
namespace qiqi\helper;

use yii\helpers\ArrayHelper;

/**
 * Class DataHelper
 * @package qiqi\helper
 */
class DataHelper
{
    static public function get($datas, $key, $defaultValue = null)
    {
        return ArrayHelper::getValue($datas, $key, $defaultValue);
    }

    /**
     * filter array
     * @param $array
     * @param null $callback
     * @return array
     */
    static public function filter($array, $callback = null)
    {
        $array = array_filter($array, 'trim');
        if($callback === null){
            return $array;
        }

        return array_map($callback, $array);
    }

    /**
     * merge default data
     * @param $data
     * @param array $dataTemplate 数据模板
     * @return mixed
     */
    static public function merge($data, $dataTemplate = [])
    {
        if(!$dataTemplate && !is_array($dataTemplate)){
            return $data;
        }
        foreach($dataTemplate as $k => $val){
            if(isset($data[$k])){
                $dataTemplate[$k] = $data[$k];
                settype($dataTemplate[$k], gettype($val));
            }
        }

        return $dataTemplate;
    }

    /**
     * array field type to string
     * @param $data
     * @return array
     */
    static public function toStringValue($data)
    {
        if(empty($data)){
            return [];
        }
        foreach($data as &$val){
//            if(is_object($val) && !empty($val) && !($val instanceof \stdClass)){
//                $val = (array) $val;
//            }
            $val = (is_array($val) || is_object($val)) ? self::toStringValue($val) : (string) $val;
        }

        return $data;
    }

    /**
     * 将 list 转成 key/value 格式
     * @param $options
     * @param $key
     * @param $value
     * @return array
     */
    static public function toMapDatas($options, $key = "key", $value = "value")
    {
        $results = [];
        foreach($options as $k => $val){
            $results[] = [$key => $k, $value => $val];
        }

        return $results;
    }

    /**
     * @alias ArrayHelper::map();
     * @param $options
     * @param string $key
     * @param string $value
     * @return array
     */
    static public function getMapDatas($options, $key = "key", $value = "value")
    {
        return ArrayHelper::map($options, $key, $value);
    }
}
