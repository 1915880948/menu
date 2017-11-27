<?php
/**
 * @category AdminUserLoginForm
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 2016/10/8 00:13
 * @since
 */
namespace application\web\admin\models;

use application\web\admin\AdminUser;
use yii\base\Model;

/**
 * Class AdminUserLoginForm
 * @package application\web\admin\models
 */
class AdminUserLoginForm extends Model
{
    public $username;
    public $password;
    /**
     * @var bool
     */
    public $rememberMe = true;
    /**
     * @var
     */
    public $captcha;
    private $_user;

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['password', 'validatePassword']
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if(!$this->hasErrors()){
            $user = $this->getUser();
            if(!$user || !$user->validatePassword($this->password, $user->password)){
                $this->addError($attribute, '用户名或者密码错误.');
            }
        }
    }

    /**
     * @return bool
     */
    public function login()
    {
        if($this->validate()){
            $user = \Yii::$app->getUser();
            return $user->login($this->getUser(), 3600 * 24 * 30);
        }

        return false;
    }

    /**
     * @return AdminUser
     */
    public function getUser()
    {
        if(!$this->_user){
            $this->_user = AdminUser::find()
                                    ->andWhere(['username' => $this->username])
                                    ->andWhere(['<>', 'groupid', AdminUser::USER_GUEST])
                                    ->one();
        }
        return $this->_user;
    }
}
