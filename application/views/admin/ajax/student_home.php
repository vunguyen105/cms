<script>
    $(function () {
        $('.txtDatePicker').datepicker({
            defaultDate:+1,
            firstDay:+0,
            dateFormat:"yy-mm-dd",
            changeMonth:true,
            changeYear:true
        });

        $("a.button").click(function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $("#ajax_load").load(url).hide().fadeIn();
        });

        $('#frmAdd').submit(function () {
            if (!confirm('Are you sure add new student?')) {
                return false;
            }

            // Get input data
            var $inputs = $('#frmAdd :input');
            var values = {};
            $inputs.each(function () {
                values[this.name] = $(this).val();
            });

            // Validate
            if (!values['name']) {
                alert('Student name is required!');
                return false;
            }
            if (!$("#cbxClassList").val()) {
                if (!confirm('Continue to add without assigning to a class?')) {
                    return false;
                }
            }

            $.post("<?=base_url('admin/student/do-add')?>", values,
                function (response) {
                    $('#ajax_load').html(response);
                }).error(function (xhr, status, error) {
                    $('#ajax_load')
                        .html("")
                        .hide()
                        .fadeIn(500, function () {
                            $('#studentSearchForm').append("<img width=\"20px\" src='<?=base_url('asset/themes/_img/cancel_red.png')?>' />");
                        });

                });
        });

    });
</script>
<p class="module_title">Student Management</p>
<div>
<!--    <a id="btnAdd" class="button" href="--><?//=base_url('admin/student_add')?><!--">Add</a>-->
<!--    <a id="btnSearch" class="button" href="--><?//=base_url('admin/student_search')?><!--">Search</a>-->
</div>
<div id="ajax_load" class="border_standard standard_block">
    <?$this->load->view('admin/ajax/student_search')?>
</div>
<div id="student_list" class="standard_block border_standard">
    <?$this->load->view('admin/ajax/student_list')?>
</div>
