<?php
/**
 * @category AdminBaseController
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 2016/10/1 23:15
 * @since
 */
namespace application\web\admin\components;

use common\core\base\BaseController;
use yii\filters\AccessControl;

/**
 * Class AdminBaseController
 * @package application\web\admin\components
 */
class AdminBaseController extends BaseController
{
    /**
     * 覆盖父类,表示login/info/clear 不需要登录
     * @inheritdoc
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
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
