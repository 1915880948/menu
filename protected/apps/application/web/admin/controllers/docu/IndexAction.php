<?php
namespace application\web\admin\controllers\docu;
use application\models\base\DocuTotal;
use application\web\admin\components\AdminBaseAction;

class IndexAction extends AdminBaseAction{
    public $select = "id,project_id,docu_id,sum(click) as click,created_at";
    public function run(){
        $project = \Yii::$app->params['project'];
        $docu = \Yii::$app->params['docu'];
        if(\Yii::$app->request->isPost){
            \Yii::$app->response->format= 'json';
            $project_id = \Yii::$app->request->post('project_id');
            $docu_id    = \Yii::$app->request->post('docu_id');
            $start_time = \Yii::$app->request->post('start_time');
            $end_time   = \Yii::$app->request->post('end_time');
            $day        = \Yii::$app->request->post('day');

            $list = DocuTotal::find()->andWhere(['status'=>1]);
            if( $project_id != 0 ){
                $list = $list->andWhere(['project_id'=>$project_id]);
                if( $docu_id != 0 ){
                    $list = $list->andWhere(['docu_id'=>$docu_id]);
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
                $list[$k]['docu_name'] = $docu[$list[$k]['docu_id']];
            }
            return $list;
        }

        return $this->render(compact('project'));
    }

}