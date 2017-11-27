<?php
/**
 * @category ActionKeywordsTrait
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 2017/6/30 10:22
 * @since
 */

namespace common\core\base\controller;

use common\core\base\Core;
use yii\helpers\Inflector;

trait ActionKeywordsTrait
{
    public function actions()
    {
        $classFullName = str_replace('\\', '/', __CLASS__);
        $classBaseName = str_replace('controller', '', strtolower(basename($classFullName)));
        if(Core::isKeyword($classBaseName)){
            $classBaseName = Inflector::pluralize($classBaseName);
        }
        $classPath = dirname($classFullName);
        $actionDirs = "{$classPath}/{$classBaseName}";
        $actionNamespace = str_replace('/', '\\', $actionDirs);
        $actions = [];
        foreach(glob(\Yii::getAlias("@{$actionDirs}") . "/*.php") as $actionFile){
            $filename = pathinfo($actionFile, PATHINFO_FILENAME);
            $actionName = strtolower(str_replace('Action', '', $filename));
            $actions[$actionName] = $actionNamespace . '\\' . $filename;
        }

        return $actions;
    }
}
