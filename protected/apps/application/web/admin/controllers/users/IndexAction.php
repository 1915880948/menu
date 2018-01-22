<?php
namespace application\web\admin\controllers\users;
use application\models\base\User;
use application\web\admin\components\AdminBaseAction;
use qiqi\helper\DataProviderHelper;

class IndexAction extends AdminBaseAction{
    public function run(){
        $query = User::find();
        $list = DataProviderHelper::create($query);

        return $this->render(compact('list'));
    }
}