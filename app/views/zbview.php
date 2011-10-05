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
                	
                    <script src="scripts/jquery.watermarkinput.js" type="text/javascript"></script>
                    <script src="scripts/jquery.qtip.pack.js" type="text/javascript"></script>
                    <link href="scripts/jquery.qtip.css" rel="stylesheet" type="text/css" /> 
                    <script type="text/javascript">
						$(function(){
							$("#email").Watermark("Rutgers Email");
							$("#password").Watermark("Password");
							$("#loginsubmit").mousedown(function(){
								$.Watermark.HideAll();
							});
							<?php if(isset($login_errors)){?>
                    
								$('#email').qtip({
								   content: '<?=$login_errors?>',
								   position: {
									  my: 'right center', 
									  at: 'left bottom'
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
		
		
								
							<?php } ?>
						});
						
					
						
					</script>
                    <div id="login">
                        <?=$login_form['open']?>
                        <?=$login_form['email']?><br />
                        <?=$login_form['password']?><br />
                        <a href="<?=site_url("account/forgotpassword")?>" style="font-size: 12px; color: white;">Forgot Password</a>
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
            	<?php if($page=='home'){?>
                    <img id="rutgers_students" src="images/Slogan-3.png" width="474" height="357" />
                    <img id="rutgers_community" src="images/rutgers_community.png" width="473" height="51" />
                    <img id="register_img" src="images/register.png" width="264" height="51" />
	  <div id="register">
                        <?=$register_form['open']?>
                        <table>
                        
                        <tr><td>First Name</td><td> <?=$register_form['firstname']?></td></tr>
                        <tr><td>Last Name</td><td><?=$register_form['lastname']?></td></tr>
                        <tr><td>Rutgers Email</td><td><?=$register_form['email']?></td></tr>
                        <tr><td>Password</td><td><?=$register_form['password']?></td></tr>
                        <tr><td>Confirm Password</td><td><?=$register_form['confirmpassword']?></td></tr>
                        <tr><td>Gender</td><td><?=$register_form['gender']?></td></tr>
                        <tr><td>Class Year</td><td><?=$register_form['class']?></td></tr>
                        </table>
                        <div id="register_errors">
                        <?php if(isset($register_errors)){?>
                        <ul>
							<?php foreach ($register_errors as $i => $reg_error){
									 if($i == 'count') continue;?>
                            	<li><?=$reg_error?></li>
                        	<?php } ?>
                        </ul>
						<?php } ?>
                        </div>
                        <?=$register_form['submit']?>
                        <?=$register_form['close']?>
                    </div>
                <?php } else if($page=='registered'){?>
                	<div id="success">
                	Thankyou for registering with Zingberry!<br /><br />
					Please verify your account by clicking the verification link that has been sent to your email: <?=$email?>
                    </div>
                <?php } else if($page=='verified'){?>
                	<div id="success">
                	Your email has been verified!<br /><br />
					Click here to login to Zingberry: <a href="<?=site_url('/')?>">Login</a>
                    </div>
                <?php } else { ?>
                
                <?php } ?>
                                
            	
            </div>
      </div>
    </div>
    
<?php $this->load->view("footer"); ?>    

</body>
</html>