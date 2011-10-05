<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php $this->load->view("header", $header); ?>
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
                        <?=$login_form['email']?><br />
                        <?=$login_form['password']?><br />
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
            <div id="events_content">
            <?php if($page=="account") { ?>
            Name: <?=$user['firstname']?> <?=$user['lastname']?><br /><br />
            Gender: <?=$user['gender']?><br /><br />
            Class: <?=$user['class']?><br /><br />
            Email: <?=$user['email']?><br /><br />
            	
            <?php }?>
            </div>
      </div>
    </div>
    
    
<?php $this->load->view("footer"); ?>

</body>
</html>