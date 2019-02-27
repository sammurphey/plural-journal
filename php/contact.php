<?php
  $form=array(
    "fields"=>array(
      array(
        "name"=>"name",
        "rules"=>array(
          "required"=>true
        )
      ),
      array(
        "name"=>"email",
        "label"=>"email address",
        "rules"=>array(
          "required"=>true,
          "contains"=>"@"
        )
      ),
      array(
        "name"=>"phone",
        "label"=>"phone number"
      ),
      array(
        "name"=>"message",
        "label"=>false,
        "input"=>"textarea",
        "rules"=>array(
          "required"=>true
        )
      )
    )
  );
//run logic, builds above into form and validates
require_once $get_to_root."php/form.php";
//upon submission form_success returns true or false
  if($form_success){
    if(mail("YOUR EMAIL","SUBJECT","BODY","HEADERS")){
    echo"sent";
    }else{
    echo"failed";
    }
  }
