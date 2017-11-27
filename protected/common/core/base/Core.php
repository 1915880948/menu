<?php
/**
 * @category Core
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 2017/6/29 12:33
 * @since
 */

namespace common\core\base;

/**
 * Class Core
 * @package common\core\base
 */
class Core
{
    public static $keywords = [
        "__halt_compiler",
        "abstract",
        "and",
        "array",
        "as",
        "break",
        "callable",
        "case",
        "catch",
        "class",
        "clone",
        "const",
        "continue",
        "declare",
        "default",
        "die",
        "do",
        "echo",
        "else",
        "elseif",
        "empty",
        "enddeclare",
        "endfor",
        "endforeach",
        "endif",
        "endswitch",
        "endwhile",
        "eval",
        "exit",
        "extends",
        "final",
        "finally",
        "for",
        "foreach",
        "function",
        "global",
        "goto",
        "if",
        "implements",
        "include",
        "include_once",
        "instanceof",
        "insteadof",
        "interface",
        "isset",
        "list",
        "namespace",
        "new",
        "or",
        "print",
        "private",
        "protected",
        "public",
        "require",
        "require_once",
        "return",
        "static",
        "switch",
        "throw",
        "trait",
        "try",
        "unset",
        "use",
        "var",
        "while",
        "xor",
        "yield",
    ];

    public static function isKeyword($keyword)
    {
        return in_array(strtolower($keyword), self::$keywords);
    }
}
