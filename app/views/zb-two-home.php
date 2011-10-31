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
<link href="css/jquery.qtip.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery_003.js"></script>
<script type="text/javascript" src="js/jquery.hoverIntent.min.js"></script>
<script type="text/javascript" src="js/blur.js"></script>
<script type="text/javascript" src="js/jquery.bubblepopup.v2.3.1.min.js"></script>
<script src="js/jquery.qtip.pack.js" type="text/javascript"></script>
<script type="text/javascript">
$.extend({URLEncode:function(c){var o='';var x=0;c=c.toString();var r=/(^[a-zA-Z0-9_.]*)/;
  while(x<c.length){var m=r.exec(c.substr(x));
    if(m!=null && m.length>1 && m[1]!=''){o+=m[1];x+=m[1].length;
    }else{if(c[x]==' ')o+='+';else{var d=c.charCodeAt(x);var h=d.toString(16);
    o+='%'+(h.length<2?'0':'')+h.toUpperCase();}x++;}}return o;},
URLDecode:function(s){var o=s;var binVal,t;var r=/(%[^%]{2})/;
  while((m=r.exec(o))!=null && m.length>1 && m[1]!=''){b=parseInt(m[1].substr(1),16);
  t=String.fromCharCode(b);o=o.replace(m[1],t);}return o;}
});

</script>
<script type="text/javascript">
$(function(){ 

		<?php if(isset($search_errors) ){
				foreach($search_errors as $i => $r){?>
				$('form#search [name="<?=$i?>"]').qtip({
				   content: '<?=$r?>',
				   position: {
					  my: 'top center', 
					  at: 'bottom center'
				   },
				   show: {
					   event: false,
					   ready: true
				   },
				   hide: false,
				   style: {
					   width: '160px',
					  classes: 'ui-tooltip-red'
				   }
				});
			<?php } } ?>
			    // find all the input elements with title attributes
				$('input[title!=""]').hint();
			});
$(document).ready(function() {
		<? if(isset($initial) && $initial){?>
		window.open('<?=site_url('video')?>','newwin');
		<? } ?>
	
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
		$("form#video_request  #uid").val( 
			$(this).parent().parent().parent().find("input#uid").val()
		); //get uid from tile and put it in the request form
		$("form#video_request  #message").val(""); // Clear old input from message textarea
		var popID = $(this).attr('rel'); //Get Popup Name
		var popURL = $(this).attr('href'); //Get Popup href to define size
		var user = $(this).attr('title');// get the username to be sent	
		$("#user_name").val(user);	// populate the value in the form in pop up
		//Pull Query & Variables from href URL
		var query= popURL.split('?');
		var dim= query[1].split('&');
		var popWidth = dim[0].split('=')[1]; //Gets the first query string value

		//Fade in the Popup and add close button
		$('#' + popID).fadeIn().css({ 'width': Number( popWidth ) }).prepend('<a href="javascript:void(0)" class="close"><img src="images/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>');
		
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
			$("form#video_request").show();
			$("div#request_success").hide();
			$("div#request_failed").hide();
		}); //fade them both out
		
		return false;
	});
	
	  
});			
	function send_request(){
		$("form#video_request").hide(); //hide the request form
		var request_url = "<?=site_url("videorequest/request")?>";
		var postdata = {
			"uid": $("form#video_request  #uid").val(),
			"message": $("form#video_request  #message").val()
		};
		$.ajax({ //send ajax chat request
			url: request_url,
			cache:false,
			type: "POST",
  			data: postdata,
			success: function(message) {
				if(message.numrequested > 0)
					$("div#request_success").show(); //show success
				else 
					$("div#request_failed").show(); //show success
			}
		});
	}

</script>

<title>Zingberry!</title>
</head>

