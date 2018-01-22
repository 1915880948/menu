<?php
namespace application\web\admin\controllers\type;
use application\models\base\MenuType;
use application\web\admin\components\AdminBaseAction;
use qiqi\helper\MessageHelper;

class DeleteAction extends AdminBaseAction{
    public function run($id){
        $model = MenuType::findByPk($id);
        $model->status = 0;
        if( $model->save() ){
            return MessageHelper::success('删除成功！');
        }
    }
}