<?
// Prepare parameters for view
$selected_year = isset($_POST['year']) ? $_POST['year'] : date('Y');
$selected_month = isset($_POST['month']) ? $_POST['month'] : date('m');

// Get list of YEARS
$year_list_query = sprintf("select distinct year(%s) as year, year(%s) as year_name from attendance_absent order by year asc",'absent_date','absent_date');
$year_list_query = $this->db->query($year_list_query);
$year_list = $year_list_query->result();
if ($year_list[0]->year == '0') {
    $year_list[0]->year_name = 'N/A';
}

// Get list of MONTH
$month_list_query = sprintf("select distinct month(%s) as month, monthname(%s) as month_name from attendance_absent order by month asc",'absent_date','absent_date');
$month_list_query = $this->db->query($month_list_query);
$month_list = $month_list_query->result();
if ($month_list[0]->month == '0') {
    $month_list[0]->month_name = 'N/A';
}

// calculate number of days in a month
$days = $selected_month == 2 ? ($selected_year % 4 ? 28 : ($selected_year % 100 ? 29 : ($selected_year % 400 ? 28 : 29))) : (($selected_month - 1) % 7 % 2 ? 30 : 31);

// Get list of respective data
$query = "select day(absent_date) as date_no, month(absent_date) as month_no, monthname(absent_date) as month_name, count(*) as total from attendance_absent";
$query .= sprintf(" where year(absent_date)='%s' and month(absent_date)='%s' group by date_no order by date_no asc",
    $selected_year,$selected_month);

$query = $this->db->query($query);
$result = $query->result();

// In case no valid data
if ($result==null) {echo "No data! ";}
else {
    $chart_data = $result;
}
?>
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
                    text:'Monthly attendance report'
                },
                subtitle:{
                    text:'How many times of absence by month'
                },
                xAxis:{
                    categories:[
                    <?
                    $output = "";
//                    for($iday = 1;$iday<=$days;$iday++){
//                        $output .= "'" . $iday . "',";
//                    }
                    foreach ($chart_data as $item) {
                        $output .= $item->date_no . ",";
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
                        return this.y + ' case(s)';
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
<script type="text/javascript">
    function reloadPage() {
        document.formFilter.submit();
    }
</script>
<script src="<?=base_url('asset/mods')?>/highcharts.js"></script>
<div id="studentSearchForm" class="standard_block border_standard">
    <form name="formFilter" method="POST" action="<?=base_url('admin/attendance/report-absence-by-days')?>">
        <label>[Filter] Campus:</label>
        <select name="campus">
            <option value="">--All--</option>
            <?foreach ($campus_list as $cam) { ?>
            <option
                value="<?=$cam->id?>" <?=($cam->id == $selected_cam) ? "selected=true" : ''?>><?=$cam->name?></option>
            <? }?>
        </select>
        <label>Year:</label>
        <select name="year" onchange="reloadPage()">
            <?foreach ($year_list as $year) { ?>
            <option
                value="<?=$year->year?>" <?=($year->year == $selected_year) ? "selected=true" : ''?>><?=$year->year_name?></option>
            <? }?>
        </select>
        <label>Month:</label>
        <select name="month" onchange="reloadPage()">
            <?foreach ($month_list as $month) { ?>
            <option
                value="<?=$month->month?>" <?=($month->month == $selected_month) ? "selected=true" :
                ''?>><?=$month->month_name?></option>
            <? }?>
        </select>
    </form>
</div>
<div class="clearfix"></div>
<div id="chart_container" class="" style="height: 300px; width:100%;margin: 0 auto"></div>


