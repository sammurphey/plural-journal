<?php
if (!$post_data) {
    $cur_paths = explode("/", $current_path);
    if (count($cur_paths) >= 2) {
        $get_post = xhrFetch("?action=get_post&system=" . $cur_paths[0] . "&user=" . $cur_paths[1] . "&post=" . $cur_paths[2]);
        if (valExists("success", $get_post)) {
            $post_data = json_decode($get_post["data"], true);
        } else {
            require_once($php_root . "views/404.php");
            die();
        }
    }
}

require_once($php_root . "components/header.php");
?>
<h1 id='page_title'><?php echo $post_data["title"]; ?></h1>
<main id='main'>
    <section>
        <p><?php echo $post_data["text"]; ?></p>
    </section>
</main>

<!--end-->
<?php
require_once($php_root . "components/footer.php");