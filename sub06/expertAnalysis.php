<div class="ticker_section">
	<div class="targ_wrap">
		<div class="targ_box tar_left">
		<?
			$recomSymbol = $gbl_symbol;
			//도넛 그래프
			include '../Recommendation01.php';
		?>
		</div>
		<div class="targ_box tar_right">
		<?
			//평균 그래프
			include '../Recommendation02.php';
		?>
		</div>
	</div>
<!--
	<div class="big_buy_box" style="margin-top: 70px;">
		<a href="" title="로그인하세요">
			<div class="plue_btn">
				<span>+</span>
			</div>
			<p>회원가입 하시고 향후 5년간의 애널리스트 컨센서스를 확인해보세요!</p>
		</a>
	</div>
-->
</div>