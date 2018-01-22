<?php
namespace application\web\admin\controllers\ingredients;
use application\models\base\Ingredients;
use application\web\admin\components\AdminBaseAction;

class AddAction extends AdminBaseAction{
    public function run(){
        if( \Yii::$app->request->isPost){
            \Yii::$app->response->format = 'json';
            $postData = \Yii::$app->request->post();

            if( $postData['method'] == 'getData'){
                $data = Ingredients::find()
                    ->andWhere(['id'=>$postData['id']])
                    ->asArray()
                    ->one();
                return $data;
            }

            if( $postData['method'] == 'add'){
                $model          = new Ingredients();
                $model->menu_id = $postData['menu_id'];
                $model->type_id = $postData['type_id'];
                $model->name    = $postData['inger_name'];
                $model->amount  = $postData['amount'];
                if($model->save()){
                    return ['code'=>200];
                }
            }
            if( $postData['method'] == 'edit'){
                $model          = Ingredients::findByPk($postData['id']);
                $model->menu_id = $postData['menu_id'];
                $model->type_id = $postData['type_id'];
                $model->name    = $postData['inger_name'];
                $model->amount  = $postData['amount'];
                if($model->save()){
                    return ['code'=>200];
                }
            }
        }
    }
}