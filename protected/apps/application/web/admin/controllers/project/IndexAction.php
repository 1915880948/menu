<?php
namespace application\web\admin\controllers\project;
use application\models\base\Project;
use application\web\admin\components\AdminBaseAction;

class IndexAction extends AdminBaseAction{
    public $select = "id,project_id,sum(visit_num) as visit_num,sum(click_num) as click_num,created_at";
    public function run(){

        $project = \Yii::$app->params['project'] ;
        if( \Yii::$app->request->isPost ){
            \Yii::$app->response->format = 'json';
            $project_id = \Yii::$app->request->post('project_id');
            $start_time = \Yii::$app->request->post('start_time');
            $end_time   = \Yii::$app->request->post('end_time');

            $day = \Yii::$app->request->post('day');

            $list = Project::find()
                ->select($this->select)
                ->andWhere(['status'=>1]);
            if( $project_id != 0 ) {
                $list = $list->andWhere(['project_id' => $project_id]);
            }
            if( $start_time && $end_time ){
                $list = $list->andWhere(['>=','created_at',$start_time])
                ->andWhere(['<=','created_at',$end_time]);
            }else{
                $list = $list->andWhere(['>','created_at', date('Y-m-d',time()-$day*86400)]);
            }
            $list = $list
                    ->groupBy(['created_at'])
                    ->orderBy(['created_at'=>SORT_ASC])
                    ->asArray()
                    ->all();

         return $list;
        }
        return $this->render(compact('project'));
    }
}