<style>
.rowDis{display:none;}
.soaringWrap {position: absolute; bottom: 20px; left: 50%; transform:translateX(-50%);}
.soaringWrap > a {margin: 0 5px; padding: 5px 10px; border-radius: 5px; background-color:#0c1540; color: #fff; text-align :center; }
.soaringWrap > .hide{display:none;}
.etf_wrap .etf_tab_wrap .etf_tab_box {padding-bottom: 40px;}
.etf_wrap .etf_tab_btn li.on {border-radius: 5px 5px 0 0 !important;}
</style>

<script>
function rowHide(){
	$('.rowDis').hide();
	$('.soaringWrap > .more').show();
	$('.soaringWrap > .hide').hide();
}

function rowShow(){
	$('.rowDis').show();
	$('.soaringWrap > .more').hide();
	$('.soaringWrap > .hide').show();
}
</script>

<div class="etf_wrap">
	<ul class="etf_tab_btn">
		<li class="on">주식</li>
	</ul>
	<div class="tab_select">
		<div class="etf_tab_wrap etf_tab_wrap01">
			<div class="etf_tab_flex">
				<div class="etf_tab_box">
					<div class="etf">
						<div class="row row_tit">
							<div class="dp_sb dp_c dp_wrap dp_cc" style="height: 100%;">
								<div class="col">급등주</div>
								<div class="col">현재가 대비(등락)</div>
								<div class="col">거래량(등락)</div>
							</div>
						</div>
						<?
							//급등주(ETF == N)
							$row = sqlArray("select s.*, c.name from Stock_Candles_Last as s left join ks_symbol as t on s.symbol=t.symbol left join api_Company_Profile as c on s.symbol=c.symbol where t.etf='N' order by s.pmDataDay desc limit 10");

							$i = 1;

							foreach($row as $v){
								$perData = Util::nf1($v['pmDataDay'],2);
								if($perData > 0){
									$txtClass = 'upClass';
									$txtArrow = '▲';

								}else if($perData < 0){
									$txtClass = 'downClass';
									$txtArrow = '▼';

								}else{
									$txtClass = '';
									$txtArrow = '';
								}

								if($i > 4)		$rowClass = 'rowDis';
								else			$rowClass = '';
						?>
						<div class="row row_cont <?=$rowClass?>">
							<div class="dp_sb dp_c dp_wrap">
								<div class="col">
									<p class="blue_tit"><?=$v['symbol']?></p>
									<p class="ellipsis"><?=$v['name']?></p>
								</div>
								<div class="col <?=$txtClass?>"><?=number_format($v['c'],2)?> <?=$txtArrow?> (<?=Util::nf1($v['pmDataDay'],2)?>%)</div>
								<div class="col"><?=Util::nf1($v['vDataDay'],2)?>%</div>
							</div>
						</div>
						<?
								$i++;
							}
						?>
					</div>
					<div class="soaringWrap">
						<a class="more" href="javascript:rowShow();">더보기</a>
						<a class="hide" href="javascript:rowHide();">숨기기</a>
					</div>
				</div>
				<div class="etf_tab_box">
					<div class="etf">
						<div class="row row_tit">
							<div class="dp_sb dp_c dp_wrap dp_cc" style="height: 100%;">
								<div class="col">거래량 급등</div>
								<div class="col">현재가 대비(등락)</div>
								<div class="col">거래량(등락)</div>
							</div>
						</div>
						<?
							//거래량 급등주(ETF == N)
							$row = sqlArray("select s.*, c.name from Stock_Candles_Last as s left join ks_symbol as t on s.symbol=t.symbol left join api_Company_Profile as c on s.symbol=c.symbol where t.etf='N' order by s.vDataDay desc limit 10");
							
							$i = 1;

							foreach($row as $v){
								$perData = Util::nf1($v['pmDataDay'],2);
								if($perData > 0){
									$txtClass = 'upClass';
									$txtArrow = '▲';

								}else if($perData < 0){
									$txtClass = 'downClass';
									$txtArrow = '▼';

								}else{
									$txtClass = '';
									$txtArrow = '';
								}

								if($i > 4)		$rowClass = 'rowDis';
								else			$rowClass = '';
						?>
						<div class="row row_cont <?=$rowClass?>">
							<div class="dp_sb dp_c dp_wrap">
								<div  class="col">
									<p class="blue_tit"><?=$v['symbol']?></p>
									<p class="ellipsis"><?=$v['name']?></p>
								</div>
								<div class="col <?=$txtClass?>"><?=number_format($v['c'],2)?> <?=$txtArrow?> (<?=Util::nf1($v['pmDataDay'],2)?>%)</div>
								<div class="col"><?=Util::nf1($v['vDataDay'],2)?>%</div>
							</div>
						</div>
						<?
								$i++;
							}
						?>
					</div>
					<div class="soaringWrap">
						<a class="more" href="javascript:rowShow();">더보기</a>
						<a class="hide" href="javascript:rowHide();">숨기기</a>
					</div>
				</div>
				<div class="etf_tab_box">
					<div class="etf">
						<div class="row row_tit">
							<div class="dp_sb dp_c dp_wrap dp_cc" style="height: 100%;">
								<div class="col">52주 신고가</div>
								<div class="col">현재가 대비(등락)</div>
								<div class="col">거래량(등락)</div>
							</div>
						</div>
						<?
							//52주 신고가(ETF == N)
							$row = sqlArray("select s.*, c.name from Stock_Candles_Last as s left join ks_symbol as t on s.symbol=t.symbol left join api_Company_Profile as c on s.symbol=c.symbol left join api_Basic_Financials as b on s.symbol=b.symbol where t.etf='N' and s.high52='1' order by c.marketCapitalization desc limit 10");
							
							$i = 1;

							foreach($row as $v){
								$perData = Util::nf1($v['pmDataDay'],2);
								if($perData > 0){
									$txtClass = 'upClass';
									$txtArrow = '▲';

								}else if($perData < 0){
									$txtClass = 'downClass';
									$txtArrow = '▼';

								}else{
									$txtClass = '';
									$txtArrow = '';
								}

								if($i > 4)		$rowClass = 'rowDis';
								else			$rowClass = '';
						?>
						<div class="row row_cont <?=$rowClass?>">
							<div class="dp_sb dp_c dp_wrap">
								<div  class="col">
									<p class="blue_tit"><?=$v['symbol']?></p>
									<p class="ellipsis"><?=$v['name']?></p>
								</div>
								<div class="col <?=$txtClass?>"><?=number_format($v['c'],2)?> <?=$txtArrow?> (<?=Util::nf1($v['pmDataDay'],2)?>%)</div>
								<div class="col"><?=Util::nf1($v['vDataDay'],2)?>%</div>
							</div>
						</div>
						<?
								$i++;
							}
						?>
					</div>
					<div class="soaringWrap">
						<a class="more" href="javascript:rowShow();">더보기</a>
						<a class="hide" href="javascript:rowHide();">숨기기</a>
					</div>
				</div>
				<div class="etf_tab_box">
					<div class="etf">
						<div class="row row_tit">
							<div class="dp_sb dp_c dp_wrap dp_cc" style="height: 100%;">
								<div class="col">급락주</div>
								<div class="col">현재가 대비(등락)</div>
								<div class="col">거래량(등락)</div>
							</div>
						</div>
						<?
							//급락주(ETF == N)
							$row = sqlArray("select s.*, c.name from Stock_Candles_Last as s left join ks_symbol as t on s.symbol=t.symbol left join api_Company_Profile as c on s.symbol=c.symbol where t.etf='N' and s.c>0 order by s.pmDataDay asc limit 10");

							$i = 1;

							foreach($row as $v){
								$perData = Util::nf1($v['pmDataDay'],2);
								if($perData > 0){
									$txtClass = 'upClass';
									$txtArrow = '▲';

								}else if($perData < 0){
									$txtClass = 'downClass';
									$txtArrow = '▼';

								}else{
									$txtClass = '';
									$txtArrow = '';
								}

								if($i > 4)		$rowClass = 'rowDis';
								else			$rowClass = '';
						?>
						<div class="row row_cont <?=$rowClass?>">
							<div class="dp_sb dp_c dp_wrap">
								<div  class="col">
									<p class="blue_tit"><?=$v['symbol']?></p>
									<p class="ellipsis"><?=$v['name']?></p>
								</div>
								<div class="col <?=$txtClass?>"><?=number_format($v['c'],2)?> <?=$txtArrow?> (<?=Util::nf1($v['pmDataDay'],2)?>%)</div>
								<div class="col"><?=Util::nf1($v['vDataDay'],2)?>%</div>
							</div>
						</div>
						<?
								$i++;
							}
						?>
					</div>
					<div class="soaringWrap">
						<a class="more" href="javascript:rowShow();">더보기</a>
						<a class="hide" href="javascript:rowHide();">숨기기</a>
					</div>
				</div>
				<div class="etf_tab_box">
					<div class="etf">
						<div class="row row_tit">
							<div class="dp_sb dp_c dp_wrap dp_cc" style="height: 100%;">
								<div class="col">한국인 매수 상위</div>
								<div class="col">현재가 대비(등락)</div>
								<div class="col">거래량(등락)</div>
							</div>
						</div>
						<?
							//한국인 매수 상위
							$row = sqlArray("select s.*, k.name from koreanBuy as k left join Stock_Candles_Last as s on k.symbol=s.symbol where s.c>0 order by k.uid asc limit 10");
							
							$i = 1;

							foreach($row as $v){
								$perData = Util::nf1($v['pmDataDay'],2);
								if($perData > 0){
									$txtClass = 'upClass';
									$txtArrow = '▲';

								}else if($perData < 0){
									$txtClass = 'downClass';
									$txtArrow = '▼';

								}else{
									$txtClass = '';
									$txtArrow = '';
								}

								if($i > 4)		$rowClass = 'rowDis';
								else			$rowClass = '';
						?>
						<div class="row row_cont <?=$rowClass?>">
							<div class="dp_sb dp_c dp_wrap">
								<div  class="col">
									<p class="blue_tit"><?=$v['symbol']?></p>
									<p class="ellipsis"><?=$v['name']?></p>
								</div>
								<div class="col <?=$txtClass?>"><?=number_format($v['c'],2)?> <?=$txtArrow?> (<?=Util::nf1($v['pmDataDay'],2)?>%)</div>
								<div class="col"><?=Util::nf1($v['vDataDay'],2)?>%</div>
							</div>
						</div>
						<?
								$i++;
							}
						?>
					</div>
					<div class="soaringWrap">
						<a class="more" href="javascript:rowShow();">더보기</a>
						<a class="hide" href="javascript:rowHide();">숨기기</a>
					</div>
				</div>
				<div class="etf_tab_box">
					<div class="etf">
						<div class="row row_tit">
							<div class="dp_sb dp_c dp_wrap dp_cc" style="height: 100%;">
								<div class="col">52주 신저가</div>
								<div class="col">현재가 대비(등락)</div>
								<div class="col">거래량(등락)</div>
							</div>
						</div>
						<?
							//52주 신저가(ETF == N)
							$row = sqlArray("select s.*, c.name from Stock_Candles_Last as s left join ks_symbol as t on s.symbol=t.symbol left join api_Company_Profile as c on s.symbol=c.symbol left join api_Basic_Financials as b on s.symbol=b.symbol where t.etf='N' and s.low52='1' order by c.marketCapitalization desc limit 10");
							
							$i = 1;

							foreach($row as $v){
								$perData = Util::nf1($v['pmDataDay'],2);
								if($perData > 0){
									$txtClass = 'upClass';
									$txtArrow = '▲';

								}else if($perData < 0){
									$txtClass = 'downClass';
									$txtArrow = '▼';

								}else{
									$txtClass = '';
									$txtArrow = '';
								}

								if($i > 4)		$rowClass = 'rowDis';
								else			$rowClass = '';
						?>
						<div class="row row_cont <?=$rowClass?>">
							<div class="dp_sb dp_c dp_wrap">
								<div  class="col">
									<p class="blue_tit"><?=$v['symbol']?></p>
									<p class="ellipsis"><?=$v['name']?></p>
								</div>
								<div class="col <?=$txtClass?>"><?=number_format($v['c'],2)?> <?=$txtArrow?> (<?=Util::nf1($v['pmDataDay'],2)?>%)</div>
								<div class="col"><?=Util::nf1($v['vDataDay'],2)?>%</div>
							</div>
						</div>
						<?
								$i++;
							}
						?>
					</div>
					<div class="soaringWrap">
						<a class="more" href="javascript:rowShow();">더보기</a>
						<a class="hide" href="javascript:rowHide();">숨기기</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
