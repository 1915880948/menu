<?php
/**
 * @category IndexAction
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 2017/5/8 09:42
 * @since
 */

namespace application\web\api\controllers\site;

use application\common\base\ApiBaseAction;
use common\core\base\Schema;

/**
 * Class IndexAction
 * @package application\web\api\controllers\site
 */
class IndexAction extends ApiBaseAction
{
    public function run()
    {
        return Schema::Success(['abc' => 123,'isdev'=>IS_LOCAL_MODE]);
    }
}
