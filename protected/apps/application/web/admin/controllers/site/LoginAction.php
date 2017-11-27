<?php
/**
 * @category LoginAction
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/4/30 13:01
 * @since
 */
namespace application\web\admin\controllers\site;

use application\web\admin\components\AdminBaseAction;
use application\web\admin\models\AdminUserLoginForm;
use common\core\session\GSession;
use qiqi\helper\MessageHelper;

/**
 * Class LoginAction
 * @package admin\controllers\site
 */
class LoginAction extends AdminBaseAction
{
    public function init()
    {
        $this->controller->layout = 'main-blank';
        parent::init();
    }

    public function run()
    {
        if(!\Yii::$app->user->isGuest){
            return $this->controller->goHome();
        }
        $model = new AdminUserLoginForm();
        if($this->request->getIsPost()){
            $model->load($this->request->post());
            if($model->validate() && $model->login()){
                return MessageHelper::show('提示信息', '恭喜你登录成功', ['site/index']);
            }
            GSession::setDbError($model);
            return MessageHelper::errorShow('提示', '用户名或者密码不正常', ['site/login']);
        }
        return $this->render(['model' => $model]);
    }
}
