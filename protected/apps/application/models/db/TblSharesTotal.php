<?php

namespace application\models\db;

use Yii;

/**
 * This is the model class for table "{{%shares_total}}".
 *
 * @property integer $id
 * @property integer $project_id
 * @property integer $docu_id
 * @property integer $shares_nums
 * @property string $created_at
 * @property string $updated_at
 * @property integer $status
 */
class TblSharesTotal extends \application\common\db\ApplicationActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shares_total}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'docu_id', 'shares_nums', 'status'], 'integer'],
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
            'docu_id' => 'Docu ID',
            'shares_nums' => 'Shares Nums',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
}
