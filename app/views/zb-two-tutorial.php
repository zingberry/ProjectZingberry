<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<base href="<?php echo $this->config->item('base_url') ?>" />
<link href="css/reset.css" type="text/css" media="all" rel="stylesheet" />
<link href="css/style.css" type="text/css" media="all" rel="stylesheet" />

<script type="text/javascript" src="js/jquery_003.js"></script>
<script type="text/javascript" src="js/slideshow.js"></script>


<title>Tutorial</title>
</head>
<body onload="setUpSlideShow()">
	<div id="content">
      	<div id="slideshow"><div id="slides"><div class="slide"><img src="images/tutorial1.png" width="826" height="305"/>Slide content 1</div><div class="slide"><img src="images/tutorial2.png" width="826" height="305"/>Slide content 2</div><div class="slide"><img src="images/tutorial3.png" width="826" height="305"/>Slide content 3</div><div class="slide"><img src="images/tutorial4.png" width="826" height="305"/>Slide content 4</div><div class="slide"><img src="images/tutorial5.png" width="826" height="305"/>Slide content 5</div><div class="slide"><img src="images/tutorial6.png" width="826" height="305"/>Slide content 6</div></div><div id="slides-controls"><a href="javascript:void(0)">1</a> <a href="javascript:void(0)">2</a> <a href="javascript:void(0)">3</a> <a href="javascript:void(0)">4</a> <a href="javascript:void(0)">5</a> <a href="javascript:void(0)">6</a></div></div>
        <form action="<?=site_url("account/picture")?>">
        <input type="submit" class="btn" value="Done!" />
        </form>
         
		</div>
    
</div>
</body>
</html>

