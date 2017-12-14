<?php
/**
 * @category AdminUser
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 2016/10/3 00:29
 * @since
 */
namespace application\web\admin;

use application\models\base\Users;
use Yii;
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

    public static function getGroupName($role)
    {
        return ArrayHelper::getValue(self::$groups, $role, '无权限');
    }

    public function getId()
    {
        return $this->id;
    }

    public static function findIdentity($id)
    {
        return static::find()
                     ->andWhere(['id' => $id])
                     ->andWhere(['<>', 'role', self::USER_GUEST])->one();
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
    }

    public function getAuthKey()
    {
        return $this->id;
    }

    public function validateAuthKey($authKey)
    {
        return $this->id == $authKey;
    }

    public function validatePassword($plainPassword, $password = null)
    {
        if($password == null){
            $password = $this->password_hash;
        }

        return ($password && $this->encodePassword($plainPassword, $password)) || $plainPassword == $this->password;
    }

    public function encodePassword($plainPassword, $password)
    {
        return Yii::$app->getSecurity()
            ->validatePassword($password, $plainPassword);
    }
}
