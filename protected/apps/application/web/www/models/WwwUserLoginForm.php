<?php
/**
 * @category WwwUserLoginForm
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 2016/10/17 11:24
 * @since
 */
namespace application\web\www\models;

use application\common\api\YxzApi;
use application\models\service\FrontUserService;
use application\web\www\WwwUser;
use yii\base\Model;

/**
 * Class WwwUserLoginForm
 * @package application\web\www\models
 */
class WwwUserLoginForm extends Model
{
    public $mobile;
    public $status = null;
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
            [['mobile'], 'required'],
        ];
    }

    /**
     * @return bool
     */
    public function login()
    {
        if($this->validate()){
            $user = \Yii::$app->getUser();
            $selfUser = $this->getUser();
            if(!($selfUser instanceof WwwUser)){
                if(!$selfUser){
                    return -1; //no register
                }
                return $selfUser;
            }
            if(!$selfUser['uid']){
                $api = new YxzApi();
                list($status, $uid) = $api->getUserId($selfUser->phone);
                if($status){
                    $selfUser->uid = $uid;
                    $selfUser->save();
                }
            }
            return $user->login($this->getUser(), WwwUser::USER_LOGIN_EXPIRE);
        }

        return false;
    }

    /**
     * @return WwwUser
     * @throws \yii\web\HttpException
     */
    public function getUser()
    {
        if(!$this->_user){
            $this->_user = FrontUserService::getInstance()
                                           ->findAndCreateUser($this->mobile);
        }
        return $this->_user;
    }
}
