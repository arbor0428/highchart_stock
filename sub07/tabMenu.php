<style>
.subBtn li{cursor:pointer;}
.subBtn li:hover{color:#e26f12;}
</style>

		<div class="ticker_tabBtnWrap">
			<div class="ticker_tabBtn"	>
				<div class="tabBtn <?if($tabBtn02 == '1'){echo 'on';}?>" onclick="location.href='sub01.php?gbl_symbol=<?=$gbl_symbol?>'" style=
				"width: 100%;">ETF정보</div>
			</div>
			<div class="ticker_subBtn">
				<ul class="subBtn <?if($tabBtn02 == '1'){echo 'on';}?>">
					<li <?if($subBtn02 == '1'){echo "class='on'";}?> onclick="location.href='sub01.php?gbl_symbol=<?=$gbl_symbol?>'">전반분석</li>
					<li <?if($subBtn02  == '2'){echo "class='on'";}?> onclick="location.href='sub02.php?gbl_symbol=<?=$gbl_symbol?>'">편입종목</li>
					<li <?if($subBtn02 == '3'){echo "class='on'";}?> onclick="location.href='sub03.php?gbl_symbol=<?=$gbl_symbol?>'">MDD</li>
				</ul>
			</div>
		</div>

		<script>
		 $(window).scroll(function(){
			 if (matchMedia("screen and (min-width: 1200px)").matches) {
				var height = $(document).scrollTop(); //실시간으로 스크롤의 높이를 측정
				if(height < 123){
				  $('.ticker_tabBtnWrap').removeClass('scroll_tabs');
				}else if(height > 123){
				  $('.ticker_tabBtnWrap').addClass('scroll_tabs')
				};
			  };
		  });
		</script>