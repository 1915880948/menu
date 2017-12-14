<?php

namespace application\models\db;

use Yii;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $password_hash
 * @property integer $role
 * @property integer $status
 * @property string $created_at
 */
class TblUsers extends \application\common\db\ApplicationActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['role', 'status'], 'integer'],
            [['created_at'], 'safe'],
            [['username'], 'string', 'max' => 30],
            [['password', 'password_hash'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'password_hash' => 'Password Hash',
            'role' => 'Role',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
}
