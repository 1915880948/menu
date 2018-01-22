@extends('layouts.main')
@section('title','菜单管理')
@section('head-style')
    <link rel="stylesheet" href="{{yStatic('vendor/bower_components/select2/dist/css/select2.min.css')}}">
@stop
@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">菜单基本信息</h3>
        </div>
        <form class="form-horizontal" method="post" id="editForm">
            <input type="hidden" name="id" value="{{ $data?$data['id']:'' }}" id="id">
            <div class="box-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">菜单名称</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="name" value="{{$data['name']}}" placeholder="菜单名称">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">食疗分类</label>
                    <div class="col-sm-6">
                        <select class="form-control" name="menu_type">
                            @foreach( $type_list as $item)
                                <option value="{{ $item['id'] }}" {{ $data['type_id']==$item['id']?'selected':'' }}>{{ $item['type_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">是否免费</label>
                    <div class="col-sm-6">
                        <select class="form-control" name="is_free">
                            <option value="1" {{ $data['is_free']==1?"selected":'' }}>收费</option>
                            <option value="0" {{ $data['is_free']==0?"selected":'' }}>免费</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">菜单价格</label>
                    <div class="col-sm-6">
                        <input type="text" name="price"  class="form-control cm-number" placeholder="菜单价格">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">标签</label>
                    <div class="col-sm-6">
                        <select name="tag_ids[]" class="form-control menu_tag" style="width: 100%;" multiple>
                            @foreach( $tag_list as $item)
                                <option value="{{ $item['id'] }}" {{in_array($item['id'],$tag_selected)?"selected":''}}>{{ $item['tag_name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">封面</label>
                    <div class="col-sm-6">
                        <img src="{{ $data['cover_img']?$data['cover_img']:yStatic('boxed-bg.jpg')}}" id="pre_cover" style="width: 300px;">
                        <input type="hidden" name="cover_img" id="cover" value="{{$data['cover_img']}}" >
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">是否上架</label>
                    <div class="col-sm-6">
                        <select class="form-control" name="is_shift">
                            <option value="1" {{ $data['is_shift']==1?'selected':'' }}>上架</option>
                            <option value="0" {{ $data['is_shift']==0?'selected':'' }}>下架</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">菜单简介</label>
                    <div class="col-sm-6">
                        <textarea class="form-control" cols="3" name="desc" placeholder="菜单简介">{{$data['desc']}}</textarea>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="form-group col-sm-8 pull-right">
                    <button type="reset" class="btn btn-info">重置</button>
                    <button type="submit" class="btn btn-info">提交</button>
                    @if($data['id'])
                        <button class="btn btn-info btn-warning">食材</button>
                        <button class="btn btn-info btn-success">步骤</button>
                    @endif
                </div>
            </div>
        </form>
    </div>
@endsection
@push('foot-script')
    <script src="{{yStatic('vendor/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
    <script src="{{yStatic('vendor/qiniu/plupload.min.js')}}"></script>
    <script src="{{yStatic('vendor/qiniu/qiniu.min.js') }}"></script>
    <script src="{{yStatic('vendor/qiniu/progress.js')}}"></script>
    <script>
        $(function () {
            $('.menu_tag').select2();

            //构建uploader实例
            var uploader = Qiniu.uploader({
                runtimes: 'html5,flash,html4',      // 上传模式，依次退化
                browse_button: 'pre_cover',          // 上传选择的点选按钮，必需
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

                        $('#pre_cover').attr("src",sourceLink);
                        $("#cover").val(sourceLink);

                    },
                    'Error': function (up, err, errTip) {
                        //上传出错时，处理相关的事情
                    },
                    'UploadComplete': function () {
                        //队列文件处理完毕后，处理相关的事情

                    },
                }
            });

        });
    </script>
@endpush