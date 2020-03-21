<?php
echo "<h2>System Members</h2><ul class='list_container bg1 border_color'>";
	if ($system_data && $system_data["users"]) {
		$system_members = explode(",", $system_data["users"]);
		foreach($system_members as $system_member) {
			echo "<li><button class='list_btn secondary_colors border_color' type='button'>@" . $system_member . "</button></li>";
		}
	}
	echo "<li><button class='list_btn primary_colors border_color' type='button'>Add new member</button></li>";
echo "</ul>";
