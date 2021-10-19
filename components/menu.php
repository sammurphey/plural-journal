
<input id="menu_checkbox" name="menu_checkbox" class="checkbox_hack" type="checkbox">
<label for='menu_checkbox' id='menu_btn' class='header_btn left'>
	<img src='<?php echo $htp_root; ?>src/icons/menu.svg' class='icon primary_icons'>
</label>
    <div id="menu" class="border_color">
        <header class="menu_header primary_colors">
            <label for='menu_checkbox' id='close_menu_btn' class='header_btn left'>
                <img src="<?php echo $htp_root; ?>src/icons/close.svg" class="icon primary_icons">
            </label>
            <p  class="title"><span>Menu</span></p>
        </header>
        <main class="secondary_colors">
            <section id="account_info" class="bg1 border_color">
                <div class='profile_container'>
                    <button id="profile_photo" class="primary_colors border_color"></button>
                </div>
                <div class='details_container'>
                    <dl id="profile_names">
                        <?php 
                        if ($current_user_data) {
                            echo "<dt>";
                            if ($current_user_data["name"]) {
                                echo $current_user_data["name"];
                            } else {
                                echo $current_user_data["username"];
                            }
                            echo "</dt>";
                        }
                        if ($current_system_data) {
                            echo "<dd>";
                            if ($current_system_data["name"]) {
                                echo $current_system_data["name"];
                            } else {
                                echo "@" . $current_system_data["username"];
                            }
                            echo " System</dd>";
                        }?>
                    </dl>
                </div>
            </section>
            <nav>
                <ul>
                    <?php
                    // init array
                    $menu_items = array(
                        "Dashboard" => ["", "home"]
                    );

                    // get folders
                    $folders_xhr = xhrFetch("?action=return_folders&user=" . $user_name);
                    if (valExists("success", $folders_xhr)) {
                        $folders = json_decode($folders_xhr["data"], true);
                        if (valExists("id", $folders)) {
                            $folders = [$folders];
                        }
                        jsLogs($folders);
                        foreach($folders as $folder) {
                            $folder_title = $folder["title"];
                            $folder_url = "folder/" . $folder["slug"];
                            $menu_items[$folder_title] = [$folder_url, "folder"];
                        }
                    }

                    // add remaining items
                    $menu_items["Customize"] = ["customize", "color"];
                    $menu_items["Settings"] = ["settings", "settings"];
                    $menu_items["Switch User"] = ["switch", "person"];
                    $menu_items["Logout"] = ["logout", "power"];
                    foreach($menu_items as $key => $val) {
                        $title = $key;
                        $icon = false;
                        if (is_array($val)) {
                            $url = $val[0];
                            if (valExists(1, $val)) {
                                $icon = $val[1];
                            }
                        } else {
                            $url = $val;
                        }

                        echo "<li><a href='" . $htp_root . $url . "' class='link_btn secondary_color secondary_text'>";
                        if ($icon) {
                            echo "<img src='" . $htp_root . "src/icons/" . $icon . ".svg' class='icon'>";
                        }
                        echo"<span>" . $title . "</span></a></li>";
                    }
                    ?>
                </ul>
            </nav>
        </main>
        <label for='menu_checkbox' id='menu_shadow'></label>
    </div>