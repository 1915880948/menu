<?php
/**
 * @category DirHelper
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 2016/11/5 09:07
 * @since
 */
namespace qiqi\helper;

use qiqi\helper\base\InstanceTrait;

/**
 * Class DirHelper
 * @package qiqi\helper
 */
class DirHelper
{
    use InstanceTrait;

    /**
     * 目录拷贝
     * @param $src
     * @param $dst
     */
    public function copy($src, $dst)
    {
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ($file = readdir($dir))){
            if(($file != '.') && ($file != '..')){
                if(is_dir($src . '/' . $file)){
                    $this->copy($src . '/' . $file, $dst . '/' . $file);
                    continue;
                } else{
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }
}
