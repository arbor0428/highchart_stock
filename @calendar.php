<?
	if(!$cellh)	$cellh = '150px';		// date cell height
?>
<link type='text/css' rel='stylesheet' href='/css/calendar.css'>
<style>
.rHide{display:none;}

.more-btn {border:1px solid #d1d1d1; background:#f8f8f8; font-size:13px; padding:5px; box-sizing:border-box;}
.more-btn:hover {background:#d1d1d1;}
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


//블릿색상
$colorArr = Array("#FF0000","#FF8000","#e4e416","#3ADF00","#0000FF","#7401DF","#FF00FF","#B40486","#66666");
shuffle($colorArr);

//달력하단 리스트 제목에서 블릿색상 표시용
$lcArr = Array();

$startTime = mktime(0,0,0,$month,1,$year);
//$startYoil = date('w',$startTime);
//$startTime -= (86400 * $startYoil);	//첫째주 이전월 일자 표기용

$endTime = mktime(23,59,59,$month,$maxdate,$year);
//$endYoil = date('w',$endTime);
//$endTime += (86400 * (6 - $endYoil));	//마지막주 다음달 일자 표기용

//echo date('Y-m-d H:i:s',$startTime).' ~ '.date('Y-m-d H:i:s',$endTime).'<br>';



//임시데이터
$sArr['20220510'] = Array("AAPL"=>"Apple Inc","TSLA"=>"Tesla Inc","RMTI"=>"Rockwell Medical Inc","APAC"=>"Stonebridge Acquisition Corp");
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

function moreWrap(d){
	if(d){
		t = $('#bt'+d).text();
		if(t == '더보기'){
			$('.wr'+d).show();
			$('.bt'+d).text('숨기기');
		}else{
			$('.wr'+d).hide();
			$('.bt'+d).text('더보기');
		}
	}
}
</script>

<form name='frm_cals' method='post' action="<?=$_SERVER['PHP_SELF']?>">
<input type="text" name="none" style="display: none;" title="none">  <!-- 텍스트박스 1개이상 처리.. 자동전송방지 -->
<input type='hidden' name='type' value=''>
<input type='hidden' name='next_url' value="<?=$_SERVER['PHP_SELF']?>">
<input type='hidden' name='year' value='<?=$year?>'>
<input type='hidden' name='month' value='<?=$month?>'>
<input type='hidden' name='day' value=''>

<table class='tableOnly'>
	<tr>
		<td style='padding-top:10px;padding-bottom:20px;'>
			<table style="margin:0 auto;">
				<tr>
					<td><a href="javascript:setCalendar('<?=$prevyear-1?>','<?=$prevmonth?>');" onfocus='this.blur()' alt='이전연도'><img src='/img/arrowLeft02.png' style='margin-bottom:2px;' alt='이전연도'></a></td>
					<td><a href="javascript:setCalendar('<?=$prevyear?>','<?=$prevmonth?>');" onfocus='this.blur()' alt='이전달'><img src='/img/arrowLeft.jpg' style='margin-bottom:2px;' alt='이전달'></a></td>
					<td style='padding:14px 30px 15px 30px;text-align:center;'><span class='calsTitle'><?=$year?>년 <?=$month?>월</span></td>
					<td><a href="javascript:setCalendar('<?=$nextyear?>','<?=$nextmonth?>');" onfocus='this.blur()' alt='다음달'><img src='/img/arrowRight.jpg' style='margin-bottom:2px;' alt='다음달'></a></td>
					<td><a href="javascript:setCalendar('<?=$nextyear+1?>','<?=$nextmonth?>');" onfocus='this.blur()' alt='다음연도'><img src='/img/arrowRight02.png' style='margin-bottom:2px;' alt='다음연도'></a></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style='padding-top:5px;'>
			<table class='tableOnly'>
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
				<tr>


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

   }else{
	   $tdgcolor = '';
   }
?>



		<td style='width:14.28%;height:<?=$cellh?>;vertical-align:top;<?=$tdgcolor?>'>
			<table class='tableOnly'>
				<tr>
					<td style='padding:5px;'><span class=<?=$style?> <?=$date_title?>><?=$date2?></span></td>
				</tr>


<?
	$ymd = $year.sprintf('%02d',$month).sprintf('%02d',$date);
	$wNum = date('W',strtotime($ymd));	//해당주차
	if($offset == 0)		$wNum += 1;			//일요일의 경우 +1
	$vArr = $sArr[$ymd];
	$disClass = '';
	$tmpNo = 0;

	foreach($vArr as $k => $v){
		$ticker = $k;
		$company = $v;

		if($dispNum <= $tmpNo)	$disClass = "class='wr".$wNum." rHide'";
		else								$disClass = "";
?>
				<tr <?=$disClass?>>
					<td onclick="clasView('<?=$uid?>');"><div class='scBox'><?=$ticker?><br><?=$company?></div></td>
				</tr>
<?
		$tmpNo++;
	}
?>

			<?if($disClass){?>
				<tr>
					<td style='padding:10px 0 20px 5px;'><a href="javascript:moreWrap('<?=$wNum?>');" id="bt<?=$wNum?>" class='more-btn bt<?=$wNum?>'>더보기</a></td>
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

</form>