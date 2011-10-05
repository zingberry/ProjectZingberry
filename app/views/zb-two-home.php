<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<base href="<?php echo $this->config->item('base_url') ?>" />
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
		
		
		$(".topMenuAction3").click( function() {
			if ($("#openCloseIdentifier3").is(":hidden")) {
				$("#slider3").animate({ 
					marginLeft: "-280px"
					}, 500 );
				
				$("#openCloseIdentifier3").show();
			} else {
				$("#slider3").animate({ 
					marginLeft: "0px"
					}, 500 );
				
				$("#openCloseIdentifier3").hide();
			}
		}); 
		$(".topMenuAction4").click( function() {
			if ($("#openCloseIdentifier4").is(":hidden")) {
				$("#slider4").animate({ 
					marginLeft: "-280px"
					}, 500 );
				
				$("#openCloseIdentifier4").show();
			} else {
				$("#slider4").animate({ 
					marginLeft: "0px"
					}, 500 );
				
				$("#openCloseIdentifier4").hide();
			}
		}); 
		
		  
	});			
</script>

<title>Zingberry!</title>
</head>

<body>
	<div id="content">
    	<div id="header">
        	<a href="<?=site_url("account/logout")?>" class="log_out" title="Logout">&nbsp;</a>
        	<a href="<?=site_url("browse")?>" title="Zingberry!"><img src="images/mini_logo.png" alt="Zingberry!" /></a>
            <input type="text" value="" title="Search similarities" />
            <ul>
            	<li><a href="<?=site_url("video")?>" class="video">&nbsp;</a></li>
                <li><a href="<?=site_url("account")?>" class="user">&nbsp;</a></li>
            </ul>
            
        </div>
    	
        <div id="body1">
        	<form>
            	<input type="text" value="" class="txt" title="What's Up?" />
                <input type="submit" value="post" class="btn" />
            </form>
        </div>
    	
    </div>
  <div id="sliderWrap3">
    <div id="openCloseIdentifier3"></div>
		<div id="slider3">
			<div id="sliderContent3">
                <ul class="ac_set">
                    <li><a href="javascript:void(0)">Personal Info</a></li>
                    <li><a href="javascript:void(0)">Academics</a>
                         <ul>
                            <li><a href="javascript:void(0)">Academics</a></li>
                            <li><a href="javascript:void(0)">Organizations</a></li>
                            <li><a href="javascript:void(0)">Interests</a></li>
                            <li><a href="javascript:void(0)">Organizations</a></li>
                            <li><a href="javascript:void(0)">Interests</a></li>
                         </ul>
                    </li>
                    <li><a href="javascript:void(0)">Organizations</a></li>
                    <li><a href="javascript:void(0)">Interests</a>
                    	<ul>
                            <li><a href="javascript:void(0)">Academics</a></li>
                            <li><a href="javascript:void(0)">Organizations</a></li>
                            <li><a href="javascript:void(0)">Interests</a></li>
                        </ul>
                    </li>
                </ul>
			</div>
			<div id="openCloseWrap3">
				<a href="javascript:void(0)" class="topMenuAction3" id="topMenuImage3">&nbsp;
				</a>
			</div>
		</div>
     </div>
     
      <div id="sliderWrap4">
    <div id="openCloseIdentifier4"></div>
		<div id="slider4">
			<div id="sliderContent4">
				<ul class="ac_set">
                    <li><a href="javascript:void(0)">Personal Info</a>
                    	<ul>
                        	<li><a href="javascript:void(0)">Academics</a></li>
                            <li><a href="javascript:void(0)">Organizations</a></li>
                            <li><a href="javascript:void(0)">Interests</a></li>
                            <li><a href="javascript:void(0)">Academics</a></li>
                            <li><a href="javascript:void(0)">Organizations</a></li>
                            <li><a href="javascript:void(0)">Interests</a></li>
                        </ul>
                    </li>
                    <li><a href="javascript:void(0)">Academics</a></li>
                    <li><a href="javascript:void(0)">Organizations</a></li>
                    <li><a href="javascript:void(0)">Interests</a></li>
                </ul>
			</div>
            
			<div id="openCloseWrap4">
				<a href="javascript:void(0)" class="topMenuAction4" id="topMenuImage4">&nbsp;
				</a>
			</div>
		</div>
     </div>
     
</body>
</html>
