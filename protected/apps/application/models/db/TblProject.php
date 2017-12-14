<?php

namespace application\models\db;

use Yii;

/**
 * This is the model class for table "{{%project}}".
 *
 * @property integer $id
 * @property integer $project_id
 * @property integer $visit_num
 * @property integer $click_num
 * @property string $created_at
 * @property string $updated_at
 * @property integer $status
 */
class TblProject extends \application\common\db\ApplicationActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%project}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'visit_num', 'click_num', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe']
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
            'visit_num' => 'Visit Num',
            'click_num' => 'Click Num',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
}
