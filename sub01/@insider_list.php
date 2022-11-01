		<div class="insider_table">
				<table id="InnerTrade" class="subtable">
					<thead>
						<tr>
							<th>
								내부자명
<!-- 								<button onclick="sortTD (0)" class='sort0'>↓</button>
								<button onclick="reverseTD (0)">↑</button> -->
							</th>
							<th>
								회사이름(티커)
<!-- 								<button onclick="sortTD (1)">↓</button>
								<button onclick="reverseTD (1)">↑</button> -->
							</th>
							<th>
								보유주식수
<!-- 								<button onclick="sortTD (2)">↓</button>
								<button onclick="reverseTD (2)">↑</button> -->
							</th>
							<th>
								변화량
<!-- 								<button onclick="sortTD (3)">↓</button>
								<button onclick="reverseTD (3)">↑</button> -->
							</th>
							<th>
								거래날짜
<!-- 								<button onclick="sortTD (4)">↓</button>
								<button onclick="reverseTD (4)">↑</button> -->
							</th>
							<th>
								거래평단가
<!-- 								<button onclick="sortTD (5)">↓</button>
								<button onclick="reverseTD (5)">↑</button> -->
							</th>
							<th>
								거래금액
<!-- 								<button onclick="sortTD (6)">↓</button>
								<button onclick="reverseTD (6)">↑</button> -->
							</th>
							<th>
								시총대비 거래액(%)
<!-- 								<button onclick="sortTD (7)">↓</button>
								<button onclick="reverseTD (7)">↑</button> -->
							</th>
						</tr>
					</thead>
					<tbody>
						<tr style="display:none;"></tr>
					</tbody>
				</table>

			</div>
			
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/js/jquery.tablesorter.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/js/jquery.tablesorter.min.js"></script>
			<link href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/css/theme.default.min.css" rel="stylesheet">
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/js/jquery.tablesorter.widgets.min.js"></script>

			<script>
				$("#InnerTrade").tablesorter();
			</script>

			<style>
				.tablesorter-default {font: 700 16px/26px 'Pretendard' !important; }
			</style>