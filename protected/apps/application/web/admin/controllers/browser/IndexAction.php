<?php
namespace application\web\admin\controllers\browser;

use application\models\base\Browserdate;
use application\models\base\BrowserTotal;
use application\web\admin\components\AdminBaseAction;

class IndexAction extends AdminBaseAction {
    public $select = "project_id, sum(use_num) as num,bro_name,is_pc,created_at,updated_at";
    public function run()
    {
        $project = \Yii::$app->params['project'];
        if( \Yii::$app->request->isPost ){
            \Yii::$app->response->format = 'json';
            $project_id = \Yii::$app->request->post('project_id');
            $start_time = \Yii::$app->request->post('start_time');
            $end_time   = \Yii::$app->request->post('end_time');
            $day        = \Yii::$app->request->post('day');
            $is_pc      = \Yii::$app->request->post('is_pc');

            $list = BrowserTotal::find()
                ->select($this->select)
                ->andWhere(['status' => 1]);
            if( $project_id != 0 ) {
                $list = $list->andWhere(['project_id' => $project_id]);
            }
            if($is_pc != 3) {
                $list = $list->andWhere(['is_pc' => $is_pc ]);
            }
            if( $start_time && $end_time ){
                $list = $list->andWhere(['>=','created_at',$start_time])
                    ->andWhere(['<=','created_at',$end_time]);
            }else{
                $list = $list->andWhere(['>','created_at', date('Y-m-d',time()-$day*86400)]);
            }
            $list = $list
                    ->groupBy(['bro_name'])
                    ->orderBy(['created_at'=>SORT_DESC])
                    ->asArray()
                    ->all();

            return $list;
        }

        return $this->render(compact('project')) ;
    }
    public function getBrowser(){
        $type = BrowserTotal::find()
            ->andWhere(['status'=>1])
            ->groupBy('bro_name')
            ->asArray()
            ->all();
        return $type;
    }
}