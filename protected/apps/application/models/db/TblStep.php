<?php

namespace application\models\db;

use Yii;

/**
 * This is the model class for table "{{%step}}".
 *
 * @property integer $id
 * @property integer $menu_id
 * @property integer $step_number
 * @property string $method
 * @property string $images
 * @property integer $status
 * @property string $created_at
 */
class TblStep extends \application\common\db\ApplicationActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%step}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_id', 'step_number', 'status'], 'integer'],
            [['created_at'], 'safe'],
            [['method', 'images'], 'string', 'max' => 255]
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
            'step_number' => '步骤序号',
            'method' => '方法',
            'images' => '图片',
            'status' => '状态：1：正常，0:删除',
            'created_at' => 'Created At',
        ];
    }
}
