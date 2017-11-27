<?php
/**
 * @category LogoutAction
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/3/26 14:05
 * @since
 */
namespace application\web\admin\controllers\site;

use application\web\admin\components\AdminBaseAction;
use qiqi\helper\MessageHelper;

/**
 * Class LogoutAction
 * @package apps\admin\controllers\site
 */
class LogoutAction extends AdminBaseAction
{
    public $method = 'POST';

    public function run()
    {
        if(\Yii::$app->user->logout()){
            return MessageHelper::show('提示信息', '退出成功', 'site/index');
        }
    }
}
