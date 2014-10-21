<?
const DB_DATE_FIELD='modified_on';

// Prepare parameters for view
$selected_cam = isset($_POST['campus']) ? $_POST['campus'] : "";
$selected_year = isset($_POST['year']) ? $_POST['year'] : date('Y');
$campus_list = $this->campus_model->get();

// Get list of YEARS with respective enrollment data
$year_list_query = sprintf("select year(%s) as year, year(%s) as year_name, count(*) as total from students",DB_DATE_FIELD,DB_DATE_FIELD);
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

// Get list of MONTHS with respective enrollment data
$query_enrollment = sprintf("select month(%s) as month_no, monthname(%s) as month_name, count(*) as total from students",
    DB_DATE_FIELD,DB_DATE_FIELD);
$query_enrollment .= " left join classes on students.class_id=classes.id where 1";

if ($selected_year != "") {
    $query_enrollment .= sprintf(" and year(%s)='%s'", DB_DATE_FIELD, $selected_year);
}

if ($selected_cam != "") {
    $query_enrollment .= " and cam_id=" . $selected_cam;
}

$query_enrollment .= " group by month_no order by month_no asc";

$query_enrollment = $this->db->query($query_enrollment);
$list_enroll = $query_enrollment->result();

// In case no valid data (DOE is not filled with data yet, so nothing
if ($list_enroll==null) {echo "No data! Please input Date Of Enrolment into Student Details";return;}

if ($list_enroll[0]->month_no == '0') {
    $list_enroll[0]->month_name = 'N/A';
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
                    text:'Monthly Enrollment/Withdrawal Report'
                },
                subtitle:{
                    text:'Source: HMS'
                },
                xAxis:{
                    categories:[
                    <?
                    $output = "";
                    foreach ($list_enroll as $item) {
                        $output .= "'" . substr($item->month_name, 0, 3) . "',";
                    }
                    echo trim($output, ",");

                    ?>
                    ]
                },
                yAxis:{
                    min:0,
                    title:{
                        text:'Quantity (person)'
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
                            this.x + ': ' + this.y + ' student(s)';
                    }
                },
                plotOptions:{
                    column:{
                        pointPadding:0.2,
                        borderWidth:0
                    }, dataLabels:{
                        enabled:true,
                        style:{
                            fontWeight:'bold',
                            color:'#CCC'
                        },
                        formatter:function () {
                            return this.y + '%';
                        }
                    }
                },
                series:[
                    {
                        name:'New Enrollment',
                        data:[
                        <?
                        $output = "";
                        foreach ($list_enroll as $item) {
                            $output .= $item->total . ",";
                        }
                        echo trim($output, ",");
                        ?>
                        ]
                    }
                    ,
                    {
                        name:'Withdrawal (sample)',
                        data:[5, 3, 25, 8, 33, 13, 5, 1]
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
    <form name="formFilter" method="POST" action="<?=base_url('admin/student/overall')?>">
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
<div class="clearfix"></div>
<div id="chart_container" class="border_standard" style="min-width: 400px; height: 400px; width:100%;"></div>