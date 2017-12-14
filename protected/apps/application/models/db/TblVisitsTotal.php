<?php

namespace application\models\db;

use Yii;

/**
 * This is the model class for table "{{%visits_total}}".
 *
 * @property integer $id
 * @property string $province
 * @property string $city
 * @property string $city_codes
 * @property integer $visits_num
 * @property string $created_at
 * @property string $updated_at
 * @property integer $status
 */
class TblVisitsTotal extends \application\common\db\ApplicationActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%visits_total}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['visits_num', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['province', 'city', 'city_codes'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'province' => 'Province',
            'city' => 'City',
            'city_codes' => 'City Codes',
            'visits_num' => 'Visits Num',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
}
