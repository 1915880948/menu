<?php
/**
 * @category ConsoleHelper
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 15/12/2 09:25
 * @since
 */
namespace qiqi\helper;

use yii\helpers\Console;

/**
 * Class ConsoleHelper
 * @package neatstudio\helpers
 */
class ConsoleHelper extends Console
{
    public static function danger($string = null)
    {
        return self::output($string, Console::FG_RED, Console::BG_BLACK, Console::BOLD);
    }

    public static function warning($string = null)
    {
        return self::output($string, Console::FG_YELLOW, Console::BG_BLACK, Console::BOLD);
    }

    public static function info($string = null)
    {
        return self::output($string, Console::FG_BLUE, Console::BG_GREY, Console::BOLD);
    }

    public static function success($string = null)
    {
        return self::output($string, Console::FG_GREEN, Console::BOLD);
    }

    /**
     * @param null $string
     * @return bool|int
     */
    public static function output($string = null)
    {
        $traces = debug_backtrace();
        $args = func_get_args();
        array_shift($args);
        $string = vsprintf("[%s] \nFile : %s \nLine : %s \nData : %s", [
            date("Y-m-d H:i:s"),
            $traces[0]['file'],
            $traces[0]['line'],
            Console::ansiFormat($string, $args)
        ]);

        return parent::output($string);
    }
}
