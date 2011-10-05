<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ZingBerry - 404 Page Not Found</title>
<base href="<?php echo $this->config->item('base_url') ?>" />
<link href="style.css" rel="stylesheet" type="text/css" /> 
<script src="scripts/jquery-1.5.2.min.js" type="text/javascript"></script>
<style type="text/css">

#error content  {
border:				#999 1px solid;
background-color:	#fff;
padding:			20px 20px 12px 20px;
}

h1 {
font-weight:		normal;
font-size:			14px;
color:				#990000;
margin:				0 0 4px 0;
}
</style>
</head>

<body>
	
	<div id="header">
    	<div class="container">
        		<div id="logo_name">
               		<a href="<?=site_url('/')?>"><img src="images/logo_name.png" border="0" width="264" height="100" /></a>
                </div>
                <?php if(!$this->session->userdata('uid')){?>
                	<?php if(isset($login_errors)){?>
                        <div id="login_error"><?=$login_errors?></div>
                    <?php } ?>
                    <div id="login">
                        <?=$login_form['open']?>
                        Email: <?=$login_form['email']?><br />
                        Password: <?=$login_form['password']?><br />
                        <?=$login_form['submit']?>
                        <?=$login_form['close']?>
                    </div>
                <?php } else {?>    
                    <div id="account">
                        <ul id="account_menu">
                            <?php $this->load->helper('url');?>
                            <li><a href="<?=site_url('account')?>">Account</a></li>
                            <li><a href="<?=site_url('account/logout')?>">Logout</a></li>
                        </ul>
                    </div>
                <?php } ?>
                
        </div>
    </div>
    


	<div id="main">
    	<div class="container">
    		<img id="logo_pic" src="images/logo_pic.png" width="76" height="76" />
            <div id="block_content">
            		<div id="content">
                        <h1><?php echo $heading; ?></h1>
                        <?php echo $message; ?>
                    </div>
            </div>
        </div>
    </div>
    
    <div id="footer">
        <div class="container">
        	<ul id="menu">
            	<?php $this->load->helper('url');?>
            	<li><a href="<?=site_url('zing/about')?>">About Us</a></li>
            	<li><a href="<?=site_url('zing/support')?>">Support</a></li>
            	<li><a href="<?=site_url('zing/feedback')?>">Site Feedback</a></li>
            	<li><a href="<?=site_url('zing/careers')?>">Careers</a></li>
            	<li><a href="<?=site_url('zing/contact')?>">Contact Us</a></li>
            	<li><a href="<?=site_url('zing/terms')?>">Terms &amp; Conditions</a></li>
            </ul>
        </div>
    </div>
    
</body>
</html>