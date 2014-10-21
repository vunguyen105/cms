<p class="module_title">Feedback</p>
<div class="standard_block border_standard">
    <table class="table_standard table_left">
        <tr>
            <td width="30px">ID.</td>
            <!--            <td>Category</td>-->
            <td width="150px">Title</td>
            <td width="300px">Message</td>
            <td width="80px">Date</td>
            <td>By</td>
        </tr>
        <?php if (isset($guide_list) && count($guide_list) > 0) {
        foreach ($guide_list as $guide) {
            ?>
            <tr>
                <td><?=$guide->id?></td>
                <!--                <td w>--><?//=$guide->category?><!--</td>-->
                <td><?=$guide->title?></td>
                <td><?=$guide->content?></td>
                <td><?=$guide->updated_on?></td>
                <td><?=$guide->updated_by?></td>
            </tr>
            <? }
    } ?>
    </table>
</div>
