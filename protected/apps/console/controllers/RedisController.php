<?php
/**
 * @category RedisController
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 27/11/2017 13:18
 * @since
 */

namespace console\controllers;

use yii\console\Controller;
use yii\helpers\Console;
use yii\helpers\Json;
use yii\redis\Connection;

class RedisController extends Controller
{
    public function actionIndex()
    {
        $actions = ['actionSharesnum', 'actionVisituserdata', 'actionBrowserdata', 'actionDocustatistical', 'actionSidebarclick'];
        while(true){
            foreach($actions as $action){
                $this->$action();
            }
            Console::output("insert success");
            sleep(rand(1,2));
        }
    }

    public function actionSharesnum()
    {
        //"{\"Project_id\":\"56\",\"Docu_id\":\"10698\",\"Shares\":\"1\",\"user_ip\":\"121.33.56.135\",\"created_at\":1511758800}"
        $data = [
            'Project_id' => rand(1, 9),
            'Docu_id'    => rand(11, 19),
            'Shares'     => rand(1, 5),
            'user_ip'    => sprintf("%s.%s.%s.%s", rand(1, 254), rand(1, 254), rand(1, 254), rand(1, 254)),
            'created_at' => time(),
        ];
        $this->getRedis()
             ->rpush('Sharesnum', Json::encode($data));
    }

    public function actionVisituserdata()
    {
        //"{\"Ip\":\"114.82.35.155\",\"province\":\"\\u4e0a\\u6d77\\u5e02\",\"city\":\"\\u4e0a\\u6d77\\u5e02\",\"created_at\":1511761742}"
        $data = [
            'Ip'         => sprintf("%s.%s.%s.%s", rand(1, 254), rand(1, 254), rand(1, 254), rand(1, 254)),
            'province'   => ['上海', '北京', '天津', '重庆','浙江','安徽','江苏','湖北','湖南','陕西'][rand(0, 9)],
            'city'       => ['上海市', '北京市', '天津市', '重庆市'][rand(0, 3)],
            'created_at' => time(),
        ];
        $this->getRedis()
             ->rpush('visituserdata', Json::encode($data));
    }

    public function actionBrowserdata()
    {
        //"{\"Project_id\":\"16\",\"bro_name\":\"Chrome 16.0.912.75\",\"is_pc\":\"1\",\"create_time\":1511758800,\"Source_url\":\"http:\\/\\/www.discovery.mediafed.net\\/cards\"}"
        $data = [
            'Project_id' => rand(1, 9),
            'bro_name'   => ['Chrome 16.0.912.75', 'Firefox 1.0.1', 'Safari 2.0.1', 'MicroMessage 1.0'][rand(0, 3)],
            'is_pc'      => rand(0, 1),
            'created_at' => time(),
            'Source_url' => 'http://www.discovery.mediafed.net/' . (['share', 'card', 'pay', 'top'][rand(0, 3)])
        ];
        $this->getRedis()
             ->rpush('browserdata', Json::encode($data));
    }

    public function actionDocustatistical()
    {
        //"{\"user_ip\":\"36.149.146.21\",\"Project_id\":\"16\",\"Docu_id\":\"10744\",\"Click\":\"1\",\"Visits\":\"1\",\"created_at\":1511758800}"
        $data = [
            'user_ip'    => sprintf("%s.%s.%s.%s", rand(1, 254), rand(1, 254), rand(1, 254), rand(1, 254)),
            'Project_id' => rand(1,9),
            'Docu_id'    => rand(11, 19),
            'Click'      => rand(1, 5),
            'Visits'     => rand(1, 5),
            'created_at' => time() ,
        ];
        $this->getRedis()
             ->rpush('docustatistical', Json::encode($data));
    }

    public function actionSidebarclick()
    {
        //"{\"Project_id\":\"56\",\"Sidebar_id\":\"718\",\"ClickTotal\":\"1\",\"create_time\":1511758800}"
        $data = [
            'Project_id' => rand(1, 9),
            'Sidebar_id' => rand(20, 30),
            'ClickTotal' => rand(1, 5),
            'created_at' => time(),
        ];
        $this->getRedis()
             ->rpush('Sidebarclick', Json::encode($data));
    }

    protected function getRedis($database = 0)
    {
        /** @var Connection $redis */
        $redis = \Yii::$app->redis;
        if($database){
            $redis->executeCommand('SELECT', [$database]);
        }
        return $redis;
    }

    /**
     * ....无效
     * @param $key
     * @return string
     */
    protected function getRedisKey($key)
    {
        return strtolower(str_replace('action', '', $key));
    }
}
