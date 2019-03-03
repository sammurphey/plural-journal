<input id="menu_checkbox" name="menu_checkbox" class="checkbox_hack" type="checkbox">
		<div id="menu">
			<header class="menu_header">
				<label for='menu_checkbox' id='close_menu_btn' class='header_btn left'>
					<img src="<?php echo $htp_root; ?>src/icons/baseline-close-24px-white.svg" class="icon">
				</label>
				<p  class="title"><span>Menu</span></p>
            </header>
            <main>
                <section id="account_info">
                    <div>
                        <button id="profile_photo"></button>
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
                        <li><a href="<?php echo $htp_root; ?>">Dashboard</a></li>
                        <li><a href="<?php echo $htp_root; ?>">Journals</a></li>
                        <li><a href="<?php echo $htp_root; ?>customize">Customize</a></li>
                        <li><a href="<?php echo $htp_root; ?>settings">Settings</a></li>
                        <li><a href="<?php echo $htp_root; ?>switch">Switch User</a></li>
                        <li><a href="<?php echo $htp_root; ?>logout">Logout</a></li>
                    </ul>
                </nav>
            </main>
            <label for='menu_checkbox' id='menu_shadow'></label>
		</div>