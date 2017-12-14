<?php

namespace application\models\db;

use Yii;

/**
 * This is the model class for table "{{%sidebar_total}}".
 *
 * @property integer $id
 * @property integer $project_id
 * @property integer $sidebar_id
 * @property integer $click_total
 * @property string $created_at
 * @property string $updated_at
 * @property integer $status
 */
class TblSidebarTotal extends \application\common\db\ApplicationActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sidebar_total}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'sidebar_id', 'click_total', 'status'], 'integer'],
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
            'sidebar_id' => 'Sidebar ID',
            'click_total' => 'Click Total',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
}
