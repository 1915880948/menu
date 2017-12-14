<?php
namespace console\controllers;

use application\models\base\Browserdate;
use application\models\base\BrowserTotal;
use application\models\base\Docustatistical;
use application\models\base\DocuTotal;
use application\models\base\Project;
use application\models\base\SharesNum;
use application\models\base\SharesTotal;
use application\models\base\SidebarClick;
use application\models\base\SidebarTotal;
use application\models\base\VisitsTotal;
use application\models\base\Visituserdata;
use yii\console\Controller;
use yii\helpers\Console;
use yii\helpers\Json;
use yii\redis\Connection;

class RedisAddController extends Controller{

    public function actionBrowser(){
        while ( $data = $this->getRedis()->lpop('browserdata') ){
            $browser = new Browserdate();
            $dataJson = Json::decode( $data );
            $browser->project_id = $dataJson['Project_id'];
            $browser->bro_name   = $dataJson['bro_name'];
            $browser->is_pc      = $dataJson['is_pc'];
            $browser->created_at = date('Y-m-d H:i:s',$dataJson['created_at']);
            $browser->source_url = $dataJson['Source_url'];
            if( $browser->save() ){
                $day_data = BrowserTotal::find()
                    ->andWhere(['bro_name'=> explode(" ",$dataJson['bro_name'])[0]])
                    ->andWhere(['project_id'=>$dataJson['Project_id']])
                    ->andWhere(['is_pc'=>$dataJson['is_pc']])
                    ->andWhere(['=','created_at',date('Y-m-d',$dataJson['created_at'])])
                    ->one();
//                $sql = $day_data->createCommand()->getRawSql();
//               print_r( $sql ); exit;
//                Console::output( json_encode($day_data));
//                Console::output( json_encode($dataJson));
//                Console::output( json_encode($sql));
                if( $day_data ){
                    $day_data->use_num += 1;
                    if( $day_data->save() ){
                        Console::output('browser use_num add success!');
                    }
                }else{
                    $browser_total = new BrowserTotal();
                    $browser_total->project_id = $dataJson['Project_id'];
                    $browser_total->bro_name   = explode(" ",$dataJson['bro_name'])[0];
                    $browser_total->is_pc      = $dataJson['is_pc'];
                    $browser_total->use_num    = 1 ;
                    $browser_total->created_at = date('Y-m-d',$dataJson['created_at']);
                    if( $browser_total->save() ){
                        Console::output('browser use_num insert success!');
                    }
                }
                Console::output('browser add success!');
                sleep(1);
            }else{
                continue ;
            }
        }
    }

    public function actionDocuStatistical(){
        while ( $data = $this->getRedis()->lpop('docustatistical')){
            $docu = new Docustatistical();
            $dataJson = Json::decode($data);
            $docu->project_id = $dataJson['Project_id'];
            $docu->docu_id    = $dataJson['Docu_id'];
            $docu->click      = $dataJson['Click'];
            $docu->visits     = $dataJson['Visits'];
            $docu->user_ip    = $dataJson['user_ip'];
            $docu->created_at = date('Y-m-d H:i:s',$dataJson['created_at']);
            if( $docu->save() ) {
                $day_data = DocuTotal::find()
                    ->andWhere(['project_id'=>$dataJson['Project_id'],'docu_id'=>$dataJson['Docu_id']])
                    ->andWhere(['=','created_at',date('Y-m-d',$dataJson['created_at'])])
                    ->one();
                if( !empty($day_data) ){
                    $day_data->click     += $dataJson['Click'];
                    $day_data->visits    += $dataJson['Visits'];
                    if( $day_data->save() ){
                        Console::output('docustatistical click,visits add success!');
                    }
                }else{
                    $docu_total = new DocuTotal();
                    $docu_total->project_id = $dataJson['Project_id'];
                    $docu_total->docu_id    = $dataJson['Docu_id'];
                    $docu_total->click      = $dataJson['Click'];
                    $docu_total->visits     = $dataJson['Visits'];
                    $docu_total->created_at =date('Y-m-d',$dataJson['created_at']);
                    if( $docu_total->save() ){
                        Console::output('docustatistical click,visits insert success!');
                    }
                }
                Console::output('docustatistical add success!');
                sleep( 1);
            }else{
                continue;
            }
        }
    }

    public function actionShares(){
        while ( $data = $this->getRedis()->lpop('Sharesnum')){
            $shares = new SharesNum();
            $dataJson = json::decode($data);
            $shares->project_id = $dataJson['Project_id'];
            $shares->docu_id    = $dataJson['Docu_id'];
            $shares->shares     = $dataJson['Shares'];
            $shares->user_ip    = $dataJson['user_ip'];
            $shares->created_at = date('Y-m-d H:i:s',$dataJson['created_at']);
            if( $shares->save() ){
                $day_data = SharesTotal::find()
                    ->andWhere(['project_id'=>$dataJson['Project_id'],'docu_id'=>$dataJson['Docu_id']])
                    ->andWhere(['=','created_at',date('Y-m-d',$dataJson['created_at'])])
                    ->one();
                if( !empty($day_data) ){
                    $day_data->shares_nums    += $dataJson['Shares'];
                    if( $day_data->save()) {
                        Console::output(' shares_total shares add success!');
                    }
                }else{
                    $shares_total = new SharesTotal();
                    $shares_total->project_id   = $dataJson['Project_id'];
                    $shares_total->docu_id      = $dataJson['Docu_id'];
                    $shares_total->shares_nums  = $dataJson['Shares'];
                    $shares_total->created_at   = date('Y-m-d',$dataJson['created_at']);
                    if( $shares_total->save() ){
                        Console::output('shares_total shares insert success!');
                    }
                }
                Console::output(' shares add success!');
                sleep(1);
            }else{
                continue;
            }
        }
    }

