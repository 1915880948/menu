<?php

namespace application\models\db;

use Yii;

/**
 * This is the model class for table "{{%menu_tag}}".
 *
 * @property integer $id
 * @property string $tag_name
 * @property integer $is_use
 * @property integer $status
 * @property string $created_at
 */
class TblMenuTag extends \application\common\db\ApplicationActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu_tag}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_use', 'status'], 'integer'],
            [['created_at'], 'safe'],
            [['tag_name'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tag_name' => 'Tag Name',
            'is_use' => '是否使用',
            'status' => '状态：1正常，0：删除',
            'created_at' => 'Created At',
        ];
    }
}
