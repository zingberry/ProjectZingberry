<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ZingBerry - <?=$title?></title>
<base href="<?php echo $this->config->item('base_url') ?>" />
<link href="style.css" rel="stylesheet" type="text/css" /> 
<script src="scripts/jquery-1.5.2.min.js" type="text/javascript"></script>
<?php if($title=='Home'){?>
<script src="scripts/home.js" type="text/javascript"></script>
<?php } ?>

<?php if($this->config->item('release')=='stable'){?>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-22749373-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<?php } ?>

<?php if(isset($js)){ echo $js;}?>
</head>