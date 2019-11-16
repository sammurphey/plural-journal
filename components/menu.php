<input id="menu_checkbox" name="menu_checkbox" class="checkbox_hack" type="checkbox">
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
                            <dt><?php echo $current_user_data["name"]; ?></dt>
                            <dd>@<?php echo $current_user_data["system"]; ?> System</dd>
                        </dl>
                    </div>
                </section>
                <nav>
                    <ul>
                        <?php
                        $menu_items = array(
                            "Dashboard" => ["", "home"],
                            "Folder1" => ["folder/1", "folder"],
                            "Folder2" => ["folder/2", "folder"],
                            "Folder3" => ["folder/3", "folder"],
                            "Folder4" => ["folder/4", "folder"],
                            "Customize" => ["customize", "color"],
                            "Settings" => ["settings", "settings"],
                            "Switch User" => ["switch", "person"],
                            "Logout" => ["logout", "power"]
                        );
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