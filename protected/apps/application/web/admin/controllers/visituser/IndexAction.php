<?php
namespace application\web\admin\controllers\visituser;
use application\models\base\VisitsTotal;
use application\web\admin\components\AdminBaseAction;

class IndexAction extends AdminBaseAction{
    public function run()
    {
        if( \Yii::$app->request->isPost ){
            \Yii::$app->response->format = 'json';
            $start_time = \Yii::$app->request->post('start_time');
            $end_time   = \Yii::$app->request->post('end_time');
            $day        = \Yii::$app->request->post('day');
            $list = VisitsTotal::find()
                ->select('province as name, sum(visits_num) as value,created_at')
                ->andWhere(['status'=>1]);
            if( $start_time && $end_time){
                $list = $list->andWhere(['>=','created_at',$start_time])
                    ->andWhere(['<=','created_at',$end_time]);
            }else{
                $list = $list->andWhere(['>','created_at',date('Y-m-d',time()-$day*86400)]);
            }
            $list = $list
                ->groupBy('province')
                ->orderBy(['created_at'=>SORT_DESC])
                ->asArray()
                ->all();

            return $list;
        }
        return $this->render(compact(''));
    }

}