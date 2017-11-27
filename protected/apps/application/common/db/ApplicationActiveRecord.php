<?php
/**
 * @category ApplicationActiveRecord
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 2016/10/3 00:10
 * @since
 */
namespace application\common\db;

use common\core\db\base\QActiveRecord;
use common\core\db\behaviors\CommonBlameableBehavior;
use common\core\db\behaviors\CommonTimestampBehavior;
use yii\db\Expression;

/**
 * Class ApplicationActiveRecord
 * @package application\common\db
 */
class ApplicationActiveRecord extends QActiveRecord
{
    public function behaviors()
    {
        return [
            [//updated_at
                'class'              => CommonTimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value'              => new Expression('NOW()'),
            ],
            [//created_by

                'class' => CommonBlameableBehavior::className(),
            ],
        ];
    }
}
