<style>
.subBtn li{cursor:pointer;}
.subBtn li:hover{color:#e26f12;}
.prog_btn {display: block; padding: 5px 20px; text-align: center; display: flex; align-items: center; border-radius: 30px; height: 35px; color: #fff; font-weight: 700; background-color: #66b915;}
</style>

		<div class="ticker_tabBtnWrap">
			<div class="ticker_tabBtn">
				<div class="tabBtn <?if($tabBtn == '1'){echo 'on';}?>" onclick="location.href='sub01.php?gbl_symbol=<?=$gbl_symbol?>'">종목정보</div>
				<div class="tabBtn <?if($tabBtn == '2'){echo 'on';}?>" onclick="location.href='sub07.php?gbl_symbol=<?=$gbl_symbol?>'">재무제표</div>
			</div>

			<div class="ticker_subBtn">
				<div class="subBtn dp_sb <?if($tabBtn == '1'){echo 'on';}?>">
					<ul class="dp_f">
						<li <?if($subBtn == '1'){echo "class='on'";}?> onclick="location.href='sub01.php?gbl_symbol=<?=$gbl_symbol?>'">전반분석</li>
						<li <?if($subBtn == '2'){echo "class='on'";}?> onclick="location.href='sub02.php?gbl_symbol=<?=$gbl_symbol?>'">전문가분석</li>
						<li <?if($subBtn == '3'){echo "class='on'";}?> onclick="location.href='sub03.php?gbl_symbol=<?=$gbl_symbol?>'">MDD/비교수익률</li>
						<li <?if($subBtn == '4'){echo "class='on'";}?> onclick="location.href='sub04.php?gbl_symbol=<?=$gbl_symbol?>'">기업실적</li>
						<li <?if($subBtn == '5'){echo "class='on'";}?> onclick="location.href='sub05.php?gbl_symbol=<?=$gbl_symbol?>'">배당정보</li>
						<li <?if($subBtn == '6'){echo "class='on'";}?> onclick="location.href='sub06.php?gbl_symbol=<?=$gbl_symbol?>'">주주정보/내부자거래</li>
					</ul>
					<a class="prog_btn" href="">분석일지 작성하기</a>
				</div>
				<div class="subBtn <?if($tabBtn == '2'){echo 'on';}?>">
					<ul class="dp_f">
						<li <?if($subBtn == '1'){echo "class='on'";}?> onclick="location.href='sub07.php?gbl_symbol=<?=$gbl_symbol?>'">손익계산서 (Income Statement)</li>
						<li <?if($subBtn == '2'){echo "class='on'";}?> onclick="location.href='sub08.php?gbl_symbol=<?=$gbl_symbol?>'">재무상태표(BalanceSheet)</li>
						<li <?if($subBtn == '3'){echo "class='on'";}?> onclick="location.href='sub09.php?gbl_symbol=<?=$gbl_symbol?>'">현금흐름표(CashFlow)</li>
					</ul>
				</div>
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