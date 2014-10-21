<script>

    function reloadClassList() {
        document.formClasses.submit();
    }
    $(document).on('click','.generate',function(){
        var id = this.id;
       // console.log($(this).parents().prev());
       var val = $("#select"+id).val();
      // alert(val);
       if(val == 'others'){
            var val =  $("#input"+id).val();
       }

       //                  <option value="very_good">Very Good</option>
       //                   <option value="good">Good</option>
       //                   <option value="satisfactory">Satisfactory</option>
       //                   <option value="needs_improvement">Needs Improvement</option>
       //                   <option value="others">Others</option>
       //             </select>';
       $.ajax({
            type: "POST",
            data: {
                id: id,
                val: val
            },
            dataType: "json",
            url: 'teacher_comments',
            beforeSend: function() {
            },
            success: function(data) {
             // console.log(data.list);
              var list = data.list;
              var length = Object.keys(data.list).length;
             // alert(length);
             //  var list = jQuery.parseJSON(data);
               // console.log(list);
               var html = '<select class="color" name="color" id="select'+id+'">';

                $.each(list, function(i,item){
                    //$('#sl_district').append('<option value="' + item.ID + '">' + item.Name + '</option>');
                    //alert(val);
                    if(i == val) { //alert(val);
                        html += '<option value="'+i+'"selected>'+item+'</option>';
                    }else{
                        html += '<option value="'+i+'">'+item+'</option>';
                    }
                   // alert(html);
                });
                var text = $("#input"+id).val();
                //console.log(text);
                if(!(!text || 0 === text.length)){ //alert('xxx');
                    html += '<option value="'+text+'"selected>'+text+'</option>';
                }
                html += '<input type="text" name="others" id="input'+id+'" style="display:none;"/>'
                html += '</select>';
               // alert(html);
                $('#td'+id).html(html);
                alert('Thay đổi đã được lưu');
            }
        });

    })
</script>
<script type="text/javascript">
// function CheckColors(val,id){
//  var element=document.getElementById('input'+id);
//  if(val=='others')
//   {
//     element.style.display='block';
//     $('#select'+id).hide();
//   } 
//    //
//  else  
//    element.style.display='none';
// }
$(document).on('change','.color',function(){ 
  var idString = this.id;
  var id = idString.substring(6); 
  //var element=document.getElementById('input'+id);
  //alert(this.value);
  var val = this.value;
  if(val=='others')
  {
    $(".text_none").css("display", "none");
    $("#input"+id).css("display", "block");
    $(".color").show();
    $('#select'+id).hide();
  } 
   //
 else {
  //alert('xxx');
    $("#input"+id).css("display", "none");
    $(".text_none").css("display", "none");
    $(".color").show();
 } 
    
});
</script> 

<p class="module_title">Custom Report</p>
<?php 
    $list = array(
        'very_good' =>'Very Good',
        'good' => 'Good',
        'satisfactory' => 'Satisfactory',
        'needs_improvement' => 'Needs Improvement',
        'others' =>'Others'
    );
    //var_dump($list);die;
?>
<div id="studentSearchForm" class="standard_block border_square">
    <div title="Chọn lớp">
        <form name="formClasses" action="<?=base_url('attendance/teacher_comments')?>" method="POST">
            <select id="cbxClasses" name="select_class" onchange="reloadClassList()">
                <option value="">--Select your class--</option>
                <?foreach ($class_list as $class) { ?>
                <option
                    value="<?=$class->id?>"><?=$class->class_name?></option>
                <? }?>
            </select>
        </form>
    </div>
    <div id="student_list" class="standard_block border_standard">
    <?if (isset($student_list) && count($student_list) > 0) { ?>
    <table class="table_standard">
        <tr class="table_header">
            <td>Grade</td>
            <td>Attended days</td>
            <td>Attendance percentage</td>
            
            
        </tr>
         <?php foreach ($student_list as $stu) { ?>
        <tr class="table_body_row" title="">
            <td><?php echo $stu->name;?></td>
            <td id="<?php echo "td".$stu->id;?>">
               
                <select  class="color" id="<?php echo "select".$stu->id;?>" name="color"> 
                    <?php foreach ($list as $key => $value) {?>
                        <option <?php if($stu->grade == $key) echo "selected";?> value="<?php echo $key;?>"><?php echo $value?></option>
                     <?php } ?>
                     <?php if(!array_key_exists($stu->grade, $list)){?>
                         <option <?php echo "selected";?> value="<?php echo $stu->grade;?>"><?php echo $stu->grade?></option>
                     <?php }?>
                  </select>
                 
                <input class="text_none" type="text" name="others" id="<?php echo "input".$stu->id;?>" style='display:none;'/>
            </td>
            <td>
                <input id='<?php echo $stu->id;?>' onclick=" return" class="generate" type="submit" value="Generate"/>
            </td>
            
        </tr>
        <? };?>
    </table>
    <? } else {
        echo "Select class<br/><br/>";
    }?>
</div>

</div>


