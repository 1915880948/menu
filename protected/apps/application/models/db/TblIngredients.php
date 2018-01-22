<?php

namespace application\models\db;

use Yii;

/**
 * This is the model class for table "{{%ingredients}}".
 *
 * @property integer $id
 * @property integer $menu_id
 * @property integer $type_id
 * @property string $name
 * @property string $amount
 * @property integer $status
 * @property string $created_at
 */
class TblIngredients extends \application\common\db\ApplicationActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ingredients}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_id'], 'required'],
            [['menu_id', 'type_id', 'status'], 'integer'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 30],
            [['amount'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'menu_id' => '菜单id',
            'type_id' => '1:主料，2:辅料，3:调料',
            'name' => '食料名称',
            'amount' => '用量',
            'status' => '状态：1:正常，0:删除',
            'created_at' => 'Created At',
        ];
    }
}
