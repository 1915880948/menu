@extends('layouts.main')
@section('title','用户管理')
@section('head-style')
@endsection
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">用户列表</h3>
                            <div class="box-tools"></div>
                        </div>
                        <?php
                        use \yii\grid\GridView;
                        use yii\helpers\Html;
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
                                    'label' => '用户ID',
                                ],
                                [
                                    'contentOptions' => ['class' => 'col-sm-1'],
                                    'attribute' => 'head_pic',
                                    'format' => 'html',
                                    'label' => '头像',
                                    'value' => function ($model) {
                                        return Html::img($model->head_pic, ["width" => 50]);
                                    }
                                ],
                                [
                                    'contentOptions' => ['class' => 'col-sm-1'],
                                    'attribute' => 'nickname',
                                    'label' => '昵称',
                                ],
                                [
                                    'contentOptions' => ['class' => 'col-sm-1'],
                                    'attribute' => 'name',
                                    'label' => '真实姓名'
                                ],
                                [
                                    'contentOptions' => ['class' => 'col-sm-1'],
                                    'attribute' => 'phone',
                                    'label' => '联系方式'
                                ],
                                [
                                    'contentOptions' => ['class' => 'col-sm-1'],
                                    'attribute' => 'email',
                                    'label' => '邮箱'
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
                                    'template' => '',
                                    'buttons' => [
                                        'edit' => function ($url, $model) {
                                            return Html::a('修改', ['users/edit', 'id' => $model['id']], []);
                                        },
                                        'delete' => function ($url, $model) {
                                            return Html::a('删除', ['users/index', 'id' => $model['id']], []);
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

        });
    </script>
@endpush