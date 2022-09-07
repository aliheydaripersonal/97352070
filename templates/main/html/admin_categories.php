<?php $this->load_template("header.php"); ?>
<h1 class="title"><?=$this->lang($D->title)?></h1>
<?php $this->load_template("message.php"); ?>
<?php if($D->tab=="list"){ ?>
    <ul class="items">
        <?php foreach($D->result->result as $category){?>
            <li>
                <a href="<?=$C->SITE_URL.'admin/categories/parent_id:'.$category->id?>"><?=$this->lang($category->name)?></a>
                <a class="button" href="<?=$C->SITE_URL.'admin/categories/tab:fields/id:'.$category->id?>"><?=$this->lang("fields")?></a>
            </li>
        <?php } ?>
    </ul>
	<h1 class="title"><?=$this->lang("new category")?></h1>
	
    <form action="" method="post">
    <?=$D->api->html()?>
    <input style="width:100%" class="button" name="submit" type="submit" value="<?=$this->lang("send")?>"></input>
<?php }elseif($D->tab=="fields"){ ?>
    <form action="" method="post">
    <?=$D->api->html()?>
    <input style="width:100%" class="button" name="submit" type="submit" value="<?=$this->lang("send")?>"></input>
    </form>
    <table>
        <thead>
        <tr>
            <td>id</td>
            <td>name</td>
            <td>type</td>
            <td>required</td>
            <td>search_type</td>
            <td></td>
        </tr>
        </thead>
        <?php foreach($D->result->result as $field){?>
            <tr>
                <td><?=$field->id?></td>
                <td><?=$field->name?></td>
                <td><?=$field->type?></td>
                <td><?=$field->required=="1"?"yes":"no"?></td>
                <td><?=$field->search_type?></td>
                <td><a class="button" href="<?=$C->SITE_URL.'admin/categories/tab:field/id:'.$field->id?>">EDIT</a></td>
            </tr>
        <?php } ?>
    </table>
<?php }elseif($D->tab=="field"){ ?>
    <form action="" method="post">
    <?=$D->api->html()?>
    <input style="width:100%" class="button" name="submit" type="submit" value="<?=$this->lang("send")?>"></input>
    </form>
    <table>
        <thead>
        <tr>
            <td>id</td>
            <td>label</td>
            <td></td>
        </tr>
        </thead>
        <?php foreach($D->result->result as $option){?>
            <tr>
                <td><?=$option->id?></td>
                <td><?=$option->label?></td>
                <td></td>
            </tr>
        <?php } ?>
    </table>
<?php } ?>
<?php $this->load_template("footer.php"); ?>