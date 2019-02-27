<?php
error_reporting("E_ALL");
$cd_="";
$dir=explode("/",$_SERVER['PHP_SELF']);
unset($dir[0],$dir[1],$dir[2]);
  foreach($dir as $dir_){
  $cd_.="../";
  }
  if(isset($page)||isset($q)){
  require_once $cd_."core/init.php";
    if(isset($q)){
    $ch=curl_init($_."api/");
    curl_setopt($ch,CURLOPT_HEADER,false);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POST,true);
    $data=array(
      "q"=>$q,
    );
      if(isset($p)){
      $data["p"]=$p;
      }
    curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($data));
    $response=curl_exec($ch);
    curl_close($ch);
    }else{
    $ch=curl_init($_."api/");
    curl_setopt($ch,CURLOPT_HEADER,false);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POST,true);
    $data=array(
      "q"=>"page",
      "p"=>"id:".$page
    );
    curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($data));
    $response=curl_exec($ch);
    curl_close($ch);
    }
  $j=json_decode($response,true);
    if($j["success"]&&$j["results"]){
      foreach($j["results"] as $j_){
        //set title
        if(isset($dynamic_meta_title)&&$dynamic_meta_title!==""){
        $h[5]=ucSmart($dynamic_meta_title);
        }elseif(isset($dynamic_intro_h)&&$dynamic_intro_h!==""){
        $h[5]=ucSmart($dynamic_intro_h);
        }elseif(isset($j_["meta_title"])&&$j_["meta_title"]!==""){
        $h[5]=ucSmart($j_["meta_title"]);
        }elseif($_SERVER["PHP_SELF"]!=="/index.php"){
        $h[5]=ucSmart($human_readable);
        }else{
        $h[5]=ucSmart($default_title);
        }
        if(strlen($h[5])<30&&strtolower($h[5])!==strtolower($default_title)){
        $h[5].=" - ".ucSmart($default_title);
        }
        //set description
        if(isset($dynamic_meta_desc)&&$dynamic_meta_desc!==""){
        $h[1]=ucfirst($dynamic_meta_desc);
        }elseif(isset($dynamic_intro_p)&&$dynamic_intro_p!==""){
        $h[1]=ucfirst($dynamic_intro_p);
        }elseif(isset($j_["meta_desc"])&&$j_["meta_desc"]!==""){
        $h[1]=ucfirst($j_["meta_desc"]);
        }elseif(isset($j_["description"])&&$j_["description"]!==""){
        $h[1]=ucfirst($j_["description"]);
        }else{
        $h[1]=ucfirst($default_description);
        }
        //set keywords
        if(isset($dynamic_meta_keys)&&$dynamic_meta_keys!==""){
        $h[3]=$dynamic_meta_keys;
        }elseif(isset($j_["meta_keys"])&&$j_["meta_keys"]!==""){
        $h[3]=$j_["meta_keys"];
        }else{
        $h[3]=$default_keys;
        }
      //begin output
      echo implode($h)."<header><a href='{$_}'title='Back to Home'><img src='{$_}img/ui/logo.svg'id='logo'alt='".ucSmart($default_title)."'></a><img src='{$_}img/ui/menu.svg'id='more'alt='Menu'title='Menu'><nav id='menu'><ul>";
        foreach($n as $nav_item){
          echo"<li><a href='{$_}{$nav_item[1]}'";
            if(isset($nav_item[2])&&$nav_item[2]!==""){
            echo"title='".ucSmart($nav_item[2])."'";
            }
            if(isset($nav_item[3])&&$nav_item[3]!==""){
            echo"class='{$nav_item[3]}'";
            }
          echo">".ucSmart($nav_item[0])."</a></li>";
        }
      echo"</ul></nav></header><main><section id='intro'>";
        //set intro heading
        if(isset($dynamic_intro_h)&&$dynamic_intro_h!==""){
        $i[0]=ucSmart($dynamic_intro_h);
        }elseif(isset($dynamic_meta_title)&&$dynamic_meta_title!==""){
        $i[0]=ucSmart($dynamic_meta_title);
        }elseif(isset($j_["intro_h"])&&$j_["intro_h"]!==""){
        $i[0]=ucSmart($j_["intro_h"]);
        }elseif(isset($j_["meta_title"])&&$j_["meta_title"]!==""){
        $i[0]=ucSmart($j_["meta_title"]);
        }elseif($_SERVER["PHP_SELF"]!=="/index.php"){
        $i[0]=ucSmart($human_readable);
        }else{
        $i[0]=ucSmart($default_intro_h);
        }
        //set intro paragraph
        if(isset($dynamic_intro_p)&&$dynamic_intro_p!==""){
        $i[1]=ucfirst($dynamic_intro_p);
        }elseif(isset($dynamic_meta_desc)&&$dynamic_meta_desc!==""){
        $i[1]=ucfirst($dynamic_meta_desc);
        }elseif(isset($j_["intro_p"])&&$j_["intro_p"]!==""){
        $i[1]=ucfirst($j_["intro_p"]);
        }elseif(isset($j_["meta_desc"])&&$j_["meta_desc"]!==""){
        $i[1]=ucfirst($j_["meta_desc"]);
        }elseif(isset($j_["description"])&&$j_["description"]!==""){
        $i[1]=ucfirst($j_["description"]);
        }else{
        $i[1]=ucfirst($default_intro_p);
        }
      echo"<h1>{$i[0]}</h1><p>{$i[1]}</p></section><article>";
        if(isset($j_["body_json"])&&$j_["body_json"]!==""){
          foreach($j_["body_json"] as $body){
            foreach($body as $k=>$v){
              switch($k){
                case"md":
                  if(!isset($md)){
                  include_once $cd_."php/parsedown.php";
                  $prs_md=new Parsedown();
                  }elseif($md!==true){
                  include_once $cd_."php/parsedown.php";
                  $prs_md=new Parsedown();
                  }
                $md=true;
                $v=str_replace("\$_.",$_,$v);
                echo"<section>".$prs_md->text($v)."</section>";
                break;
                case"img":
                $sprd=false;
                echo"<section><pre>";
                  if(count($v)>1){
                  echo"<div class='spread'>";
                  $sprd=true;
                  }
                  foreach($v as $v_){
                  //get img data
                  $ch=curl_init($_."api/");
                  curl_setopt($ch,CURLOPT_HEADER,false);
                  curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                  curl_setopt($ch,CURLOPT_POST,true);
                  $data=array(
                    "q"=>"image",
                    "p"=>"id:".$v_
                  );
                  curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($data));
                  $response=curl_exec($ch);
                  curl_close($ch);
                  $v_j=json_decode($response,true);
                    if($v_j["success"]&&$v_j["results"]){
                      foreach($v_j["results"] as $v_r){
                      $v_r_url="";
                        if(strpos($v_r["url"],"http://")==false){
                        $v_r_url=$_."img/";
                        }
                      $v_r_url.=$v_r["url"]."";
                      //check that image exists
                      $ch=curl_init($v_r_url);
                      curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
                      $response=curl_exec($ch);
                      $status=curl_getinfo($ch,CURLINFO_HTTP_CODE);
                      curl_close($ch);
                        if($status!==404){
                        //if curl success then output img
                        echo"<figure itemscope itemtype='https://schema.org/ImageObject'><a itemprop='url'href='{$v_r_url}'><meta itemprop='contentUrl'content='{$v_r_url}'><img itemprop='thumbnail'src='{$v_r_url}'";
                          //title
                          if(isset($v_r["title"])&&$v_r["title"]!==""){
                          echo"title='{$v_r["title"]}'";
                          }elseif(isset($v_r["caption"])&&$v_r["caption"]!==""){
                          echo"title='{$v_r["caption"]}'";
                          }elseif(isset($v_r["alt"])&&$v_r["alt"]!==""){
                          echo"title='{$v_r["alt"]}'";
                          }
                          //alt
                          if(isset($v_r["alt"])&&$v_r["alt"]!==""){
                          echo"alt='{$v_r["alt"]}'";
                          }elseif(isset($v_r["title"])&&$v_r["title"]!==""){
                          echo"alt='{$v_r["title"]}'";
                          }elseif(isset($v_r["caption"])&&$v_r["caption"]!==""){
                          echo"alt='{$v_r["caption"]}'";
                          }else{
                          echo"alt='".strtolower(str_replace("-"," ",str_replace("/","",reset($human_readable))))."'";
                          }
                        echo"></a><a itemprop='about'href='";
                          //related page
                          if(isset($v_r["url"])&&$v_r["url"]!==""){
                            if(strpos($v_r["url"],"http://")==false){
                            echo $_;
                            }
                          echo $v_r["url"];
                          }else{
                          echo $_."photos/".$v_;
                          }
                        echo"'><figcaption>";
                          //caption
                          if(isset($v_r["caption"])&&$v_r["caption"]!==""){
                          echo ucwords($v_r["caption"]);
                          }elseif(isset($v_r["title"])&&$v_r["title"]!==""){
                          echo ucwords($v_r["title"]);
                          }
                        echo"</figcaption></a></figure>";
                        }
                      }
                    }else{
                    echo"<script>console.log('PHP ERROR: {$v_j["error"]}');</script>";
                    }
                  }
                  if($sprd){
                  echo"</div>";
                  }
                echo"</section>";
                break;
                case"include":
                  foreach($v as $v_){
                  $v_url=$cd_."php/".$v_.".php";
                  $ch=curl_init($v_url);
                  curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
                  $response=curl_exec($ch);
                  $status=curl_getinfo($ch,CURLINFO_HTTP_CODE);
                    if($status!==404){
                    include $v_url;
                    }
                  curl_close($ch);
                  }
                break;
                case"script":
                  foreach($v as $v_){
                  $v_url="";
                    if(str_pos($v_,"http://")==false){
                    $v_url=$cd_."js/";
                    }
                  $v_url.=$v_.".js";
                  $ch=curl_init($v_url);
                  curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
                  $response=curl_exec($ch);
                  $status=curl_getinfo($ch,CURLINFO_HTTP_CODE);
                    if($status!==404){
                    $js[]=$v_url;
                    }
                  curl_close($ch);
                  }
                break;
                case"var":
                  foreach($v as $k_=>$v_){
                  ${$k_}=$v_;
                  }
                break;
              }
            }
          }
        }//include scripts at the bottom of page body
        if(count($js)>0){
        echo"<script src='".$jq."'></script>";
          foreach($js as $js_){
          echo"<script async src='";
            if(strpos($js_,"http")!==false){
            echo $js_;
            }else{
            echo $_."js/{$js_}.js";
            }
          echo"'></script>";
          }
        }
      }
    }else{
    echo $j["error"];
    }
  }else{
  header("Location: ".$_);
  }
echo"</article></main><footer><nav><ul>";
  foreach($fn as $fn_){
  echo"<li><a href='{$fn_[1]}'";
    if(isset($fn_[2])&&$fn_[2]!==""){
    echo"title='".ucSmart($fn_[2])."'";
    }
    if(isset($fn_[3])&&$fn_[3]!==""){
    echo"class='{$fn_[3]}'";
    }
  echo">".ucSmart($fn_[0])."</a></li>";
  }
echo"</ul></nav></footer><link rel='stylesheet'type='text/css'media='all'href='{$cd_}css/global.css'>";
  foreach($js as $js_){
  echo"<script src='";

  echo"'></script>";
  }
