<?
	include "/home/myss/www/module/login/head.php";
	include "/home/myss/www/module/class/class.DbCon.php";
	include "/home/myss/www/module/class/class.Msg.php";
	include "/home/myss/www/module/class/class.Util.php";
	include '/home/myss/www/module/enc_func.php';
	include '/home/myss/www/module/lib.php';

	$GBL_USERID = 'iweb';
?>


<head>
<?
	include '/home/myss/www/module/login/metaTag.php';
?>



    <!-- Custom fonts for this template-->
    <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<!--     <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"> -->

    <!-- Custom styles for this template-->
    <link href="/css/header.css?v=<?=time()?>" rel="stylesheet">
    <link href="/css/footer.css" rel="stylesheet">
	<link href="/css/main.css?v=<?=time()?>" rel="stylesheet">
	<link href="/css/sub.css?v=<?=time()?>" rel="stylesheet">


	<link href="/css/font.css" rel="stylesheet">


    <!-- Custom styles for this page -->
    <link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

	<!-- Bootstrap core JavaScript-->
	<script src="/vendor/jquery/jquery.min.js"></script>
	<script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


	<!-- Core plugin JavaScript-->
	<script src="/vendor/jquery-easing/jquery.easing.min.js"></script>

	<!--chart.js -->
	<script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
	
	<!-- 	<script type="text/javascript" src="http://unpkg.com/chart.js-plugin-labels-dv/dist/chartjs-plugin-labels.min.js"></script> -->

	<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0/chartjs-plugin-datalabels.min.js" integrity="sha512-R/QOHLpV1Ggq22vfDAWYOaMd5RopHrJNMxi8/lJu8Oihwi4Ho4BRFeiMiCefn9rasajKjnx9/fTQ/xkWnkDACg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	<script src="/js/tableSort.js"></script>




<!-- 	highchart
	<script src="https://code.highcharts.com/stock/highstock.js"></script>
	<script src="https://code.highcharts.com/highcharts-more.js"></script>
	<script src="https://code.highcharts.com/stock/modules/data.js"></script>
	<script src="https://code.highcharts.com/stock/indicators/indicators-all.js"></script>
	<script src="https://code.highcharts.com/stock/modules/drag-panes.js"></script>
	<script src="https://code.highcharts.com/modules/annotations-advanced.js"></script>
	<script src="https://code.highcharts.com/modules/price-indicator.js"></script>
	<script src="https://code.highcharts.com/modules/full-screen.js"></script>
	<script src="https://code.highcharts.com/modules/stock-tools.js"></script>
	<script src="https://code.highcharts.com/stock/modules/heikinashi.js"></script>
	<script src="https://code.highcharts.com/stock/modules/hollowcandlestick.js"></script>
	<script src="https://code.highcharts.com/modules/accessibility.js"></script>
	<script src="https://code.highcharts.com/stock/modules/series-label.js"></script>
	<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/stock/modules/export-data.js"></script>
	<script src="https://code.highcharts.com/stock/modules/accessibility.js"></script>
	
	<link rel="stylesheet" type="text/css" href="https://code.highcharts.com/css/annotations/popup.css">
	<link rel="stylesheet" type="text/css" href="https://code.highcharts.com/css/stocktools/gui.css"> -->

	<!--highchart-->
	<script src="/module/js/highchart/highstock.js"></script>
	<script src="/module/js/highchart/highcharts-more.js"></script>
	<script src="/module/js/highchart/data.js"></script>
	<script src="/module/js/highchart/indicators-all.js"></script>
	<script src="/module/js/highchart/drag-panes.js"></script>
	<script src="/module/js/highchart/annotations-advanced.js"></script>
	<script src="/module/js/highchart/price-indicator.js"></script>
	<script src="/module/js/highchart/full-screen.js"></script>
<!-- 	<script src="/module/js/highchart/stock-tools.js"></script> -->
	<script src="/module/js/highchart/heikinashi.js"></script>
	<script src="/module/js/highchart/hollowcandlestick.js"></script>
	<script src="/module/js/highchart/accessibility.js"></script>
	<script src="/module/js/highchart/series-label.js"></script>
	<script src="/module/js/highchart/exporting.js"></script>
	<script src="/module/js/highchart/export-data.js"></script>

	<link rel="stylesheet" type="text/css" href="/module/js/highchart/highchart_popup.css">
	<link rel="stylesheet" type="text/css" href="/module/js/highchart/highcharts_gui.css">

	<!-- Ubuntu -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;700&display=swap" rel="stylesheet">

	<!--slick-->
	<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css">

	<!--linearicons-->
	<link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
	<!-- font awesome -->
	  <link
		rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css"
	  />

	<script src="/module/js/common.js?v=1.8"></script>
	<script src="/module/popupoverlay/jquery.popupoverlay.js"></script>
	<link href="/module/popupoverlay/popupoverlay.css" rel="stylesheet">

	<link type='text/css' rel='stylesheet' href='/module/js/placeholder.css?v=1'><!-- 웹킷브라우져용 -->
	<script src="/module/js/jquery.placeholder.js"></script><!-- placeholder 태그처리용 -->
	<script src="/js/script.js"></script>
	<link rel="stylesheet" type="text/css" href="/css/button.css?v=1.1">

</head>