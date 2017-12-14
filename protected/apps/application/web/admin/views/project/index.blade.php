@extends('layouts.main')
@section('title','项目访问趋势图')

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
@endsection

@push('foot-script')
    <script>
        var  date = [] , visit_num = [], click_num = [];
        var project_id = 0,start_time,end_time, day =7;
        $(function () {
            line_chart(project_id,start_time,end_time,day);
            $(".btn-group .btn").click(function () {
                var _this = $(this);
                if( _this.hasClass('btn-info') ) return false;
                start_time = '';
                end_time = '';
                day = _this.attr('data-date');
                project_id = $('.project').val();
                $('.btn-group .btn').removeClass('btn-info');
                _this.addClass('btn-info');
                line_chart(project_id,start_time,end_time,day);
            });
            $('.project').change(function () {
                //day = _this.attr('data-date');
                project_id = $('.project').val();
                line_chart(project_id,start_time,end_time,day);
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
                    line_chart(project_id,start_time,end_time,day);
                    $('.btn-group .btn').removeClass('btn-info');
                }
            });
        });

        function line_chart (project_id,start_time,end_time,day) {
            var post_date = {
                'project_id':project_id,
                'start_time':start_time,
                'end_time':end_time,
                'day':day
            };
            $.jsonPost("{{yUrl(['project/index'])}}",post_date,function (res) {
                if(res){
                    date = [];  visit_num = []; click_num = [];
                    for(var i=0;i<res.length; i++){
                        date[i]      = res[i].created_at ;
                        visit_num[i] = res[i].visit_num;
                        click_num[i] = res[i].click_num;
                    }

                    // 基于准备好的dom，初始化echarts实例
                    var myChart = echarts.init(document.getElementById('line-chart'));
                    // 指定图表的配置项和数据
                    var option = {
                        title: {
                            text: '项目访问趋势图'
                        },
                        tooltip: {
                            trigger: 'axis'
                        },
                        legend: {
                            data:['访问量','点击量']
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
                                name:'访问量',
                                type:'line',
                                stack: '总量',
                                data:visit_num
                            },
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

    </script>
@endpush