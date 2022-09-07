<?php $this->load_template("header.php"); ?>
<?php $this->load_template("message.php"); ?>
<table>
    <tr>
        <td><?=$this->lang("users")?></td>
        <td><?=$this->lang("yesterday users")?></td>
        <td><?=$this->lang("today users")?></td>
        <td><?=$this->lang("posts")?></td>
        <td><?=$this->lang("yesterday posts")?></td>
        <td><?=$this->lang("today posts")?></td>
        <td><?=$this->lang("pending posts")?></td>
        <td><?=$this->lang("categories")?></td>
    </tr>
    <tr>
        <td><?=$D->stats->users?></td>
        <td><?=$D->stats->yesterday_users?></td>
        <td><?=$D->stats->today_users?></td>
        <td><?=$D->stats->posts?></td>
        <td><?=$D->stats->yesterday_posts?></td>
        <td><?=$D->stats->today_posts?></td>
        <td><?=$D->stats->pending_posts?></td>
        <td><?=$D->stats->categories?></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><a class="red" href="<?=$C->SITE_URL?>admin/approval/"><?=$this->lang("approval")?></a></td>
        <td><a class="red" href="<?=$C->SITE_URL?>admin/categories/"><?=$this->lang("manage")?></a></td>
    </tr>
</table>
<?php $this->load_template("footer.php"); ?>