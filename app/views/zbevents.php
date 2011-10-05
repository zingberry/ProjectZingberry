<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php $this->load->view("header", $header); ?>
<?php if($page=="events"){ ?>
	<script src="scripts/jquery.json-2.2.min.js"></script>
	<script type="text/javascript">
        $(function() {
			var searchdata = Object();
			
			
			$(window).scroll(function(){
				if  ($(window).scrollTop() == $(document).height() - $(window).height()){
				   lastPostFunc();
				}
			});
			
			function lastPostFunc() 
			{ 
				//$('div#lastPostsLoader').html('<img src="images/ajax-loader.gif">');
				$('.event:last').after('<div id="lastPostsLoader" style="margin-right:20px; margin-bottom:20px; float:left; width:150px; height:220px;"><img src="images/ajax-loader.gif"></div>');
				searchdata.searchterm = $("#searchbox").val();
				searchdata.page = $(".event:last").attr("id");
				searchdata.cats = "";
				$("input:checkbox:checked").each(function(elm,index){
					searchdata.cats = searchdata.cats+$(this).attr("id")+' ';
				});
				$.post("<?=site_url('events/events_ajax')?>",searchdata,function(data){
					if (data != "") {
						$(".event:last").parent().after(data);            
					}
					$('div#lastPostsLoader').remove();
				});
			};
			
			
			$("#cats").load("<?=site_url('events/cats')?>",function(){
				
				searchdata.searchterm = "";
				searchdata.page = 0;
				searchdata.cats = "";
				$("input:checkbox:checked").each(function(elm,index){
					searchdata.cats = searchdata.cats+$(this).attr("id")+' ';
				});
				$("#events_content").load("<?=site_url('events/events_ajax')?>",searchdata);
				
				
				$("input:checkbox").click(function(){
					searchdata.searchterm = $("#searchbox").val();
					searchdata.page = 0;
					searchdata.cats = "";
					$("input:checkbox:checked").each(function(elm,index){
						searchdata.cats = searchdata.cats+$(this).attr("id")+' ';
					});
					$.post("<?=site_url('events/events_ajax')?>",searchdata,function(data){
						$("#events_content").html(data);
						//alert(getCats());
					});
				});
				
			});
			
			
			
        });
		
    </script>
<?php }?>
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
                <?php if($page=="events") { ?>
    				<img id="event_browser_pic" src="images/event_browser.png" width="210" height="50" />
                <?php } ?>
                
            <?php if($page=="events") { ?>
            	<script type="text/javascript">
					
				</script>
				
                <form id="searchbar">
                
                <div id="cats">
                </div>
                
                </form>
                
                	
                
            <?php } ?>
            <div id="events_content">
            <?php if($page=="events") { ?>
				
            <?php } else if($page=="details") {?>
            	<div id="event_details_pic">
            	<?php if(isset($pic['eiid'])){?>
                    <img src="eventimages/<?=$pic['filename']?>" width="120" height="120" />
                <?php } else {?>
                    <img src="eventimages/placeholder_<?=$details['catid']?>.png" width="120" height="120" />
                <?php }?>
                </div>
            
            	Name: <?=$details['eventname']?><br />
            	Start Time: <?=$details['startform']?><br />
            	End Time: <?=$details['endform']?><br />
            	Description: <?=$details['description']?><br /><br />
				Location:<br />
				<?=$details['street']?><br />
				<?=$details['city']?>, <?=$details['state']?> <?=$details['zipcode']?>

			<?php } else if($page=="map") {?>
				<?=$sidebar?>
            	<?=$onload?>
				<?=$map?>
            <?php } ?>
            </div>
      </div>
    </div>
    
    

<?php $this->load->view("footer"); ?>

</body>
</html>