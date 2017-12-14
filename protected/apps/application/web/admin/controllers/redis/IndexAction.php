<?php
namespace application\web\admin\controllers\redis;

use application\models\base\Browserdate;
use application\models\base\Docustatistical;
use application\models\base\SharesNum;
use application\models\base\SidebarClick;
use application\models\base\Visituserdata;
use application\web\admin\components\AdminBaseAction;
use yii\helpers\Json;
use yii\redis\Connection;

class IndexAction extends AdminBaseAction{
    public function run(){
        $visituserdate   = new Visituserdata();
        $sharesnum       = new SharesNum();
        $browser         = new Browserdate();
        $sidebarclick    = new SidebarClick();
        $docustatistical = new Docustatistical();

        $length_visituserdata   =  $this->getRedis()->llen('visituserdata');
        $length_sharesnum       =  $this->getRedis()->llen('Sharesnum');
        $length_browser         =  $this->getRedis()->llen('browserdata');
        $length_sidebarclick    =  $this->getRedis()->llen('Sidebarclick');
        $length_docustatistical =  $this->getRedis()->llen('docustatistical');

        while($length_visituserdata){
            $list = Json::decode($this->getRedis()->lpop('visituserdata'));
            $visituserdate->ip         = $list['Ip'];
            $visituserdate->province   = $list['province'];
            $visituserdate->city       = $list['city'];
            $visituserdate->created_at = $list['created_at'];
            if( $visituserdate->save() ){
                $visituserdate         = new Visituserdata();
                $length_visituserdata -= 1;
            }
        }
        while($length_sharesnum){
            $list = Json::decode($this->getRedis()->lpop('Sharesnum'));
            $sharesnum->project_id = $list['Project_id'];
            $sharesnum->docu_id    = $list['Docu_id'];
            $sharesnum->shares     = $list['Shares'];
            $sharesnum->user_ip    = $list['user_ip'];
            $sharesnum->created_at = $list['created_at'];
            if( $sharesnum->save() ){
                $sharesnum         = new SharesNum();
                $length_sharesnum     -= 1;
            }
        }
        while ($length_browser){
            $list = Json::decode($this->getRedis()->lpop('browserdata'));
            $browser->project_id = $list['Project_id'];
            $browser->bro_name   = $list['bro_name'];
            $browser->is_pc      = $list['is_pc'];
            $browser->created_at = $list['created_at'];
            $browser->source_url = $list['Source_url'];
            if( $browser->save() ){
                $browser         = new Browserdate();
                $length_browser  -= 1;
            }
        }
        while ($length_sidebarclick ){
            $list = Json::decode($this->getRedis()->lpop('Sidebarclick'));
            $sidebarclick->project_id  = $list['Project_id'];
            $sidebarclick->sidebar_id  = $list['Sidebar_id'];
            $sidebarclick->click_total = $list['ClickTotal'];
            $sidebarclick->created_at  = $list['created_at'];
            if( $sidebarclick->save() ){
                $sidebarclick          = new SidebarClick();
                $length_sidebarclick  -= 1;
            }
        }
        while ($length_docustatistical ){
            $list = Json::decode($this->getRedis()->lpop('docustatistical'));
            $docustatistical->project_id = $list['Project_id'];
            $docustatistical->docu_id   = $list['Docu_id'];
            $docustatistical->click      = $list['Click'];
            $docustatistical->visits = $list['Visits'];
            $docustatistical->user_ip = $list['user_ip'];
            $docustatistical->created_at = $list['created_at'];
            if( $docustatistical->save() ){
                $docustatistical         = new Docustatistical();
                $length_docustatistical -= 1;
            }
        }

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

}