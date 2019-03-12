<?php
function ucSmart($string){//smart ucwords function
  return preg_replace_callback("/\b(A|An|The|And|Of|But|Or|For|Nor|With|On|At|To|From|By)\b/i",function($matches){//add words here to avoid capitalization
    return strtolower($matches[1]);
  },ucwords($string));
}
function valExists($key, $arr) {
	if (is_array($arr)) {
		if (array_key_exists($key, $arr) && $arr[$key]) {
			return true;
		}
		return false;
	}
	return false;
}
function xhrFetch($url, $params = false) {
	if (strpos($url, 'http') == false) {
		$xhr_url = "https://api.sammurphey.net/dreams" . $url;

	} else {
		$xhr_url = $url;
	}
	jsLogs("xhrFetching: " . $xhr_url);
	$xhr_res = "";
	//if (function_exists("curl_init")) {
	//	$ch = curl_init();
	  //  curl_setopt($ch, CURLOPT_URL, $url);
	    //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	   // $xhr_res = curl_exec($ch);
	   // curl_close($ch);
	//} else {
		$xhr_res = file_get_contents($xhr_url);
	//}
	if (strlen($xhr_res) > 0) {
		$xhr_first = substr($xhr_res, 0, 1);
		if ($xhr_first == "{" || $xhr_first == "[") {
			$xhr_json = json_decode($xhr_res, true);
			if (is_array($xhr_json)) {
				return $xhr_json;
			} else {
				return $xhr_res;
			}
		}
		return $xhr_res;
	} else {
		return false;
	}
}
function jsLogs($data) {
    $html = "";
    $coll;

    if (is_array($data) || is_object($data)) {
        $coll = json_encode($data);
    } else {
        $coll = $data;
    }

    $html = "<script>console.log('PHP: ".$coll."');</script>";

    //echo($html);
}
function newFormField($id, $name, $type = "text", $val = false) {
	$html = "<div class='field";
	switch($type) {
		case "text":
		case "password":
		case "email":
		case "tel":
		case "date":
			$input = "'><label for='" . $id . "'>" . $name . "</label><input id='" . $id . "' name='" . $id . "' type='" . $type . "'";
			if ($val) {
				$input .= "value='" . $val . "'";
			}
			$input .= "/>";
			break;
		case "textarea":
			$input = " textarea_field'><label for='" . $id . "'>" . $name . "</label><textarea id='" . $id . "' name='" . $id . "'>";
			if (is_array($val)) {
				foreach($val as $v) {
					$input .= $v ."
					";
				}
			}
			if ($val) {
				$input .= $val;
			}
			$input .= "</textarea>";
			break;
		case "checkbox":
			$input = "'><input id='" . $id . "' name='" . $id . "' type='" . $type . "'";
			if ($val) {
				$input .= " checked";
			}
			$input .= " /><label class='checkbox_label' for='" . $id . "'>" . $name . "</label>";
			break;
		case "select":
			$input = "'><label for='" . $id . "'>" . $name . "</label><select id='" . $id . "' name='" . $id . "'><option value='null'>Select One</option>";
				if(is_array($val)) {
					foreach($val as $v) {
						$input .= "<option value='" . $v . "'>" . $v . "</option>";
					}
				} else {
					$input .= "<option value='" . $val . "'>" . $val . "</option>";
				}
			$input .= "</select>";
			break;
		case "photo":
		case "photos":
			$input = "'><label for='" . $id . "'>" . $name . "</label><input id='" . $id . "' name='" . $id . "' type='hidden' /><button id='" . $id . "_browser' type='button' class='photo_browser_btn";
				if ($type == "photos") {
					$input .= " multi";
				}
			$input .= "'>Browse ";
			$browse_photos_icon = xhrFetch($_SERVER['DOCUMENT_ROOT'] . "/delta/src/img/icons/image_search.svg");
			if ($browse_photos_icon) {
				$input .= $browse_photos_icon;
			}
			$input .= "</button>";
			break;
		case "submit":
			$input = "'><input id='" . $id . "' name='" . $id . "' type='" . $type . "'";
			if ($val) {
				$input .= "value='" . $val . "'";
			}
			$input .= "/>";
			break;
	}
	$html .= $input;
	$html .= "</div>";
	return $html;
}
