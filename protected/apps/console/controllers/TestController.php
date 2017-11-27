<?php
/**
 * @category TestController
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 2017/4/25 00:37
 * @since
 */

namespace console\controllers;

use yii\console\Controller;

/**
 * Class TestController
 * @package console\controllers
 */
class TestController extends Controller
{
    public function actionIndex()
    {
        echo __FILE__;
    }
}
