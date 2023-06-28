@extends('admin.base')

@section('page-content')
    <div class="page-wrapper">
        <div class="page-breadcrumb bg-white">
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Dashboard</h4>
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-12">
                    <div class="white-box analytics-info">
                        <h3 class="box-title">Tổng số người dùng</h3>
                        <ul class="list-inline two-part d-flex align-items-center mb-0">
                            <li>
                                <div id="sparklinedash">
                                    <canvas width="67" height="30"
                                            style="display: inline-block;
                                            width: 67px; height: 30px; vertical-align: top;">
                                    </canvas>
                                </div>
                            </li>
                            <li class="ms-auto"><span class="counter text-success">{{$countUsers}}</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="white-box analytics-info">
                        <h3 class="box-title">Tổng số hóa đơn</h3>
                        <ul class="list-inline two-part d-flex align-items-center mb-0">
                            <li>
                                <div id="sparklinedash2"><canvas width="67" height="30"
                                                                 style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>
                                </div>
                            </li>
                            <li class="ms-auto"><span class="counter text-purple">{{$countOrders}}</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="white-box analytics-info">
                        <h3 class="box-title">Tổng số sản phẩm</h3>
                        <ul class="list-inline two-part d-flex align-items-center mb-0">
                            <li>
                                <div id="sparklinedash3"><canvas width="67" height="30"
                                                                 style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>
                                </div>
                            </li>
                            <li class="ms-auto"><span class="counter text-info">{{$countProducts}}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <div class="white-box">
                        <h3 class="box-title">Biểu đồ</h3>
                        <div class="d-md-flex">
                            <ul class="list-inline d-flex ms-auto">
                                <li class="ps-3">
                                    <h5><i class="fa fa-circle me-1 text-inverse"></i>Đăng ký</h5>
                                </li>
                                <li class="ps-3">
                                    <h5><i class="fa fa-circle me-1 text-info"></i>Đơn hàng</h5>
                                </li>
                            </ul>
                        </div>
                        <div id="ct-visits" style="height: 405px;">
                            <div class="chartist-tooltip" style="top: -17px; left: -12px;">
                                <span class="chartist-tooltip-value">6</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="application/javascript">
        $(function () {
            "use strict";
            // ==============================================================
            // Newsletter
            // ==============================================================

            //ct-visits
            new Chartist.Line('#ct-visits', {
                labels: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
                series: {{$chart}}
            }, {
                top: 0,
                low: 1,
                showPoint: true,
                fullWidth: true,
                plugins: [
                    Chartist.plugins.tooltip()
                ],
                axisY: {
                    labelInterpolationFnc: function (value) {
                        return (value / 1);
                    }
                },
                showArea: true
            });


            var chart = [chart];

            var sparklineLogin = function () {
                $('#sparklinedash').sparkline([0, 5, 6, 10, 9, 12, 4, 9], {
                    type: 'bar',
                    height: '30',
                    barWidth: '4',
                    resize: true,
                    barSpacing: '5',
                    barColor: '#7ace4c'
                });
                $('#sparklinedash2').sparkline([0, 5, 6, 10, 9, 12, 4, 9], {
                    type: 'bar',
                    height: '30',
                    barWidth: '4',
                    resize: true,
                    barSpacing: '5',
                    barColor: '#7460ee'
                });
                $('#sparklinedash3').sparkline([0, 5, 6, 10, 9, 12, 4, 9], {
                    type: 'bar',
                    height: '30',
                    barWidth: '4',
                    resize: true,
                    barSpacing: '5',
                    barColor: '#11a0f8'
                });
                $('#sparklinedash4').sparkline([0, 5, 6, 10, 9, 12, 4, 9], {
                    type: 'bar',
                    height: '30',
                    barWidth: '4',
                    resize: true,
                    barSpacing: '5',
                    barColor: '#f33155'
                });
            }
            var sparkResize;
            $(window).on("resize", function (e) {
                clearTimeout(sparkResize);
                sparkResize = setTimeout(sparklineLogin, 500);
            });
            sparklineLogin();
        });
    </script>
@endsection
