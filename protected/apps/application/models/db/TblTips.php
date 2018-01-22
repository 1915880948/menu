<?php

namespace application\models\db;

use Yii;

/**
 * This is the model class for table "{{%tips}}".
 *
 * @property integer $id
 * @property integer $menu_id
 * @property integer $tip_number
 * @property string $tip_name
 * @property integer $status
 * @property string $created_at
 */
class TblTips extends \application\common\db\ApplicationActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tips}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_id', 'tip_number', 'status'], 'integer'],
            [['created_at'], 'safe'],
            [['tip_name'], 'string', 'max' => 255]
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
            'tip_number' => '小贴士序号',
            'tip_name' => '小贴士',
            'status' => '状态：1:正常，0:删除',
            'created_at' => 'Created At',
        ];
    }
}
