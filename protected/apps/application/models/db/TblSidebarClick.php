<?php

namespace application\models\db;

use Yii;

/**
 * This is the model class for table "{{%sidebar_click}}".
 *
 * @property integer $id
 * @property integer $project_id
 * @property integer $sidebar_id
 * @property integer $click_total
 * @property string $created_at
 * @property string $updated_at
 * @property string $txt
 * @property integer $status
 */
class TblSidebarClick extends \application\common\db\ApplicationActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sidebar_click}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'sidebar_id', 'click_total', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
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
            'project_id' => '项目ID',
            'sidebar_id' => '导航ID',
            'click_total' => '导航点击总数',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'txt' => 'Txt',
            'status' => 'Status',
        ];
    }
}