<body>
	<div id="content">
    	<div id="header">
        	<a href="<?=site_url("account/logout")?>" class="log_out" title="Logout">&nbsp;</a>
        	<a href="<?=site_url("browse")?>" title="Zingberry!"><img src="images/mini_logo.png" alt="Zingberry!" /></a>
            <form id="search" action="<?=site_url("browse/search")?>" method="post" style="display:inline;">
            	<select height=24 class="category" name="category">
                	<option value="">Choose a Category</option>
                	<option <? if($this->input->post('category')=='favorite_music_artists'){ echo 'selected="selected"';}?> value="favorite_music_artists">Favorite Music Artist</option>
                	<option <? if($this->input->post('category')=='favorite_heroes'){ echo 'selected="selected"';}?> value="favorite_heroes">Hero</option>
                	<option <? if($this->input->post('category')=='favorite_movies'){ echo 'selected="selected"';}?> value="favorite_movies">Favorite Movie</option>
                	<option <? if($this->input->post('category')=='favorite_tvshows'){ echo 'selected="selected"';}?> value="favorite_tvshows">Favorite Tv Show</option>
                	<option <? if($this->input->post('category')=='favorite_sports_teams'){ echo 'selected="selected"';}?> value="favorite_sports_teams">Favorite Sports Team</option>
                	<option <? if($this->input->post('category')=='favorite_video_games'){ echo 'selected="selected"';}?> value="favorite_video_games">Favorite Game</option>
                	<option <? if($this->input->post('category')=='favorite_books'){ echo 'selected="selected"';}?> value="favorite_books">Favorite Book</option>
                	<option <? if($this->input->post('category')=='favorite_foods'){ echo 'selected="selected"';}?> value="favorite_foods">Favorite Food</option>
                	<option <? if($this->input->post('category')=='organizations'){ echo 'selected="selected"';}?> value="organizations">Organization</option>
                	<option <? if($this->input->post('category')=='workplaces'){ echo 'selected="selected"';}?> value="workplaces">Workplace</option>
                	<option <? if($this->input->post('category')=='greeks'){ echo 'selected="selected"';}?> value="greeks">Greeks</option>
                	<option <? if($this->input->post('category')=='courses'){ echo 'selected="selected"';}?> value="courses">Course</option>
                	<option <? if($this->input->post('category')=='majors'){ echo 'selected="selected"';}?> value="majors">Major</option>
                	<option <? if($this->input->post('category')=='highschool'){ echo 'selected="selected"';}?> value="highschool">High School</option>
                	<option <? if($this->input->post('category')=='languages'){ echo 'selected="selected"';}?> value="languages">Language</option>
                	<option <? if($this->input->post('category')=='nationalities'){ echo 'selected="selected"';}?> value="nationalities">Nationality</option>
                	<option <? if($this->input->post('category')=='class'){ echo 'selected="selected"';}?> value="class">Class Year</option>
                </select>
            	<input name="term" class="term" type="text" value="<?=$this->input->post("term")?>" title="search similarities" />
                <input class="submit" type="submit" value="search!" />
            </form>
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
                	<input type="hidden" id="uid" value="<?=$u['user']['uid']?>" />
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
                    
                <img class="img" src="./user_images/<? if(isset($u['pic']['filename']) && file_exists('user_images/'."thumb_".$u['pic']['filename'])){ echo "thumb_".$u['pic']['filename'];} else { echo "thumb_default.jpg";}?>" />
                <ul class="inner">
                	<li><a href="javascript:void(0)">Personal Information</a>
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
                     <li><a href="javascript:void(0)">Academics </a>
                    <ul class="inner_most">
                        	<li class="title">Major</li>
                            	<li class="data"><?=implode(", ",$u['majors'])?></li>
                            <li class="title">Classes</li>
                            	<li class="data"><?=implode("<br />",$u['courses'])?></li>
                        </ul>
                    <li><a href="javascript:void(0)">Organizations</a>
                    <ul class="inner_most">
                        	<li class="title">Organization</li>
                            <li class="data"><?=implode(", ",$u['organizations'])?></li>
                            <li class="title">Greek Life</li>
                            <li class="data"><?=implode(", ",$u['greeks'])?></li>
                            <li class="title">Workplace</li>
                            <li class="data"><?=implode(", ",$u['workplaces'])?></li>
                           
                        </ul></li>
                    <li><a href="javascript:void(0)">Interests </a>
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
                            <li class="title">Favorite Games</li>
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
	<div id="request_success" style="display:none; text-align:center;"> Request sent successfully </div>
	<div id="request_failed" style="display:none; text-align:center;"> Request failed to send </div>
    <form id="video_request" name="video_request" action="javascript:send_request();" method="post">
    	<input type="hidden" id="uid" value="21" />
        <ul id="form">
            <li class="lbl">User Name:</li>
            <li class="input"><input type="text" class="txt_small" value="" id="user_name" readonly="readonly" /></li>
            <li class="lbl">Your Message: </li>
            <li class="input"><textarea id="message" name="message" class="txt_area" cols="35" rows="4"></textarea></li>
            <li class="lbl">&nbsp;</li>
            <li class="input"><input type="submit" value="Send" class="btn" />&nbsp;&nbsp;<input type="button" value="Cancel" id="close" class="btn" /></li>
        </ul>
    </form>
</div>     
     
</body>
</html>
