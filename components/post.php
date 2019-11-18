<?php
$cur_paths = explode("/", $current_path);

// NEW VIEW
$post_title = "";
$post_text = "";
$post_color = " class='secondary_color_bg'";

// EDIT VIEW
/*if (!$post_data) {
    $get_post = xhrFetch("?action=get_post&system=" . $cur_paths[0] . "&user=" . $cur_paths[1] . "&post=" . $cur_paths[2]);
    if (valExists("success", $get_post)) {
        $post_data = json_decode($get_post["data"], true);
    } else {
        require_once($php_root . "views/404.php");
        die();
    }
}*/
$post_text = valExists("text", $post_data) ? $post_data["text"] : "";

if (valExists("color", $post_data)){
    $post_color = " style='background: #" . $post_data["color"] . "!important'";
}


echo "<div class='field textarea_field'>";
    echo "<textarea id='text' name='text'" . $post_color . ">" . $post_text . "</textarea>";
echo "</div>";