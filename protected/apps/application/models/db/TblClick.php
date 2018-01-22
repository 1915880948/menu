<?php

namespace application\models\db;

use Yii;

/**
 * This is the model class for table "{{%click}}".
 *
 * @property integer $id
 * @property integer $menu_id
 * @property integer $user_id
 * @property string $menu_name
 * @property string $cover_image
 * @property string $created_at
 */
class TblClick extends \application\common\db\ApplicationActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%click}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_id', 'user_id'], 'integer'],
            [['created_at'], 'safe'],
            [['menu_name'], 'string', 'max' => 30],
            [['cover_image'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'menu_id' => 'Menu ID',
            'user_id' => 'User ID',
            'menu_name' => '菜谱名称',
            'cover_image' => '封面',
            'created_at' => 'Created At',
        ];
    }
}
