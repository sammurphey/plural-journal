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
                            "Dashboard" => "",
                            "Customize" => "customize",
                            "Settings" => "settings",
                            "Switch User" => "switch",
                            "Dashboard2" => "",
                            "Customize2" => "customize",
                            "Settings2" => "settings",
                            "Switch User2" => "switch",
                            "Dashboard3" => "",
                            "Customize3" => "customize",
                            "Settings3" => "settings",
                            "Switch User3" => "switch",
                            "Dashboard4" => "",
                            "Customize4" => "customize",
                            "Settings4" => "settings",
                            "Switch User4" => "switch",
                            
                            "Logout" => "logout"
                        );
                        foreach($menu_items as $title => $url) {
                            echo "<li><a href='" . $htp_root . $url . "' class='link_btn secondary_text'><span>" . $title . "</span></a></li>";
                        }
                        ?>
                    </ul>
                </nav>
            </main>
            <label for='menu_checkbox' id='menu_shadow'></label>
		</div>