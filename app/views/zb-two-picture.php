<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<base href="<?php echo $this->config->item('base_url') ?>" />
<link href="css/reset.css" type="text/css" media="all" rel="stylesheet" />
<link href="css/style.css" type="text/css" media="all" rel="stylesheet" />
<link href="css/imgareaselect-animated.css" type="text/css" media="all" rel="stylesheet" />
<script type="text/javascript" src="js/jquery_003.js"></script>
<script type="text/javascript" src="js/blur.js"></script>
<script type="text/javascript" src="js/jquery.imgareaselect.pack.js"></script>
<script src="js/jquery.MultiFile.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
$(function(){ 
			    // find all the input elements with title attributes
				$('input[title!=""]').hint();
			});
$(document).ready(function() {
	
    <?php if(isset($large_image)){?>
	$('#save_thumb').click(function() {
		var x = $('#x').val();
		var y = $('#y').val();
		var w = $('#w').val();
		var h = $('#h').val();
		if(x=="" || y=="" || w=="" || h==""){
			alert("You must make a selection first");
			return false;
		}else{
			return true;
		}
	});
	
	$("#croptoggle").click(function(){
		$("#croppable").toggle();
	});
	<?php } ?>
	
	
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
	
<?php if(isset($large_image)){?>
	function preview(img, selection) { 
		var scaleX = <?php echo $thumb_width;?> / selection.width; 
		var scaleY = <?php echo $thumb_height;?> / selection.height; 
		
		$('#thumbnail + div > img').css({ 
			width: Math.round(scaleX * <?php echo $large_width;?>) + 'px', 
			height: Math.round(scaleY * <?php echo $large_height;?>) + 'px',
			marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px', 
			marginTop: '-' + Math.round(scaleY * selection.y1) + 'px' 
		});
		$('#x').val(selection.x1);
		$('#y').val(selection.y1);
		$('#w').val(selection.width);
		$('#h').val(selection.height);
	} 
	
	$(window).load(function () { 
		$('#thumbnail').imgAreaSelect({ aspectRatio: '1:1', onSelectChange: preview }); 
	});


<?php }?>
	
		
</script>



<title>Zingberry! Account- Picture</title>
<?php $this->load->view('google-analytics'); ?>
</head>

<body>
	<div id="content">
    	<div id="header">
        	<a href="<?=site_url("account/logout")?>" class="log_out" title="Logout">&nbsp;</a>
        	<a href="<?=site_url("/")?>" title="Zingberry!"><img src="images/mini_logo.png" alt="Zingberry!" /></a>
            <ul>
            	<li><a href="<?=site_url("video")?>" class="video" title="Video Chat">&nbsp;</a></li>
            	<li><a href="<?=site_url("browse")?>" class="browse" title="Browse">&nbsp;</a></li>
                <li><a href="<?=site_url("account/picture")?>" class="user" title="Account">&nbsp;</a></li>
            </ul>
        </div>
    	
        <div id="body">
        	<h2>Display Picture</h2>
            <?php if(isset($thumb_image) && isset($upload_folder) && file_exists($upload_folder.$thumb_image)){ ?>
                Current Pic:<br />
                <img src="<?=$upload_folder.$thumb_image?>" />
            <?php } ?>
            <br />
        	<?php if(isset($large_image)){?>
                <?php if(file_exists($upload_folder.$thumb_image)){?><button id="croptoggle"> Crop Pic </button><?php } ?>
                <div id="croppable" <?php if(file_exists($upload_folder.$thumb_image)){?>style="display:none;"<?php } ?>>
                    <form name="thumbnail" action="<?=site_url('account/picture')?>" method="post">
                        <img src="<?=$upload_folder.$large_image?>" style="float: left; margin-right: 10px;" id="thumbnail" alt="Create Thumbnail" />
                        <div style="border:1px #e5e5e5 solid; float:left; position:relative; overflow:hidden; width:<?=$thumb_width?>px; height:<?=$thumb_height?>px;">
                            <img src="<?=$upload_folder.$large_image?>" style="position: relative;" alt="Thumbnail Preview" />
                        </div>
                        <input type="hidden" name="x" value="" id="x" />
                        <input type="hidden" name="y" value="" id="y" />
                        <input type="hidden" name="w" value="" id="w" />
                        <input type="hidden" name="h" value="" id="h" />
                        <input type="submit" name="upload_thumbnail" value="Save Thumbnail" id="save_thumb" />
                    </form>
                </div>
				<br />
         	<?php } ?>
        	<form name="frm_login" action="<?=site_url('account/picture')?>" method="post" enctype="multipart/form-data">
                <ul class="form_account">
                    <li>Upload a New Picture</li>
                    <?php if(isset($upload_error)){echo '<li style="color:red;">'.$upload_error."</li>";}?>
                    <li><input type="file" name="userfile" class="multi" accept="gif|jpg|png" maxlength="1"/></li>
                    <li><input type="submit" name="upload" value="Upload" class="btn"/></li>
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
                    <li><a href="<?=site_url("account/picture")?>" class="active">Picture</a></li>
                    <li><a href="<?=site_url("account")?>">Personal Info</a></li>
                    <li><a href="<?=site_url("account/academics")?>">Academics</a></li>
                    <li><a href="<?=site_url("account/organizations")?>">Organizations</a></li>
                    <li><a href="<?=site_url("account/interests")?>">Interests</a></li>
                </ul>
			</div>
			<div id="openCloseWrap1">
				<a href="javascript:void(0)" class="topMenuAction1" id="topMenuImage1">&nbsp;
				</a>
			</div>
		</div>
     </div>
     
     
</body>
</html>
