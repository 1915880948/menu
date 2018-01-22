<?php
namespace application\web\admin\controllers\order;
use application\models\base\Order;
use application\web\admin\components\AdminBaseAction;
use qiqi\helper\DataProviderHelper;

class IndexAction extends AdminBaseAction{
    public function run($menu_name='',$is_pay='-99'){
        $query = Order::find()
            ->andWhere(['status'=>1]);
        if( $menu_name ){
            $query = $query->andWhere(['like','menu_name',$menu_name]);
        }
        if( $is_pay != -99 ){
            $query = $query->andWhere(['is_pay'=>$is_pay]);
        }
        $query = $query->orderBy(['created_at'=>SORT_DESC]);

        $list = DataProviderHelper::create($query);
        return $this->render(compact('list'));
    }
}