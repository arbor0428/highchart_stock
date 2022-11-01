<style>
#loading {
	width: 100%;
	height: 100%;
	top: 0;
	left: 0;
	position: fixed;
	opacity: 0.6;
	z-index: 99;
	text-align: center;
	background:#999;
}

.loader {
	opacity: 1;
	border: 16px solid #f3f3f3;
	border-top: 16px solid #3498db;
	border-radius: 50%;
	width: 120px;
	height: 120px;
	animation: spin 2s linear infinite;
	position: fixed;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
}

@keyframes spin {
	0% {transform: translate(-50%, -50%) rotate(0deg);}
	100% {transform: translate(-50%, -50%) rotate(360deg);}
}
</style>

<div id='loading'>
	<div class="loader"></div>
</div>

<script>
$(document).ready(function(){
	$("#loading").delay("200").fadeOut();
});
</script>