    public function actionSidebar(){
        while ( $data = $this->getRedis()->lpop('Sidebarclick')){
            $sidebar = new SidebarClick();
            $dataJson = Json::decode($data);
            $sidebar->project_id  = $dataJson['Project_id'];
            $sidebar->sidebar_id  = $dataJson['Sidebar_id'];
            $sidebar->click_total = $dataJson['ClickTotal'];
            $sidebar->created_at  = date('Y-m-d H:i:s',$dataJson['created_at']);
            if( $sidebar->save() ){
                $day_data = SidebarTotal::find()
                    ->andWhere(['project_id'=>$dataJson['Project_id'],'sidebar_id'=>$dataJson['Sidebar_id']])
                    ->andWhere(['=','created_at',date('Y-m-d',$dataJson['created_at'])])
                    ->one();
                if( !empty($day_data) ){
                    $day_data->click_total += $dataJson['ClickTotal'];
                    if( $day_data->save() ){
                        Console::output('sidebar click_total add success!');
                    }
                }else{
                    $sidebar_total = new SidebarTotal();
                    $sidebar_total->project_id  = $dataJson['Project_id'];
                    $sidebar_total->sidebar_id  = $dataJson['Sidebar_id'];
                    $sidebar_total->click_total = $dataJson['ClickTotal'];
                    $sidebar_total->created_at  = date('Y-m-d',$dataJson['created_at']);
                    if($sidebar_total->save()){
                        Console::output('sidebar click_total insert success!');
                    }
                }
                Console::output('sidebar add success!');
                sleep(1);
            }else{
                continue;
            }
        }
    }

    public function actionVisitor(){
        while ( $data = $this->getRedis()->lpop('visituserdata')){
            $visitor = new Visituserdata();
            $dataJson = Json::decode($data);
            $visitor->ip         = $dataJson['Ip'];
            $visitor->province   = $dataJson['province'];
            $visitor->city       = $dataJson['city'];
            $visitor->created_at = date('Y-m-d H:i:s',$dataJson['created_at']);
            if( $visitor->save() ){
                $day_data = VisitsTotal::find()
                    ->andWhere(['province'=>$dataJson['province'],'city'=>$dataJson['city']])
                    ->andWhere(['=','created_at',date('Y-m-d',$dataJson['created_at'])])
                    ->one();
                if( !empty($day_data)){
                    $day_data->visits_num += 1;
                    if($day_data->save()){
                        Console::output('visitor visits_num add success!');
                    }
                }else{
                    $visits_total = new VisitsTotal();
                    $visits_total->province = $dataJson['province'];
                    $visits_total->city = $dataJson['city'];
                    $visits_total->visits_num = 1;
                    $visits_total->created_at = date('Y-m-d',$dataJson['created_at']);
                    if($visits_total->save()){
                        Console::output('visitor visits_num insert success!');
                    }
                }
                Console::output('visitor add success!');
                sleep(1);
            }else{
                continue;
            }
        }
    }


    protected function getRedis($database = 0){
        /** @var Connection $redis */
        $redis = \Yii::$app->redis;
        if($database){
            $redis->executeCommand('SELECT', [$database]);
        }
        return $redis;
    }

    public function actionProject(){
        $dayData = SidebarTotal::find()
            ->select("sidebar.project_id,sum(click_total) as click_num,sum(visits) as visit_num,sidebar.created_at,docu.updated_at")
            ->from("{{%sidebar_total}} as sidebar")
            ->leftJoin("{{%docu_total}} as docu","sidebar.project_id= docu.project_id")
            ->andWhere(['>','sidebar.updated_at',date('Y-m-d 00:00:00',time())])
            ->groupBy('project_id')
            ->asArray()
            ->all();

        if( $dayData ){
            foreach ( $dayData as $k=>$v){
                $project = Project::find()
                    ->andWhere(['project_id'=>$v['project_id']])
                    ->andWhere(['=','created_at',date('Y-m-d',time())])
                    ->one();
                if( $project ){
                    $project->click_num += $v['click_num'];
                    $project->visit_num += $v['visit_num'];
                    $project->updated_at = $v['updated_at'];
                    $project->save();
                }else{
                    $dayProject = new Project();
                    $dayProject->project_id = $v['project_id'];
                    $dayProject->click_num  = $v['click_num'];
                    $dayProject->visit_num  = $v['visit_num'];
                    $dayProject->created_at = $v['created_at'];
                    if( !$dayProject->save() ){
                        continue;
                    }
                }

            }
        }
        Console::output('project insert success every day!');
    }

}
