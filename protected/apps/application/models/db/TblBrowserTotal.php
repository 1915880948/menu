<?php

namespace application\models\db;

use Yii;

/**
 * This is the model class for table "{{%browser_total}}".
 *
 * @property integer $id
 * @property integer $project_id
 * @property string $bro_name
 * @property integer $is_pc
 * @property integer $use_num
 * @property string $created_at
 * @property string $updated_at
 * @property integer $status
 */
class TblBrowserTotal extends \application\common\db\ApplicationActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%browser_total}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'is_pc', 'use_num', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['bro_name'], 'string', 'max' => 20]
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
            'bro_name' => 'Bro Name',
            'is_pc' => '1:是 0：否 ',
            'use_num' => 'Use Num',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
}
