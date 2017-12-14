@extends('layouts.main')
@section('title','浏览器统计数据')
@section('head-script')
@stop
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
        <div class="box-tools">
            是否PC
            <div class="btn-group" id="realtime" data-toggle="btn-toggle">
                <button type="button" class="btn btn-default is_pc btn-info" data-date="3" data-toggle="on">全部</button>
                <button type="button" class="btn btn-default is_pc" data-date="1" data-toggle="on">是</button>
                <button type="button" class="btn btn-default is_pc" data-date="0" data-toggle="off">否</button>
            </div>
        </div>
        <div class="btn-group">
            <button type="button" class="btn btn-default btn-info day" data-date="7">最近7天</button>
            <button type="button" class="btn btn-default day" data-date="30">最近30天</button>
            <button type="button" class="btn btn-default day" data-date="365">最近1年</button>
        </div>
    </ol>


    <!-- LINE CHART -->
    <div class="box box-info" style="clear: both;" >
        <div class="box-header with-border"><h5>浏览器使用比例图</h5>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                            class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                            class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body chart-responsive">
            <div class="chart" id="pie-chart" style="height: 500px;"></div>
        </div>
        <!-- /.box-body -->
    </div>

@endsection
@push('foot-script')
    <script>
        var is_pc = 3;
        var day = 7;
        var project_id = 0;
        var start_time , end_time;
        $(function () {
            pie_chart(project_id,start_time,end_time,day,is_pc);
            $(".btn-group .btn.day").click(function () {
                var _this = $(this);
                if( _this.hasClass('btn-info') ) return false;
                day = _this.attr('data-date');
                start_time = '';
                end_time   = '';
                $('.btn-group .btn.day').removeClass('btn-info');
                _this.addClass('btn-info');
                pie_chart(project_id,start_time,end_time,day,is_pc);
            });
            $(".btn-group .is_pc").click(function () {
                var _this = $(this);
                if( _this.hasClass('btn-info') ) return false;
                is_pc = _this.attr('data-date');
                $('.btn-group .is_pc').removeClass('btn-info');
                _this.addClass('btn-info');
                pie_chart(project_id,start_time,end_time,day,is_pc);
            });
            $('.project').change(function () {
                project_id = $('.project').val();
                pie_chart(project_id,start_time,end_time,day,is_pc);
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
                    pie_chart(project_id,start_time,end_time,day,is_pc);
                    $('.btn-group .btn').removeClass('btn-info');
                }
            });
        });

        function pie_chart(project_id,start_time,end_time,day,is_pc) {
            $.jsonPost("{{yUrl(['browser/index'])}}", {
                'project_id': project_id,
                'start_time':start_time,
                'end_time':end_time,
                'day': day,
                'is_pc': is_pc
            }, function (res) {
                var bro_name = [], bro_data = [];
                if (res) {
                    for (var i = 0; i < res.length; i++) {
                        bro_name[i] = res[i].bro_name;
                        bro_data[i] = {"value": res[i].num, "name": res[i].bro_name};
                    }
                    // 基于准备好的dom，初始化echarts实例
                    var myChart = echarts.init(document.getElementById('pie-chart'));
                    var option = {
                        title: {
                            text: '客户端访问来源',
                            subtext: '统计比例',
                            x: 'center'
                        },
                        tooltip: {
                            trigger: 'item',
                            formatter: "{a} <br/>{b} : {c} ({d}%)"
                        },
                        legend: {
                            orient: 'vertical',
                            left: 'left',
                            data: bro_name
                        },
                        series: [
                            {
                                name: '使用比例',
                                type: 'pie',
                                radius: '55%',
                                center: ['50%', '60%'],
                                data: bro_data,
                                itemStyle: {
                                    emphasis: {
                                        shadowBlur: 10,
                                        shadowOffsetX: 0,
                                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                                    }
                                }
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