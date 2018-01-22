@extends('layouts.main')
@section('title','标签列表')
@section('head-script')
@stop
@section('content')
    <div class="row">
        <div class="col-xs-8">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">标签列表</h3>
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
                                    'label' => '标签ID',
                                ],
                                [
                                    'contentOptions' => ['class' => 'col-sm-2'],
                                    'attribute' => 'tag_name',
                                    'label' => '标签名称'
                                ],
                                [
                                    'contentOptions' => ['class' => 'col-sm-2'],
                                    'attribute' => 'is_use',
                                    'label' => '是否使用',
                                    'value' =>function($model){
                                        return $model->is_use==1?'使用':'不使用';
                                    }
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
                                            return Html::a('修改', ['tag/index', 'id' => $model['id']], []);
                                        },
                                        'delete'   => function($url, $model) use ($selfurl) {
                                            return Html::a('删除', ['tag/delete', 'id' => $model['id']], []);
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
            <?= $form->field($model,'tag_name')->textInput()->label('标签名') ?>
            <?= $form->field($model, 'is_use')->radioList(['1'=>'使用','0'=>'不使用']);?>
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

        });
    </script>
@endpush