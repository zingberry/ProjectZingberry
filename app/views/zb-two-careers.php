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
<!--
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
//-->	
</script>

<title>About Us</title>
</head>
<body>
<div id="content">
    	<div id="header">
        	<a href="<?=site_url("/")?>" title="Zingberry!"><img src="images/mini_logo.png" alt="Zingberry!" /></a>
            
        </div>
           <div id="body">
        	<h2>Careers</h2>
            <br />
            <p>Zingberry is a great team to join. We are a startup company made up of amazing programmers, designers and entrepreneurs working together to create a phenomenal product. If you meet the team, you will find out that we are a talented, determined and diverse group looking to change how people meet each other on campus.</p>
<br />
<br />
<p>We are looing for people who can't stand the idea of having a 9-5 job. We are looking for talented hackers, designers and entrepreneurs who are absolutely motivated to work on something big. We are looking for people who want to change the world.</p>
<br />
<br />
<p>If you think you have what it takes to work with us, send us your info along with any projects you have worked on at <a href="mailto:employment@zingberry.com">employment@zingberry.com</a>   </p>  
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
</body>
</html>
