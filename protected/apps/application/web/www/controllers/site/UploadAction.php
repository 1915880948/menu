<?php
/**
 * @category UploadAction
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 2017/6/9 13:23
 * @since
 */

namespace application\web\www\controllers\site;

use application\web\www\components\WwwBaseAction;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

/**
 * Class UploadAction
 * @package application\web\www\controllers
 */
class UploadAction extends WwwBaseAction
{
    public function run()
    {
        $up = new UploadManager();
        $auth = new Auth('4anqkkH-pq0_pS32h95UEXqVB3LG5p7l-XEW8r7w', 'dpNGr525pxte5s-eFdJBgoxP2mqTUZ2WOOX8UQQj');
        $token = $auth->uploadToken('kkread');
        $filePath = \Yii::getAlias('@root/app.sh');
        $key = basename($filePath);
        list($ret, $err) = $up->putFile($token, $key, $filePath);
        echo "\n====> putFile result: \n";
        if($err !== null){
            var_dump($err);
        } else{
            var_dump($ret);
        }
    }
}
