<?php
/**
 * @category Options
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/4/30 14:40
 * @since
 */
namespace common\core\base;

use Mage\Config;
use yii\base\Object;
use yii\helpers\ArrayHelper;

/**
 * Class Options
 * @package common\core\base
 */
class Options extends Object
{
    private static $_options = [];

    public static function get($name)
    {
        return ArrayHelper::getValue(self::$_options, $name);
    }

    public static function set($name, $value)
    {
        self::$_options[$name] = $value;
    }

    public static function mSet(array $data)
    {
        foreach($data as $key => $value){
            self::set($key, $value);
        }
    }

    public static function mGet(array $names)
    {
        $results = [];
        foreach($names as $name){
            $results[$name] = self::get($name);
        }
    }
}
