<?php
namespace application\web\admin\controllers\tips;
use application\models\base\Tips;
use application\web\admin\components\AdminBaseAction;
use qiqi\helper\MessageHelper;

class DeleteAction extends AdminBaseAction{
    public function run($id=''){
        $model = Tips::findByPk($id);
        $model->status = 0;
        if( $model->save() ){
            return MessageHelper::success('删除成功！！');
        }
    }
}