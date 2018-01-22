<?php
namespace application\web\admin\controllers\type;
use application\models\base\MenuType;
use application\web\admin\components\AdminBaseAction;
use qiqi\helper\DataProviderHelper;
use qiqi\helper\MessageHelper;

class IndexAction extends AdminBaseAction{
    public function run($id = ''){
        $model = MenuType::findByPk($id);
        if( !$model ){
            $model = new MenuType();
            $model->loadDefaultValues();
        }
        $query = MenuType::find()
            ->andWhere(['status'=>1])
            ->orderBy(['created_at'=>SORT_DESC]);
        $list = DataProviderHelper::create( $query,3 );
        if( \Yii::$app->request->isPost ){
            $data = $this->request->post();
            if( $id ){
                $model->type_name  = $data['MenuType']['type_name'];
                $model->created_at = date('Y-m-d H:i:s');
                if( $model->save() ){
                    return MessageHelper::success('修改成功！');
                }
            }else{
                $addModel = new MenuType();
                $addModel->type_name  = $data['MenuType']['type_name'];
                $addModel->created_at = date('Y-m-d H:i:s');
                if( $addModel->save() ){
                    return MessageHelper::success('新增成功！');
                }
            }
        }
        return $this->render(compact('model','list'));
    }
}