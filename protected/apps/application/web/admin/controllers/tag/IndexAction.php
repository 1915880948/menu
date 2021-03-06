<?php

namespace application\web\admin\controllers\tag;

use application\models\base\MenuTag;
use application\web\admin\components\AdminBaseAction;
use qiqi\helper\DataProviderHelper;
use qiqi\helper\MessageHelper;

class IndexAction extends AdminBaseAction
{
    public function run($id = '')
    {
        $model = MenuTag::findByPk($id);
        if (!$model) {
            $model = new MenuTag();
            $model->loadDefaultValues();
        }
        $query = MenuTag::find()
            ->andWhere(['status' => 1])
            ->orderBy(['created_at' => SORT_DESC]);
        $list = DataProviderHelper::create($query);

        if (\Yii::$app->request->isPost) {
            $data = $this->request->post();
            $model->tag_name = $data['MenuTag']['tag_name'];
            $model->is_use = $data['MenuTag']['is_use'];
            $model->created_at = date('Y-m-d H:i:s');
            if ($model->save()) {
                return MessageHelper::success(($id ? '编辑' : '新增') . '成功！', ['']);
            }

        }
        return $this->render(compact('model', 'list'));
    }
}