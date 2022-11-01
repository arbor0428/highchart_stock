<?
	include './head2.php';
	include './module/loading2.php';

	if(!$cellh)	$cellh = '150px';		// date cell height
?>
<link type='text/css' rel='stylesheet' href='/css/calendar.css'>
<style>
.lnr:hover{color:#233276;font-weight:800;cursor:pointer;}
.rHide{display:none;}

.more-btn {display: block; border-radius: 3px; width: 100%; text-align: center; background:#0c1540; color: #fff; font-size:13px; padding:5px; box-sizing:border-box;}
.more-btn:hover {background:#233276;}
</style>
<?
function ErrorMsg($msg)
{
  echo " <script>                ";
  echo "   window.alert('$msg'); ";
  echo "   history.go(-1);       ";
  echo " </script>               ";
  exit;
}

function SkipOffset($no,$sdate='',$edate='')
{
  for($i=1;$i<=$no;$i++) {
    $ck = $no-$i+1;
    if($sdate) $num = date('d',$sdate-((3600*24)*$ck));
	if($edate) $num=$i;
    echo "  <TD align=center><a href='/' class=snum2>$num</a></TD> \n";
  }
}

//---- 오늘 날짜
$thisyear  = date('Y');  // 2000
$thismonth = date('n');  // 1, 2, 3, ..., 12
$today     = date('j');  // 1, 2, 3, ..., 31


//------ $year, $month 값이 없으면 현재 날짜
if (!$year)		$year = $thisyear;
if (!$month)		$month = $thismonth;
if (!$day)		$day = $today;

//------ 날짜의 범위 체크
if (($year > 2038) or ($year < 1900)) ErrorMsg("연도는 1900~2038년만 가능합니다.");
if (($month > 12) or ($month < 0)) ErrorMsg("달은 1~12만 가능합니다.");
/*
while (checkdate($month,$day,$year)):
    $date++;
endwhile;
$maxdate = date-1;
*/
$maxdate = date('t', mktime(0, 0, 0, $month, 1, $year));   // the final date of $month

if ($day>$maxdate) ErrorMsg("$month 월 에는 $lastday 일이 마지막 날입니다.");

$prevmonth = $month - 1;
$nextmonth = $month + 1;
$prevyear = $nextyear=$year;
if ($month == 1) {
  $prevmonth = 12;
  $prevyear = $year - 1;
} elseif ($month == 12) {
  $nextmonth = 1;
  $nextyear = $year + 1;
}

//휴일정의
include './module/class/class.Holiday.php';
$HOLIDAY = Holiday($prevyear,$nextyear);


$startTime = mktime(0,0,0,$month,1,$year);
//$startYoil = date('w',$startTime);
//$startTime -= (86400 * $startYoil);	//첫째주 이전월 일자 표기용

$endTime = mktime(23,59,59,$month,$maxdate,$year);
//$endYoil = date('w',$endTime);
//$endTime += (86400 * (6 - $endYoil));	//마지막주 다음달 일자 표기용

//echo date('Y-m-d H:i:s',$startTime).' ~ '.date('Y-m-d H:i:s',$endTime).'<br>';


/********************************** 달력에 표기되는 모든 데이터는 S&P500 심볼 기준 **********************************************/
if(!$dataType){
	if($path == 'sub01-sub02')	$dataType = 'dividends';		//주식 > 배당캘린더(sub01/sub02.php)
	else									$dataType = 'earnings';		//메인 페이지에서 호출
}
$sArr = Array();

//데이터 구조예시
//$sArr['20220510'] = Array("AAPL"=>"Apple Inc","TSLA"=>"Tesla Inc","RMTI"=>"Rockwell Medical Inc","APAC"=>"Stonebridge Acquisition Corp");

//실적발표
if($dataType == 'earnings'){
	$row = sqlArray("select c.*, p.name from api_Earnings_Calendar as c left join ks_symbol as s on c.symbol=s.symbol left join api_Company_Profile as p on c.symbol=p.symbol where c.dateTime>='".$startTime."' and c.dateTime<='".$endTime."' and s.snp500=1 order by c.symbol");
	foreach($row as $v){
		$k = str_replace('-','',$v['date']);
		$u = $v['uid'];

		$sArr[$k][$u]['symbol'] = $v['symbol'];
		$sArr[$k][$u]['name'] = $v['name'];
	}


//배당
}elseif($dataType == 'dividends'){
	$row = sqlArray("select c.*, p.name from api_Dividends as c left join ks_symbol as s on c.symbol=s.symbol left join api_Company_Profile as p on c.symbol=p.symbol where c.dateTime>='".$startTime."' and c.dateTime<='".$endTime."' and s.snp500=1 order by c.symbol");
	foreach($row as $v){
		$k = str_replace('-','',$v['date']);
		$u = $v['uid'];

		$sArr[$k][$u]['symbol'] = $v['symbol'];
		$sArr[$k][$u]['name'] = $v['name'];
	}


//IPO
}elseif($dataType == 'ipo'){
	$row = sqlArray("select * from api_IPO_Calendar where dateTime>='".$startTime."' and dateTime<='".$endTime."' order by symbol");
	foreach($row as $v){
		$k = str_replace('-','',$v['date']);
		$u = $v['uid'];

		$sArr[$k][$u]['symbol'] = $v['symbol'];
		$sArr[$k][$u]['name'] = $v['name'];
	}
}
?>

<script>
function setCalendar(y,m){
	form = document.frm_cals;
	form.year.value = y;
	form.month.value = m;
	form.day.value = '1';
	form.target = '';
	form.action = "<?=$_SERVER['PHP_SELF']?>";
	form.submit();
}

function clasView(s){
	alert(s);
}

function moreWrap(d){
	if(d){
		t = $('#bt'+d).text();
		if(t == '+더보기'){
			$('.wr'+d).show();
			$('.bt'+d).text('-숨기기');
		}else{
			$('.wr'+d).hide();
			$('.bt'+d).text('+더보기');
		}
	}

	parent.iFrameHeight('ifra_calendar');
}

$(function(){
	$('.dataType').click(function(){
		c = $(this).is(":checked");
		d = $(this).attr('id');

		if(c){
			$('.dataType').each(function(){
				if($(this).attr('id') != d){
					$(this).prop('checked', false);
				}
			});

			if('<?=$path?>' == 'sub04-sub01'){
				//아이프레임 밖에 있는 체크박스 컨트롤
				parent.$('.dataType').prop('checked', false);
				parent.$('#'+d).prop('checked', true);
			}

			$('#frm_cals').submit();
		}else{
			$(this).prop('checked', true);
		}		
	});
});
</script>


<form name='frm_cals' id='frm_cals' method='post' action="<?=$_SERVER['PHP_SELF']?>">
<input type="text" name="none" style="display: none;" title="none">  <!-- 텍스트박스 1개이상 처리.. 자동전송방지 -->
<input type='hidden' name='type' value=''>
<input type='hidden' name='next_url' value="<?=$_SERVER['PHP_SELF']?>">
<input type='hidden' name='year' value='<?=$year?>'>
<input type='hidden' name='month' value='<?=$month?>'>
<input type='hidden' name='day' value=''>
<input type='hidden' name='path' value='<?=$path?>'>

<div class="mainIssue_calendar">

	<div class="ameriCalTop">
		<div class="calTit">
		<!--
			<h3>미국 시장 이슈 캘린더</h3>
		-->
		</div>

		<div class="calMonth">
			<a href="javascript:setCalendar('<?=$prevyear-1?>','<?=$prevmonth?>');" onfocus='this.blur()' alt='이전연도'><img src='/img/c_double_prev.png' style='margin-bottom:2px;' alt='이전연도'></a>
			<a href="javascript:setCalendar('<?=$prevyear?>','<?=$prevmonth?>');" onfocus='this.blur()' alt='이전달'><img src='/img/c_prev.png' style='margin-bottom:2px;' alt='이전달'></a>
			<span class='calsTitle'><?=$year?>. <?=$month?>.</span>
			<a href="javascript:setCalendar('<?=$nextyear?>','<?=$nextmonth?>');" onfocus='this.blur()' alt='다음달'><img src='/img/c_next.png' style='margin-bottom:2px;' alt='다음달'></a>
			<a href="javascript:setCalendar('<?=$nextyear+1?>','<?=$nextmonth?>');" onfocus='this.blur()' alt='다음연도'><img src='/img/c_double_next.png' style='margin-bottom:2px;' alt='다음연도'></a>
		</div>

		<div class="calChkWrap">
		<?
			if($path == 'sub01-sub02'){
		?>
			<div class="calChk">
				<input type="checkbox" name="dataType" id="dt1" class="dataType" value="mySymbol" <?if($dataType == 'mySymbol'){echo "checked";}?>>
				<label for="dt1">관심종목만 보기</label>
			</div>
			<div class="calChk">
				<input type="checkbox" name="dataType" id="dt4" class="dataType" value="dividends" <?if($dataType == 'dividends'){echo "checked";}?>>
				<label for="dt4">배당</label>
			</div>
		<?
			}else{
		?>
		<!--
			<div class="calChk">
				<input type="checkbox" name="dataType" id="dt1" class="dataType" value="mySymbol" <?if($dataType == 'mySymbol'){echo "checked";}?>>
				<label for="dt1">관심종목만 보기</label>
			</div>
			<div class="calChk">
				<input type="checkbox" name="dataType" id="dt2" class="dataType" value="myDiary" <?if($dataType == 'myDiary'){echo "checked";}?>>
				<label for="dt2">작성한 다이어리</label>
			</div>
		-->
			<div class="calChk">
				<input type="checkbox" name="dataType" id="dt3" class="dataType" value="earnings" <?if($dataType == 'earnings'){echo "checked";}?>>
				<label for="dt3">실적발표</label>
			</div>
			<div class="calChk">
				<input type="checkbox" name="dataType" id="dt4" class="dataType" value="dividends" <?if($dataType == 'dividends'){echo "checked";}?>>
				<label for="dt4">배당</label>
			</div>
			<div class="calChk">
				<input type="checkbox" name="dataType" id="dt5" class="dataType" value="ipo" <?if($dataType == 'ipo'){echo "checked";}?>>
				<label for="dt5">IPO</label>
			</div>
		<!--
			<div class="calChk">
				<input type="checkbox" name="dataType" id="dt6" class="dataType" value="ok" <?if($dataType == 'ok'){echo "checked";}?>>
				<label for="dt6">적정주가 도달주식</label>
			</div>
		-->
		<?
			}
		?>
		</div>
	</div>

	<table class='tableOnly'>
		<tr>
			<td style='padding-top:5px;'>
				<table class='tableOnly' style="border-bottom:2px solid #000;">
					<tr style='text-align:center;'>
						<td class='week'>Sun</td>
						<td class='week'>Mon</td>
						<td class='week'>Tue</td>
						<td class='week'>Wed</td>
						<td class='week'>Thu</td>
						<td class='week'>Fri</td>
						<td class='week'>Sat</td>
					</tr>
				</table>

				<table class='cTable'>
					<tr class="twoline" >


			<!-- 날짜 테이블 -->


<?
//표시하는 컨텐츠 개수
$dispNum = 3;

$date   = 1;
$offset = 0;
$ck_row=0; //프레임 사이즈 조절을 위한 체크인자

while ($date <= $maxdate) {
   if ($date < 10) $date2 = "&nbsp;".$date;
   else $date2 = $date;
   if($date == '1') {
    $offset = date('w', mktime(0, 0, 0, $month, $date, $year));  // 0: sunday, 1: monday, ..., 6: saturday
//	SkipOffset($offset,mktime(0, 0, 0, $month, $date, $year));
	$no = $offset;
	$sdate = mktime(0, 0, 0, $month, $date, $year);
	$edate = '';
	include 'calendar_skip.php';

   }
   if($offset == 0) $style ="sholy";
   elseif($offset == 6) $style ="ssat";
   else $style = "snum";

   $date_title = '';

   $hChk = $HOLIDAY[$year.sprintf("%02d",$month).sprintf("%02d",$date)];

   if($hChk){
	   $style="sholy";
	   $date_title = "title='{$month}월 {$date}일은 ".$hChk." 입니다'";
   }


   if($date == $today  &&  $year == $thisyear &&  $month == $thismonth){
	   $style = 'snum';
	   $tdgcolor = "background-color:#f5f5f5;";
	   $todayTxt = "<span class='sholy'>TODAY</span>";

   }else{
	   $tdgcolor = '';
	   $todayTxt = '';
   }



	//일별 데이터
	$ymd = $year.sprintf('%02d',$month).sprintf('%02d',$date);
	$wNum = date('W',strtotime($ymd));	//해당주차
	if($offset == 0)		$wNum += 1;			//일요일의 경우 +1
	$vArr = $sArr[$ymd];
	$disClass = '';
	$tmpNo = 0;
?>




			<td style='width:14.28%;height:<?=$cellh?>;vertical-align:top;<?=$tdgcolor?>'>
				<table class='tableOnly'>
				<?
					if($path == 'sub01-sub02' && count($vArr)){
						$r = $year."-".sprintf('%02d',$month)."-".sprintf('%02d',$date);
				?>
					<tr>
						<td style='padding:5px;'><span class="<?=$style?>" style="float:left;"<?=$date_title?>><?=$date2?></span> <?=$todayTxt?> 
						<div class="calMemo">
							<span class="lnr lnr-pencil"></span>

							<!--메모하기-->
							<div  class="calMemoOpen">
								<p class="calMemo_p">메모하기</p>
								<textarea></textarea>
								<div class="side_choice dp_f dp_c dp_cc" style="width: 100%;">
										<span style="margin-right: 10px;">※ 알림 설정 하기 : </span>
										<div>
											<input type="checkbox" id="calmemoAlrt1">
											<label for="calmemoAlrt1"></label>
										</div>
								</div>
								<a class="calmemo_save dp_f dp_c dp_cc" href="" title="저장하기">저장하기</a>
							</div>
							<!--메모하기-->

						</div>
						<span class="lnr lnr-calendar-full" style="float:right;"  onclick="parent.dividendCall('<?=$r?>');" title="일별보기"></span>
						</td>
						<script>
								$(".calMemo").on("click",function(){

									$(".calMemoOpen").hide();
									$(this).children(".calMemoOpen").show();
								});
						</script>
					</tr>
				<?
					}elseif(($path == 'main' || $path == 'sub04-sub01') && count($vArr) && ($dataType == 'earnings' || $dataType == 'dividends')){
						$r = $year."-".sprintf('%02d',$month)."-".sprintf('%02d',$date);
				?>
					<tr>
						<td style='padding:5px;'><span class="<?=$style?>" style="float:left;"<?=$date_title?>><?=$date2?></span> <?=$todayTxt?> 
						<div class="calMemo">
							<span class="lnr lnr-pencil"></span>

							<!--메모하기-->
							<div  class="calMemoOpen">
								<p class="calMemo_p">메모하기</p>
								<textarea></textarea>
								<div class="side_choice dp_f dp_c dp_cc" style="width: 100%;">
										<span style="margin-right: 10px;">※ 알림 설정 하기 : </span>
										<div>
											<input type="checkbox" id="calmemoAlrt1">
											<label for="calmemoAlrt1"></label>
										</div>
								</div>
								<a class="calmemo_save dp_f dp_c dp_cc" href="" title="저장하기">저장하기</a>
							</div>
							<!--메모하기-->

						</div>
						<span class="lnr lnr-calendar-full" style="float:right;"  onclick="dateCall(0,'<?=$r?>');" title="일별보기"></span>

						<script>
								$(".calMemo").on("click",function(){

									$(".calMemoOpen").hide();
									$(this).children(".calMemoOpen").show();
								});
						</script>
						</td>
					</tr>
				<?
					}else{
				?>
					<tr>
						<td style='padding:5px;'><span class=<?=$style?> <?=$date_title?>><?=$date2?></span> <?=$todayTxt?></td>
					</tr>
				<?
					}
				?>



<?
	foreach($vArr as $k => $v){
		$ticker = $v['symbol'];
		$company = $v['name'];

		if($dispNum <= $tmpNo)	$disClass = "class='wr".$wNum." rHide'";
		else								$disClass = "";
?>
					<tr <?=$disClass?>>
						<td onclick="parent.symbolData('<?=$ticker?>','<?=$k?>','<?=$dataType?>');"><div class='scBox'><span style="color:#0048df;"><?=$ticker?></span><br><span><?=$company?></span></div></td>
					</tr>
<?
		$tmpNo++;
	}
?>

				<?if($disClass){?>
					<tr>
						<td style='padding:10px 5px 20px 5px;'><a href="javascript:moreWrap('<?=$wNum?>');" id="bt<?=$wNum?>" class='more-btn bt<?=$wNum?>'>+더보기</a></td>
					</tr>
				<?}?>

				</table>
			</td>

<?
  $date++;
  $offset++;

  if($offset == 7){
	  echo ("</tr>");
	  if($date <= $maxdate){
		  echo ("<tr style='height:$cellh;'>");
		  $ck_row++;
	  }
	  $offset = 0;
  }
} // end of while

if($offset != 0){
//  SkipOffset((7-$offset),'',mktime(0, 0, 0, $month, $date, $year));
  $no = 7-$offset;
  $sdate = '';
  $edate = mktime(0, 0, 0, $month, $date, $year);
  include 'calendar_skip.php';
  echo ("</tr>");
}

?>
<!-- 날짜 테이블 끝 -->

				</table>
			</td>
		</tr>
	</table>

</div>
</form>


<?
//메인 또는 투자다이어리 > 캘린더
if($path == 'main' || $path == 'sub04-sub01'){
?>

<style>
.sec_etf_wrap{margin-top:100px;}
/*.sec_table{max-height:650px;overflow-y:auto;}*/
.sec_etf_wrap .sec_table table tr th:first-child, .sec_etf_wrap .sec_table table tr td:first-child {
	padding-left:0;
	text-align:center;
}
</style>

<div id='listTable'>
<?
	//실시간 환율정보
	$exArr = Util::ExchangeRate();
	$exRate = str_replace(',','',$exArr[1]);

	if(!$cDate)	$cDate = date('Y-m-d');
	$csTime = strtotime($cDate);
	$ceTime = $csTime + 86399;

	if($dataType == 'earnings'){
		$act = 'sub01Table01.php';
		include '/home/myss/www/sub04/sub01Table01.php';	//실적발표


	}elseif($dataType == 'dividends'){
		$act = 'sub01Table02.php';
		include '/home/myss/www/sub04/sub01Table02.php';	//배당

	}elseif($dataType == 'ipo'){
		$csTime = strtotime($year.'-'.$month.'-01');
		$ceTime = strtotime($year.'-'.$month.'-'.$maxdate) + 86399;

		$act = 'sub01Table03.php';
		include '/home/myss/www/sub04/sub01Table03.php';		//IPO
	}
?>
</div>

<script>
function dateCall(r,d){
//	$('.loader').css('top','80%');
	$('#loading').show();

	$('#listTable').load('/sub04/<?=$act?>?jQueryLoad=1&cDate='+d+'&year=<?=$year?>&month=<?=$month?>&maxdate=<?=$maxdate?>&record_start='+r);
}
</script>

<?
}
?>
