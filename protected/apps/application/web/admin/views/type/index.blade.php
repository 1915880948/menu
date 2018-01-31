@extends('layouts.main')
@section('title','食疗分类')
@section('head-script')
@stop
@section('content')
    <div class="row">
        <div class="col-xs-8">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">食疗分类列表</h3>
                            <div class="box-tools"></div>
                        </div>
                        <?php
                        use \yii\grid\GridView;
                        use yii\helpers\Html;
                        use yii\web\View;
                        use yii\widgets\ActiveForm;
                        use common\assets\ace\InlineForm;
                        use yii\helpers\ArrayHelper;

                        echo GridView::widget([
                            'dataProvider' => $list,
                            'emptyText' => '暂无记录',
                            'layout' => "{items}\n{summary}<div class=\"text-right tooltip-demo\" style=\"margin-top: -40px;\">{pager}</div>",
                            'showFooter' => false,
                            'showHeader' => true,
                            'columns' => [
                                [
                                    'contentOptions' => ['class' => 'col-sm-2'],
                                    'attribute' => 'id',
                                    'label' => '类别ID',
                                ],
                                [
                                    'contentOptions' => ['class' => 'col-sm-2'],
                                    'attribute' => 'type_name',
                                    'label' => '食疗分类名称'
                                ],
                                [
                                    'contentOptions' => ['class' => 'col-sm-2'],
                                    'attribute' => 'created_at',
                                    'label' => '时间'
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
                                            return Html::a('修改', ['type/index', 'id' => $model['id']], []);
                                        },
                                        'delete'   => function($url, $model) use ($selfurl) {
                                            return Html::a('删除', 'javascript:;', ['id' => $model['id'],'class'=>'delete']);
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
        <div class="col-xs-4">
            <?php $form = ActiveForm::begin(['id' => 'tag-form',])?>
            <?= $form->field($model,'type_name')->textInput()->label('类别名称') ?>
            <div class="form-group">
                <div class="col-lg-offset-1 col-lg-11">
                    <?= Html::resetButton('重置', ['class' => 'btn btn-primary']) ?>
                    <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
            <?php ActiveForm::end()?>
        </div>
    </div>
@endsection
@push('foot-script')
    <script>
        $(function () {
            $('.delete').click(function () {
                var _this = $(this);
                layer.confirm('您确认要删除吗?', {icon: 3}, function(index){
                    $.post("{{yUrl('type/delete')}}",{'id':_this.attr('id')},function (res) {
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