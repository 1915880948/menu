<?php

namespace application\models\db;

use Yii;

/**
 * This is the model class for table "{{%menu_type}}".
 *
 * @property integer $id
 * @property string $type_name
 * @property integer $status
 * @property string $created_at
 */
class TblMenuType extends \application\common\db\ApplicationActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_name'], 'required'],
            [['status'], 'integer'],
            [['created_at'], 'safe'],
            [['type_name'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_name' => 'Type Name',
            'status' => '状态：1：正常，0：删除',
            'created_at' => 'Created At',
        ];
    }
}
