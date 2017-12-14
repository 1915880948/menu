<?php
namespace application\web\admin\controllers\sidebar;
use application\models\base\Project;
use application\models\base\SidebarTotal;
use application\web\admin\components\AdminBaseAction;

class IndexAction extends AdminBaseAction {
    public function run(){
        $project = \Yii::$app->params['project'];
        $sidebar = \Yii::$app->params['sidebar'];
        if( \Yii::$app->request->isPost ){
            \Yii::$app->response->format = 'json';
            $project_id = \Yii::$app->request->post('project_id');
            $sidebar_id = \Yii::$app->request->post('sidebar_id');
            $start_time = \Yii::$app->request->post('start_time');
            $end_time = \Yii::$app->request->post('end_time');
            $day = \Yii::$app->request->post('day');
            $list = SidebarTotal::find()->andWhere(['status'=>1]);
            if( $project_id != 0){
                $list = $list->andWhere(['project_id'=>$project_id]);
                if($sidebar_id!=0){
                    $list = $list->andWhere(['sidebar_id'=>$sidebar_id]);
                }
            }
            if( $start_time && $end_time ){
                $list = $list->andWhere(['>=','created_at',$start_time])
                    ->andWhere(['<=','created_at',$end_time]);
            }else{
                $list = $list
                    ->andWhere(['>','created_at', date('Y-m-d',time()-$day*86400)]);
            }
            $list = $list
                ->groupBy(['created_at'])
                ->orderBy(['created_at'=>SORT_ASC])
                ->asArray()
                ->all();
            foreach ($list as $k=>$v){
                $list[$k]['project_name'] = $project[$list[$k]['project_id']];
                $list[$k]['sidebar_name'] = $sidebar[$list[$k]['sidebar_id']];
            }
            return $list;
        }
        return $this->render(compact('project'));
    }
}