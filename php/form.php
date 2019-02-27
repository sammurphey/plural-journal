<?php
  if(isset($form)&&$form!==""){
  array_push($js,"https://www.google.com/recaptcha/api.js","form");
  $show_form=true;
  $form_success=false;
  $available_fields=array();
  $errors=array();
    if(isset($dynamic_errors)&&$dynamic_errors!==""){
    $errors[]=$dynamic_errors;
    }
    foreach($form["fields"] as $field){
    $field_name=$field["name"];
    $available_fields[]=$field_name;
    ${$field_name."_value"}="";
      if(isset(${$field_name."_dynamic"})&&${$field_name."_dynamic"}!==""){
      ${$field_name."_value"}=str_replace("'","’",${$field_name."_dynamic"});
      }else{
        if(isset($_GET[$field_name])&&$_GET[$field_name]!==""){
        ${$field_name."_value"}=str_replace("'","’",$_GET[$field_name]);
        }
        if(isset($_GET[$field_name."_value"])&&$_GET[$field_name."_value"]!==""){
        ${$field_name."_value"}=str_replace("'","’",$_GET[$field_name."_value"]);
        }
        if(isset($_POST[$field_name])&&$_POST[$field_name]!==""){
        ${$field_name."_value"}=str_replace("'","’",$_POST[$field_name]);
        }
        if(isset($_POST[$field_name."_value"])&&$_POST[$field_name."_value"]!==""){
        ${$field_name."_value"}=str_replace("'","’",$_POST[$field_name."_value"]);
        }
        if(isset($_FILES[$field_name])&&$_FILES[$field_name]!==""){
        ${$field_name."_value"}=str_replace("'","’",$_FILES[$field_name]);
        }
        if(isset($_FILES[$field_name."_value"])&&$_FILES[$field_name."_value"]!==""){
        ${$field_name."_value"}=str_replace("'","’",$_FILES[$field_name."_value"]);
        }
      }
    }
    if(isset($_REQUEST["submit"])){
    $iv=substr(sha1(sha1(sha1(rand()))),0,16);
    $private_key=md5(md5(md5(rand())));
    $submit_value=$_REQUEST["submit"];
      //validation
      foreach($form["fields"] as $field){
        if(isset($field["rules"])&&$field["rules"]!==""){
        ${$field["name"]."_passed"}=false;
          if(isset($field["id"])&&$field["id"]!==""){
          $id=$field["id"];
          }else{
          $id=$field["name"];
          }
          if(isset($field["label"])&&$field["label"]!==""){
            if($field["label"]!==false){
            $label=$field["label"];
            }else{
            $label=str_replace("_"," ",str_replace("-"," ",$field["name"]));
            }
          }else{
          $label=str_replace("_"," ",str_replace("-"," ",$field["name"]));
          }
        $passed=false;
          foreach($field["rules"] as $rule=>$rule_value){//loop through rules to validate fields
            //start by looking for 'required' or 'required_if'. if these values are not present theres no reason to validate any additional rules.
            if($rule=="required"){//check for input, fails on empty or undefined
              if($rule_value==true){
                if(!isset(${$field["name"]."_value"})){//field does not even exist
                $errors[]=array("target"=>$id,"message"=>"missing ".$label);
                }elseif(${$field["name"]."_value"}==""){//field exists but is empty
                $errors[]=array("target"=>$id,"message"=>"missing ".$label);
                }else{//value present
                $passed=true;
                }
              }
            }elseif($rule=="required_if"){//only required if another field = supplied value
            $total_conditions=count($rule_value);
            $passed_conditions=0;
              foreach($rule_value as $condition=>$condition_value){
                if($condition_value=="is_true"){
                  if(isset(${$condition."_value"})&&${$condition."_value"}!==""){
                  $passed_conditions++;
                  }
                }else{
                  if(isset(${$condition."_value"})&&${$condition."_value"}==$condition_value){//condition met
                  $passed_conditions++;
                  }
                }
              }
              if($passed_conditions==$total_conditions){//if all conditions have been met, continue
                if(!isset(${$field["name"]."_value"})){//reitterate the original required function
                $errors[]=array("target"=>$id,"message"=>"missing ".$label);
                }elseif(${$field["name"]."_value"}==""){
                $errors[]=array("target"=>$id,"message"=>"missing ".$label);
                }else{
                $passed=true;
                }
              }else{//if any conditions fail the field is not required
              $passed=false;//setting to false stops the script from checking the rest of its rules, it will still pass overall validation because that checks for an empty errors array
              ${$field["name"]."_passed"}=true;
              }
            }
          }
          if($passed){//only check other cases after you verify input. everything below will asume value is present so there will hardly be any need for isset statements
          $total_rules=count($field["rules"]);
          $rules_passed=1;
            foreach($field["rules"] as $rule=>$rule_value){//run fresh loop to avoid skipping any rules from the functions above
              switch($rule){
                case"contains"://checks that rule_value is present in field_value at least once
                  if($rule_value!==""){//rule_value can be anything from a single character to a long string
                    if(strpos(${$field["name"]."_value"},$rule_value)==false){//rule value not present
                    $errors[]=array("target"=>$id,"message"=>"invalid ".$label);
                    }else{
                    $rules_passed++;
                    }
                  }
                break;
                case"matches"://checks that field_value is equal to rule_value's field_value
                  if($rule_value!==""){//rule_value needs to be the same as the field_name you're looking for
                  $frieldly_rule_value=ucSmart(str_replace("_"," ",str_replace("-"," ",$rule_value)));//format rule_value the same as labels
                    if(!isset(${$rule_value."_value"})){//requested field not present
                    $errors[]=array("target"=>$id,"message"=>$label." must match ".$friendly_rule_value);
                    }elseif(${$rule_value."_value"}!==${$field["name"]."_value"}){//does not match
                    $errors[]=array("target"=>$id,"message"=>$label." must match ".$friendly_rule_value);
                    }else{
                    $rules_passed++;
                    }
                  }
                break;
                case"minimum"://checks that there are at least n# of characters
                if($rule_value!==""&&is_numeric($rule_value)){//only works with intigers, sorry!
                  if(strlen(${$field["name"]."_value"})<$rule_value){
                  $errors[]=array("target"=>$id,"message"=>$label." must be at least {$rule_value} characters long");
                  }else{
                  $rules_passed++;
                  }
                }
                break;
                case"maximum"://same as above but with a reversed opperand
                if($rule_value!==""&&is_numeric($rule_value)){
                  if(strlen(${$field["name"]."_value"})>$rule_value){
                  $errors[]=array("target"=>$id,"message"=>$label." cannot exceed {$rule_value} characters in length");
                  }else{
                  $rules_passed++;
                  }
                }
                break;
                case"unique"://checks that the value is not equal to a supplied column in a supplied table
                  if($rule_value!==""){
                  $check=explode(",",$rule_value);//breakup params, [0] is the table, [1] is the column
                  $ch=curl_init($_."api/");//curl request to the api
                  curl_setopt($ch,CURLOPT_HEADER,false);
                  curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                  curl_setopt($ch,CURLOPT_POST,true);
                  $data=array(
                    "q"=>$check[0],//supplied table
                    "p"=>$check[1].":".${$field["name"]."_value"}//supplied column : user entered value
                  );
                  curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($data));
                  $results=curl_exec($ch);
                  curl_close($ch);
                  $results=json_decode($results,true);
                    if($results["success"]&&$results["results"]){
                    $errors[]=array("target"=>$id,"message"=>$label." already exists");
                    }else{
                    $rules_passed++;
                    }
                  }
                break;
                case"no_more_than"://for updating - allows n# of duplicate records, similar to 'unique' but with a set number of allowances
                  if($rule_value!==""){
                  $check=explode(",",$rule_value);//breakup params, [0] is the number of allowances, [1] is the table, and [2] is the column
                  $ch=curl_init($_."api/");//curl request to the api
                  curl_setopt($ch,CURLOPT_HEADER,false);
                  curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                  curl_setopt($ch,CURLOPT_POST,true);
                  $data=array(
                    "q"=>$check[1],//supplied table
                    "p"=>$check[2].":".${$field["name"]."_value"}//supplied column : user entered value
                  );
                  curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($data));
                  $results=curl_exec($ch);
                  curl_close($ch);
                  $results=json_decode($results,true);
                    if($results["success"]&&$results["results"]){
                      if(count($results["results"])>$check[0]){
                      $errors[]=array("target"=>$id,"message"=>$label." already exists");
                      }elseif(count($results["results"])==$check[0]){
                        if(isset($_GET["id"])&&$_GET["id"]!==""){
                          if($_GET["id"]!==$results["results"][0]["id"]){
                          $errors[]=array("target"=>$id,"message"=>$label." already exists");
                          }else{
                          $rules_passed++;
                          }
                        }
                      }else{
                      $rules_passed++;
                      }
                    }else{
                    $rules_passed++;
                    }
                  }
                break;
              }
            }
            if($total_rules==$rules_passed){//if all rules conditions were met
            ${$field["name"]."_passed"}=true;
            }
          }
          if(${$field["name"]."_passed"}){
            if(isset($field["encrypt"])&&$field["encrypt"]==true){
            $encrypt=openssl_encrypt(${$field["name"]."_value"},$enc_method_1,$public_key,0,$iv);
            ${$field["name"]."_value_encrypted"}=openssl_encrypt($encrypt,$enc_method_2,$private_key,0,$iv);
            ${$field["name"]."_value"}="";
            }
          }
        }
      }
      //if(strpos(strtolower($submit_value),"draft")!==false||strpos(strtolower($submit_value),"delete")!==false){
      //$errors=array();
      //}
    //captcha
    if(!isset($form["captcha"])||$form["captcha"]!==false){
      if(isset($form["method"])){//set captcha request method
        switch($form["method"]){
        case"post":
        $captcha_response=$_POST["g-recaptcha-response"];
        break;
        case"get":
        $captcha_response=$_GET["g-recaptcha-response"];
        break;
        case"request":
        $captcha_response=$_REQUEST["g-recaptcha-response"];
        break;
        }
      }else{//default to post
      $captcha_response=$_POST["g-recaptcha-response"];
      }
      //make post request to googles recaptcha api
      $ch=curl_init($captcha_url);
      curl_setopt($ch,CURLOPT_HEADER,false);
      curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
      curl_setopt($ch,CURLOPT_POST,true);
      $data=array(
        "secret"=>$captcha_secret,
        "response"=>$captcha_response,
        "remoteip"=>$_SERVER["REMOTE_ADDR"]//users ip
      );
      curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($data));
      $captcha_results=curl_exec($ch);
      curl_close($ch);
      $captcha_results=json_decode($captcha_results,true);
        if($captcha_results["success"]==false){//failed captcha test
        $errors[]=array("target"=>"captcha","message"=>"please check the \"I'm not a robot\" button");
        }
    }
      if($errors==array()){//nothing in array = all fields pass inspection
      $private_key_encrypted=openssl_encrypt($private_key,$enc_method_1,$public_key,0,$iv);//encrypt private key
      $private_key="";//unset private key
      $show_form=false;//hide form
      $form_success=true;//this value gets returned to the parent file, you can choose the pages fate there
      }
    }
    if($errors!==array()){
    echo"<div class='errors'>";
      foreach($errors as $error){
      echo"<p><a href='#{$error["target"]}'>".ucSmart($error["message"])."</a></p>";
      }
    echo"</div>";
    }
    if($show_form){
    echo"<div class='card'><form action='";
      if(isset($form["action"])&&$form["action"]!==""){
      echo $form["action"];
      }else{
      echo $current_url;
      }
    echo"'method='";
      if(isset($form["method"])&&$form["method"]!==""){
      echo $form["method"];
      }else{
      echo"post";
      }
    echo"'";
      if(isset($form["uploads"])&&$from["uploads"]==true){
      echo"enctype='multipart/form-data'";
      }
    echo">";
    $previous_group="";
      foreach($form["fields"] as $field){//set variables for faster computation and shorter code
      $field_name=$field["name"];//no need to check for name, its always there
      $field_id="";
      $field_class="";
      $field_label="";
      $field_input="";
      $field_type="";
      $field_options="";
      $field_value="";
      $field_group="";
      $hidden_group=false;
      $field_rules="";
      $field_placeholder="";
        if(isset($field["id"])&&$field["id"]!==""){//populate values if they exist
        $field_id=$field["id"];
        }
        if(isset($field["class"])&&$field["class"]!==""){
        $field_class=$field["class"];
        }
        if(isset($field["label"])&&$field["label"]!==""){
        $field_label=$field["label"];
        }
        if(isset($field["input"])&&$field["input"]!==""){
        $field_input=$field["input"];
        }
        if(isset($field["type"])&&$field["type"]!==""){
        $field_type=$field["type"];
        }
        if(isset($field["options"])&&$field["options"]!==""){
        $field_options=$field["options"];
        }
        if(isset($field["value"])&&$field["value"]!==""){
        $field_value=$field["value"];
        }
        if(isset($field["placeholder"])&&$field["placeholder"]!==""){
        $field_placeholder=$field["placeholder"];
        }
        if(isset($field["group"])&&$field["group"]!==""){
          $group=explode("_",$field["group"]);
          $group_suffix=end($group);
          if($group_suffix=="hidden"){
          $hidden_group=true;
          array_pop($group);
          }
        $field_group=implode("_",$group);;
        }
        if(isset($field["rules"])&&$field["rules"]!==""){
        $field_rules=$field["rules"];
        }
      $textarea=false;
      $textarea_value=null;
      $select=false;
      $select_value=null;
      if($field_group!==""){
        if($previous_group!==""){
          if($previous_group!==$field_group){
          echo"</section><h2 class='".$field_group;
            if($hidden_group){
            echo" hidden";
            }
          echo"'>".ucSmart(str_replace("-"," ",str_replace("_"," ",$field_group)))."</h2><section class='field_group ".$field_group;
            if($hidden_group){
            echo" hidden";
            }
          echo"'>";
          $previous_group=$field_group;          
          }
        }else{
        echo"<h2 class='".$field_group;
          if($hidden_group){
          echo" hidden'";
          }
        echo"'>".ucSmart(str_replace("-"," ",str_replace("_"," ",$field_group)))."</h2><section class='field_group ".$field_group;
          if($hidden_group){
          echo" hidden";
          }
        echo"'>";
        $previous_group=$field_group;
        }
      }else{
        if($previous_group!==""){
        echo"</div>";
        $previous_group="";
        }
      }
      if(isset($field["clear"])&&$field["clear"]==true){
      echo"<br/>";
      }
      echo"<div class='field";
        if($field_class!==""){
        echo" ".$field_class;
        }else{
        echo" ".$field_name;
        }
        if($field_type=="checkbox"||$field_type=="radio"){
        echo" ".$field_type;
        }
        if(isset(${$field_name."_passed"})&&${$field_name."_passed"}==false){
          if($submit_value!=="submit_button_0"){
          echo" error";
          }
        }
      echo"'><label for='";
        if($field_id!==""){
        echo $field_id;
        }else{
        echo $field_name;
          if($field_value!==""){
          echo"_".$field_value;
          }
        }
      echo"'>";
        if(isset($field_rules["required"])&&$field_rules["required"]==true){
        echo"* ";
        }
        if($field_label!==""){
          if($field_label!==false&&$field_type!=="checkbox"&&$field_type!=="radio"){
          echo ucSmart($field_label).":";
          }
        }else{
          if($field_label!==false&&$field_type!=="checkbox"&&$field_type!=="radio"){
          echo ucSmart(str_replace("-"," ",str_replace("_"," ",$field_name))).":";
          }
        }
        if($field_input=="textarea"){
        echo"<textarea rows='10'";
        $textarea=true;
        }elseif($field_input=="select"){
        echo"<select ";
        $select=true;
        }else{
        echo"<input type='";
          if($field_type!==""){
          echo $field_type;
          }else{
          echo "text";
          }
        echo"'";
        }
      echo"id='";
        if($field_id!==""){
        echo $field_id;
        }else{
        echo $field_name;
          if($field_value!==""){
          echo"_".$field_value;
          }
        }
      echo"'name='{$field_name}'class='";
      if($field_class!==""){
        echo $field_class;
        }else{
        echo $field_name;
        }
        if($field_rules!==array()){
          if(isset($field_rules["required"])&&$field_rules["required"]==true){
          echo" required";
          }elseif(isset($field_rules["required-if"])&&$field_rules["required-if"]!==array()){
          echo" required";
          }
        }
        echo"'";
        if($field_type=="checkbox"||$field_type=="radio"){
        echo"value='";
          if($field_value!==""){
          echo $field_value."'";
            if(${$field_name."_value"}==$field_value){
            echo"checked";
            }
          }else{
          echo $field_label."'";
            if(${$field_name."_value"}==$field_label){
            echo"checked";
            }
          }
        }elseif(${$field_name."_value"}!==""){
          if($textarea){
          $textarea_value=${$field_name."_value"};
          }elseif($select){
          $select_value=${$field_name."_value"};
          }else{
          echo"value='${$field_name."_value"}'";
          }
        }elseif($field_value!==""){
          if($textarea){
          $textarea_value=$field_value;
          }elseif($select){
          $select_value=$field_value;
          }else{
          echo"value='".ucSmart(str_replace("'","’",$field_value))."'";
          }
        }
        if($field_placeholder!==""){
          echo"placeholder='".str_replace("'","’",$field_placeholder)."'";
        }
      echo">";
        if($textarea){
          if($textarea_value){
          echo $textarea_value;
          }
        echo"</textarea>";
        }
        if($select){
        echo"<option value=''>--</option>";
          foreach($field_options as $field_option){
          echo"<option value='".strtolower($field_option)."'";
            if(strtolower($select_value)==strtolower($field_option)){
            echo"selected";
            }
          echo">".ucSmart($field_option)."</option>";
          }
        echo"</select>";
        }
        if($field_type=="checkbox"||$field_type=="radio"){
          if($field_label!==false){
            if($field_label!==""){
          echo ucSmart($field_label);
            }else{
            echo ucSmart(str_replace("-"," ",str_replace("_"," ",$field_name)));
            }
          }
        }
      echo"</label></div>";
      }
      if($previous_group!==""){
      echo"</section>";
      }
      if(!isset($form["captcha"])||$form["captcha"]!==false){
      echo"<div class='field captcha'><div id='captcha'class='g-recaptcha commentField'data-sitekey='{$captcha_public}'></div></div>";
      }
    echo"<div class='field submit'>";
      if($admin){
        foreach($_cta as $_cta_){
          if(!isset($_cta_[3])){
          echo"<input name='submit'type='submit'title='".strtolower($_cta_[1])."'value='".ucSmart($_cta_[0])."'>";
          }
        }
      }else{
        foreach($cta as $cta_){
          if(!isset($cta_[3])){
          echo"<input name='submit'type='submit'title='".strtolower($cta_[1])."'value='".ucSmart($cta_[0])."'>";
          }
        }
      }
    echo"</div></section></form>";
    }
  }else{
  echo"<section>Form == Undefined</section>";
  }