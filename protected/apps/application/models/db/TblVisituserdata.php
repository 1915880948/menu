<?php

namespace application\models\db;

use Yii;

/**
 * This is the model class for table "{{%visituserdata}}".
 *
 * @property integer $id
 * @property string $ip
 * @property string $province
 * @property string $city
 * @property string $created_at
 * @property string $txt
 * @property integer $status
 */
class TblVisituserdata extends \application\common\db\ApplicationActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%visituserdata}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at'], 'safe'],
            [['status'], 'integer'],
            [['ip', 'province', 'city'], 'string', 'max' => 20],
            [['txt'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip' => 'Ip',
            'province' => 'Province',
            'city' => 'City',
            'created_at' => 'Created At',
            'txt' => 'Txt',
            'status' => 'Status',
        ];
    }
}
