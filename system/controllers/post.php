<?php
    $D->breadcrumb = [];
    $D->post = $this->core->get_post_by_id($this->params->post_id,true);
    $D->noindex = true;
    if(!$D->post)
        $this->redirect("/");
    $D->city = $this->core->get_city_by_id($D->post->city_id);
    $D->breadcrumb[] = (object)[
        "url"=>$D->city->url,
        "label"=>$this->lang($D->city->name)
    ];
    foreach($D->post->categories as $_category_id){
        $_category = $this->core->get_category_by_id($_category_id);
        $D->breadcrumb[] = (object)[
            "url"=>$D->city->url.$_category->uri,
            "label"=>$this->lang($_category->name)
        ];
    }

    $D->title = $D->post->title;
    $D->description = $D->post->title;
    $this->load_template("post.php");
?>