<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - laravel-bjyadmin</title>
    <link href="{{ asset('statics/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('statics/gentelella/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('statics/gentelella/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <link href="{{ asset('statics/gentelella/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('statics/gentelella/build/css/custom.min.css') }}" rel="stylesheet">
    @yield('css')
</head>
<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>Gentellela Alela!</span></a>
                </div>

                <div class="clearfix"></div>

                <!-- menu profile quick info -->
                <div class="profile">
                    <div class="profile_pic">
                        <img src="{{ asset('statics/gentelella/production/images/img.jpg') }}" alt="..." class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span>Welcome,</span>
                        <h2>John Doe</h2>
                    </div>
                </div>
                <!-- /menu profile quick info -->

                <br />

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section">
                        <h3>General</h3>
                        <ul class="nav side-menu">
                            @foreach($adminNav as $v)
                                {{--<li class="active"><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>--}}
                                    {{--<ul class="nav child_menu" style="display: block;">--}}
                                        {{--<li class="current-page"><a href="index.html">Dashboard</a></li>--}}
                                        {{--<li><a href="index2.html">Dashboard2</a></li>--}}
                                        {{--<li><a href="index3.html">Dashboard3</a></li>--}}
                                    {{--</ul>--}}
                                {{--</li>--}}
                                <li><a><i class="fa fa-edit"></i> {{ $v['name'] }} <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        @foreach($v['_data'] as $n)
                                            <li><a href="{{ url($n['mca']) }}">{{ $n['name'] }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </div>


                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <div class="sidebar-footer hidden-small">
                    <a data-toggle="tooltip" data-placement="top" title="Settings">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Lock">
                        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Logout">
                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                    </a>
                </div>
                <!-- /menu footer buttons -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <div class="nav_menu">
                <nav>
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <img src="{{ asset('statics/gentelella/production/images/img.jpg') }}" alt="">John Doe
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                <li><a href="javascript:;"> Profile</a></li>
                                <li>
                                    <a href="javascript:;">
                                        <span class="badge bg-red pull-right">50%</span>
                                        <span>Settings</span>
                                    </a>
                                </li>
                                <li><a href="javascript:;">Help</a></li>
                                <li><a href="login.html"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                            </ul>
                        </li>

                        <li role="presentation" class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-envelope-o"></i>
                                <span class="badge bg-green">6</span>
                            </a>
                            <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                <li>
                                    <a>
                                        <span class="image"><img src="{{ asset('statics/gentelella/production/images/img.jpg') }}" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                                        <span class="image"><img src="{{ asset('statics/gentelella/production/images/img.jpg') }}" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                                        <span class="image"><img src="{{ asset('statics/gentelella/production/images/img.jpg') }}" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                                        <span class="image"><img src="{{ asset('statics/gentelella/production/images/img.jpg') }}" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                                    </a>
                                </li>
                                <li>
                                    <div class="text-center">
                                        <a>
                                            <strong>See All Alerts</strong>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>@yield('nav') <small>@yield('description')</small></h3>
                    </div>

                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>

        <!-- footer content -->
        <footer>
            <div class="pull-right">
                Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>
</div>

<script src="{{ asset('statics/gentelella/vendors/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('statics/gentelella/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('statics/gentelella/vendors/fastclick/lib/fastclick.js') }}"></script>
<script src="{{ asset('statics/gentelella/vendors/nprogress/nprogress.js') }}"></script>
<script src="{{ asset('statics/gentelella/vendors/Chart.js/dist/Chart.min.js') }}"></script>
<script src="{{ asset('statics/gentelella/vendors/gauge.js/dist/gauge.min.js') }}"></script>
<script src="{{ asset('statics/gentelella/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
<script src="{{ asset('statics/gentelella/vendors/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('statics/gentelella/vendors/skycons/skycons.js') }}"></script>
<script src="{{ asset('statics/gentelella/vendors/Flot/jquery.flot.js') }}"></script>
<script src="{{ asset('statics/gentelella/vendors/Flot/jquery.flot.pie.js') }}"></script>
<script src="{{ asset('statics/gentelella/vendors/Flot/jquery.flot.time.js') }}"></script>
<script src="{{ asset('statics/gentelella/vendors/Flot/jquery.flot.stack.js') }}"></script>
<script src="{{ asset('statics/gentelella/vendors/Flot/jquery.flot.resize.js') }}"></script>
<script src="{{ asset('statics/gentelella/vendors/flot.orderbars/js/jquery.flot.orderBars.js') }}"></script>
<script src="{{ asset('statics/gentelella/vendors/flot-spline/js/jquery.flot.spline.min.js') }}"></script>
<script src="{{ asset('statics/gentelella/vendors/flot.curvedlines/curvedLines.js') }}"></script>
<script src="{{ asset('statics/gentelella/vendors/DateJS/build/date.js') }}"></script>
<script src="{{ asset('statics/gentelella/vendors/jqvmap/dist/jquery.vmap.js') }}"></script>
<script src="{{ asset('statics/gentelella/vendors/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
<script src="{{ asset('statics/gentelella/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js') }}"></script>
<script src="{{ asset('statics/gentelella/production/js/moment/moment.min.js') }}"></script>
<script src="{{ asset('statics/gentelella/production/js/datepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('statics/gentelella/build/js/custom.min.js') }}"></script>
<!-- Flot -->
<script>
    $(document).ready(function() {
        //random data
        var d1 = [
            [0, 1],
            [1, 9],
            [2, 6],
            [3, 10],
            [4, 5],
            [5, 17],
            [6, 6],
            [7, 10],
            [8, 7],
            [9, 11],
            [10, 35],
            [11, 9],
            [12, 12],
            [13, 5],
            [14, 3],
            [15, 4],
            [16, 9]
        ];

        //flot options
        var options = {
            series: {
                curvedLines: {
                    apply: true,
                    active: true,
                    monotonicFit: true
                }
            },
            colors: ["#26B99A"],
            grid: {
                borderWidth: {
                    top: 0,
                    right: 0,
                    bottom: 1,
                    left: 1
                },
                borderColor: {
                    bottom: "#7F8790",
                    left: "#7F8790"
                }
            }
        };
        var plot = $.plot($("#placeholder3xx3"), [{
            label: "Registrations",
            data: d1,
            lines: {
                fillColor: "rgba(150, 202, 89, 0.12)"
            }, //#96CA59 rgba(150, 202, 89, 0.42)
            points: {
                fillColor: "#fff"
            }
        }], options);
    });
</script>
<!-- /Flot -->

<!-- jQuery Sparklines -->
<script>
    $(document).ready(function() {
        $(".sparkline_one").sparkline([2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 5, 6, 7, 5, 4, 3, 5, 6], {
            type: 'bar',
            height: '40',
            barWidth: 9,
            colorMap: {
                '7': '#a1a1a1'
            },
            barSpacing: 2,
            barColor: '#26B99A'
        });

        $(".sparkline_two").sparkline([2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 5, 6, 7, 5, 4, 3, 5, 6], {
            type: 'line',
            width: '200',
            height: '40',
            lineColor: '#26B99A',
            fillColor: 'rgba(223, 223, 223, 0.57)',
            lineWidth: 2,
            spotColor: '#26B99A',
            minSpotColor: '#26B99A'
        });
    });
</script>
<!-- /jQuery Sparklines -->

<!-- Doughnut Chart -->
<script>
    $(document).ready(function() {
        var options = {
            legend: false,
            responsive: false
        };

        new Chart(document.getElementById("canvas1"), {
            type: 'doughnut',
            tooltipFillColor: "rgba(51, 51, 51, 0.55)",
            data: {
                labels: [
                    "Symbian",
                    "Blackberry",
                    "Other",
                    "Android",
                    "IOS"
                ],
                datasets: [{
                    data: [15, 20, 30, 10, 30],
                    backgroundColor: [
                        "#BDC3C7",
                        "#9B59B6",
                        "#E74C3C",
                        "#26B99A",
                        "#3498DB"
                    ],
                    hoverBackgroundColor: [
                        "#CFD4D8",
                        "#B370CF",
                        "#E95E4F",
                        "#36CAAB",
                        "#49A9EA"
                    ]
                }]
            },
            options: options
        });
    });
</script>
<!-- /Doughnut Chart -->

<!-- bootstrap-daterangepicker -->
<script type="text/javascript">
    $(document).ready(function() {

        var cb = function(start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        };

        var optionSet1 = {
            startDate: moment().subtract(29, 'days'),
            endDate: moment(),
            minDate: '01/01/2012',
            maxDate: '12/31/2015',
            dateLimit: {
                days: 60
            },
            showDropdowns: true,
            showWeekNumbers: true,
            timePicker: false,
            timePickerIncrement: 1,
            timePicker12Hour: true,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            opens: 'left',
            buttonClasses: ['btn btn-default'],
            applyClass: 'btn-small btn-primary',
            cancelClass: 'btn-small',
            format: 'MM/DD/YYYY',
            separator: ' to ',
            locale: {
                applyLabel: 'Submit',
                cancelLabel: 'Clear',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom',
                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: 1
            }
        };
        $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
        $('#reportrange').daterangepicker(optionSet1, cb);
        $('#reportrange').on('show.daterangepicker', function() {
            console.log("show event fired");
        });
        $('#reportrange').on('hide.daterangepicker', function() {
            console.log("hide event fired");
        });
        $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
            console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
        });
        $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
            console.log("cancel event fired");
        });
        $('#options1').click(function() {
            $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
        });
        $('#options2').click(function() {
            $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
        });
        $('#destroy').click(function() {
            $('#reportrange').data('daterangepicker').remove();
        });
    });
