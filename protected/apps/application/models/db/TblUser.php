<?php

namespace application\models\db;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $openid
 * @property string $head_pic
 * @property string $nickname
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $created_at
 */
class TblUser extends \application\common\db\ApplicationActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at'], 'safe'],
            [['openid'], 'string', 'max' => 50],
            [['head_pic', 'nickname'], 'string', 'max' => 255],
            [['name', 'phone'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'openid' => 'Openid',
            'head_pic' => 'Head Pic',
            'nickname' => 'Nickname',
            'name' => 'Name',
            'phone' => 'Phone',
            'email' => 'Email',
            'created_at' => 'Created At',
        ];
    }
}
