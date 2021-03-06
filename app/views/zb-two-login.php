<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<base href="<?php echo $this->config->item('base_url') ?>" />
<link href="css/reset.css" type="text/css" rel="stylesheet" />
<link href="css/style.css" type="text/css" rel="stylesheet" />
<link href="css/jquery.qtip.css" rel="stylesheet" type="text/css" />
                    

<script type="text/javascript" src="js/jquery_003.js"></script>
<script type="text/javascript" src="js/blur.js"></script>
<script type="text/javascript" src="js/slideshow.js"></script>
<script src="js/jquery.qtip.pack.js" type="text/javascript"></script>


<script type="text/javascript">
$(function(){ 
			    // find all the input elements with title attributes
				$('input[title!=""]').hint();
				<?php if(isset($login_errors)){?>
					$('.forgot').qtip({
					   content: '<?=$login_errors?>',
					   position: {
						  my: 'left center', 
						  at: 'right center'
					   },
					   show: {
						   event: false,
						   ready: false
					   },
					   hide: false,
					   style: {
						   width: '200px',
						  classes: 'ui-tooltip-red'
					   }
					});
				<?php } ?>
				
				<?php if(isset($register_errors) ){
					foreach($register_errors as $i => $r){?>
					$('form#frm_register input[name="<?=$i?>"]').qtip({
					   content: '<?=$r?>',
					   position: {
						  my: 'left center', 
						  at: 'right center'
					   },
					   show: {
						   event: false,
						   ready: true
					   },
					   hide: false,
					   style: {
						   width: '200px',
						  classes: 'ui-tooltip-red'
					   }
					});
				<?php } } ?>
			});
$(document).ready(function() {
		$(".topMenuAction").click( function() {
			if ($("#openCloseIdentifier").is(":hidden")) {
				
				$('.forgot').qtip('hide');
				$("#slider").animate({ 
					marginLeft: "-320px"
					}, 
					500,
					function(){
					}
				);
				
				$("#openCloseIdentifier").show();
			} else {
				$("#slider").animate({ 
					marginLeft: "0px"
					}, 
					500,
					function(){
						$('.forgot').qtip('show');
					} 
				);
				
				$("#openCloseIdentifier").hide();
			}
		});  
	if ($("#openCloseIdentifier").is(":hidden")) {
				$("#slider").animate({ 
					marginLeft: "-320px"
					}, 500 );
				
				$("#openCloseIdentifier").show();
			} else {
				$("#slider").animate({ 
					marginLeft: "0px"
					}, 500 ,
					function(){
						$('.forgot').qtip('show');
					} );
				
				$("#openCloseIdentifier").hide();
			}  
	});			
</script>

<title>Zingberry!</title>
</head>

<body onload="setUpSlideShow()">
	<div id="content">
	  <form id="frm_register" name="frm_register" action="<?=site_url("account/register")?>" method="post">
   	  <ul class="form">
      	<div id="slideshow"><div id="slides"><div class="slide"><img src="images/slideshowtext.png" width="826" height="305"/>Slide content 1</div><div class="slide"><img src="images/slideshowtile.png" width="826" height="305"/>Slide content 2</div><div class="slide"><img src="images/slideshowvideo.png" width="826" height="305"/>Slide content 3</div></div><div id="slides-controls"><a href="javascript:void(0)">1</a> <a href="javascript:void(0)">2</a> <a href="javascript:void(0)">3</a></div></div>
      			<!--           
           	    <input type="text" name="name" value="<?=$this->input->post('name')?>" title="Name"/></li>
                <li><input type="text" name="email" value="<?=$this->input->post('email')?>" title="Rutgers Email" /></li>
                <li><input type="password" name="password" value="" title="Password" /></li>
        <li>* By registering you agree to Zingberry's <a href="<?=site_url('zing/terms')?>" target="_blank">Terms of Service</a></li>
                <li><input type="submit" class="sub" value="Register" /></li>
                <li>
                </li>
        </ul>
      </form>
    	-->
        <br />
        <br />
        <big><a href="https://github.com/zingberry/ProjectZingberry" target="_blank">Now on Github</a></big>

       
    	
</div>
    <div id="footer">
    	<ul>       
        	<li><a href="<?=site_url('zing/about')?>">about</a></li>
            <li><a href="<?=site_url('zing/support')?>">support</a></li>
            <li><a href="<?=site_url('zing/careers')?>">careers</a></li>
            <li><a href="<?=site_url('zing/terms')?>">terms &amp; conditions</a></li>
            
        </ul>
    </div>
    <!--
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
        -->
</div>
</body>
</html>
