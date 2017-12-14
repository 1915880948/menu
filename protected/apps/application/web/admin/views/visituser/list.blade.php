@extends('layouts.main')
@section('title','用户访问数据')
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
                                    'attribute' => 'id',
                                    'label' => '编号'
                                ],
                                [
                                    'contentOptions' => ['class' => 'col-sm-2'],
                                    'attribute' => 'province',
                                    'label' => '所在省份'
                                ],
                                [
                                    'contentOptions' => ['class' => 'col-sm-2'],
                                    'attribute' => 'city',
                                    'label' => '城市',
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