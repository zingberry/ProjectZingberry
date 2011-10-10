<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<base href="<?php echo $this->config->item('base_url') ?>" />
<link href="css/reset.css" type="text/css" media="all" rel="stylesheet" />
<link href="css/style.css" type="text/css" media="all" rel="stylesheet" />
<link href="css/token-input-facebook.css" type="text/css" media="all" rel="stylesheet" />
<link href="css/token-input.css" type="text/css" media="all" rel="stylesheet" />

<script type="text/javascript" src="js/jquery_003.js"></script>
<script type="text/javascript" src="js/jquery.tokeninput.js"></script>
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
		
		$(".topMenuAction1").click( function() {
			if ($("#openCloseIdentifier1").is(":hidden")) {
				$("#slider1").animate({ 
					marginLeft: "-240px"
					}, 500 );
				
				$("#openCloseIdentifier1").show();
			} else {
				$("#slider1").animate({ 
					marginLeft: "0px"
					}, 500 );
				
				$("#openCloseIdentifier1").hide();
			}
		}); 
		$(".topMenuAction2").click( function() {
			if ($("#openCloseIdentifier2").is(":hidden")) {
				$("#slider2").animate({ 
					marginLeft: "-240px"
					}, 500 );
				
				$("#openCloseIdentifier2").show();
			} else {
				$("#slider2").animate({ 
					marginLeft: "0px"
					}, 500 );
				
				$("#openCloseIdentifier2").hide();
			}
		}); 
		if ($("#openCloseIdentifier1").is(":hidden")) {
				$("#slider2").animate({ 
					marginLeft: "-240px"
					}, 500 );
				
				$("#openCloseIdentifier1").show();
			} else {
				$("#slider1").animate({ 
					marginLeft: "0px"
					}, 500 );
				
				$("#openCloseIdentifier1").hide();
			}
		  
	});			
</script>

<title>Zingberry! Account- Organizations</title>
</head>

<body>
	<div id="content">
    	<div id="header">
        	<a href="<?=site_url("account/logout")?>" class="log_out" title="Logout">&nbsp;</a>
        	<a href="<?=site_url("/")?>" title="Zingberry!"><img src="images/mini_logo.png" alt="Zingberry!" /></a>
            <input type="text" value="" title="Search similarities" />
            <ul>
            	<li><a href="<?=site_url("video")?>" class="video">&nbsp;</a></li>
                <li><a href="<?=site_url("account")?>" class="user">&nbsp;</a></li>
            </ul>
        </div>
    	
        <div id="body">
        	<h2>Organizations</h2>
        	<form name="frm_login" action="<?=current_url()?>" method="post">
                <ul class="form_account">
                    <li>Organizations</li>
                    <li><input id="organizations" type="text" name="organizations"/></li>
                    <script type="text/javascript">
						$(document).ready(function() {
							$("#organizations").tokenInput("<?=site_url("account/json_token/organizations")?>", {
								allowNewTokens: true,
								tokenValue: 'name',
								theme: "facebook",
								method: "post",
								prePopulate: <?=$user['organizations']?>
							});
						});
					</script>
                    <li>Greek Life</li>
                    <li><input id="greeks" type="text" name="greeks"/></li>
                    <script type="text/javascript">
						$(document).ready(function() {
							$("#greeks").tokenInput("<?=site_url("account/json_token/greeks")?>", {
								allowNewTokens: true,
								tokenLimit: 3,
								tokenValue: 'name',
								theme: "facebook",
								method: "post",
								prePopulate: <?=$user['greeks']?>
							});
						});
					</script>
                    <li>Workplace</li>
                    <li><input id="workplaces" type="text" name="workplaces"/></li>
                    <script type="text/javascript">
						$(document).ready(function() {
							$("#workplaces").tokenInput("<?=site_url("account/json_token/workplaces")?>", {
								allowNewTokens: true,
								tokenValue: 'name',
								theme: "facebook",
								method: "post",
								prePopulate: <?=$user['workplaces']?>
							});
						});
					</script>
                    <li><input type="submit" name="organizations_update" class="sub" value="Save Changes" /> </li>
                </ul>
            </form>
        </div>
    	
    </div>
    <div id="footer">
    	<ul>       
        	<li><a href="<?=site_url('zing/about')?>">about</a></li>
            <li><a href="<?=site_url('zing/support')?>">support</a></li>
            <li><a href="<?=site_url('zing/careers')?>">careers</a></li>
            <li><a href="<?=site_url('zing/terms')?>">terms &amp; conditions</a></li>
            
        </ul>
    </div>
    <div id="sliderWrap1">
    <div id="openCloseIdentifier1"></div>
		<div id="slider1">
			<div id="sliderContent1">
                <ul class="ac_set">
                    <li><a href="<?=site_url("account")?>">Personal Info</a></li>
                    <li><a href="<?=site_url("account/academics")?>">Academics</a></li>
                    <li><a href="<?=site_url("account/organizations")?>" class="active">Organizations</a></li>
                    <li><a href="<?=site_url("account/interests")?>">Interests</a></li>
                    <li><a href="<?=site_url("account/picture")?>">Picture</a></li>
                </ul>
			</div>
			<div id="openCloseWrap1">
				<a href="javascript:void(0)" class="topMenuAction1" id="topMenuImage1">&nbsp;
				</a>
			</div>
		</div>
     </div>
     
      <div id="sliderWrap2">
    <div id="openCloseIdentifier2"></div>
		<div id="slider2">
			<div id="sliderContent2">
				<ul class="ac_set">
                    <li><a href="javascript:void(0)">Personal Info</a></li>
                    <li><a href="javascript:void(0)">Academics</a></li>
                    <li><a href="javascript:void(0)">Organizations</a></li>
                    <li><a href="javascript:void(0)">Interests</a></li>
                </ul>
			</div>
            
			<div id="openCloseWrap2">
				<a href="javascript:void(0)" class="topMenuAction2" id="topMenuImage2">&nbsp;
				</a>
			</div>
		</div>
     </div>
     
</body>
</html>
