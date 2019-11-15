<input id="menu_checkbox" name="menu_checkbox" class="checkbox_hack" type="checkbox">
		<div id="menu">
			<header class="menu_header primary_colors">
				<label for='menu_checkbox' id='close_menu_btn' class='header_btn left'>
					<img src="<?php echo $htp_root; ?>src/icons/close.svg" class="icon primary_icons">
				</label>
				<p  class="title"><span>Menu</span></p>
            </header>
            <main class="secondary_colors">
                <section id="account_info" class="bg2 has_edges">
                    <div>
                        <button id="profile_photo" class="primary_colors"></button>
                    </div>
                    <div>
                        <dl id="profile_names">
                            <dt><?php echo $current_user_data["name"]; ?></dt>
                            <dd>@<?php echo $current_user_data["system"]; ?> System</dd>
                        </dl>
                    </div>
                </section>
                <nav>
                    <ul>
                        <li><a href="<?php echo $htp_root; ?>" class='link_btn secondary_colors'>Dashboard</a></li>
                        <li><a href="<?php echo $htp_root; ?>" class='link_btn secondary_colors'>Journals</a></li>
                        <li><a href="<?php echo $htp_root; ?>customize" class='link_btn secondary_colors'>Customize</a></li>
                        <li><a href="<?php echo $htp_root; ?>settings" class='link_btn secondary_colors'>Settings</a></li>
                        <li><a href="<?php echo $htp_root; ?>switch" class='link_btn secondary_colors'>Switch User</a></li>
                        <li><a href="<?php echo $htp_root; ?>logout" class='link_btn secondary_colors'>Logout</a></li>
                    </ul>
                </nav>
            </main>
            <label for='menu_checkbox' id='menu_shadow'></label>
		</div>