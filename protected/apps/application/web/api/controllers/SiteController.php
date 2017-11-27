<?php
/**
 * @category SiteController
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 2017/5/8 09:42
 * @since
 */

namespace application\web\api\controllers;

use application\web\api\components\ApiBaseController;

/**
 * Class SiteController
 * @package application\web\api\controllers
 */
class SiteController extends ApiBaseController
{
    public function actions()
    {
        $actionDirs = __DIR__ . "/" . $this->id;
        $actionNamespace = __NAMESPACE__ . '\\' . $this->id;
        $actions = [];
        foreach(glob($actionDirs . "/*.php") as $actionFile){
            $filename = pathinfo($actionFile, PATHINFO_FILENAME);
            $actionName = strtolower(str_replace('Action', '', $filename));
            $actions[$actionName] = $actionNamespace . '\\' . $filename;
        }

        return $actions;
    }
}
