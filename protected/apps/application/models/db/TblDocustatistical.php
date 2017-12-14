<?php

namespace application\models\db;

use Yii;

/**
 * This is the model class for table "{{%docustatistical}}".
 *
 * @property integer $id
 * @property integer $project_id
 * @property integer $docu_id
 * @property integer $click
 * @property integer $visits
 * @property string $user_ip
 * @property string $created_at
 * @property string $updated_at
 * @property string $txt
 * @property integer $status
 */
class TblDocustatistical extends \application\common\db\ApplicationActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%docustatistical}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'docu_id', 'click', 'visits', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['user_ip'], 'string', 'max' => 20],
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
            'project_id' => 'Project ID',
            'docu_id' => 'Docu ID',
            'click' => 'Click',
            'visits' => 'Visits',
            'user_ip' => 'User Ip',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'txt' => 'Txt',
            'status' => 'Status',
        ];
    }
}
