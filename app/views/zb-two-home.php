<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<base href="<?php echo $this->config->item('base_url') ?>" />
<link href="css/reset.css" type="text/css" media="all" rel="stylesheet" />
<link href="css/style.css" type="text/css" media="all" rel="stylesheet" />
<link href="css/jquery.bubblepopup.v2.3.1.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery_003.js"></script>
<script type="text/javascript" src="js/jquery.hoverIntent.min.js"></script>
<script type="text/javascript" src="js/blur.js"></script>
<script type="text/javascript" src="js/jquery.bubblepopup.v2.3.1.min.js"></script>
<script type="text/javascript">
$(function(){ 
			    // find all the input elements with title attributes
				$('input[title!=""]').hint();
			});
$(document).ready(function() {
		$("ul.outer li").hoverIntent(
		function(){
			$(this).find("ul.inner").fadeIn(100);
			$(this).find("div.hovername").fadeIn(100);
			},
		function(){
			$(this).find("ul.inner").fadeOut(100);
			$(this).find("div.hovername").fadeOut(100);
			}
		);
		$("ul.inner li").hoverIntent(
		function(){
			$(this).find("ul.inner_most").fadeIn(100);
			},
		function(){
			$(this).find("ul.inner_most").fadeOut(100);
			}
		);
		
		
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
		
		
	$('a.poplight[href^=#]').click(function() {
		var popID = $(this).attr('rel'); //Get Popup Name
		var popURL = $(this).attr('href'); //Get Popup href to define size
		var user = $(this).attr('title');// get the username to be sent	
		$("#user_name").val(user);	// populate the value in the form in pop up
		//Pull Query & Variables from href URL
		var query= popURL.split('?');
		var dim= query[1].split('&');
		var popWidth = dim[0].split('=')[1]; //Gets the first query string value

		//Fade in the Popup and add close button
		$('#' + popID).fadeIn().css({ 'width': Number( popWidth ) }).prepend('<a href="#" class="close"><img src="images/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>');
		
		//Define margin for center alignment (vertical + horizontal) - we add 80 to the height/width to accomodate for the padding + border width defined in the css
		var popMargTop = ($('#' + popID).height() + 80) / 2;
		var popMargLeft = ($('#' + popID).width() + 80) / 2;
		
		//Apply Margin to Popup
		$('#' + popID).css({ 
			'margin-top' : -popMargTop,
			'margin-left' : -popMargLeft
		});
		
		//Fade in Background
		$('body').append('<div id="fade"></div>'); //Add the fade layer to bottom of the body tag.
		$('#fade').css({'filter' : 'alpha(opacity=80)'}).fadeIn(); //Fade in the fade layer 
		
		return false;
	});
	
	
	//Close Popups and Fade Layer
	$('a.close, #fade,#close').live('click', function() { //When clicking on the close or fade layer...
	  	$('#fade , .popup_block').fadeOut(function() {
			$('#fade, a.close').remove();  
		}); //fade them both out
		
		return false;
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
            <input type="text" value="" title="search similarities" />
            <ul>
            	<li><a href="<?=site_url("video")?>" class="video">&nbsp;</a></li>
                <li><a href="<?=site_url("account")?>" class="user">&nbsp;</a></li>
            </ul>
            
        </div>
        
        <div id="body1">
        	
            <div id="main_content">
        	<ul class="outer">
            <?php foreach( $users as $u){ ?>
        		<li>
                	<div class="hovername" style="
                        position: absolute;
                        margin-left: 5px;
                        margin-top: 5px;
                        padding-bottom:3px;
                        background-color: white;
                        width: 133px;
                        text-align: center;
                        display:none;
                    "><?=$u["user"]["firstname"].' '.$u["user"]["lastname"]?></div>
                    
                <img class="img" src="./user_images/<? if(isset($u['pic']['filename'])){ echo "thumb_".$u['pic']['filename'];} else { echo "thumb_default.jpg";}?>" />
                <ul class="inner">
                	<li><a href="#">Personal Information</a>
                    	<ul class="inner_most">
                        	<li class="name"><b><?=$u["user"]["firstname"].' '.$u["user"]["lastname"]?></b></li>
                        	<li class="title">Class Year</li>
                            	<li class="data"><?=$u["user"]["class"]?></li>
                            <li class="title">Gender</li>
                            	<li class="data"><? switch($u["user"]["gender"]){ case 'm': echo 'Male'; break; case 'f': echo 'Female';}?></li>
                            <li class="title">Interested In</li>
                            	<li class="data"><? switch($u["user"]["interested_in"]){ case 'm': echo 'Male'; break; case 'f': echo 'Female';}?></li>
                            <li class="title">Relationship Status</li>
                            	<li class="data"><? switch($u["user"]["relationship_status"]){ case 's': echo 'Single'; break; case 'r': echo 'In a Relationship';}?></li>
                            <li class="title">High School</li>
                            	<li class="data"><?=implode(", ",$u['highschool'])?></li>
                            <li class="title">Nationality</li>
                            	<li class="data"><?=implode(", ",$u['nationalities'])?></li>
                            <li class="title">Languages</li>
                            	<li class="data"><?=implode(", ",$u['languages'])?></li>
                            <li class="title">Religious Views</li>
                           		<li class="data"><?=$u["user"]["religious_views"]?></li>
                            <li class="title">Political Views</li>
                            	<li class="data"><?=$u["user"]["political_views"]?></li>
                        </ul>
                    </li>
                     <li><a href="#">Academics </a>
                    <ul class="inner_most">
                        	<li class="title">Major</li>
                            	<li class="data"><?=implode(", ",$u['majors'])?></li>
                            <li class="title">Classes</li>
                            	<li class="data"><?=implode("<br />",$u['courses'])?></li>
                        </ul>
                    <li><a href="#">Organizations</a>
                    <ul class="inner_most">
                        	<li class="title">Organization</li>
                            <li class="data"><?=implode(", ",$u['organizations'])?></li>
                            <li class="title">Greek Life</li>
                            <li class="data"><?=implode(", ",$u['greeks'])?></li>
                            <li class="title">Workplace</li>
                            <li class="data"><?=implode(", ",$u['workplaces'])?></li>
                           
                        </ul></li>
                    <li><a href="#">Interests </a>
                    <ul class="inner_most">
                        	<li class="title">Favorite Music Artists</li>
                            <li class="data"><?=implode(", ",$u['favorite_music_artists'])?></li>
                            <li class="title">Favorite Heroes</li>
                            <li class="data"><?=implode(", ",$u['favorite_heroes'])?></li>
                            <li class="title">Favorite Movies</li>
                            <li class="data"><?=implode(", ",$u['favorite_movies'])?></li>
                            <li class="title">Favorite TV Shows</li>
                            <li class="data"><?=implode(", ",$u['favorite_tvshows'])?></li>
                            <li class="title">Favorite Sports Teams</li>
                            <li class="data"><?=implode(", ",$u['favorite_sports_teams'])?></li>
                            <li class="title">Favorite Video Games</li>
                            <li class="data"><?=implode(", ",$u['favorite_video_games'])?></li>
                            <li class="title">Favorite Books</li>
                            <li class="data"><?=implode(", ",$u['favorite_books'])?></li>
                            <li class="title">Favorite Foods</li>
                            <li class="data"><?=implode(", ",$u['favorite_foods'])?></li>
                        </ul></li> 
                    <!-- the href attrib is the width of pop up window and the title is the Name of the user which will be displayed on pop up. -->    
                    <li><a href="#?w=450" rel="popup5" class="poplight" title="<?=$u["user"]["firstname"].' '.$u["user"]["lastname"]?>">Send Chat Request</a></li>        
                </ul>
                
                </li>
            <?php } ?>
        	</ul>
        
        </div>
        </div>
    </div>   
<div id="popup5" class="popup_block">
    <form name="frm_request" action="#" method="post">
        <ul id="form">
            <li class="lbl">User Name:</li>
            <li class="input"><input type="text" class="txt_small" value="" id="user_name" readonly="readonly" /></li>
            <li class="lbl">Your Message: </li>
            <li class="input"><textarea name="message" class="txt_area" cols="35" rows="4"></textarea></li>
            <li class="lbl">&nbsp;</li>
            <li class="input"><input type="submit" value="Send" class="btn" />&nbsp;&nbsp;<input type="button" value="Cancel" id="close" class="btn" /></li>
        </ul>
    </form>
</div>     
     
</body>
</html>
