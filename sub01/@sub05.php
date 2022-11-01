<?
	include '../header.php';
?>

<div id="sub_cont">
	<?
		include 'Sidebar.php';
	?>
	<div class="sub_center">
		<div class="insiderTrade">
			<div class="insider_searchBar">
				<input id="tiker_name" type="text" placeholder="aapl">
				<input id="prev_date" type="text" placeholder="2021-10-01">
				<span style="display: block; line-height: 35px;">~</span>
				<input id="next_date" type="text" placeholder="2022-01-20">
				<a class="insider_searchBtn" href="">검색</a>
				<a class="insider_addBtn" href="">내 관심종목 추가</a>
			</div>
			<div class="insider_searchTag">
				<div class="searchTag"><span>AAPL</span><a class="minus" href="" title="제거">-</a></div>
				<div class="searchTag"><span>TSLA</span><a class="minus" href="" title="제거">-</a></div>
				<div class="searchTag"><span>JOBY</span><a class="minus" href="" title="제거">-</a></div>
			</div>
			<script>
				$('.minus').click(function(event) {

					event.preventDefault();
					$(this).parent(".searchTag").hide();

				});
			</script>
			<div class="insider_table">
				<table id="InnerTrade" class="subtable">
					<thead>
						<tr>
							<th>
								내부자명
								<button onclick="sortTD (0)">↓</button>
								<button onclick="reverseTD (0)">↑</button>
							</th>
							<th>
								회사이름(티커)
								<button onclick="sortTD (1)">↓</button>
								<button onclick="reverseTD (1)">↑</button>
							</th>
							<th>
								보유주식수
								<button onclick="sortTD (2)">↓</button>
								<button onclick="reverseTD (2)">↑</button>
							</th>
							<th>
								변화량
								<button onclick="sortTD (3)">↓</button>
								<button onclick="reverseTD (3)">↑</button>
							</th>
							<th>
								거래날짜
								<button onclick="sortTD (4)">↓</button>
								<button onclick="reverseTD (4)">↑</button>
							</th>
							<th>
								거래평단가
								<button onclick="sortTD (5)">↓</button>
								<button onclick="reverseTD (5)">↑</button>
							</th>
							<th>
								거래금액
								<button onclick="sortTD (6)">↓</button>
								<button onclick="reverseTD (6)">↑</button>
							</th>
							<th>
								시총대비 거래액(%)
								<button onclick="sortTD (7)">↓</button>
								<button onclick="reverseTD (7)">↑</button>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>KONDO CHRIS</td>
							<td><span class="blue bb">AAPL</span></td>
							<td>37,197</td>
							<td>-9,005</td>
							<td>2021-11-12</td>
							<td>150</td>
							<td>-1,350,750</td>
							<td>0.04%</td>
						</tr>
						<tr>
							<td>Adams Katherine L.</td>
							<td><span class="blue bb">TSLA</span></td>
							<td>447,993</td>
							<td>-3,290</td>
							<td>2021-11-01</td>
							<td>149.11</td>
							<td>-490,571.9</td>
							<td>0.3%</td>
						</tr>
						<tr>
							<td>Adams Katherine L.</td>
							<td><span class="blue bb">TSLA</span></td>
							<td>447,993</td>
							<td>-3,290</td>
							<td>2021-11-01</td>
							<td>149.11</td>
							<td>-490,571.9</td>
							<td>0.3%</td>
						</tr>
						<tr>
							<td>Adams Katherine L.</td>
							<td><span class="blue bb">TSLA</span></td>
							<td>447,993</td>
							<td>-3,290</td>
							<td>2021-11-01</td>
							<td>149.11</td>
							<td>-490,571.9</td>
							<td>0.3%</td>
						</tr>
						<tr>
							<td>Adams Katherine L.</td>
							<td><span class="blue bb">TSLA</span></td>
							<td>447,993</td>
							<td>-3,290</td>
							<td>2021-11-01</td>
							<td>149.11</td>
							<td>-490,571.9</td>
							<td>0.3%</td>
						</tr>
					</tbody>
				</table>
				<div class="big_buy_box">
					<a href="" title="로그인하세요">
						<div class="plue_btn">
							<span>+</span>
						</div>
						<p>회원가입 하시고 내부자 거래 현황을 좀 더 쉽게 한눈에 파악하세요.</p>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	//table 오름차순내림차순
	var myTable = document.getElementById( "InnerTrade" ); 
	var replace = replacement( myTable ); 
	function sortTD( index ){    
		replace.ascending( index );    
	} 
	function reverseTD( index ){    
		replace.descending( index );    
	} 
</script>

<?
	include '../footer.php';
?>