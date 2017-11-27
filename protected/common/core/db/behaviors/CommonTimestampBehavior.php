<?php
/**
 * @category CommonTimestampBehavior
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 2016/10/6 10:02
 * @since
 */
namespace common\core\db\behaviors;

use yii\base\Event;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Class CommonTimestampBehavior
 * @package common\core\db\behaviors
 */
class CommonTimestampBehavior extends TimestampBehavior
{
    use SafeAttributeBehavior;
}
