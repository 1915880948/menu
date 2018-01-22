<?php

namespace application\models\db;

use Yii;

/**
 * This is the model class for table "{{%comment}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $menu_id
 * @property string $content
 * @property integer $to_user_id
 * @property integer $approved
 * @property string $created_at
 */
class TblComment extends \application\common\db\ApplicationActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'menu_id', 'to_user_id', 'approved'], 'integer'],
            [['created_at'], 'safe'],
            [['content'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'menu_id' => 'Menu ID',
            'content' => '评论',
            'to_user_id' => '回复@',
            'approved' => '点赞',
            'created_at' => 'Created At',
        ];
    }
}
