<div class="diaryBox">
	<h3 class="sub_tit">관심있는 종목을 찾고 분석일지를 작성해보세요</h3>
	<div class="diary_searchWrap">
		<div class="search_box">
			<input type="text" placeholder="관심 종목을 검색하세요 (기업명, Ticker, Symbol)">
			<button>
				<img src="/img/search_icon.png">
			</button>
		</div>
	</div>
	<!--------------------분석일지 작성했을때 뜨는 리스트--------------------------->
	<?
		include 'analysis_list.php';
	?>
	<!--------------------분석일지 작성했을때 뜨는 리스트--------------------------->



	<!--------------------검색결과 상세페이지--------------------------->
	<?
		include 'analysis_result.php';
	?>
	<!--------------------검색결과 상세페이지--------------------------->
</div>

