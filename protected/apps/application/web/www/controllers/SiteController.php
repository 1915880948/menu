<?php
/**
 * @category SiteController
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 2016/10/1 23:14
 * @since
 */

namespace application\web\www\controllers;

use application\web\www\components\WwwBaseController;
use yii\filters\AccessControl;

/**
 * Class SiteController
 * @package application\web\www\controllers
 */
class SiteController extends WwwBaseController
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

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        //'actions' => [ 'index', 'withdraw' ],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index', 'upload'],
                        'roles'   => ['@'],
                    ],
                ],
            ],
        ];
    }
}
