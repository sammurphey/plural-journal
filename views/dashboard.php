<?php
require_once($php_root . "components/header.php");
?>

<main id='main'>
<h1 id='page_title'>Dashboard</h1>

<ul id="overviews">
<?php

    $overviews = false;
    $overview_xhr = xhrFetch("?action=getOverviews&token=" . $user_token);

    if (valExists("success", $overview_xhr)) {
        $overviews = $overview_xhr["data"];
    }

    if ($overviews) {
        foreach ($overviews as $overview) {
            echo "<li><a href=" . $htp_root . $overview["id"] . ">";
            echo "<dl><dt>" . $overview["title"] . "</dt><dd>" . $overview["short_desc"] . "</dd></dl>";
            echo "</a></li>";
        }
    } else {
        echo "<p>Nothing written yet.<br/><a href=" . $htp_root . "new>Get started.</a></p>";
    }

?>
</ul>
</main>
<a href="<?php echo $htp_root; ?>new"><button class="fab">+</button></a>
<?php
require_once($php_root . "components/footer.php");