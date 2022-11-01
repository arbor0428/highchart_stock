<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

<style>
.ui-menu-item{padding-left:5px;width:90% !important;}
.ui-corner-all{font-size:1rem;color:#6e707e !important;}

.timepicker{
	background:url('/img/clock.png') no-repeat;
	background-color:#fff !important;
	background-position:calc(100% - 5px) center;
	cursor:pointer;
}
</style>

<script>
$(function(){
	$('.timepicker').timepicker({
		timeFormat: 'HH:mm',
		interval: 30,
		minTime: '00',
		maxTime: '23:50pm',
//		defaultTime: '11',
//		startTime: '10:00',
		dynamic: false,
		dropdown: true,
		scrollbar: true,

	});
});
</script>