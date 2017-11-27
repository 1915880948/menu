<?php
/**
 * @category WwwUser
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 2016/10/15 12:39
 * @since
 */
namespace application\web\www;

use application\common\api\District;
use application\models\base\Users;
use qiqi\helper\ip\IpHelper;
use qiqi\helper\log\FileLogHelper;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * Class WwwUser
 * @package application\web\www
 */
class WwwUser extends Account implements IdentityInterface
{
    //专门用来预览的用户ID
    const PREVIEW_USER_ID = 2;
    //一年才过期
    const USER_LOGIN_EXPIRE = 31104000;
    //权限
    const USER_SUPER_ADMIN = 1;
    const USER_ADMIN = 2;
    const USER_GUEST = 3;
    protected static $groups = [
        self::USER_SUPER_ADMIN => '超级管理员',
        self::USER_ADMIN       => '管理员',
        self::USER_GUEST       => '游客'
    ];

    public static function getGroups()
    {
        return self::$groups;
    }

    public static function getGroupName($groupid)
    {
        return ArrayHelper::getValue(self::$groups, $groupid, '无权限');
    }

    public static function findIdentity($id)
    {
        return static::find()
                     ->andWhere(['userid' => $id])
                     ->andWhere(['groupid' => self::USER_GUEST])
                     ->one();
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
    }

    public function getId()
    {
        return $this->userid;
    }

    public function getAuthKey()
    {
        return $this->userid;
    }

    public function validateAuthKey($authKey)
    {
        return $this->userid == $authKey;
    }

    /**
     * 注册用户
     * @param $userInfo
     * @return array
     */
    public static function registerUser($userInfo)
    {

        $model = new WwwUser();
        $model->username = $model->phone = isset($userInfo['phone']) ? $userInfo['phone'] : $userInfo['mobile'];
        $model->nickname = isset($userInfo['nickName']) ? $userInfo['nickName'] : "";
        $model->department = $userInfo['department'];
        $model->realname = isset($userInfo['realname']) ? $userInfo['realname'] : $userInfo['name'];
        $model->type = $userInfo['type'];
        $model->hospital = $userInfo['hospital'];
        $model->password = md5(microtime(1));
        $model->regdateline = time();
        $model->region = isset($userInfo['addr'])?$userInfo['addr']:null;
        $districtId = null;
        if( isset($userInfo['addr'])){
            $addresses = explode("|",$userInfo['addr']);
            if($addresses[0]){
                $districtId = District::getProvinceId($addresses[0]);

            }
        }
        // FileLogHelper::xlog([$model->getAttributes(),$districtId,$userInfo],'register');
        $model->lastpost = time();
        $model->groupid = WwwUser::USER_GUEST;
        $model->regip = IpHelper::getRealIP();
        $model->district_id = strval( isset($userInfo['city']) ? $userInfo['city'] : ($districtId?$districtId:'000000'));
        $model->gender = isset($userInfo['gender']) ? $userInfo['gender'] : 0;
        $model->jobtitle = isset($userInfo['title']) ? $userInfo['title'] : (isset($userInfo['jobtitle']) ? $userInfo['jobtitle'] : '');
        $model->hospital_level = isset($userInfo['hospital_level'])?$userInfo['hospital_level']:(isset($userInfo['level'])?$userInfo['level']:"");
        $model->uid = isset($userInfo['uid'])?$userInfo['uid']:'0';
        $model->channel = isset($userInfo['channel'])?$userInfo['channel']:0;
        // FileLogHelper::xlog(['register',$model->getAttributes(),$districtId,$userInfo],'register');
        return [$model->save(), $model];
    }

    public function validatePassword($plainPassword, $password = null)
    {
        if($password == null){
            $password = $this->password;
        }
        return $this->encodePassword($plainPassword) == $password;
    }

    public function encodePassword($plainPassword)
    {
        return md5($plainPassword);
    }

    public function getRegip()
    {
        if(!$this->regip){
            $this->regip = IpHelper::getRealIP();
        }
        return $this->regip;
    }

    public function setRegip($regip = null)
    {
        if($regip){
            $this->regip = $regip;
        } else{
            $this->regip = $this->getRegip();
        }
    }
}
