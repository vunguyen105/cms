<script type="text/javascript">
    $(function () {
        var chart;
        $(document).ready(function () {

            // Radialize the colors
            Highcharts.getOptions().colors = $.map(Highcharts.getOptions().colors, function (color) {
                return {
                    radialGradient:{ cx:0.5, cy:0.3, r:0.7 },
                    stops:[
                        [0, color],
                        [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
                    ]
                };
            });

            // Build the chart
            chart = new Highcharts.Chart({
                chart:{
                    renderTo:'chart_class_size',
                    plotBackgroundColor:null,
                    plotBorderWidth:null,
                    plotShadow:false
                },
                title:{
                    text:'Students Proportion by Grade'
                },
                tooltip:{
                    pointFormat:'{series.name}: <b>{point.percentage} %</b>',
                    percentageDecimals:1
                },
                plotOptions:{
                    pie:{
                        allowPointSelect:true,
                        cursor:'pointer',
                        dataLabels:{
                            enabled:true,
                            color:'#000000',
                            connectorColor:'#000000',
                            formatter:function () {
                                return '<b>' + this.point.name + '</b>: ' + this.y + ' (student)';
                            }
                        }
                    }
                },
                series:[
                    {
                        type:'pie',
                        name:'Grade ratio in SIS',
                        data:[
                        <?
                        $output = "";
                        foreach ($student_count_by_grade as $item) {
                            $output .= "['Grade " . $item->grade . "'," . $item->total_students . "],";
                        }
                        echo trim($output, ",");
                        ?>

//                            ['Firefox', 45.0],
//                            ['IE', 26.8],
//                            {
//                                name:'Chrome',
//                                y:12.8,
//                                sliced:true,
//                                selected:true
//                            },
//                            ['Safari', 8.5],
//                            ['Opera', 6.2],
//                            ['Others', 0.7]
                        ]
                    }
                ]
            });
        });

    });
</script>
<script src="<?=base_url('asset/mods')?>/highcharts.js"></script>
<div id="chart_class_size" style="min-width: 400px; height: 400px; width:100%;margin: 0 auto"></div>
    <h5 class="align_center">Total: <?php echo $total_students_count ?></h5>