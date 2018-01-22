@extends('layouts.main')
@section('title','菜单步骤')
@section('head-style')
    <style type="text/css">
        #ingredient .form-group,#step .form-group,#tips .form-group{
            padding: 20px;
        }
    </style>
@endsection
@section('content')
<?php
    use \yii\grid\GridView;
    use yii\helpers\Html;
    use yii\web\View;
    use yii\widgets\ActiveForm;
    use common\assets\ace\InlineForm;
    use yii\helpers\ArrayHelper;
?>
    <h3 class="center-block">{{$_GET['menu']}}--做法：</h3>

    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
                        {{--<div class="box-header">--}}
                            {{--<h3 class="box-title pull-left">食材列表</h3>--}}
                            {{--<div class="box-tools"><button class="btn btn-info add_ingres">添加食材</button></div>--}}
                        {{--</div>--}}
                        <div class="box-header">
                            <h3 class="box-title">食材列表</h3>
                            <!-- tools box -->
                            <div class="pull-right box-tools">

                                    <button class="btn btn-info add_ingres">添加食材</button>

                                {{--<button type="button" class="btn  btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>--}}
                                {{--</button>--}}
                                {{--<button type="button" class="btn  btn-sm" data-widget="remove"><i class="fa fa-times"></i>--}}
                                {{--</button>--}}
                            </div>
                            <!-- /. tools -->
                        </div>
                        <?php
                        echo GridView::widget([
                            'dataProvider' => $ingresList,
                            'emptyText' => '暂无记录',
                            'layout' => "{items}\n{summary}<div class=\"text-right tooltip-demo\" style=\"margin-top: -40px;\">{pager}</div>",
                            'showFooter' => false,
                            'showHeader' => true,
                            'columns' => [
                                [
                                    'contentOptions' => ['class' => 'col-sm-1'],
                                    'attribute' => 'id',
                                    'label' => '食材ID',
                                ],
                                [
                                    'contentOptions' => ['class' => 'col-sm-1'],
                                    'attribute' => 'type_id',
                                    'label' => '类型',
                                    'value' =>function($model){
                                        return yIngredientsName($model->type_id);
                                    }
                                ],
                                [
                                    'contentOptions' => ['class' => 'col-sm-1'],
                                    'attribute' => 'name',
                                    'label' => '食材名称'
                                ],
                                [
                                    'contentOptions' => ['class' => 'col-sm-2'],
                                    'attribute' => 'amount',
                                    'label' => '用量'
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
                                            return Html::a('修改', 'javascript:void(0);', ['class'=>'ingredients_edit','id' => $model['id']]);
                                        },
                                        'delete'   => function($url, $model) use ($selfurl) {
                                            return Html::a('删除', ['ingredients/delete', 'id' => $model['id']], []);
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
<hr/>
<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title pull-left">步骤</h3>
                        <div class="box-tools"><button class="btn btn-info add_step">添加步骤</button></div>
                    </div>
                    <?php
                    echo GridView::widget([
                        'dataProvider' => $stepList,
                        'emptyText' => '暂无记录',
                        'layout' => "{items}\n{summary}<div class=\"text-right tooltip-demo\" style=\"margin-top: -40px;\">{pager}</div>",
                        'showFooter' => false,
                        'showHeader' => true,
                        'columns' => [
//                                [
//                                    'contentOptions' => ['class' => 'col-sm-1'],
//                                    'attribute' => 'id',
//                                    'label' => 'ID',
//                                ],
                            [
                                'contentOptions' => ['class' => 'col-sm-1'],
                                'attribute' => 'step_number',
                                'label' => '步骤序号',
                            ],
                            [
                                'contentOptions' => ['class' => 'col-sm-4'],
                                'attribute' => 'method',
                                'label' => '方法'
                            ],
                            [
                                'contentOptions' => ['class' => 'col-sm-2'],
                                'attribute' => 'images',
                                'format'=> 'html',
                                'label' => '配图',
                                'value' =>function($model){
                                    $img = '';
                                    if($model->images){
                                        foreach ( json_decode($model->images) as $k=>$v){
                                            $img .= '<img src="'.$v.'" width="80" height="80" />&nbsp;&nbsp;';
                                        }
                                    }
                                    return $img;
                                }
                            ],
                            [
                                /** @see yii\grid\ActionColumn */
                                'header'         => '功能管理',
                                'headerOptions'  => ['class' => 'center'],
                                'contentOptions' => ['class' => 'col-sm-1 center'],
                                'class'          => 'yii\grid\ActionColumn',
                                'template'       => '{edit} {delete}',
                                'buttons'        => [
                                    'edit'   => function($url, $model) {
                                        return Html::a('修改', 'javascript:void(0);', ['class'=>'step_edit','id' => $model['id']]);
                                    },
                                    'delete'   => function($url, $model) {
                                        return Html::a('删除', ['step/delete', 'id' => $model['id']], []);
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
<hr/>
<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title pull-left">小贴士</h3>
                        <div class="box-tools"><button class="btn btn-info add_tips">添加贴士</button></div>
                    </div>
                    <?php
                    echo GridView::widget([
                        'dataProvider' => $tipsList,
                        'emptyText' => '暂无记录',
                        'layout' => "{items}\n{summary}<div class=\"text-right tooltip-demo\" style=\"margin-top: -40px;\">{pager}</div>",
                        'showFooter' => false,
                        'showHeader' => true,
                        'columns' => [
                            [
                                'contentOptions' => ['class' => 'col-sm-1'],
                                'attribute' => 'tip_number',
                                'label' => '小贴士序号',
                            ],
                            [
                                'contentOptions' => ['class' => 'col-sm-4'],
                                'attribute' => 'tip_name',
                                'label' => '小贴士'
                            ],
                            [
                                /** @see yii\grid\ActionColumn */
                                'header'         => '功能管理',
                                'headerOptions'  => ['class' => 'center'],
                                'contentOptions' => ['class' => 'col-sm-1 center'],
                                'class'          => 'yii\grid\ActionColumn',
                                'template'       => '{edit} {delete}',
                                'buttons'        => [
                                    'edit'   => function($url, $model) {
                                        return Html::a('修改', 'javascript:void(0);', ['class'=>'tips_edit','id' => $model['id']]);
                                    },
                                    'delete'   => function($url, $model) {
                                        return Html::a('删除', ['tips/delete', 'id' => $model['id']], []);
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
<div id="ingredient" class="box-body" style="display:none;">
    <div class="form-group">
        <label class="col-sm-4 control-label">食材类型</label>
        <div class="col-sm-8">
            <select class="form-control" id="type_id">
                <option value="1">主料</option>
                <option value="2">辅料</option>
                <option value="3">调料</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">食材名称</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="inger_name" placeholder="食材名称">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">用量(带上单位)</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="amount" placeholder="用量(带上单位)">
        </div>
    </div>
</div>
<div id="step" class="box-body" style="display:none;">
    <div class="form-group">
        <label class="col-sm-2 control-label">步骤序号</label>
        <div class="col-sm-10">
            <input type="number" class="form-control" id="step_number" min="1" placeholder="步骤序号">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">做法</label>
        <div class="col-sm-10">
            <textarea class="form-control" id="do_way" rows="4" maxlength="150" placeholder="做法"></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">配图</label>
        <div class="col-sm-10" id="pre_cover">
            <img src="{{yStatic('/boxed-bg.jpg')}}" alt="" id="upload" width="180" height="180">
        </div>
    </div>
</div>
<div id="tips" class="box-body" style="display:none;">
    <div class="form-group">
        <label class="col-sm-4 control-label">小贴士序号</label>
        <div class="col-sm-8">
            <input type="number" class="form-control" id="tip_number" min="1" placeholder="小贴士序号">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">小贴士</label>
        <div class="col-sm-8">
            <textarea class="form-control" id="tip_name" rows="4" maxlength="150" placeholder="小贴士"></textarea>
        </div>
    </div>
</div>
@endsection

@push('foot-script')
    <script src="{{yStatic('vendor/qiniu/plupload.min.js')}}"></script>
    <script src="{{yStatic('vendor/qiniu/qiniu.min.js') }}"></script>
    <script src="{{yStatic('vendor/qiniu/progress.js')}}"></script>

    <script>
        $(function () {
            //构建uploader实例
            var uploader = Qiniu.uploader({
                runtimes: 'html5,flash,html4',      // 上传模式，依次退化
                browse_button: 'upload',          // 上传选择的点选按钮，必需
                uptoken_url: "{{yUrl(['site/uptoken'])}}",         // Ajax请求uptoken的Url，强烈建议设置（服务端提供）
                // unique_names: false, // 默认 false，key为文件名。若开启该选项，SDK为自动生成上传成功后的key（文件名）。
                // save_key: false,   // 默认 false。若在服务端生成uptoken的上传策略中指定了 `sava_key`，则开启，SDK会忽略对key的处理
                get_new_uptoken: true,              // 设置上传文件的时候是否每次都重新获取新的uptoken
                domain: "{{env('QINIU_DOMAIN')}}",     // bucket域名，下载资源时用到，必需
                max_file_size: '100mb',             // 最大文件体积限制
                // flash_swf_url: 'path/of/plupload/Moxie.swf',  //引入flash，相对路径
                max_retries: 3,                     // 上传失败最大重试次数
                dragdrop: false,                    // 开启可拖曳上传
                chunk_size: '4mb',                  // 分块上传时，每块的体积
                auto_start: true,                   // 选择文件后自动上传，若关闭需要自己绑定事件触发上传
                filters: {
                    mime_types: [ //只允许上传文件格式
                        {title: "image files", extensions: "jpg,png,jpeg"}
                    ]
                },
                resize: {
                    width: 1024,
                    height: 1024,
                    crop: true,
                    preserve_headers: false
                },
                init: {
                    'FilesAdded': function (up, files) {
                        plupload.each(files, function (file) {
                            // 文件添加进队列后，处理相关的事情
                        });
                    },
                    'BeforeUpload': function (up, file) {
                        // 每个文件上传前，处理相关的事情
                    },
                    'UploadProgress': function (up, file) {
                        // 每个文件上传时，处理相关的事情
                    },
                    'FileUploaded': function (up, file, info) {
                        layer.msg('上传成功', {time: 1200}, function () {
                        });
                        var res = JSON.parse(info);
                        // 查看简单反馈
                        var domain = up.getOption('domain');
                        var sourceLink = "http://"+domain + "/" + res.key; //获取上传成功后的文件的Url
                        var img_html = '<img src="'+sourceLink+'" width="180" height="180">';
                        var input_html = '<input type="hidden" name="images[]" value="'+sourceLink+'">';
                        $('#pre_cover').append(img_html);
                        $('#pre_cover').append(input_html);
                        if( $('#pre_cover img').length>3){
                            $("#upload").remove();
                        }

                    },
                    'Error': function (up, err, errTip) {
                        //上传出错时，处理相关的事情
                    },
                    'UploadComplete': function () {
                        //队列文件处理完毕后，处理相关的事情
                    },
                }
            });


            $(".add_ingres").click(function () {
                ingredients('add',id='');
            });
            $(".ingredients_edit").click(function () {
                var _this = $(this);
                $.post("{{yUrl(['ingredients/add'])}}",{'method':'getData','id':_this.attr('id')},function (res) {
                    $("#type_id").find("option[value="+res.type_id+"]").prop("selected",true);
                    $("#inger_name").attr('value',res.name);
                    $("#amount").attr('value',res.amount);
                    ingredients('edit',_this.attr('id'));
                });
            });
            $(".add_step").click(function () {
                $('#pre_cover').empty();
                $('#pre_cover').append('<img src="{{yStatic('boxed-bg.jpg')}}" alt="" id="upload" width="180" height="180">');
                step('add',id='');
            });
            $(".step_edit").click(function () {
                var _this = $(this);
                $.post("{{yUrl(['step/add'])}}",{'method':'getData','id':_this.attr('id')},function (res) {
                    $("#step_number").attr('value',res.step_number);
                    $("#do_way").text(res.method);
                    $("#pre_cover").empty();
                    if( res.images ){
                        var images = $.parseJSON( res.images );
                        for(var i=0;i<images.length;i++){
                            var img_html = '<img src="'+images[i]+'" width="180" height="180">';
                            var input_html = '<input type="hidden" name="images[]" value="'+images[i]+'">';
                            $('#pre_cover').append(img_html);
                            $('#pre_cover').append(input_html);
                        }
                    }
                    if($('#pre_cover img').length<3){
                        $('#pre_cover').append('<img src="{{yStatic('boxed-bg.jpg')}}" alt="" id="upload" width="180" height="180">');
                    }
                    step('edit',_this.attr('id'));
                });
            });

            $(".add_tips").click(function () {
                tips('add',id='');
            });
            $(".tips_edit").click(function () {
                var _this = $(this);
                $.post("{{yUrl(['tips/add'])}}",{'method':'getData','id':_this.attr('id')},function (res) {
                    $("#tip_number").attr('value',res.tip_number);
                    $("#tip_name").text(res.tip_name);
                    tips('edit',_this.attr('id'));
                });
            });

        });

        function ingredients(method,id){
            layer.open({
                type: 1,
                title:'食材管理',
                area: ['500px', '300px'],
                content: $('#ingredient'),
                btn: ['保存', '取消'],
                yes: function () {
                    if ($("#inger_name").val() && $("#amount").val()) {
                        $.post("{{yUrl('ingredients/add')}}",
                            {
                                'method'    : method,
                                'id'        :id,
                                'menu_id'   : "{{ $_GET['id'] }}",
                                'type_id'   : $("#type_id").val(),
                                'inger_name': $("#inger_name").val(),
                                'amount'    : $("#amount").val()
                            }, function (res) {
                                if (res.code == 200) {
                                    layer.msg('保存成功！！', {'icon': 1, time: 1200}, function () {
                                        layer.closeAll();
                                        location.reload();
                                    });
                                }
                            }
                        );
                    } else {
                        $("#ingredient .form-group").addClass("has-error");
                    }
                }
            });
        }
        function step(method,id){
            layer.open({
                type: 1,
                title:'步骤',
                area: ['800px', '500px'],
                content: $('#step'),
                btn: ['保存', '取消'],
                yes: function () {
                    var images = '';
                    $('input[name="images[]"]').each(function () {
                        images += $(this).val() + ',';
                    });
                    if ($("#step_number").val() && $("#do_way").val()) {
                        $.post("{{yUrl('step/add')}}",
                            {
                                'method'     : method,
                                'id'         :id,
                                'menu_id'    : "{{ $_GET['id'] }}",
                                'step_number': $("#step_number").val(),
                                'do_way'     : $("#do_way").val(),
                                'images'     : images
                            }, function (res) {
                                if (res.code == 200) {
                                    layer.msg('保存成功！！', {'icon': 1, time: 1200}, function () {
                                        layer.closeAll();
                                        location.reload();
                                    });
                                }
                            }
                        );
                    } else {
                        $("#ingredient .form-group").addClass("has-error");
                    }
                }
            });
        }
        function tips(method,id){
            layer.open({
                type: 1,
                title:'步骤',
                area: ['500px', '300px'],
                content: $('#tips'),
                btn: ['保存', '取消'],
                yes: function () {
                    if ($("#tip_number").val() && $("#tip_name").val()) {
                        $.post("{{yUrl('tips/add')}}",
                            {
                                'method'     : method,
                                'id'         :id,
                                'menu_id'    : "{{ $_GET['id'] }}",
                                'tip_number' : $("#tip_number").val(),
                                'tip_name'   : $("#tip_name").val()
                            }, function (res) {
                                if (res.code == 200) {
                                    layer.msg('保存成功！！', {'icon': 1, time: 1200}, function () {
                                        layer.closeAll();
                                        location.reload();
                                    });
                                }
                            }
                        );
                    } else {
                        $("#ingredient .form-group").addClass("has-error");
                    }
                }
            });
        }
    </script>
@endpush