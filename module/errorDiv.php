<style>
.errorBox {
	width:50%;
	text-align:center;
    position: relative;
    min-height: 1em;
    margin: 5em auto;
    background: #f8f8f9;
    padding: 1em 1.5em;
    line-height: 1.4285em;
    color: rgba(0,0,0,.87);
    -webkit-transition: opacity .1s ease,color .1s ease,background .1s ease,-webkit-box-shadow .1s ease;
    -webkit-transition: opacity .1s ease,color .1s ease,background .1s ease,box-shadow .1s ease;
    transition: opacity .1s ease,color .1s ease,background .1s ease,box-shadow .1s ease;
    border-radius: .28571429rem;
    box-shadow: inset 0 0 0 1px rgb(34 36 38 / 22%), 0 0 0 0 transparent;
}
</style>

<?
	if(!$errMsg)	$errMsg = '잘못된 접근입니다.';
?>

<div class='errorBox'><?=$errMsg?></div>

<?
exit;
?>