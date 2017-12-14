@extends('layouts.main')
@section('title','浏览器统计数据')
@section('head-script')
@stop
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">浏览器列表</h3>
                            <div class="box-tools"></div>
                        </div>
                        <?php
                        use \yii\grid\GridView;
                        echo GridView::widget([
                            'dataProvider' => $list,
                            'emptyText' => '暂无记录',
                            'layout' => "{items}\n{summary}<div class=\"text-right tooltip-demo\" style=\"margin-top: -40px;\">{pager}</div>",
                            'showFooter' => false,
                            'showHeader' => true,
                            'columns' => [
                                [
                                    'contentOptions' => ['class' => 'col-sm-2'],
                                    'attribute' => 'project_id',
                                    'label' => '项目ID',
                                    'value' => function($model) use ($project){
                                        return $project[$model->project_id];
                                    }
                                ],
                                [
                                    'contentOptions' => ['class' => 'col-sm-2'],
                                    'attribute' => 'bro_name',
                                    'label' => '浏览器名称'
                                ],
                                [
                                    'contentOptions' => ['class' => 'col-sm-2'],
                                    'attribute' => 'source_url',
                                    'label' => '访问连接'
                                ],
                                [
                                    'contentOptions' => ['class' => 'col-sm-2'],
                                    'attribute' => 'is_pc',
                                    'label' => '是否PC',
                                    'value' => function ($model) {
                                        if ($model->is_pc == 1) {
                                            return '是';
                                        } else {
                                            return '否';
                                        }
                                    }
                                ],
                                [
                                    'contentOptions' => ['class' => 'col-sm-2'],
                                    'attribute' => 'created_at',
                                    'label' => '时间'
                                ]
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