@extends('layouts.main')
@section('title','导航列表')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">导航点击列表   {{$project[3]}}</h3>
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
                                    'value' =>function($model) use ($project){
                                        return $project[$model->project_id];
                                    }
                                ],
                                [
                                    'contentOptions' => ['class' => 'col-sm-2'],
                                    'attribute' => 'sidebar_id',
                                    'label' => '导航ID',
                                    'value' => function($model) use($sidebar){
                                        return $sidebar[$model->sidebar_id];
                                    }
                                ],
                                [
                                    'contentOptions' => ['class' => 'col-sm-2'],
                                    'attribute' => 'click_total',
                                    'label' => '点击数',
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