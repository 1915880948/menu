<?php
namespace application\web\admin\controllers\step;
use application\models\base\Step;
use application\web\admin\components\AdminBaseAction;

class AddAction extends AdminBaseAction{
    public function run(){
        if(\Yii::$app->request->isPost) {
            \Yii::$app->response->format = 'json';
            $postData = \Yii::$app->request->post();
            if( $postData['method'] == 'add') {
                $model = new Step();
                $imageArr  = explode(',',trim($postData['images'],','));
                $model->menu_id     = $postData['menu_id'];
                $model->step_number = $postData['step_number'];
                $model->method      = $postData['do_way'];
                $model->images      = json_encode($imageArr);
                $model->status      = 1;
                $model->created_at  = date('Y-m_d H:i:s');
                if( $model->save() ){
                    return ['code'=>200];
                }
            }

            if( $postData['method'] == 'edit' ){
                $model = Step::findByPk($postData['id']);
                $imageArr  = explode(',',trim($postData['images'],','));
                $model->menu_id     = $postData['menu_id'];
                $model->step_number = $postData['step_number'];
                $model->method      = $postData['do_way'];
                $model->images      = json_encode($imageArr);
                $model->status      = 1;
                $model->created_at  = date('Y-m_d H:i:s');
                if( $model->save() ){
                    return ['code'=>200];
                }
            }

            if( $postData['method'] == 'getData'){
                $data = Step::find()
                    ->andWhere(['id'=>$postData['id']])
                    ->asArray()
                    ->one();
                return $data;
            }
        }
    }
}