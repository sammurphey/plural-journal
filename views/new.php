<?php
// If currently attempting save
if (empty($_REQUEST) === false) {
    // Sanitize provided data
	$title_input = addslashes($_REQUEST["title"]);
    $date_time_input = addslashes($_REQUEST["date-time"]);
    $text_input = addslashes($_REQUEST["text"]);
    //check that something was actually written
    if ($title_input || $text_input) {
        //verify login
        if ($user_id && $user_token) {
            $verification = xhrFetch("?action=verify_token&id=" . $user_id . "&token=" . $user_token);
            if (valExists("success", $verification)) {
                $save_dream_url = "?action=save_new_dream";
                //save title
                if ($title_input) {
                    $save_dream_url .= "&title=" . urlencode($title_input);
                } else {
                    $save_dream_url .= "&title=Untitled";
                }
                //save date
                if ($date_time_input) {
                    $save_dream_url .= "&date=" . urlencode($date_time_input);
                } else {
                    $save_dream_url .= "&date=" . date("Y-m-d h:m:s");
                }
                //save text
                if ($text_input) {
                    $save_dream_url .= "&text=" . urlencode($text_input);
                }
                $save_dream_url .="&user=" . $user_id;
                $save_dream = xhrFetch($save_dream_url);
                if ($save_dream["success"]) {
                    echo "hell ya";
                } else {
                    echo ":(";
                    echo "<br>" . $save_dream_url;
                }
            } else {
                // not logged in !!
              //  require_once($php_root . "views/login.php");
            }
        }
    } else {
        //didnt write anything..
    }
} else {
    // default behavoir, show new text form
    require_once($php_root . "components/header.php");
/*    echo "<h1 id='page_title'>New</h1><main id='main'>";
        echo "<form action='" . $htp_root . "new' method='POST'>";
            echo newFormField("title", "Title");
            $current_date = date("Y-m-d h:m:s");
            echo newFormField("date-time", "Date + Time", "text", $current_date);
            echo newFormField("text", "Text", "textarea");
            echo newFormField("save", "Save", "submit", "Save");
        echo "</form>";
    echo "</main>";*/
    require_once($php_root . "components/post.php");
    require_once($php_root . "components/footer.php");
}