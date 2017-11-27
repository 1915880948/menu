<?php
/**
 * @category CommonBlameableBehavior
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 2016/10/20 00:21
 * @since
 */
namespace common\core\db\behaviors;

use yii\behaviors\BlameableBehavior;

/**
 * Class CommonBlameableBehavior
 * @package common\core\db\behaviors
 */
class CommonBlameableBehavior extends BlameableBehavior
{
    use SafeAttributeBehavior;
}
