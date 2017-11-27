<?php
/**
 * 如果extension的目录不能被加载,或者命名空间有问题,则在这里处理
 * @category bootstrap.php
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/3/11 15:04
 * @since
 */
/**
 * autoset
 */
foreach(glob(__DIR__ . "/*") as $dirname){
    if(is_dir($dirname)){
        $basename = basename($dirname);
        Yii::setAlias($basename, "@ext/{$basename}");
    }
}
