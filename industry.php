<?
	//미국 주식 산업별 분위기..
	$sArr = Array("XLK"=>"Technology (정보기술)","XLV"=>"Healthcare (헬스케어)","XLP"=>"Consumer Staples (필수소비재)","XLU"=>"Utilities (유틸리티)","XLY"=>"Consumer Diser (임의소비재)","XLC"=>"Communication Svcs (커뮤니케이션 서비스)","XLB"=>"Basic Materials (소재)","XLF"=>"Financial Services (금융)","XLI"=>"Industrials (산업)","XLE"=>"Energy (에너지)","XLRE"=>"Real Estate (부동산)");
?>
					<table>
						<colgroup>
							<col style="width: 335px;">
							<col style="width: 102px;">
							<col style="width: 102px;">
							<col style="width: 102px;">
							<col style="width: 102px;">
							<col style="width: 102px;">
							<col style="width: 396px;">
						</colgroup>
						<tbody>
							<tr>
								<th>Sector</th>
								<th>ETF</th>
								<th>Today</th>
								<th>1 Month</th>
								<th>YTD</th>
								<th>1 Year</th>
								<th>로고 티커 등락율</th>
							</tr>
						<?
							foreach($sArr as $k => $v){
								$row = sqlRow("select * from Stock_Candles_Last where symbol='".$k."'");

								//본장(22:30 ~ 05:00)에서는 Today값을 quote DB를 사용
								$QuoteCall = false;
								if($QuoteCall){
									$dp = sqlRowOne("select dp from spec5Quote where symbol='".$k."'");
									$row['pmDataDay'] = $dp;
								}

								$udClass01 = UpDownClass($row['pmDataDay']);
								$udClass02 = UpDownClass($row['pmDataMonth']);
								$udClass03 = UpDownClass($row['pmDataYearFirst']);
								$udClass04 = UpDownClass($row['pmDataYear1']);


						?>
							<tr>
								<td title="Sector"><?=$v?></td>
								<td title="ETF"><a href="/sub07/sub01.php?gbl_symbol=<?=$k?>"><span class="blue bb"><?=$k?></span></a></td>
								<td title="Today"><span class="<?=$udClass01?>"><?=Util::nf1($row['pmDataDay'],2)?>%</span></td>
								<td title="1 Month"><span class="<?=$udClass02?>"><?=Util::nf1($row['pmDataMonth'],2)?>%</span></td>
								<td title="YTD"><span class="<?=$udClass03?>"><?=Util::nf1($row['pmDataYearFirst'],2)?>%</span></td>
								<td title="1 Year"><span class="<?=$udClass04?>"><?=Util::nf1($row['pmDataYear1'],2)?>%</span></td>
								<td title="logo">
									<div class="logo_wrap">
									<?
										//ETFs Holdings 에서 상위 3개 주식심볼
										$etf = sqlArray("select h.symbolTxt, p.*, c.pmDataDay from api_ETFs_Holdings as h left join api_Company_Profile as p on h.symbolTxt=p.symbol left join Stock_Candles_Last as c on h.symbolTxt=c.symbol where h.symbol='".$k."' order by h.uid asc limit 10");

										$c = 0;

										foreach($etf as $f){
											if($f['symbolTxt']){
												$perData = Util::nf1($f['pmDataDay'],2);
												$udClass = UpDownClass($perData);
									?>
										<div class="logo_tiker">
										<a href="/sub06/sub01.php?gbl_symbol=<?=$f['symbolTxt']?>">
											<div class="img_wrap">
												<img src="<?=$f['logo']?>" onerror="this.style.display='none'">
											</div>
										</a>
										<a href="/sub06/sub01.php?gbl_symbol=<?=$f['symbolTxt']?>">
											<div class="txt_box">
												<p><?=$f['symbolTxt']?></p>
												<span class="<?=$udClass?>"><?=$perData?>%</span>
											</div>
										</a>
										</div>
									<?
												$c++;
												if($c == 3)	break;
											}
										}
									?>
									</div>
								</td>
							</tr>
						<?
							}
						?>
						</tbody>
					</table>