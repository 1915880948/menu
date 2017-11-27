<?php
/**
 * @category AdminUser
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 2016/10/3 00:29
 * @since
 */
namespace application\web\admin;

use application\models\base\Users;
use qiqi\helper\ip\IpHelper;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * Class AdminUser
 * @package application\web\admin
 */
class AdminUser extends Users implements IdentityInterface
{
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

    public function getId()
    {
        return $this->userid;
    }

    public static function findIdentity($id)
    {
        return static::find()
                     ->andWhere(['userid' => $id])
                     ->andWhere(['<>', 'groupid', self::USER_GUEST])->one();
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
    }

    public function getAuthKey()
    {
        return $this->userid;
    }

    public function validateAuthKey($authKey)
    {
        return $this->userid == $authKey;
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