</script>
<!-- /bootstrap-daterangepicker -->

<!-- morris.js -->
<script>
    $(document).ready(function() {
        Morris.Bar({
            element: 'graph_bar',
            data: [
                { "period": "Jan", "Hours worked": 80 },
                { "period": "Feb", "Hours worked": 125 },
                { "period": "Mar", "Hours worked": 176 },
                { "period": "Apr", "Hours worked": 224 },
                { "period": "May", "Hours worked": 265 },
                { "period": "Jun", "Hours worked": 314 },
                { "period": "Jul", "Hours worked": 347 },
                { "period": "Aug", "Hours worked": 287 },
                { "period": "Sep", "Hours worked": 240 },
                { "period": "Oct", "Hours worked": 211 }
            ],
            xkey: 'period',
            hideHover: 'auto',
            barColors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
            ykeys: ['Hours worked', 'sorned'],
            labels: ['Hours worked', 'SORN'],
            xLabelAngle: 60,
            resize: true
        });

        $MENU_TOGGLE.on('click', function() {
            $(window).resize();
        });
    });
</script>
<!-- /morris.js -->

<!-- Skycons -->
<script>
    var icons = new Skycons({
                "color": "#73879C"
            }),
            list = [
                "clear-day", "clear-night", "partly-cloudy-day",
                "partly-cloudy-night", "cloudy", "rain", "sleet", "snow", "wind",
                "fog"
            ],
            i;

    for (i = list.length; i--;)
        icons.set(list[i], list[i]);

    icons.play();
</script>
<!-- /Skycons -->

<!-- gauge.js -->
<script>
    var opts = {
        lines: 12,
        angle: 0,
        lineWidth: 0.4,
        pointer: {
            length: 0.75,
            strokeWidth: 0.042,
            color: '#1D212A'
        },
        limitMax: 'false',
        colorStart: '#1ABC9C',
        colorStop: '#1ABC9C',
        strokeColor: '#F0F3F3',
        generateGradient: true
    };
    var target = document.getElementById('foo'),
            gauge = new Gauge(target).setOptions(opts);

    gauge.maxValue = 100;
    gauge.animationSpeed = 32;
    gauge.set(80);
    gauge.setTextField(document.getElementById("gauge-text"));

    var target = document.getElementById('foo2'),
            gauge = new Gauge(target).setOptions(opts);

    gauge.maxValue = 5000;
    gauge.animationSpeed = 32;
    gauge.set(4200);
    gauge.setTextField(document.getElementById("gauge-text2"));
</script>
<!-- /gauge.js -->
@yield('js')
</body>
</html>