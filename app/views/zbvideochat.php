<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<base href="<?php echo $this->config->item('base_url'); ?>" />
		<link href="css/reset.css" type="text/css" media="all" rel="stylesheet" />
		<link href="css/style.css" type="text/css" media="all" rel="stylesheet" />

		<!--<script type="text/javascript" src="js/jquery_003.js"></script>-->
		<script src="scripts/jquery-1.5.2.min.js" type="text/javascript"></script>
		<script type="text/javascript" src="js/blur.js"></script>

		<!-- Scripts for generating the tooltips -->
		<script type="text/javascript" src="scripts/balloon.config.js"></script>
		<script type="text/javascript" src="scripts/balloon.js"></script>
		<script type="text/javascript" src="scripts/box.js"></script>
		<script type="text/javascript" src="scripts/yahoo-dom-event.js"></script> 
		<script type="text/javascript">
			// white balloon with default configuration
			var balloon = new Balloon;
			BalloonConfig(balloon,'GBubble');

			// plain balloon tooltip
			var tooltip = new Balloon;
			BalloonConfig(tooltip,'GPlain');
			
			// fading balloon
			var fader = new Balloon;
			BalloonConfig(fader,'GFade');   

			// a plainer popup box
			var box = new Box;
			BalloonConfig(box,'GBox');

			// a box that fades in/out
			var fadeBox     = new Box;
			BalloonConfig(fadeBox,'GBox');
			fadeBox.bgColor     = 'black';
			fadeBox.fontColor   = 'white';
			fadeBox.borderStyle = 'none';
			fadeBox.delayTime   = 200;
			fadeBox.allowFade   = true;
			fadeBox.fadeIn      = 750;
			fadeBox.fadeOut     = 200;
			
			balloon.delayTime = 250;
		</script>

		<script type="text/javascript">	
			$(function(){ 
				//<!-- find all the input elements with title attributes-->
				$('input[title!=""]').hint();
			});

			$(document).ready(function() {
				$(".topMenuAction3").click( function() 
				{
					if ($("#openCloseIdentifier3").is(":hidden")) 
					{
						$("#slider3").animate({ 
						marginLeft: "-280px"
						}, 500 );
						$("#openCloseIdentifier3").show();
					} 
					else 
					{
						$("#slider3").animate({ 
						marginLeft: "0px"
						}, 500 );

						$("#openCloseIdentifier3").hide();
					}
				}); 
				
				$(".topMenuAction4").click( function() 
				{
					if ($("#openCloseIdentifier4").is(":hidden")) 
					{
						$("#slider4").animate({ 
						marginLeft: "-280px"
						}, 500 );

						$("#openCloseIdentifier4").show();
					} 
					else 
					{
						$("#slider4").animate({ 
						marginLeft: "0px"
						}, 500 );

						$("#openCloseIdentifier4").hide();
					}
				}); 
			});

			//<!-- Define arrays for handling chat request info: source, date, message -->
			
		</script>

		<!-- Enable Browser History by replacing useBrowserHistory tokens with two hyphens -->
		<!-- BEGIN Browser History required section -->
		<link rel="stylesheet" type="text/css" href="cirrusapp/history/history.css" />
		<script type="text/javascript" src="cirrusapp/history/history.js"></script>
		<!-- END Browser History required section -->         

		<script type="text/javascript" src="scripts/swfobject.js"></script>
		<script type="text/javascript">
			var randomNumber = Math.floor(Math.random()*10000000);
			var myDate = new Date();
			var randStr = randomNumber + myDate.getTime();		
			<!--
			// For version detection, set to min. required Flash Player version, or 0 (or 0.0.0), for no version detection. 
			var swfVersionStr = "10.2.0";
			// To use express install, set to playerProductInstall.swf, otherwise the empty string. 
			var xiSwfUrlStr = "cirrusapp/playerProductInstall.swf";
			var flashvars = {};
			flashvars.uid = "<?=$uid?>"; // "commnad-line-style" argument to automatically connect with this user id
			flashvars.name = "<?php
								echo $firstname . ' ' . $lastname; ?>"; // "commnad-line-style" argument to automatically set the user's name
			// check if the target user is defined and set accordingly
			flashvars.tuid = "<?php 
				if (isset($tuid) && isset($t_firstname) && isset($t_lastname))				
					echo $tuid;?>";
			flashvars.tname = "<?php 
				if (isset($tuid) && isset($t_firstname) && isset($t_lastname))				
					echo $t_firstname . ' ' . $t_lastname;?>";
			var params = {};
			params.wmode ="transparent";
			params.quality = "high";			
			params.allowscriptaccess = "sameDomain";
			params.allowfullscreen = "true";
			var attributes = {};
			attributes.id = "VideoChatSample";
			attributes.name = "VideoChatSample";
			attributes.align = "middle";
			swfobject.embedSWF(
				"cirrusapp/VideoChatSample.swf?" + randStr, "flashContent", 
				"520", "630", 
				swfVersionStr, xiSwfUrlStr, 
				flashvars, params, attributes);
			swfobject.createCSS("#flashContent", "z-index:-1; position:absolute; display:none; text-align:center; width:525px; margin:auto;");

			<!-- Function for deregistering the user when they move away from the page (Requires jQuery) -->
			function doUnregistration()
			{
				$.get("http://dev.zingberry.com/index.php/cirrus",
					{username : '<?=$uid?>', identity : '0'});
			}

			// variable for setting request refresh rate
			var requestsTimeout = 30*1000;
			var fetchRequestsTimer = null;
			var updateStatusDelay = 30*1000;
			var updateStatusTimer = null;
			$(document).ready(function(){
				// set function to unregister on exit
				$(window).bind("beforeunload", function(e) {
					doUnregistration();
				});
				
				// fetch initial set of requests - self-calling timer
				fetchChatRequests();			
				// set up timer for automatically refreshing online status
				updateStatusTimer = setTimeout("refreshOnlineStatus()", updateStatusDelay);				
			});

			
			// update online status using AJAX		
			var refreshRequestObj = null;
			function refreshOnlineStatus()
			{							
				$.ajax({
					type: "POST",
					url: "<?=site_url('video/updateOnlineStatus')?>", 
					success: function(msg){
						// parse JSON string
						refreshRequestObj = eval(msg);
						if (refreshRequestObj == null)
						{							
							alert("Lost communication with the server. Check your internet connection and reload the page.");
						}											
					}
				});
				
				// set timer for next refresh of online status
				updateStatusTimer = setTimeout("refreshOnlineStatus()", updateStatusDelay);
			}
			
			
			function getMyApp(movieName) 
			{
				var isIE = navigator.appName.indexOf("Microsoft") != -1;
				return (isIE) ? window[movieName] : document[movieName];
			}

			function makeTestJSCallToNick()
			{
				// call flash method to make test call	
				getMyApp("VideoChatSample").callUser_JS("32", "Nicholas Michael");
			}
					
			function makeJSVideoCall(target_uid, target_name)
			{
				// call flash method to start video call to given user
				getMyApp("VideoChatSample").callUser_JS(target_uid, target_name);
			}				
			
			// global variable for counting number of pending chat requests
			var numOfRequests = 0;
			
			// send AJAX request to remove request
			// on success the request with id listElementId is removed from the list
			function deleteChatRequest(ruid, listElementId)
			{
				// confirm that user wants to delete request
				var r=confirm("Are you sure you want to remove this chat request?");
				if (r==true)
				{					
					// first send AJAX request to delete request
					$.ajax({
						type: "POST",
						url: "<?=site_url('videorequest/delsingle')?>/" + ruid, 
						success: function(msg){
							// check response
							var tmpResponseObj = eval(msg);
							if (tmpResponseObj != null)
							{
								if (tmpResponseObj.numdeleted > 0)
								{
									// get handle to list
									var chatList = document.getElementById("chat_request_list");
									// get handle to child list element
									var listItem = document.getElementById(listElementId);
									// remove child element
									chatList.removeChild(listItem);
									numOfRequests--;
									if (numOfRequests < 1)
									{					
										chatList.innerHTML = "<li>You have no pending requests at this time.</li>";
									}
								}
								else
								{
									alert("Could not remove given request at this time.");
								}
							}
							else
							{
								alert("Could not remove given request at this time.");
							}
						}
					});
				}
			}
			
			// send AJAX request to remove all pending request
			// on success all requests are removed from the list
			function deleteAllChatRequests()
			{
				// confirm that user wants to delete request
				var r=confirm("Are you sure you want to remove ALL pending chat request?");
				if (r==true)
				{					
					// first send AJAX request to delete request
					$.ajax({
						type: "POST",
						url: "<?=site_url('videorequest/delall')?>", 
						success: function(msg){
							// check response
							var tmpResponseObj = eval(msg);
							if (tmpResponseObj != null)
							{
								if (tmpResponseObj.numdeleted > 0)
								{
									// get handle to list
									var chatList = document.getElementById("chat_request_list");
									// remove child element
									numOfRequests--;
									chatList.innerHTML = "<li>You have no pending requests at this time.</li>";									
								}
								else
								{
									alert("Could not delete all pending requests at this time.");
								}
							}
							else
							{
								alert("Could not delete all pending requests at this time.");
							}
						}
					});
				}
			}
			
			
			// check for new requests using AJAX		
			var requestObj = null;
			var htmlStr = "";			
			function fetchChatRequests()
			{							
				$.ajax({
					type: "POST",
					url: "<?=site_url('videorequest/lookupbytarget/1/1')?>", // change to fetch online only
					success: function(msg){
						// parse JSON string
						requestObj = eval(msg);
						numOfRequests = 0;
						htmlStr = ""; // reset html string
						if (requestObj != null)
						{							
							// now populate the chat request panel							
							for (var i in requestObj)
							{
								htmlStr += "<li id=\"request_" + requestObj[i].requestor_uid + "\"><a href='javascript:void(0)'><span onmouseover=\"balloon.showTooltip(event,'" 
									+ requestObj[i].request_message + "',0)\">"
									+ requestObj[i].firstname + " " + requestObj[i].lastname 
									+ " " + requestObj[i].date_requested + "</span></a>"
									+ "<a href='javascript:deleteChatRequest(\"" + requestObj[i].requestor_uid + "\", \"request_" + requestObj[i].requestor_uid + "\");'><img src='<?=site_url('images')?>/delete_request.png' alt='Remove request'/></a>&nbsp;"
									+ "<a href='javascript:makeJSVideoCall(\"" + requestObj[i].requestor_uid + "\", \"" + requestObj[i].firstname + " " + requestObj[i].lastname + "\");'><img src='<?=site_url('images')?>/accept_request.png' alt='Accept request'/></a>";
								htmlStr += "</li>";	
								numOfRequests++;
							}
							htmlStr += "<br><li><a href='javascript:deleteAllChatRequests();'>Delete ALL!</a></li>";
						}
						else
						{							
							htmlStr = "<li>You have no pending requests at this time.</li>";
						}
						
						// change inner html to show the requests
						$("#chat_request_list").html(htmlStr);						
					}
				});
				
				// set timer for next refresh of chat requests
				fetchRequestsTimer = setTimeout("fetchChatRequests()", requestsTimeout);
			}
			
			//-->
		</script>

		<title>Zingberry - <?=$title?></title>
	</head>

	<body onbeforeunload="doUnregistration()">
		<div id="content">
			<div id="header">
				<a href="<?=site_url("account/logout")?>" class="log_out" title="Logout">&nbsp;</a>
				<a href="<?=site_url("browse")?>" title="Zingberry!"><img src="images/mini_logo.png" alt="Zingberry!" /></a>
				<ul>
					<li><a class="video" alt="Call Nicholas (32)" onclick="makeTestJSCallToNick();" 
							onmouseover="balloon.showTooltip(event,'Click to make a test call to Nicholas',0,250)">&nbsp;</a></li>
					<li><a href="<?=site_url("account")?>" class="user">&nbsp;</a></li>
				</ul>
			</div>

			<div id="bodyVideoChat">
				<!-- Insert Video Chat Flash App -->
				<div id="flashContent">
					<p>
						To view this page ensure that Adobe Flash Player version 
						10.2.0 or greater is installed. 
					</p>
					<script type="text/javascript"> 
						var pageHost = ((document.location.protocol == "https:") ? "https://" : "http://"); 
						document.write("<a href='http://www.adobe.com/go/getflashplayer'><img src='" 
						+ pageHost + "www.adobe.com/images/shared/download_buttons/get_flash_player.gif' alt='Get Adobe Flash player' /></a>" ); 
					</script> 
				</div>

				<noscript>
					<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="520" height="630" id="VideoChatSample">
						<param name="movie" value="cirrusapp/VideoChatSample.swf" />
						<param name="quality" value="high" />						
						<param name="allowScriptAccess" value="sameDomain" />
						<param name="allowFullScreen" value="true" />
						<param name="wmode" value="transparent"/>
						<!--[if !IE]>-->
						<object type="application/x-shockwave-flash" data="cirrusapp/VideoChatSample.swf" width="520" height="630">
							<param name="wmode" value="transparent">
							<param name="quality" value="high" />
							<param name="bgcolor" value="#cfec69" />
							<param name="allowScriptAccess" value="sameDomain" />
							<param name="allowFullScreen" value="true" />
							<!--<![endif]-->
							<!--[if gte IE 6]>-->
							<p> 
								Either scripts and active content are not permitted to run or Adobe Flash Player version
								10.2.0 or greater is not installed.
							</p>
							<!--<![endif]-->
							<a href="http://www.adobe.com/go/getflashplayer">
								<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash Player" />
							</a>
							<!--[if !IE]>-->
						</object>
						<!--<![endif]-->
					</object>
				</noscript>				
			</div>	

			<div id="footer">
				<ul>       
					<li><a href="<?=site_url("about")?>">about</a></li>
					<li><a href="<?=site_url("support")?>">support</a></li>
					<li><a href="<?=site_url("careers")?>">careers</a></li>
					<li><a href="<?=site_url("tos")?>">terms &amp; conditions</a></li>
					
				</ul>
			</div>			
		</div>	
		
		<div id="sliderWrap3">
			<div id="openCloseIdentifier3">
			</div>
			
			<div id="slider3">
				<div id="sliderContent3">
					<ul class="ac_set">
						<li><a href="javascript:void(0)">Personal Info</a></li>
						<li><a href="javascript:void(0)">Academics</a>
							<ul>
								<li><a href="javascript:void(0)">Academics</a></li>
								<li><a href="javascript:void(0)">Organizations</a></li>
								<li><a href="javascript:void(0)">Interests</a></li>
								<li><a href="javascript:void(0)">Organizations</a></li>
								<li><a href="javascript:void(0)">Interests</a></li>
							</ul>
						</li>
						<li><a href="javascript:void(0)">Organizations</a></li>
						<li><a href="javascript:void(0)">Interests</a>
							<ul>
								<li><a href="javascript:void(0)">Academics</a></li>
								<li><a href="javascript:void(0)">Organizations</a></li>
								<li><a href="javascript:void(0)">Interests</a></li>
							</ul>
						</li>
					</ul>
				</div>
				<div id="openCloseWrap3">
					<a href="javascript:void(0)" class="topMenuAction3" id="topMenuImage3">&nbsp;</a>
				</div>
			</div>
		</div>

		<div id="sliderWrap4">			
			<div id="openCloseIdentifier4">
			</div>
			
			<div id="slider4">			
				<div id="sliderContent4">
					<ul class="ac_set2" id="chat_request_list">
						<li>Searching for any pending video requests...</li>					
					</ul>
				</div>

				<div id="openCloseWrap4">
					<a href="javascript:void(0)" class="topMenuAction4" id="topMenuImage4">&nbsp;</a>
				</div>
			</div>
		</div>
	</body>
</html>
