<script type="text/javascript">
    $(function () {
        var chart;
        $(document).ready(function () {
            chart = new Highcharts.Chart({
                chart:{
                    renderTo:'chart_container',
                    type:'column'
                },
                title:{
                    text:'Monthly absence'
                },
                subtitle:{
                    text:'How many times of absence by month'
                },
                xAxis:{
                    categories:[
                    <?
                    $output = "";
                    foreach ($chart_data as $item) {
                        $output .= "'" . substr($item->month_name, 0, 3) . "',";
                    }
                    echo trim($output, ",");

                    ?>
                    ]
                },
                yAxis:{
                    min:0,
                    title:{
                        text:'Quantity (times)'
                    }
                },
                legend:{
                    layout:'vertical',
                    backgroundColor:'#FFFFFF',
                    align:'left',
                    verticalAlign:'top',
                    x:100,
                    y:70,
                    floating:true,
                    shadow:true
                },
                tooltip:{
                    formatter:function () {
                        return '' +
                            this.x + ': ' + this.y + ' case(s)';
                    }
                },
                plotOptions:{
                    column:{
                        pointPadding:0.2,
                        borderWidth:0
                    }
                },
                series:[
                    {
                        name:'SIS@VanPhuc',
                        data:[
                        <?
                        $output = "";
                        foreach ($chart_data as $item) {
                            $output .= $item->total . ",";
                        }
                        echo trim($output, ",");
                        ?>
                        ]
                    }
                ]
            });
        });

    });
</script>
<script src="<?=base_url('asset/mods')?>/highcharts.js"></script>
<div id="chart_container" class="border_standard" style="height: 300px; width:100%;margin: 0 auto"></div>


