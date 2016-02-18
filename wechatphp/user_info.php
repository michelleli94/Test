<?php
require_once "lib.php";

/*echo "<pre>";
var_dump($_REQUEST);
echo "</pre>";
exit;*/
if(isset($_GET['code'])){
  //p($_GET['code']); //  data received for the first time - step1
  	define("CODE", $_GET['code']);
   //get the ACCESS_TOKEN/APPID for authorization
  	$get_webPage_access_token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".APPID."&secret=".APPSECRET."&code=".CODE."&grant_type=authorization_code";
  	
  	//retrieve access_toke、 refresh_token、openid、 scope from webpage
  	$json_result = getCatch($get_webPage_access_token_url);  // step2
  	$arr_result = json_decode($json_result, true); //retrieve access_token
   //p($arr_result);
   //exit;
   //	echo $arr_result['refresh_token'];
   // echo "<br />"."===============================刷新后的access_token相关信息==========step3================================"."<br />";   
    /*define("REFRESH_TOKEN", $arr_result['refresh_token']);
    $refresh_access_token_url = "https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=".APPID."&grant_type=refresh_token&refresh_token=".REFRESH_TOKEN;
  	$new_access_token_by_refresh_json = getCatch($refresh_access_token_url);
    $new_access_token_by_refresh_arr = json_decode($new_access_token_by_refresh_json, true); 
  	p($new_access_token_by_refresh_arr);// */
  	
   //echo "<br />"."===============================刷新后的access_token相关信息结束==========step3================================"."<br />";   
   // exit;
   //retrieve user information (scope shoulb be snsapi_userinfo)  step4
    define("ACCESS_TOKEN", $arr_result['access_token']);
    //define("ACCESS_TOKEN", $new_access_token_by_refresh_arr['access_token']);
  	$webPageUserInfoGet_url = "https://api.weixin.qq.com/sns/userinfo?access_token=".ACCESS_TOKEN."&openid=".$arr_result['openid'];
  	$userInfo_json = getCatch($webPageUserInfoGet_url);
  	$userInfo_arr = json_decode($userInfo_json, true);
  	
  //	p($userInfo_arr);
  //	exit;
  
    //获取132*132大小的图片链接地址
    $headimgurl =  $userInfo_arr['headimgurl']; 
  	$headimgurl_tmpl =  substr($headimgurl, 0, -1);  	
  	$headimgurl = $headimgurl_tmpl."132";
    
  //  exit;
  //p($userInfo_arr);
	
  // echo '<img src="'.$userInfo_arr["headimgurl"].'/">';
  	
  
}else{
    echo "NO CODE";
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <title>Demo of Webpage having authorization to retrieve user information</title>
    
  <link rel="stylesheet" href="https://d10ajoocuyu32n.cloudfront.net/mobile/1.3.1/jquery.mobile-1.3.1.min.css">
  
  <!-- Extra Codiqa features -->
  <link rel="stylesheet" href="codiqa.ext.css">
  
  <!-- jQuery and jQuery Mobile -->
  <script src="https://d10ajoocuyu32n.cloudfront.net/jquery-1.9.1.min.js"></script>
  <script src="https://d10ajoocuyu32n.cloudfront.net/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>

  <!-- Extra Codiqa features -->
  <script src="https://d10ajoocuyu32n.cloudfront.net/codiqa.ext.js"></script>
  <script>
    	document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
				WeixinJSBridge.call('hideOptionMenu');
				WeixinJSBridge.call('hideToolbar');
		});
  </script>
</head>
<body>
<!-- Home -->
<div data-role="page" id="page1">
    <div data-role="content">
        <div style="width:132px ; height: 132px; background-color: #fbfbfb; border: 1px solid #b8b8b8;">
            <img src="<?php echo $headimgurl; ?>" alt="image">
        </div>
    <!--<div data-role="fieldcontain">
            <label for="textinput1">
                headimageurl：
            </label>
				<input name="" id="textinput1" placeholder="" value="<?php //echo $headimgurl;?>" data-mini="true"
            type="text">
        </div>-->
        <div data-role="fieldcontain">
            <label for="textinput1">
                User's unique ID, openid：
            </label>
            <input name="" id="textinput1" placeholder="" value="<?php echo $userInfo_arr['openid']; ?>" data-mini="true"
            type="text">
        </div>
        <div data-role="fieldcontain">
            <label for="textinput2">
                User's nickname：
            </label>
            <input name="" id="textinput2" placeholder="" value="<?php echo $userInfo_arr['nickname']; ?>" data-mini="true"
            type="text">
        </div>
        <div data-role="fieldcontain">
            <label for="textinput3">
                Gender(1:Male，2:Female，0:Unknown)：
            </label>
            <input name="" id="textinput3" placeholder="" value="<?php echo $userInfo_arr['sex']; ?>" data-mini="true"
            type="text">
        </div>
        <div data-role="fieldcontain">
            <label for="textinput4">
                Wechat Client Language：
            </label>
            <input name="" id="textinput4" placeholder="" value="<?php echo $userInfo_arr['language']; ?>" data-mini="true"
            type="text">
        </div>
        <div data-role="fieldcontain">
            <label for="textinput5">
                City：
            </label>
            <input name="" id="textinput5" placeholder="" value="<?php echo $userInfo_arr['city']; ?>" data-mini="true"
            type="text">
        </div>
        <div data-role="fieldcontain">
            <label for="textinput7">
                State/Provience：
            </label>
            <input name="" id="textinput7" placeholder="" value="<?php echo $userInfo_arr['province']; ?>" data-mini="true"
            type="text">
        </div>
        <div data-role="fieldcontain">
            <label for="textinput8">
                Country：
            </label>
            <input name="" id="textinput8" placeholder="" value="<?php echo $userInfo_arr['country']; ?>" data-mini="true"
            type="text">
        </div>
        <div data-role="fieldcontain">
            <label for="textinput6">
                User privilege info：
            </label>
            <input name="" id="textinput6" placeholder="" value="<?php print_r($userInfo_arr['privilege']); ?>" data-mini="true"
            type="text">
        </div>
    </div>
    <div data-theme="a" data-role="footer" data-position="fixed">
        <h3>
            Wechat user information demo
        </h3>
    </div>
</div>
</body>
</html>