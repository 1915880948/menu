@extends('layouts.main')
@section('title','导航点击趋势图')

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
        <select class="form-control sidebar_select">
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

    <div class="box box-info">
        <div class="box-header with-border">
            <div class="box-body chart-responsive">
                <div class="chart" id="line-chart" style="height: 600px;"></div>
            </div>
        </div>
    </div>

    <div id="list">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th><a href="#" data-sort="project_id">项目ID</a></th>
                <th><a href="#" data-sort="docu_id">导航栏目</a></th>
                <th><a href="#" data-sort="click">点击次数</a></th>
                <th><a href="#" data-sort="created_at">截止时间</a></th>
            </tr>
            </thead>
            <tbody id="tab_body"></tbody>
        </table>
    </div>
@endsection

@push('foot-script')
    <script>
        var  date = [] , visit_num = [], click_num = [];
        var project_id = 0,sidebar_id = 22,start_time,end_time,day =7;
        $(function () {
            line_chart(project_id, sidebar_id,start_time,end_time,day);
            $(".btn-group .btn").click(function () {
                var _this = $(this);
                if( _this.hasClass('btn-info') ) return false;
                day = _this.attr('data-date');
                start_time = ''; end_time = '';
                $('.btn-group .btn').removeClass('btn-info');
                _this.addClass('btn-info');
                line_chart(project_id, sidebar_id,start_time,end_time,day);
            });

            $('.project').change(function () {
                project_id = $(".project").val();
                $.jsonPost("{{yUrl(['post-select/sidebar'])}}",{'project_id':project_id},function (res) {
                    $('.form-control.sidebar_select').empty();
                    var side_list = '<option value="0">全部</option>';
                    for(var key in res ){
                        side_list += '<option value="'+key+'">'+res[key]+'</option>';
                    }
                    $('.form-control.sidebar_select').append(side_list);
                });
                sidebar_id = $('.form-control.sidebar_select').val();
                line_chart(project_id, sidebar_id ,start_time,end_time,day);
            });
            $('.form-control.sidebar_select').change(function () {
                sidebar_id = $('.form-control.sidebar_select').val();
                line_chart(project_id, sidebar_id,start_time,end_time,day);
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
                    line_chart(project_id,sidebar_id,start_time,end_time,day);
                    $('.btn-group .btn').removeClass('btn-info');
                }
            });


        });

        function line_chart (project_id, sidebar_id ,start_time,end_time,day) {
            $.jsonPost("{{yUrl(['sidebar/index'])}}",
                {'project_id':project_id,
                    'sidebar_id':sidebar_id,
                    'start_time':start_time,
                    'end_time':end_time,
                    'day':day
                },function (res) {
                list(res,project_id, sidebar_id,day);
                if(res){
                    date = [];  visit_num = []; click_num = [];
                    for(var i=0;i<res.length; i++){
                        date[i]      = res[i].created_at ;
                        visit_num[i] = res[i].visit_num;
                        click_num[i] = res[i].click_total;
                    }

                    // 基于准备好的dom，初始化echarts实例
                    var myChart = echarts.init(document.getElementById('line-chart'));
                    // 指定图表的配置项和数据
                    var option = {
                        title: {
                            text: '项目导航点击趋势图'
                        },
                        tooltip: {
                            trigger: 'axis'
                        },
                        legend: {
                            data:['点击量']
                        },
                        grid: {
                            left: '3%',
                            right: '4%',
                            bottom: '3%',
                            containLabel: true
                        },
                        toolbox: {
                            feature: {
                                saveAsImage: {}
                            }
                        },
                        xAxis: {
                            type: 'category',
                            boundaryGap: false,
                            data:date
                        },
                        yAxis: {
                            type: 'value'
                        },
                        series: [
                            {
                                name:'点击量',
                                type:'line',
                                stack: '总量',
                                data:click_num
                            }
                        ]
                    };
                    // 使用刚指定的配置项和数据显示图表。
                    myChart.setOption(option);
                }
            });

        }

        function list(list) {
            $("#tab_body").empty();
            var tab_body = '';
            if(list.length> 30 ){
                tab_body = '<tr><td colspan="4">此数据暂不显示</td></tr>';
            }else {
                for(var i=0; i<list.length;i++) {
                    tab_body += '<tr><td class="col-sm-2">'  + list[i].project_name  ;
                    tab_body += '</td><td class="col-sm-2">' + list[i].sidebar_name ;
                    tab_body += '</td><td class="col-sm-1">' + list[i].click_total;
                    tab_body += '</td><td class="col-sm-2">' + list[i].updated_at;
                    tab_body += '</td></tr>';
                }
            }
            $("#tab_body").append(tab_body);
        }
    </script>
@endpush