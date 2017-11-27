<?php
/**
 * @category SiteController
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/4/30 11:53
 * @since
 */
namespace application\web\admin\controllers;

use application\web\admin\components\AdminBaseController;
use common\core\base\controller\ActionsTrait;
use yii\filters\AccessControl;

/**
 * Class SiteController
 * @package admin\controllers
 */
class SiteController extends AdminBaseController
{
    use ActionsTrait;
    /**
     * 覆盖父类,表示login/info/clear 不需要登录
     * @inheritdoc
     * @return array
     */
    public function behaviors()
    {
        return [];
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'info', 'clear','video'],
                        'allow'   => true,
                        'roles'   => ['?'],
                    ],
                    [
                        //'actions' => [ 'index', 'withdraw' ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

}
