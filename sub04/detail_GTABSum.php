<?
	$colorArr11 = Array('#ff6384','#ff9f40','#ffcd56','#4bc0c0','#36a2eb','#e85255','#d499d4','#437eb4','#779c74','#6f0c4f','#9e9fae');
?>

<div class="transferSecWrap dp_sb">
	<div class="transferSec">
		<p class="sub_tit"><span><?=$grow['title']?></span> 포트폴리오 평가액 비중</p>
		<div class="cirGraphwrap02">
			<div class="ora_line"></div>
			<div class="titTabwrap dp_sb dp_c" style="padding: 20px 0;">
				<p style="font-size: 20px; font-weight: 700; padding: 0 0 0 20px;">자산 구성</p>
				<ul class="cirTabBtn dp_f">
					<li class="on"><a class="dp_f dp_c dp_cc" href="" title="">매수기준</a></li>
					<li><a class="dp_f dp_c dp_cc" href="" title="">현재기준</a></li>
				</ul>
			</div>
			<div class="cirTabGraphWrap">
			<?
				$gArr = $gArr0101;	//평가액비중(매수기준)
				arsort($gArr);

				$graphID = 'cirg0101';		//그래프ID
				$cirTitle = "$".number_format($p1Tot,2);			//그래프 가운데 텍스트
				if($w1Tot)	$cirTitle .= "<br>(".number_format($w1Tot)."원)";

				include 'insertDATA.php';



				$gArr = $gArr0102;	//평가액비중(매수기준)
				arsort($gArr);

				$graphID = 'cirg0102';		//그래프ID
				$cirTitle = "$".number_format($p1Tot,2);			//그래프 가운데 텍스트
				if($w1Tot)	$cirTitle .= "<br>(".number_format($w1Tot)."원)";

				include 'insertDATA.php';
			?>
			</div>
		</div>
	</div>
	<div class="transferSec">
		<p class="sub_tit"><span><?=$grow['title']?></span> 포트폴리오 섹터비중</p>
		<div class="cirGraphwrap02">
			<div class="ora_line"></div>		
			<div class="titTabwrap dp_sb dp_c" style="padding: 20px 0;">
				<p style="font-size: 20px; font-weight: 700; padding: 0 0 0 20px;">자산 구성</p>
				<ul class="cirTabBtn dp_f">
					<li class="on"><a class="dp_f dp_c dp_cc" href="" title="">매수기준</a></li>
					<li><a class="dp_f dp_c dp_cc" href="" title="">현재기준</a></li>
				</ul>
			</div>

			<div class="cirTabGraphWrap">
			<?
				$gArr = $gArr0201;	//섹터비중(매수기준)
				arsort($gArr);

				$graphID = 'cirg0201';		//그래프ID
				$cirTitle = "$".number_format($p1Tot,2);			//그래프 가운데 텍스트
				if($w1Tot)	$cirTitle .= "<br>(".number_format($w1Tot)."원)";

				include 'insertDATA.php';



				$gArr = $gArr0202;	//섹터비중(매수기준)
				arsort($gArr);

				$graphID = 'cirg0202';		//그래프ID
				$cirTitle = "$".number_format($p1Tot,2);			//그래프 가운데 텍스트
				if($w1Tot)	$cirTitle .= "<br>(".number_format($w1Tot)."원)";

				include 'insertDATA.php';
			?>
			</div>
		</div>
	</div>
</div>

<!--포트폴리오 예상 배당추이-->
<?
	$dividendTot = 0;
	$lineData = '';
	for($i=1; $i<=12; $i++){
		$v = $gArr04[$i];
		$p = ($v ? $v : 0);

		if($i > 1)		$lineData .= ',';
		$lineData .= $p;

		$dividendTot += $v;	//연간 배당금(예상)
	}
/*
	echo $lineData.'<Br>';

	ksort($gArr04);
	foreach($gArr04 as $k => $v){
		echo $k.' / '.$v.'<br>';
	}
*/
?>
<div class="transferSecWrap dp_sb">
	<div class="transferSec">
		<p class="sub_tit"><span><?=$grow['title']?></span> 포트폴리오 예상 배당추이</p>
		<div class="cirGraphwrap02">
			<div class="ora_line"></div>
			<div class="titTabwrap dp_sb dp_c" style="padding: 20px 0;">
				<p style="font-size: 20px; font-weight: 700; padding: 0 0 0 20px;">자산 구성</p>
			<!--
				<ul class="cirTabBtn dp_f">
					<li class="on"><a class="dp_f dp_c dp_cc" href="" title="">매수기준</a></li>
					<li><a class="dp_f dp_c dp_cc" href="" title="">현재기준</a></li>
				</ul>
			-->
			</div>
			<div class="cirTabGraphWrap">
			<?
				//예상 배당추이 그래프 데이터
				foreach($gArr03Tmp as $k => $v){
					$gArr03[$k] = Util::fnPercent2($p6Tot,$v);
				}

				$gArr = $gArr03;	//예상 배당추이
				arsort($gArr);

				$graphID = 'cirg0301';
				$cirTitle = "$".$dividendTot;
				$cirTitle .= "<br>(".number_format($dividendTot * $exRate)."원)";

				include 'insertDATA.php';
			?>
			</div>
		</div>
	</div>

	<div class="transferSec dp_f dp_fc dp_cc">
		<table class="subtable">
			<tbody>
				<tr>
					<th>종목수</th>
					<th>총매입</th>
					<th>총평가</th>
					<th>수익률<br>(현재)</th>
					<th>배당률<br>(현재)</th>
					<th>연간 배당금<br>(예상)</th>
				</tr>
				<tr>
					<td><?=$sCnt?></td>
					<td>$<?=Util::NumberSet2($p1Tot)?></td>
					<td>$<?=Util::NumberSet2($p2Tot)?></td>
					<td><?=$p4Tot?>%</td>
					<td><?=$p5Tot?>%</td>
					<td>$<?=$dividendTot?></td>
				</tr>
			</tbody>
		</table>
		<?
			//월간 예상 배당금 분포
			include 'expectMongraph.php';
		?>
	</div>
</div>



<script>
				           
		$(".cirTabBtn > li").on("click",function(event){

			event.preventDefault();

			let tabNumber = $(this).index();

			$(this).siblings(".cirTabBtn > li").removeClass("on");
			$(this).addClass("on");

			$(this).parent().parent().siblings().children(".cirTabGraphWrap .cirTabGraph").hide();
			$(this).parent().parent().siblings().children(".cirTabGraphWrap .cirTabGraph").eq(tabNumber).show();

		});
</script>

<style>
.cirTabGraphWrap .cirTabGraph {display: none;}
.cirTabGraphWrap .cirTabGraph:first-child {display: block;}
.cirTabBtn {padding: 0 20px 0 0;}
.cirTabBtn li {margin: 0 5px; border: 1px solid #0c1540; width: 100px; height: 40px; border-radius: 35px; color: #0c1540;}
.cirTabBtn li a {width: 100%; height: 100%;}
.cirTabBtn li.on {color: #fff; background-color: #0c1540;}
</style>