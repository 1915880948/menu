<?php
namespace application\web\admin\controllers\ingredients;
use application\models\base\Ingredients;
use application\web\admin\components\AdminBaseAction;
use qiqi\helper\MessageHelper;

class DeleteAction extends AdminBaseAction{
    public function run($id=''){
        $model = Ingredients::findByPk($id);
        $model->status = 0;
        if( $model->save()){
            return MessageHelper::success('删除成功！！');
        }
    }
}