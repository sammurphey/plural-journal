<input id="menu_checkbox" name="menu_checkbox" class="checkbox_hack" type="checkbox">
		<div id="menu">
			<header class="menu_header primary_color_bg">
				<label for='menu_checkbox' id='close_menu_btn' class='header_btn left'>
					<img src="<?php echo $htp_root; ?>src/icons/baseline-close-24px-white.svg" class="icon">
				</label>
				<p  class="title"><span>Menu</span></p>
            </header>
            <main class="secondary_color_bg">
                <section id="account_info" class="bg2 has_edges">
                    <div>
                        <button id="profile_photo" class="primary_color_bg"></button>
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
                        <li><a href="<?php echo $htp_root; ?>" class='link_btn'>Dashboard</a></li>
                        <li><a href="<?php echo $htp_root; ?>" class='link_btn'>Journals</a></li>
                        <li><a href="<?php echo $htp_root; ?>customize" class='link_btn'>Customize</a></li>
                        <li><a href="<?php echo $htp_root; ?>settings" class='link_btn'>Settings</a></li>
                        <li><a href="<?php echo $htp_root; ?>switch" class='link_btn'>Switch User</a></li>
                        <li><a href="<?php echo $htp_root; ?>logout" class='link_btn'>Logout</a></li>
                    </ul>
                </nav>
            </main>
            <label for='menu_checkbox' id='menu_shadow'></label>
		</div>