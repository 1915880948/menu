@extends('layouts.main')
@section('title','订单管理')
@section('head-script')
@stop
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-sm-12">
                    {{--<a href="{{yUrl(['menu/edit'])}}" class="btn btn-primary add_menu">+添加</a>--}}

                    <div style="text-align: right;">
                        <?php
                        use \yii\grid\GridView;
                        use yii\helpers\Html;
                        use yii\web\View;
                        use yii\widgets\ActiveForm;
                        use common\assets\ace\InlineForm;
                        use yii\helpers\ArrayHelper;

                        /** @var InlineForm $form */
                        $form = InlineForm::begin(['action' => yUrl(['order/index']),'method' => 'get']);
                        echo $form->label("菜单名称", Html::textInput("menu_name", ArrayHelper::getValue($_GET, 'menu_name', '')));
                        echo $form->label("食疗分类", Html::dropDownList("is_pay", ArrayHelper::getValue($_GET, 'is_pay', ''), [
                            '-99' => '全部',
                            '1' => '已支付',
                            '0' => '未支付'
                        ]));
                        echo $form->submitInput("查询");
                        $form->end();
                        ?>
                    </div>
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">订单列表</h3>
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
                                    'label' => '订单ID',
                                ],
                                [
                                    'contentOptions' => ['class' => 'col-sm-1'],
                                    'attribute' => 'user_id',
                                    'label' => '购买人'
                                ],
                                [
                                    'contentOptions' => ['class' => 'col-sm-1'],
                                    'attribute' => 'cover_image',
                                    'label' => '封面'
                                ],
                                [
                                    'contentOptions' => ['class' => 'col-sm-2'],
                                    'attribute' => 'menu_name',
                                    'label' => '菜单名称'
                                ],
                                [
                                    'contentOptions' => ['class' => 'col-sm-1'],
                                    'attribute' => 'total_price',
                                    'label' => '总价'
                                ],
                                [
                                    'contentOptions' => ['class' => 'col-sm-1'],
                                    'attribute' => 'is_pay',
                                    'label' => '是否支付',
                                    'value' =>function($model){
                                        return $model->is_pay==1?'是':'否';
                                    }
                                ],
                                [
                                    'contentOptions' => ['class' => 'col-sm-2'],
                                    'attribute' => 'pay_time',
                                    'label' => '支付时间'
                                ],
                                [
                                    'contentOptions' => ['class' => 'col-sm-2'],
                                    'attribute' => 'created_at',
                                    'label' => '创建时间'
                                ],
                                [
                                    /** @see yii\grid\ActionColumn */
                                    'header'         => '功能管理',
                                    'headerOptions'  => ['class' => 'center'],
                                    'contentOptions' => ['class' => 'col-sm-1 center'],
                                    'class'          => 'yii\grid\ActionColumn',
                                    'template'       => '{edit} {delete}',
                                    'buttons'        => [
                                        'edit'   => function($url, $model) use ($selfurl) {
                                            return Html::a('修改', ['order/index', 'id' => $model['id']], []);
                                        },
                                        'delete'   => function($url, $model) use ($selfurl) {
                                            return Html::a('删除', ['order/delete', 'id' => $model['id']], []);
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