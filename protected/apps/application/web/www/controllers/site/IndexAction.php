<?php
/**
 * @category IndexAction
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 2016/10/11 20:26
 * @since
 */

namespace application\web\www\controllers\site;

use application\web\www\components\WwwBaseAction;

/**
 * Class IndexAction
 * @package application\web\www\controllers\site
 */
class IndexAction extends WwwBaseAction
{
    public function run()
    {
        return $this->render();
    }
}
