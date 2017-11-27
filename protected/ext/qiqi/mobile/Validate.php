<?php
/**
 * @category Validate
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 2016/10/6 10:33
 * @since
 */
namespace qiqi\mobile;

/**
 * Class Validate
 * @package qiqi\mobile
 */
class Validate
{
    protected static $regex = '/^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])\d{8}$/';

    /**
     * @param $mobile
     * @param $isParsed bool 是否已经解析过
     * @return bool
     */
    public static function filter($mobile, $isParsed = true)
    {
        return preg_match(self::$regex, $isParsed ? $mobile : self::getRealPhone($mobile));
    }

    public static function getRealPhone($mobile)
    {
        return str_replace(["+", "-", " "], "", $mobile);
    }
}
