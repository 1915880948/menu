<?php
/**
 * @category QActiveQuery
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/1/12 15:12
 * @since
 */
namespace common\core\db\base;

use yii\db\ActiveQuery;

/**
 * Class QActiveQuery
 * @package common\core\db\base
 */
class QActiveQuery extends ActiveQuery
{
    public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }
}
