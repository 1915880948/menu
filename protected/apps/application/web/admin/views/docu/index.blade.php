@extends('layouts.main')
@section('title','分享数据列表')

@section('content')
    <div class="form-group col-md-3 ">
        <select class="form-control project">
            <option value="0">全部</option>
            @foreach( $project as $k=>$v)
                <option value="{{$k}}">{{$v}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-3 ">
        <select class="form-control docu_select">
            <option value="0">全部</option>
        </select>
    </div>
    <div class="form-group col-md-3 ">
        <div class="input-group">
            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>
            <input type="text" class="form-control pull-right" id="reservation">
        </div>
        <!-- /.input group -->
    </div>
    <ol class=" " style="text-align:right;">
        <div class="btn-group">
            <button type="button" class="btn btn-default btn-info" data-date="7">最近7天</button>
            <button type="button" class="btn btn-default" data-date="30">最近30天</button>
            <button type="button" class="btn btn-default" data-date="365">最近1年</button>
        </div>
    </ol>

    <div id="main" style="height:600px;"></div>
    <div id="list">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th><a href="#" data-sort="project_id">项目ID</a></th>
                    <th><a href="#" data-sort="docu_id">文章ID</a></th>
                    <th><a href="#" data-sort="click">点击数</a></th>
                    <th><a href="#" data-sort="visits">访问量</a></th>
                    <th><a href="#" data-sort="created_at">时间</a></th>
                </tr>
            </thead>
            <tbody id="tab_body"></tbody>
        </table>
    </div>
@endsection
@push('foot-script')
    <script>
        var  date = [] , click_num = [], visit_num = [] , mean = [];
        var project_id = 0,docu_id,start_time,end_time, day =7;
        $(function () {
            line_chart(project_id,docu_id,start_time,end_time,day);
            $(".btn-group .btn").click(function () {
                var _this = $(this);
                if( _this.hasClass('btn-info') ) return false;
                day = _this.attr('data-date');
                start_time = ''; end_time = '';
                project_id = $('.project').val();
                $('.btn-group .btn').removeClass('btn-info');
                _this.addClass('btn-info');
                line_chart(project_id,docu_id,start_time,end_time,day);
            });
            $('.project').change(function () {
                project_id = $('.project').val();
                $.jsonPost("{{yUrl(['post-select/docu'])}}",{'project_id':project_id},function (res) {
                    $('.form-control.docu_select').empty();
                    var docu_list = '<option value="0">全部</option>';
                    for(var key in res ){
                        docu_list += '<option value="'+key+'">'+res[key]+'</option>';
                    }
                    $('.form-control.docu_select').append(docu_list);
                });
                docu_id = $('.docu_select').val();
                line_chart(project_id,docu_id,start_time,end_time,day);
            });
            $('.form-control.docu_select').change(function () {
                docu_id = $('.form-control.docu_select').val();
                line_chart(project_id, docu_id,start_time,end_time,day);
            });
            //Date range picker
            $('#reservation').daterangepicker({
                opens : 'right',
                "linkedCalendars": true,
                "autoUpdateInput": false,
                'autoApply' : true,
                "locale": {
                    format: 'YYYY-MM-DD',
                    separator: '~',
                    applyLabel: "应用",
                    cancelLabel: "取消"
                }
            }, function(start, end, label) {
                start_time = this.startDate.format(this.locale.format);
                end_time   = this.endDate.format(this.locale.format);
                if (!this.startDate) {
                    this.element.val('');
                } else {
                    this.element.val(this.startDate.format(this.locale.format) + this.locale.separator + this.endDate.format(this.locale.format));
                    line_chart(project_id,docu_id,start_time,end_time,day);
                    $('.btn-group .btn').removeClass('btn-info');
                }
            });

        });
        function line_chart(project_id,docu_id,start_time,end_time,day) {
            $.jsonPost("{{yUrl('docu/index')}}",
                {
                    'project_id':project_id,
                    'docu_id':docu_id,
                    'start_time':start_time,
                    'end_time':end_time,
                    'day':day
                }, function (res) {
                list(res,day);
                if(res) {
                    date = []; click_num = [];  visit_num = []; mean = [];
                    for (var i = 0; i < res.length; i++) {
                        date[i]      = res[i].created_at ;
                        click_num[i] = res[i].click;
                        visit_num[i] = res[i].visits;
                        mean[i] = ( parseInt(res[i].click)+parseInt(res[i].visits) )/2;
                    }
                    var myChart = echarts.init(document.getElementById('main'));

                    // 指定图表的配置项和数据
                    var option = {
                        tooltip: {
                            trigger: 'axis',
                            axisPointer: {
                                type: 'cross',
                                crossStyle: {
                                    color: '#999'
                                }
                            }
                        },
                        toolbox: {
                            feature: {
                                dataView: {show: true, readOnly: false},
                                magicType: {show: true, type: ['line', 'bar']},
                                restore: {show: true},
                                saveAsImage: {show: true}
                            }
                        },
                        legend: {
                            data:['点击量','访问量','平均量']
                        },
                        xAxis: [
                            {
                                type: 'category',
                                data: date,
                                axisPointer: {
                                    type: 'shadow'
                                }
                            }
                        ],
                        yAxis: [
                            {
                                type: 'value',
                                name: '点击量',
                                min: 0,
//                                max: 250,
//                                interval: 50,
                                axisLabel: {
                                    formatter: '{value}'
                                }
                            },
                            {
                                type: 'value',
                                name: '访问量',
                                min: 0,
//                                max: 25,
//                                interval: 5,
                                axisLabel: {
                                    formatter: '{value}'
                                }
                            }
                        ],
                        series: [
                            {
                                name:'点击量',
                                type:'bar',
                                data:click_num
                            },
                            {
                                name:'访问量',
                                type:'bar',
                                data:visit_num
                            },
                            {
                                name:'平均量',
                                type:'line',
                                yAxisIndex: 1,
                                data:mean
                            }
                        ]
                    };
                    // 使用刚指定的配置项和数据显示图表。
                    myChart.setOption(option);
                }
            });
        }

        function list(list,day) {
            $("#tab_body").empty();
            var tab_body = '';
            if(list.length>30){
                tab_body = '<tr><td colspan="5">此数据暂不显示</td></tr>';
            }else {
                for(var i=0; i<list.length;i++) {
                    tab_body += '<tr><td class="col-sm-2">'  + list[i].project_name  ;
                    tab_body += '</td><td class="col-sm-2">' + list[i].docu_name ;
                    tab_body += '</td><td class="col-sm-1">' + list[i].click;
                    tab_body += '</td><td class="col-sm-1">' + list[i].visits;
                    tab_body += '</td><td class="col-sm-2">' + list[i].created_at;
                    tab_body += '</td></tr>';
                }
            }
            $("#tab_body").append(tab_body);
        }
    </script>
@endpush