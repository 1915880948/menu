<?php

namespace application\models\db;

use Yii;

/**
 * This is the model class for table "{{%menu_series}}".
 *
 * @property integer $id
 * @property string $series_name
 * @property string $desc
 * @property integer $status
 * @property string $created_at
 */
class TblMenuSeries extends \application\common\db\ApplicationActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu_series}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['series_name'], 'required'],
            [['status'], 'integer'],
            [['created_at'], 'safe'],
            [['series_name'], 'string', 'max' => 20],
            [['desc'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'series_name' => '系列',
            'desc' => '描述',
            'status' => '状态：1：正常，0：删除',
            'created_at' => 'Created At',
        ];
    }
}
