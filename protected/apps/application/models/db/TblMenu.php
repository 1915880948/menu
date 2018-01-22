<?php

namespace application\models\db;

use Yii;

/**
 * This is the model class for table "{{%menu}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $cover_img
 * @property string $desc
 * @property string $type_id
 * @property string $tag_ids
 * @property integer $series_id
 * @property integer $is_free
 * @property integer $price
 * @property integer $pay_num
 * @property integer $love_num
 * @property integer $click_num
 * @property integer $views_num
 * @property integer $is_shift
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class TblMenu extends \application\common\db\ApplicationActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['series_id', 'is_free', 'price', 'pay_num', 'love_num', 'click_num', 'views_num', 'is_shift', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 30],
            [['cover_img', 'desc'], 'string', 'max' => 255],
            [['type_id', 'tag_ids'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'cover_img' => '封面图片',
            'desc' => '简介',
            'type_id' => '类别id',
            'tag_ids' => '标签id',
            'series_id' => '菜系id',
            'is_free' => '是否付费：1：付费，0：免费',
            'price' => '价格',
            'pay_num' => '购买人数',
            'love_num' => '收藏数',
            'click_num' => '点赞数',
            'views_num' => '浏览数',
            'is_shift' => '是否上架：1：是，0：否',
            'status' => '状态：1：正常，0：删除',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
