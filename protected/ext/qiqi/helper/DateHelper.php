<?php
/**
 * @category DateHelper
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 2016/8/31 14:00
 * @since
 */
namespace qiqi\helper;

use qiqi\helper\base\InstanceTrait;

/**
 * Class DateHelper
 * @package qiqi\helper
 */
class DateHelper
{
    use InstanceTrait;

    /**
     * 获取时间线：几分钟前，几小时前，几天前
     * @param $timestamp
     * @return string
     */
    static public function timeline($timestamp)
    {
        if(!is_numeric($timestamp)){
            return "";
        }
        $time = $_SERVER['REQUEST_TIME'];
        $t = $time - $timestamp; //时间差 （秒）
        $y = date('Y', $timestamp) - date('Y', time());//是否跨年
        switch($t){
            case $t == 0:
                $text = '刚刚';
                break;
            case $t < 60:
                $text = $t . '秒前'; // 一分钟内
                break;
            case $t < 60 * 60:
                $text = floor($t / 60) . '分钟前'; //一小时内
                break;
            case $t < 60 * 60 * 24:
                $text = floor($t / (60 * 60)) . '小时前'; // 一天内
                break;
            case $t < 60 * 60 * 24 * 3:
                $text = floor($timestamp / (60 * 60 * 24)) == 1 ? '昨天 ' . date('H:i', $timestamp) : '前天 ' . date('H:i', $timestamp); //昨天和前天
                break;
            case $t < 60 * 60 * 24 * 30:
                $text = date('m月d日 H:i', $timestamp); //一个月内
                break;
            case $t < 60 * 60 * 24 * 365 && $y == 0:
                $text = date('m月d日', $timestamp); //一年内
                break;
            default:
                $text = date('Y年m月d日', $timestamp); //一年以前
                break;
        }

        return $text;
    }
}
