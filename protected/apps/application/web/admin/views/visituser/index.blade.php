@extends('layouts.main')
@section('title','用户分布')
@section('content')
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
    <div class="chart" id="map-chart" style="height: 500px;"></div>
    <div id="list">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th><a href="#" data-sort="project_id">省份/直辖市</a></th>
                <th><a href="#" data-sort="visits">访问量</a></th>
                <th><a href="#" data-sort="updated_at">截止时间</a></th>
            </tr>
            </thead>
            <tbody id="tab_body"></tbody>
        </table>
    </div>
@endsection
@push('foot-script')
    <script>
        var start_time,end_time,day = 7;
        $(function () {
            map_charts(start_time,end_time,day);
            $(".btn-group .btn").click(function () {
                var _this = $(this);
                if( _this.hasClass('btn-info') ) return false;
                day = _this.attr('data-date');
                start_time = ''; end_time = '';
                $('.btn-group .btn').removeClass('btn-info');
                _this.addClass('btn-info');
                map_charts(start_time,end_time,day);
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
                    map_charts(start_time,end_time,day);
                    $('.btn-group .btn').removeClass('btn-info');
                }
            });
        });
        function map_charts(start_time,end_time,day) {
            $.post("{{yUrl('visituser/index')}}",{'start_time':start_time,'end_time':end_time,'day':day},function (res) {
                list(res);
                // 基于准备好的dom，初始化echarts实例
                var myChart = echarts.init(document.getElementById('map-chart'));
                myChart.setOption({
                    series: [{
                        type: 'map',
                        map: 'china'
                    }]
                });
                option = {
                    title: {
                        text: '用户访问分布图',
                        subtext: '访问量分布图',
                        sublink: '#',
                        itemGap: 30,
                        left: 'center',
                        textStyle: {
                            color: '#1a1b4e',
                            fontStyle: 'normal',
                            fontWeight: 'bold',
                            fontSize: 30
                        },

                        subtextStyle: {
                            color: '#58d9df',
                            fontStyle: 'normal',
                            fontWeight: 'bold',
                            fontSize: 16
                        }
                    },
                    tooltip: {
                        trigger: 'item'
                    },
                    visualMap: {
                        min: 0,
                        max: 100,
                        left: 'left',
                        top: 'bottom',
                        text: ['高', '低'],
                        calculable: true,
                        inRange: {
                            color: ['#ffffff', '#E0DAFF', '#ADBFFF', '#9CB4FF', '#6A9DFF', '#3889FF']
                        }
                    },
                    toolbox: {
                        show: true,
                        orient: 'vertical',
                        left: 'right',
                        top: 'center',
                        feature: {
                            dataView: {
                                readOnly: false
                            },
                            restore: {},
                            saveAsImage: {}
                        }
                    },

                    geo: {
                        map: 'china',
                        zoom: 1.2,
                        label: {
                            normal: {

                                show: true,
                                color: '#c1c4c8'
                            },
                            emphasis: {
                                show: false,
                                color: '#292929'
                            }
                        },
                        roam: true,
                        itemStyle: {
                            normal: {
                                areaColor: '#fbfbfb',
                                borderColor: '#b9b4b7'

                            },
                            emphasis: {
                                areaColor: '#05ff09'
                            }
                        }
                    },
//                {
//                    name:'访问量',
//                        type:'line',
//                    stack: '总量',
//                    data:visit_num
//                }
                    series: [{
                        name: '访问量',
                        stack: '总量',
                        type: 'effectScatter',
                        coordinateSystem: 'geo',
//                        data: convertData(data),
                        symbolSize: 10,
                        showEffectOn: 'render',
                        rippleEffect: {
                            brushType: 'stroke'
                        },
                        hoverAnimation: true,
                    }, {
                        type: 'map',
                        mapType: 'china',
                        geoIndex: 0,
                        label: {
                            normal: {
                                show: true
                            },
                            emphasis: {
                                show: true
                            }
                        },
                        data: res
                    }]
                };
                myChart.setOption(option);
            });
        }
        function list(list) {
            $("#tab_body").empty();
            var tab_body = '';
            if(list.length < 1 ){
                tab_body = '<tr><td colspan="5">暂无数据</td></tr>';
            }else {
                for(var i=0; i<list.length;i++) {
                    tab_body += '<tr><td class="col-sm-2">'  + list[i].name  ;
                    tab_body += '</td><td class="col-sm-2">' + list[i].value ;
                    tab_body += '</td><td class="col-sm-2">' + list[i].created_at ;
                    tab_body += '</td></tr>';
                }
            }
            $("#tab_body").append(tab_body);
        }
    </script>
@endpush