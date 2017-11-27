<?php
/**
 * @category DefaultController
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 2017/6/9 13:02
 * @since
 */

namespace application\web\www\modules\wechat\controllers;

use application\web\www\modules\wechat\components\WechatController;
use wechat\Weixin;

/**
 * Class DefaultController
 * @package application\web\www\modules\wechat\controllers
 */
class DefaultController extends WechatController
{
    public function actionIndex()
    {
        $app = Weixin::getApp();
        $app->server->serve()
                    ->send();
    }
}
