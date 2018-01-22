<?php

namespace application\models\db;

use Yii;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $menu_id
 * @property string $menu_name
 * @property string $cover_image
 * @property integer $total_price
 * @property integer $is_pay
 * @property integer $status
 * @property string $pay_time
 * @property string $created_at
 */
class TblOrder extends \application\common\db\ApplicationActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'menu_id'], 'required'],
            [['user_id', 'menu_id', 'total_price', 'is_pay', 'status'], 'integer'],
            [['pay_time', 'created_at'], 'safe'],
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
            'user_id' => 'User ID',
            'menu_id' => 'Menu ID',
            'menu_name' => '菜谱名',
            'cover_image' => '封面',
            'total_price' => '总价价格',
            'is_pay' => '是否支付：1: 是。0:否',
            'status' => '状态：1:正常，0:删除',
            'pay_time' => '支付时间',
            'created_at' => '创建时间',
        ];
    }
}
