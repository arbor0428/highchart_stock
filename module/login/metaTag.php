<?
if($_SERVER['SERVER_PORT'] == '443'){
	$siteShortcut = "https://".$_SERVER['HTTP_HOST']."/img/imgone.png";
}else{
	$siteShortcut = "http://".$_SERVER['HTTP_HOST']."/img/imgone.png";
}
?>


<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--link rel="shortcut icon" href="/img/favicon.ico"-->


<meta property="og:title" content="마이셀프스탁">
<meta property="og:type" content="website">
<meta property="og:image" content="<?=$siteShortcut?>">
<meta property="og:description" content="마이셀프스탁">

<title>마이셀프스탁</title>