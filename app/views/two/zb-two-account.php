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
</script>

<!--<title>Zingberry! Account Personal Information</title>-->
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
        	<h2>Personal Info</h2>
        	<form name="frm_login" action="#" method="post">
                <ul class="form_account">
                    <li>First Name</li>
                    <li><input type="text" value="<?=$user['firstname']?>" name="txt_name"/></li>
                    <li>Last Name</li>
                    <li><input type="text" value="<?=$user['lastname']?>" name="txt_name"/></li>
                    <li>Gender</li>
                    <li>
                    	<select name="sel_gender">
                        	<option value=""></option>
                            <option <? if($user['gender']=="m"){echo ' selected="selected" ';} ?> value="m">Male</option>
                            <option <? if($user['gender']=="f"){echo ' selected="selected" ';} ?> value="f">Female</option>
                        </select>
                    </li>
                    <li>Interested In</li>
                    <li>
                    	<select name="sel_interest">
                        	<option value=""></option>
                            <option <? if($user['interested_in']=="m"){echo ' selected="selected" ';} ?> value="m">Male</option>
                            <option <? if($user['interested_in']=="f"){echo ' selected="selected" ';} ?> value="f">Female</option>
                        </select>
                    </li>
                    <li>Relationship Status</li>
                    <li>
                    	<select name="sel_rel">
                        	<option value=""></option>
                            <option <? if($user['relationship_status']=="s"){echo ' selected="selected" ';} ?> value="s">Single</option>
                            <option <? if($user['relationship_status']=="r"){echo ' selected="selected" ';} ?> value="r">In A Relationship</option>
                        </select>
                    </li>
                    <li>Dorm Location</li>
                    <li><input type="text" name="txt_name1"/></li>
                    <li>Class Year</li>
                    <li><input type="text" name="txt_name1"/></li>
                    <li>High School</li>
                    <li><input type="text" name="txt_name1"/></li>
                    <li>Nationality</li>
                    <li><input type="text" name="txt_name1"/></li>
                    <li>Languages</li>
                    <li><input type="text" name="txt_name1"/></li>
                    <li>Religious Views</li>
                    <li><input type="text" name="txt_name1"/></li>
                    <li>Political Views</li>
                    <li><input type="text" name="txt_name2"/></li>
                     
                </ul>
            </form>
        </div>
    	
    </div>
    <div id="footer">
    	<ul>       
        	<li><a href="about.html">about</a></li>
            <li><a href="support.html">support</a></li>
            <li><a href="careers.html">careers</a></li>
            <li><a href="tos.html">terms &amp; conditions</a></li>
            
        </ul>
    </div>
    <div id="sliderWrap1">
    <div id="openCloseIdentifier1"></div>
		<div id="slider1">
			<div id="sliderContent1">
                <ul class="ac_set">
                    <li><a href="<?=site_url("account")?>" class="active">Personal Info</a></li>
                    <li><a href="<?=site_url("account/academics")?>">Academics</a></li>
                    <li><a href="<?=site_url("account/organizations")?>">Organizations</a></li>
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
