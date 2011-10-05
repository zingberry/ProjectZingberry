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
    	<a href="index.html" class="logo" title="Zingberry!"><img src="images/logo_forgot_password.jpg" alt="Zingberry!" /></a>
        <form name="frm_login" action="#" method="post">
        	<ul class="form">
            	<li>Forgot Password?</li>
                <li><input type="text" name="txt_email" title="Rutgers Email" /></li>
                <li><input type="submit" class="sub" value="Send" /></li>
            </ul>
        </form>
    	
    	
    </div>
    <div id="footer">
    	<ul>       
        	<li><a href="about.html">about</a></li>
            <li><a href="support.html">support</a></li>
            <li><a href="careers.html">careers</a></li>
            <li><a href="tos.html">terms &amp; conditions</a></li>
            
        </ul>
    </div>
    <div id="sliderWrap">
    <div id="openCloseIdentifier"></div>
		<div id="slider">
			<div id="sliderContent">
				<form name="frm_login" action="account.html" method="post">
                    <ul class="form_sm">
                        <li><input type="text" name="txt_email" title="Rutgers Email" /></li>
                        <li><input type="password" name="txt_password" title="Password" /></li>
                        <li><input type="submit" class="sub" value="Login" /></li>
                        <li><a href="forgot-password.html" class="forgot">Forgot Password?</a></li>
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
