@extends('layouts.main')
@section('title','菜单管理')
@section('head-style')
@endsection
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-sm-12">
                    <a href="{{yUrl(['menu/edit'])}}" class="btn btn-primary add_menu">+添加</a>
                    <div style="float: right;">
                        <?php
                        use \yii\grid\GridView;
                        use yii\helpers\Html;
                        use yii\web\View;
                        use yii\widgets\ActiveForm;
                        use common\assets\ace\InlineForm;
                        use yii\helpers\ArrayHelper;

                        /** @var InlineForm $form */
                        $form = InlineForm::begin(['action' => yUrl(['menu/index']),'method' => 'get']);
                        echo $form->label("菜单名称", Html::textInput("name", ArrayHelper::getValue($_GET, 'name', '')));
                        echo $form->label("食疗分类", Html::dropDownList("type_id", ArrayHelper::getValue($_GET, 'type_id', ''), $type_idsArr));
                        echo $form->label("标签", Html::dropDownList("tag_ids", ArrayHelper::getValue($_GET, 'tag_ids', ''), $tag_idsArr));
                        echo $form->submitInput("查询");
                        $form->end();
                        ?>
                    </div>
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">菜单列表</h3>
                            <div class="box-tools"></div>
                        </div>
                        <?php
                        echo GridView::widget([
                            'dataProvider' => $list,
                            'emptyText' => '暂无记录',
                            'layout' => "{items}\n{summary}<div class=\"text-right tooltip-demo\" style=\"margin-top: -40px;\">{pager}</div>",
                            'showFooter' => false,
                            'showHeader' => true,
                            'columns' => [
                                [
                                    'contentOptions' => ['class' => 'col-sm-1'],
                                    'attribute' => 'id',
                                    'label' => '菜单ID',
                                ],
                                [
                                    'contentOptions' => ['class' => 'col-sm-1'],
                                    'attribute' => 'name',
                                    'label' => '菜单名称',
                                ],
                                [
                                    'contentOptions' => ['class' => 'col-sm-1'],
                                    'attribute' => 'type_id',
                                    'label' => '食疗分类',
                                    'value' => function ($model) use ($type_idsArr) {
                                        return $type_idsArr[$model->type_id];
                                    }
                                ],
                                [
                                    'contentOptions' => ['class' => 'col-sm-1'],
                                    'attribute' => 'cover_img',
                                    'format' => 'html',
                                    'label' => '封面',
                                    'value' => function ($model) {
                                        return Html::img($model->cover_img, ["width" => 50]);
                                    }
                                ],
                                [
                                    'contentOptions' => ['class' => 'col-sm-1'],
                                    'attribute' => 'tag_ids',
                                    'label' => '标签',
                                    'value' => function ($model) use ($tag_idsArr) {
                                        $str = '';
                                        $arr = explode('|', $model->tag_ids);
                                        foreach ($arr as $k => $v) {
                                            $str .= $tag_idsArr[$v] . '|';
                                        }
                                        return trim($str, '|');
                                    }
                                ],
                                [
                                    'contentOptions' => ['class' => 'col-sm-1'],
                                    'attribute' => 'is_free',
                                    'label' => '是否付费',
                                    'value' => function ($model) {
                                        return $model->is_shift == 1 ? '付费' : '免费';
                                    }
                                ],
                                [
                                    'contentOptions' => ['class' => 'col-sm-1'],
                                    'attribute' => 'price',
                                    'label' => '价格'
                                ],
                                [
                                    'contentOptions' => ['class' => 'col-sm-1'],
                                    'attribute' => 'pay_num',
                                    'label' => '购买次数'
                                ],
//                                [
//                                    'contentOptions' => ['class' => 'col-sm-1'],
//                                    'attribute' => 'love_num',
//                                    'label' => '收藏数'
//                                ],
//                                [
//                                    'contentOptions' => ['class' => 'col-sm-1'],
//                                    'attribute' => 'click_num',
//                                    'label' => '点击数'
//                                ],
//                                [
//                                    'contentOptions' => ['class' => 'col-sm-1'],
//                                    'attribute' => 'views_num',
//                                    'label' => '查看数'
//                                ],
                                [
                                    'contentOptions' => ['class' => 'col-sm-1'],
                                    'attribute' => 'is_shift',
                                    'label' => '是否上架',
                                    'value' => function ($model) {
                                        return $model->is_shift == 1 ? '上架' : '下架';
                                    }
                                ],
                                [
                                    'contentOptions' => ['class' => 'col-sm-1'],
                                    'attribute' => 'created_at',
                                    'label' => '时间'
                                ],
                                [
                                    /** @see yii\grid\ActionColumn */
                                    'header' => '功能管理',
                                    'headerOptions' => ['class' => 'center'],
                                    'contentOptions' => ['class' => 'col-sm-1 center'],
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '{todo} {edit} {delete}',
                                    'buttons' => [
                                        'todo' => function ($url, $model) {
                                            return Html::a('步骤', ['step/index', 'id' => $model['id'], 'menu' => $model['name']], []);
                                        },
                                        'edit' => function ($url, $model) {
                                            return Html::a('修改', ['menu/edit', 'id' => $model['id']], []);
                                        },
                                        'delete' => function ($url, $model) {
                                            return Html::a('删除', 'javascript:;',['id' => $model['id'],'class'=>'delete']);
                                        },
                                    ],
                                ],
                            ]
                        ])
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('foot-script')
    <script>
        $(function () {
            $('.delete').click(function () {
                var _this = $(this);
                layer.confirm('您确认要删除吗?', {icon: 3}, function(index){
                    $.post("{{yUrl('menu/delete')}}",{'id':_this.attr('id')},function (res) {
                        if(res.code == 200 ){
                            layer.msg('删除成功！',{icon:1,time:1200},location.reload());
                        }else{
                            layer.msg('删除失败！',{icon:2,time:1200},function (err) {
                                console.log(err.message);
                            });
                        }
                    });

                });
            });
        });
    </script>
@endpush