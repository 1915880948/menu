<?php

namespace application\models\db;

use Yii;

/**
 * This is the model class for table "{{%browserdate}}".
 *
 * @property integer $id
 * @property integer $project_id
 * @property string $bro_name
 * @property integer $is_pc
 * @property string $source_url
 * @property string $created_at
 * @property string $txt
 * @property integer $status
 */
class TblBrowserdate extends \application\common\db\ApplicationActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%browserdate}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'is_pc', 'status'], 'integer'],
            [['created_at'], 'safe'],
            [['bro_name'], 'string', 'max' => 20],
            [['source_url'], 'string', 'max' => 50],
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
            'bro_name' => 'Bro Name',
            'is_pc' => 'Is Pc',
            'source_url' => 'Source Url',
            'created_at' => 'Created At',
            'txt' => 'Txt',
            'status' => 'Status',
        ];
    }
}
