<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>学习小组github提交情况</title>
</head>
<body>
<div id="main" style="width: 100%;height:500px;"></div>

<br>
<br>
<br>

@foreach($name as $k => $v)
    {{ $v }} : <a href="{{ $url[$k] }}" target="_blank">{{ $url[$k] }}</a> <br>
@endforeach

<script src="https://cdn.bootcss.com/echarts/3.5.4/echarts.common.min.js"></script>
<script type="text/javascript">
    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('main'));

    // 指定图表的配置项和数据
    option = {
        title: {
            text: '最近一周github提交统计'
        },
        tooltip: {
            trigger: 'axis'
        },
        legend: {
            data: {!! json_encode($name) !!}
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
            data: {!! json_encode($date) !!}
        },

        yAxis: {
            type: 'value',
            axisLabel: {
                formatter: '{value} '
            },
            interval: 1,
            min: 0,
            splitLine: {
                show: true
            }
        },
        series: {!! json_encode($series) !!}
    }
    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);
</script>
</body>
</html>