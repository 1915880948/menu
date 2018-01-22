<?php
namespace application\web\admin\controllers\menu;
use application\models\base\Menu;
use application\models\base\MenuTag;
use application\models\base\MenuType;
use application\web\admin\components\AdminBaseAction;
use qiqi\helper\DataProviderHelper;
use qiqi\helper\MessageHelper;

class IndexAction extends AdminBaseAction{
    public function run($id = '',$type_id='',$tag_ids='',$name=''){
        if( $id ){
            $model = Menu::findByPk($id);
            $model->status = 0;
            if( $model->save() ){
                return MessageHelper::success('删除成功！');
            }
        }
        $tag_list = MenuTag::find()
            ->andWhere(['status'=>1,'is_use'=>1])
            ->asArray()
            ->all();
        $type_list = MenuType::find()
            ->andWhere(['status'=>1])
            ->asArray()
            ->all();
        $query = Menu::find()
            ->andWhere(['status'=>1]);
        if($type_id){
            $query = $query->andWhere(['type_id'=>$type_id]);
        }
        if($tag_ids){
            $tag_idsArr = explode('|',$tag_ids);
            $query = $query->andWhere(['in','tag_ids',$tag_idsArr]);
        }
        if($name){
            $query = $query->andWhere(['like','name',$name]);
        }
        $query = $query->orderBy(['created_at'=>SORT_DESC]);
        $list = DataProviderHelper::create($query);


        $tag_idsArr = [''=>'全部'];
        $type_idsArr = [''=>'全部'];
        foreach ( $tag_list as $key=>$v ){
            $tag_idsArr[$v['id']] = $v['tag_name'];
        }
        foreach ( $type_list as $key=>$v ){
            $type_idsArr[$v['id']] = $v['type_name'];
        }

        return $this->render(compact('tag_list','type_list','list','tag_idsArr','type_idsArr'));
    }
}