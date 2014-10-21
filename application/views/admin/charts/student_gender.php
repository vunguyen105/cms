<?$chartData = $this->student_model->get_chart_gender();?>
<?
// Prepare parameters for view
$selected_cam = isset($_POST['campus']) ? $_POST['campus'] : "";
$selected_year = isset($_POST['year']) ? $_POST['year'] : date('Y');
$campus_list = $this->campus_model->get();

// Get list of YEARS with respective enrollment data
$year_list_query = "select year(doe) as year, year(doe) as year_name, count(*) as total from students";
$year_list_query .= " left join classes on students.class_id=classes.id";

if ($selected_cam != "") {
    $year_list_query .= " where cam_id=" . $selected_cam;
}

$year_list_query .= " group by year order by year asc";

$year_list_query = $this->db->query($year_list_query);
$year_list = $year_list_query->result();
if ($year_list[0]->year == '0') {
    $year_list[0]->year_name = 'N/A';
}
?>
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
                    text:'Student Gender Ratio * 2012-2013'
                },
                tooltip:{
                    pointFormat:'{series.name}: <b>{point.percentage}%</b>',
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
                                return '<b>' + this.point.name + '</b>: ' + this.y + ' pupils';
                            }
                        }
                    }
                },
                series:[
                    {
                        type:'pie',
                        name:'Gender ratio in SIS',
                        data:[
                        <?
                        $output = "";
                        foreach ($chartData as $item) {
                            $item->gender=($item->gender)?'Male':'Female';
                            $output .= "['" . $item->gender . "'," . $item->total . "],";
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
<div id="studentSearchForm" class="standard_block border_standard">
    <form name="formFilter" method="POST" action="<?=base_url('admin/student/gender-ratio')?>">
        <label>[Filter] Campus:</label>
        <select name="campus" onchange="reloadPage()">
            <option value="">--All--</option>
            <?foreach ($campus_list as $cam) { ?>
            <option
                value="<?=$cam->id?>" <?=($cam->id == $selected_cam) ? "selected=true" : ''?>><?=$cam->name?></option>
            <? }?>
        </select>
        <label>Year:</label>
        <select name="year" onchange="reloadPage()">
            <option value="">--All--</option>
            <?foreach ($year_list as $year) { ?>
            <option
                value="<?=$year->year?>" <?=($year->year == $selected_year) ? "selected=true" : ''?>><?=$year->year_name?></option>
            <? }?>
        </select>
    </form>
</div>
<div id="chart_class_size" style="min-width: 400px; height: 400px; width:100%;margin: 0 auto"></div>