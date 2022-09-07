<?php
    if(!$this->user->check_admin()){
        $this->redirect("/");
    }
    if(!$this->param("id")){
        $id = $this->db->fetch_field("SELECT `id` FROM `posts` WHERE `status`=0 LIMIT 1");
        if(!$id)
            $this->redirect("admin/");
        $this->redirect("admin/approval/id:".$id);
    }
    $this->params->post_id = $this->param("id");
    if(isset($_POST["approve"]))
    {
        $this->core->update_post_by_id($this->params->post_id,null,null,null,null,null,1,null);
        $this->redirect("admin/approval/");
    }
    if(isset($_POST["reject"]))
    {
        $this->core->update_post_by_id($this->params->post_id,null,null,null,null,null,2,null);
        $this->redirect("admin/approval/");
    }
    if(isset($_POST["remove"]))
    {
        $this->core->delete_post_by_id($this->params->post_id);
        $this->redirect("admin/approval/");
    }
    $this->load_controller("post.php");
?>
<div style="position:fixed;bottom: 0;left:0;background: #3b3a3a;padding: 10px;border-radius: 5px;margin: 5px;">
    <form method="post">
        <input type="submit" name="approve" value="<?=$this->lang("approve")?>"></input>
        <input type="submit" name="remove" value="<?=$this->lang("reject")?>"></input>
        <input type="submit" name="remove" value="<?=$this->lang("remove")?>"></input>
    </form>
</div>