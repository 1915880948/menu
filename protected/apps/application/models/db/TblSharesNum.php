<?php

namespace application\models\db;

use Yii;

/**
 * This is the model class for table "{{%shares_num}}".
 *
 * @property integer $id
 * @property integer $project_id
 * @property integer $docu_id
 * @property integer $shares
 * @property string $user_ip
 * @property string $created_at
 * @property string $updated_at
 * @property string $txt
 * @property integer $status
 */
class TblSharesNum extends \application\common\db\ApplicationActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shares_num}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'docu_id', 'shares', 'status'], 'integer'],
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
            'shares' => 'Shares',
            'user_ip' => 'User Ip',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'txt' => 'Txt',
            'status' => 'Status',
        ];
    }
}
