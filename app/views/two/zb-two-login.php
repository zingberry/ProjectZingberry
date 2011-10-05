<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="" />
<meta name="keywords" content="" />

<link href="css/reset.css" type="text/css" media="all" rel="stylesheet" />
<link href="css/style.css" type="text/css" media="all" rel="stylesheet" />

<script type="text/javascript" src="js/jquery_003.js"></script>
<script type="text/javascript" src="js/blur.js"></script>
<script type="text/javascript">
$(function(){ 
			    // find all the input elements with title attributes
				$('input[title!=""]').hint();
			});
$(document).ready(function() {
		$(".topMenuAction").click( function() {
			if ($("#openCloseIdentifier").is(":hidden")) {
				$("#slider").animate({ 
					marginLeft: "-320px"
					}, 500 );
				
				$("#openCloseIdentifier").show();
			} else {
				$("#slider").animate({ 
					marginLeft: "0px"
					}, 500 );
				
				$("#openCloseIdentifier").hide();
			}
		});  
	});			
</script>

<title>Zingberry!</title>
</head>

<body>
	<div id="content">
	  <form name="frm_login" action="#" method="post">
   	  <ul class="form">
            	<li><a href="<?=site_url("/")?>" class="logo" title="Zingberry!"><img src="images/logo_login.jpg" alt="Zingberry!" /></a>
           	    <input type="text" name="firstname" title="First Name"/></li>
                <li><input type="text" name="lastname" title="Last Name"/></li>
                <li><input type="text" name="email" title="Rutgers Email" /></li>
                <li><input type="password" name="password" title="Password" /></li>
                <li><input type="password" name="confirmpassword" title="Confirm Password" /></li>
        <li>* By registering you agree to Zingberry's <a href="<?=site_url('zing/terms')?>" target="_blank">Terms of Service</a></li>
                <li><input type="submit" class="sub" value="Register" /></li>
        </ul>
      </form>
    	
    	
</div>
    <div id="footer">
    	<ul>       
        	<li><a href="<?=site_url('zing/about')?>">about</a></li>
            <li><a href="<?=site_url('zing/support')?>">support</a></li>
            <li><a href="<?=site_url('zing/careers')?>">careers</a></li>
            <li><a href="<?=site_url('zing/terms')?>">terms &amp; conditions</a></li>
            
        </ul>
    </div>
    <div id="sliderWrap">
    <div id="openCloseIdentifier"></div>
		<div id="slider">
			<div id="sliderContent">
				<form name="frm_login" action="<?=site_url("account/login")?>" method="post">
                    <ul class="form_sm">
                        <li><input type="text" name="email" title="Rutgers Email" /></li>
                        <li><input type="password" name="password" title="Create a Password" /></li>
                        <li><input type="submit" name="loginsubmit" class="sub" value="Login" /></li>
                        <li><a href="<?=site_url("account/forgotpassword")?>" class="forgot">Forgot Password?</a></li>
                    </ul>
                </form>
			</div>
            
			<div id="openCloseWrap">
				<a href="javascript:void(0)" class="topMenuAction" id="topMenuImage">&nbsp;
				</a>
			</div>
		</div>
</div>
</body>
</html>
