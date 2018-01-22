<?php
namespace application\web\admin\controllers\menu;
use application\models\base\MenuTag;
use application\models\base\MenuType;
use application\models\base\Menu;
use application\web\admin\components\AdminBaseAction;
use qiqi\helper\MessageHelper;

class EditAction extends AdminBaseAction{
    public function run($id=''){
        $data = Menu::find()
            ->andWhere(['id' => $id])
            ->asArray()
            ->one();
        $tag_selected = explode('|',$data['tag_ids']);
        $tag_list = MenuTag::find()
            ->andWhere(['status'=>1,'is_use'=>1])
            ->asArray()
            ->all();
        $type_list = MenuType::find()
            ->andWhere(['status'=>1])
            ->asArray()
            ->all();
        if(\Yii::$app->request->isPost){
            $postData = \Yii::$app->request->post();
            if($id){
                $model = Menu::findByPk($id);
            }else{
                $model = new Menu();
            }
            $model->name      = $postData['name'];
            $model->type_id   = $postData['menu_type'];
            $model->is_free   = $postData['is_free'];
            $model->price     = $postData['price'];
            $model->tag_ids   = implode('|',$postData['tag_ids']);
            $model->cover_img = $postData['cover_img'];
            $model->desc      = $postData['desc'];
            if($model->save()){
                return MessageHelper::success(($id?"编辑":"新增").'成功!');
            }
        }
        return $this->render(compact('tag_selected','tag_list','type_list','data'));
    }
}