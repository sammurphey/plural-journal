<?php
require_once($php_root . "components/header.php");
?>

<!-- display list of past enteries -->
<section id="overviews" class="grid">
<ul class="grid_contents">
<?php

    // fetch all works for current user
    $overview_xhr = xhrFetch("?action=return_overviews&user=" . $user_name);
    if (valExists("success", $overview_xhr)) {
        $overviews = json_decode($overview_xhr["data"], true);
        jsLogs($overviews);

        // echo each result
        foreach ($overviews as $overview) {
            echo "<li class='grid_item'>";

            echo "<span class='date bg2_text'>" . $overview["date"] . "</span>";

            $post_color = "";
            if (valExists("color", $overview)){
                $post_color = " style='background: #" . $overview["color"] . "!important'";
            }
            echo "<div class='primary_colors card border_color'" . $post_color . "><a href=" . $htp_root . $overview["system"] . "/" . $overview["user"] . "/" . $overview["post_slug"] . ">";
            
            echo "<dl><dt>" . $overview["title"] . "</dt><dd>" . $overview["short_desc"] . "</dd></dl>";
            
            echo "</a></div>";
            
            echo "</li>";
        }

    } else {
        // if no results
        echo "<p>Nothing written yet.<br/><a href=" . $htp_root . "new>Get started.</a></p>";
    }

?>
</ul>
</section>

<!--end-->
<?php
require_once($php_root . "components/footer.php");