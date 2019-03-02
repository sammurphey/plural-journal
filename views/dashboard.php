<?php
require_once($php_root . "components/header.php");
?>
<h1 id='page_title'>Dashboard</h1>
<main id='main'>

<!-- display list of past enteries -->
<ul id="overviews">
<?php

    // fetch all works for current user
    $overview_xhr = xhrFetch("?action=return_overviews&user=" . $user_id);
    if (valExists("success", $overview_xhr)) {
        $overviews = json_decode($overview_xhr["data"], true);
        jsLogs($overviews);

        // echo each result
        foreach ($overviews as $overview) {
            echo "<li><a href=" . $htp_root . $overview["user_system"] . "/post/" . $overview["id"] . ">";
            echo "<dl><dt>" . $overview["title"] . "</dt><dd>" . $overview["short_desc"] . "</dd></dl>";
            echo "<span class='date'>" . $overview["date"] . "</span>";
            echo "</a></li>";
        }

    } else {
        // if no results
        echo "<p>Nothing written yet.<br/><a href=" . $htp_root . "new>Get started.</a></p>";
    }

?>
</ul>
</main>


<!-- new button -->
<button class="fab"><a href="<?php echo $htp_root; ?>new">+</a></button>

<!--dashboard specific styles-->
<link href="<?php echo $htp_root; ?>src/css/Dashboard.css" rel="stylesheet" media="none" onload="if(media!='all')media='all'">
<noscript>
    <link href="<?php echo $htp_root; ?>src/css/Dashboard.css" rel="stylesheet" media="all">
</noscript>

<!--end-->
<?php
require_once($php_root . "components/footer.php");