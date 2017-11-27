<?php
/**
 * @category helpers.php
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 2016/8/29 00:17
 * @since
 */

use qiqi\helper\StringHelper;

if(!function_exists('value')){
    /**
     * Return the default value of the given value.
     *
     * @param  mixed $value
     * @return mixed
     */
    function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}
if(!function_exists('env')){
    /**
     * Gets the value of an environment variable. Supports boolean, empty and null.
     *
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        $value = getenv($key);

        if($value === false){
            return value($default);
        }

        switch(strtolower($value)){
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return;
        }

        if(strlen($value) > 1 && StringHelper::startsWith($value, '"') && StringHelper::endsWith($value, '"')){
            return substr($value, 1, -1);
        }

        return $value;
    }
}
if(!function_exists('windows_os')){
    /**
     * Determine whether the current environment is Windows based.
     *
     * @return bool
     */
    function windows_os()
    {
        return strtolower(substr(PHP_OS, 0, 3)) === 'win';
    }
}

if(!function_exists('with')){
    /**
     * Return the given object. Useful for chaining.
     *
     * @param  mixed $object
     * @return mixed
     */
    function with($object)
    {
        return $object;
    }
}
if(!function_exists('trait_uses_recursive')){
    /**
     * Returns all traits used by a trait and its traits.
     *
     * @param  string $trait
     * @return array
     */
    function trait_uses_recursive($trait)
    {
        $traits = class_uses($trait);

        foreach($traits as $trait){
            $traits += trait_uses_recursive($trait);
        }

        return $traits;
    }
}
