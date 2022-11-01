<?
    function sunlunar_data() {
        return "1212122322121-1212121221220-1121121222120-2112132122122-2112112121220-2121211212120-2212321121212-2122121121210-2122121212120-1232122121212-1212121221220-1121123221222-1121121212220-1212112121220-2121231212121-2221211212120-1221212121210-2123221212121-2121212212120-1211212232212-1211212122210-2121121212220-1212132112212-2212112112210-2212211212120-1221412121212-1212122121210-2112212122120-1231212122212-1211212122210-2121123122122-2121121122120-2212112112120-2212231212112-2122121212120-1212122121210-2132122122121-2112121222120-1211212322122-1211211221220-2121121121220-2122132112122-1221212121120-2121221212110-2122321221212-1121212212210-2112121221220-1231211221222-1211211212220-1221123121221-2221121121210-2221212112120-1221241212112-1212212212120-1121212212210-2114121212221-2112112122210-2211211412212-2211211212120-2212121121210-2212214112121-2122122121120-1212122122120-1121412122122-1121121222120-2112112122120-2231211212122-2121211212120-2212121321212-2122121121210-2122121212120-1212142121212-1211221221220-1121121221220-2114112121222-1212112121220-2121211232122-1221211212120-1221212121210-2121223212121-2121212212120-1211212212210-2121321212221-2121121212220-1212112112210-2223211211221-2212211212120-1221212321212-1212122121210-2112212122120-1211232122212-1211212122210-2121121122210-2212312112212-2212112112120-2212121232112-2122121212110-2212122121210-2112124122121-2112121221220-1211211221220-2121321122122-2121121121220-2122112112322-1221212112120-1221221212110-2122123221212-1121212212210-2112121221220-1211231212222-1211211212220-1221121121220-1223212112121-2221212112120-1221221232112-1212212122120-1121212212210-2112132212221-2112112122210-2211211212210-2221321121212-2212121121210-2212212112120-1232212122112-1212122122110-2121212322122-1121121222120-2112112122120-2211231212122-2121211212120-2122121121210-2124212112121-2122121212120-1212121223212-1211212221220-1121121221220-2112132121222-1212112121220-2121211212120-2122321121212-1221212121210-2121221212120-1232121221212-1211212212210-2121123212221-2121121212220-1212112112220-1221231211221-2212211211220-1212212121210-2123212212121-2112122122120-1211212322212-1211212122210-2121121122120-2212114112122-2212112112120-2212121211210-2212232121211-2122122121210-2112122122120-1231212122212-1211211221220-2121121321222-2121121121220-2122112112120-2122141211212-1221221212110-2121221221210-2114121221221";
    }

    function lun2sol($yyyymmdd) {
        $getYEAR = (int)substr($yyyymmdd,0,4);
        $getMONTH = (int)substr($yyyymmdd,4,2);
        $getDAY = (int)substr($yyyymmdd,6,2);
        
        $arrayDATASTR = sunlunar_data();
        $arrayDATA = explode("-",$arrayDATASTR);
        
        $arrayLDAYSTR="31-0-31-30-31-30-31-31-30-31-30-31";
        $arrayLDAY = explode("-",$arrayLDAYSTR);
    
        $arrayYUKSTR="갑-을-병-정-무-기-경-신-임-계";
        $arrayYUK = explode("-",$arrayYUKSTR);
    
        $arrayGAPSTR="자-축-인-묘-진-사-오-미-신-유-술-해";
        $arrayGAP = explode("-",$arrayGAPSTR);
    
        $arrayDDISTR="쥐-소-호랑이-토끼-용-뱀-말-양-원숭이-닭-개-돼지";
        $arrayDDI = explode("-",$arrayDDISTR);
    
        $arrayWEEKSTR="일-월-화-수-목-금-토";
        $arrayWEEK = explode("-",$arrayWEEKSTR);
        
        if ($getYEAR <= 1881 || $getYEAR >= 2050) { //년수가 해당일자를 넘는 경우
           $YunMonthFlag = 0;
            return false;    //년도 범위가 벗어남.. 
        }
        if ($getMONTH > 12) { // 달수가 13이 넘는 경우
           $YunMonthFlag = 0;
            return false;    //달수 범위가 벗어남.. 
        }    
        $m1 = $getYEAR - 1881;
        if (substr($arrayDATA[$m1],12,1) == 0) { // 윤달이 없는 해임
            $YunMonthFlag = 0;
        } else {
            if (substr($arrayDATA[$m1],$getMONTH, 1) > 2) {
                $YunMonthFlag = 1;
            } else {
                $YunMonthFlag = 0;
            }
        }
//-------------    
    $m1 = -1;
    $td = 0;

    if ($getYEAR > 1881 && $getYEAR < 2050) {
       $m1 = $getYEAR - 1882;
       for ($i=0;$i<=$m1;$i++) {
           for ($j=0;$j<=12;$j++) {
              $td = $td + (substr($arrayDATA[$i],$j,1));
           }
           if (substr($arrayDATA[$i],12,1) == 0) {
              $td = $td + 336;
           } else {
              $td = $td + 362;
           }
       }
    } else {
        $gf_lun2sol = 0;
    }
    
    $m1++;
    $n2 = $getMONTH - 1;
    $m2 = -1;
    
    while(1) {
       $m2++;
       if (substr($arrayDATA[$m1], $m2, 1) > 2) {
          $td = $td + 26 + (substr($arrayDATA[$m1], $m2, 1));
          $n2++;
       } else {
          if ($m2 == $n2) {
            if ($gf_yun) {
                $td = $td + 28 + (substr($arrayDATA[$m1], $m2, 1));
            }
            break;
          } else {
             $td = $td + 28 + (substr($arrayDATA[$m1], $m2, 1));
          }
       }
     }
     
     $td = $td + $getDAY + 29;
     $m1 = 1880;
     while(1) {
          $m1++;
          if ($m1 % 400 == 0 || $m1 % 100 != 0 && $m1 % 4 == 0) {
             $leap = 1;
          } else {
             $leap = 0;
          }
          
          if ($leap == 1) {
             $m2 = 366;
          } else {
             $m2 = 365;
          }
          
          if ($td < $m2) break;
          
          $td = $td - $m2;
     }
     $syear = $m1;
     $arrayLDAY[1] = $m2 - 337;

     $m1 = 0;
     
     while(1) {
          $m1++;
          if ($td <= $arrayLDAY[$m1-1]) {
             break;
          }
          $td = $td - $arrayLDAY[$m1-1];
     }
     $smonth = $m1;
     $sday = $td;
     $y = $syear - 1;
     $td = intval($y*365) + intval($y/4) - intval($y/100) + intval($y/400);
     
     if ($syear % 400 == 0 || $syear % 100 != 0 && $syear % 4 == 0) {
        $leap = 1;
     } else {
        $leap = 0;
     }

     if ($leap == 1) {
        $arrayLDAY[1] = 29;
     } else {
        $arrayLDAY[1] = 28;
     }
     for ($i=0;$i<=$smonth-2;$i++) {
         $td = $td + $arrayLDAY[$i];
     }
     $td = $td + $sday;
     $w = $td % 7;
     
     $sweek = $arrayWEEK[$w];
     $gf_lun2sol = 1;

    // return($syear."|".$smonth."|".$sday."|".$sweek);
	 return(mktime(0,0,0,$smonth,$sday,$syear));
    }


    function sol2lun($yyyymmdd) {
        $getYEAR = (int)substr($yyyymmdd,0,4);
        $getMONTH = (int)substr($yyyymmdd,4,2);
        $getDAY = (int)substr($yyyymmdd,6,2);
        
        $arrayDATASTR = sunlunar_data();
        $arrayDATA = explode("-",$arrayDATASTR);

        $arrayLDAYSTR="31-0-31-30-31-30-31-31-30-31-30-31";
        $arrayLDAY = explode("-",$arrayLDAYSTR);

        $arrayYUKSTR="갑-을-병-정-무-기-경-신-임-계";
        $arrayYUK = explode("-",$arrayYUKSTR);
    
        $arrayGAPSTR="자-축-인-묘-진-사-오-미-신-유-술-해";
        $arrayGAP = explode("-",$arrayGAPSTR);
    
        $arrayDDISTR="쥐-소-호랑이-토끼-용-뱀-말-양-원숭이-닭-개-돼지";
        $arrayDDI = explode("-",$arrayDDISTR);
        
        $arrayWEEKSTR="일-월-화-수-목-금-토";
        $arrayWEEK = explode("-",$arrayWEEKSTR);

        $dt = $arrayDATA;

        for ($i=0;$i<=168;$i++) {
            $dt[$i] = 0;
            for ($j=0;$j<12;$j++) {
                switch (substr($arrayDATA[$i],$j,1)) {
                    case 1:
                        $dt[$i] += 29;
                        break;
                    case 3:
                        $dt[$i] += 29;
                        break;
                    case 2:
                        $dt[$i] += 30;
                        break;
                    case 4:
                        $dt[$i] += 30;
                        break;
                }
            }

            switch (substr($arrayDATA[$i],12,1)) {
                case 0:
                    break;
                case 1:
                    $dt[$i] += 29;
                    break;
                case 3:
                    $dt[$i] += 29;
                    break;
                case 2:
                    $dt[$i] += 30;
                    break;
                case 4:
                    $dt[$i] += 30;
                    break;
            }
        }


        $td1 = 1880 * 365 + (int)(1880/4) - (int)(1880/100) + (int)(1880/400) + 30;
        $k11 = $getYEAR - 1;

        $td2 = $k11 * 365 + (int)($k11/4) - (int)($k11/100) + (int)($k11/400);
        
        if ($getYEAR % 400 == 0 || $getYEAR % 100 != 0 && $getYEAR % 4 == 0) {
            $arrayLDAY[1] = 29;
        } else {
            $arrayLDAY[1] = 28;
        }
        
        if ($getMONTH > 13) {
            $gf_sol2lun = 0;
        }

        if ($getDAY > $arrayLDAY[$getMONTH-1]) {
            $gf_sol2lun = 0;
        }
        
        for ($i=0;$i<=$getMONTH-2;$i++) {
            $td2 += $arrayLDAY[$i];
        }
        
        $td2 += $getDAY;
        $td = $td2 - $td1 + 1;
        $td0 = $dt[0];
    
        for ($i=0;$i<=168;$i++) {
            if ($td <= $td0) {
               break;
            }
            $td0 += $dt[$i+1];
        }
        
        $ryear = $i + 1881;
        $td0 -= $dt[$i];
        $td -= $td0;
        
        if (substr($arrayDATA[$i], 12, 1) == 0) {
           $jcount = 11;
        } else {
           $jcount = 12;
        }
        $m2 = 0;
        
        for ($j=0;$j<=$jcount;$j++) { // 달수 check, 윤달 > 2 (by harcoon)
            if (substr($arrayDATA[$i],$j,1) <= 2) {
                $m2++;
                $m1 = substr($arrayDATA[$i],$j,1) + 28;
                $gf_yun = 0;
            } else {
                $m1 = substr($arrayDATA[$i],$j,1) + 26;
                $gf_yun = 1;
            }
            if ($td <= $m1) {
               break;
            }
            $td = $td - $m1;
        }
    
         $k1=($ryear+6) % 10;
         $syuk = $arrayYUK[$k1];
         $k2=($ryear+8) % 12;
         $sgap = $arrayGAP[$k2];
         $sddi = $arrayDDI[$k2];
        
        $gf_sol2lun = 1;
        
        return ($ryear."|".$m2."|".$td."|".$syuk.$sgap."년|".$sddi."띠");
    }










/****************** 휴일 정의 ************************/
$HOLIDAY = Array();

if($sRange == '')	$sRange = 10;
if($eRange == '')	$eRange = 10;

$sYear = date('Y') - $sRange;
$eYear = date('Y') + $eRange;

//$yearRange = 'c-'.$sRange.':c+'.$eRange;
$yearRange = $sYear.':'.$eYear;


for($i=$sYear; $i<=$eYear; $i++){
	$tmp = lun2sol($i."0101");   //설날
	$HOLIDAY[] = array(0=>date("md",($tmp-(3600*24))),1=>'설연휴',2=>$i);
	$HOLIDAY[] = array(0=>date("md",$tmp),1=>'설날',2=>$i);
	$HOLIDAY[] = array(0=>date("md",($tmp+(3600*24))),1=>'설연휴',2=>$i);

	$tmp = lun2sol($i."0408");   //석가탄신일
	$HOLIDAY[] = array(0=>date("md",$tmp),1=>'석가탄신일',2=>$i);

	$tmp = lun2sol($i."0815");   //추석
	$HOLIDAY[] = array(0=>date("md",($tmp-(3600*24))),1=>'추석연휴',2=>$i);
	$HOLIDAY[] = array(0=>date("md",$tmp),1=>'추석',2=>$i);
	$HOLIDAY[] = array(0=>date("md",($tmp+(3600*24))),1=>'추석연휴',2=>$i);
}

unset($tmp);

/****************** 휴일 정의 ************************/
?>

<link href="/module/datepicker/bootstrap-datepicker3.standalone.css" rel="stylesheet">
<script src="/module/datepicker/bootstrap-datepicker.js"></script>
<script src="/module/datepicker/bootstrap-datepicker.ko.js"></script>

<style>
/*
.fpicker{
	background:url('/img/cals.jpg') no-repeat;
	background-color:#fff !important;
	background-position:calc(100% - 5px) center;
	cursor:pointer;
}
*/
.table-condensed th, .table-condensed td{font-size:14px;}

.table-condensed td.date-saturday{color:#4e73df !important;}
.table-condensed td.date-sunday, .table-condensed td.holiday{color:#e74a3b !important;}
.table-condensed td.old, .table-condensed td.new{color:#d6d6d6 !important;}

.table-condensed span.disabled{color:#d6d6d6 !important;}

</style>

<!-- 달력구조
<div class="datepicker-days" style="">
	<table class="table-condensed">
		<thead>
			<tr>
				<th colspan="7" class="datepicker-title" style="display: none;"></th>
			</tr>
			<tr>
				<th class="prev">«</th>
				<th colspan="5" class="datepicker-switch">2021년12월</th>
				<th class="next">»</th>
			</tr>
			<tr>
				<th class="dow">일</th>
				<th class="dow">월</th>
				<th class="dow">화</th>
				<th class="dow">수</th>
				<th class="dow">목</th>
				<th class="dow">금</th>
				<th class="dow">토</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="old day" data-date="1638057600000">28</td>
				<td class="old day" data-date="1638144000000">29</td>
				<td class="old day" data-date="1638230400000">30</td>
				<td class="day" data-date="1638316800000">1</td>
				<td class="day" data-date="1638403200000">2</td>
				<td class="day" data-date="1638489600000">3</td>
				<td class="day" data-date="1638576000000">4</td>
			</tr>
			<tr>
				<td class="day" data-date="1640476800000">26</td>
				<td class="day" data-date="1640563200000">27</td>
				<td class="day" data-date="1640649600000">28</td>
				<td class="today day" data-date="1640736000000">29</td>
				<td class="day" data-date="1640822400000">30</td>
				<td class="day" data-date="1640908800000">31</td>
				<td class="new day" data-date="1640995200000">1</td>
			</tr>
		</tfoot>
	</table>
</div>
-->

<script>
$(document).ready(function () {
	$('.fpicker').prop('readonly', true);
});

$(function() {	
	holidays = new Array();
<?
for($i=0;$i<count($HOLIDAY);$i++){
	$h0 = $HOLIDAY[$i][0];
	$h1 = $HOLIDAY[$i][1];
	$h2 = $HOLIDAY[$i][2];

	$mod = $i % 7;

	if($mod == 0){
?>
	holidays["<?=$h2?>0101"] = "신정";
	holidays["<?=$h2?>0301"] = "삼일절";
	holidays["<?=$h2?>0505"] = "어린이날";
	holidays["<?=$h2?>0606"] = "현충일";
	holidays["<?=$h2?>0815"] = "광복절";
	holidays["<?=$h2?>1003"] = "개천절";
	holidays["<?=$h2?>1009"] = "한글날";
	holidays["<?=$h2?>1225"] = "크리스마스";
<?
	}
?>
	holidays["<?=$h2?><?=$h0?>"] = "<?=$h1?>";
<?
}
?>

	$('.fpicker').datepicker({
		format: "yyyy-mm-dd",	//데이터 포맷 형식(yyyy : 년 mm : 월 dd : 일 )
		startDate: '2000-01-01',	//달력에서 선택 할 수 있는 가장 빠른 날짜. 이전으로는 선택 불가능 ( d : 일 m : 달 y : 년 w : 주)
		endDate: '',	//달력에서 선택 할 수 있는 가장 느린 날짜. 이후로 선택 불가 ( d : 일 m : 달 y : 년 w : 주)
		autoclose : true,	//사용자가 날짜를 클릭하면 자동 캘린더가 닫히는 옵션
		calendarWeeks : false, //캘린더 옆에 몇 주차인지 보여주는 옵션 기본값 false 보여주려면 true
		clearBtn : false, //날짜 선택한 값 초기화 해주는 버튼 보여주는 옵션 기본값 false 보여주려면 true
		datesDisabled : [],//선택 불가능한 일 설정 하는 배열 위에 있는 format 과 형식이 같아야함.
		daysOfWeekDisabled : [],	//선택 불가능한 요일 설정 0 : 일요일 ~ 6 : 토요일
		daysOfWeekHighlighted : [], //강조 되어야 하는 요일 설정
		disableTouchKeyboard : false,	//모바일에서 플러그인 작동 여부 기본값 false 가 작동 true가 작동 안함.
		immediateUpdates: false,	//사용자가 보는 화면으로 바로바로 날짜를 변경할지 여부 기본값 :false 
		multidate : false, //여러 날짜 선택할 수 있게 하는 옵션 기본값 :false 
		multidateSeparator :",", //여러 날짜를 선택했을 때 사이에 나타나는 글짜 2019-05-01,2019-06-01
		templates : {
			leftArrow: '&laquo;',
			rightArrow: '&raquo;'
		}, //다음달 이전달로 넘어가는 화살표 모양 커스텀 마이징 
		showWeekDays : true ,// 위에 요일 보여주는 옵션 기본값 : true
		title: "",	//캘린더 상단에 보여주는 타이틀
		todayHighlight : true ,	//오늘 날짜에 하이라이팅 기능 기본값 :false 
		toggleActive : true,	//이미 선택된 날짜 선택하면 기본값 : false인경우 그대로 유지 true인 경우 날짜 삭제
		weekStart : 0 ,//달력 시작 요일 선택하는 것 기본값은 0인 일요일 
		language : "ko",	//달력의 언어 선택, 그에 맞는 js로 교체해줘야한다.
        beforeShowDay: function(dateTxt){
			yy = dateTxt.getFullYear();
			mm = dateTxt.getMonth() + 1;
			dd = dateTxt.getDate();

			day = yy+(("00"+mm.toString()).slice(-2))+(("00"+dd.toString()).slice(-2));

			holiday = holidays[day];

            // exist holiday?
            if (holiday){
				return {tooltip: holiday,classes: 'holiday'};

            }else{
                switch (dateTxt.getDay()) {
                    case 0: // is sunday?
						return {classes: 'date-sunday'};

                    case 6: // is saturday?
						return {classes: 'date-saturday'};
                }
            }
        },

		
	});//datepicker end
});//ready end

/* 원본
$(function() {	
	$('.fpicker').datepicker({
		format: "yyyy-mm-dd",	//데이터 포맷 형식(yyyy : 년 mm : 월 dd : 일 )
		startDate: '-10d',	//달력에서 선택 할 수 있는 가장 빠른 날짜. 이전으로는 선택 불가능 ( d : 일 m : 달 y : 년 w : 주)
		endDate: '+10d',	//달력에서 선택 할 수 있는 가장 느린 날짜. 이후로 선택 불가 ( d : 일 m : 달 y : 년 w : 주)
		autoclose : true,	//사용자가 날짜를 클릭하면 자동 캘린더가 닫히는 옵션
		calendarWeeks : false, //캘린더 옆에 몇 주차인지 보여주는 옵션 기본값 false 보여주려면 true
		clearBtn : false, //날짜 선택한 값 초기화 해주는 버튼 보여주는 옵션 기본값 false 보여주려면 true
		datesDisabled : ['2019-06-24','2019-06-26'],//선택 불가능한 일 설정 하는 배열 위에 있는 format 과 형식이 같아야함.
		daysOfWeekDisabled : [0,6],	//선택 불가능한 요일 설정 0 : 일요일 ~ 6 : 토요일
		daysOfWeekHighlighted : [], //강조 되어야 하는 요일 설정
		disableTouchKeyboard : false,	//모바일에서 플러그인 작동 여부 기본값 false 가 작동 true가 작동 안함.
		immediateUpdates: false,	//사용자가 보는 화면으로 바로바로 날짜를 변경할지 여부 기본값 :false 
		multidate : false, //여러 날짜 선택할 수 있게 하는 옵션 기본값 :false 
		multidateSeparator :",", //여러 날짜를 선택했을 때 사이에 나타나는 글짜 2019-05-01,2019-06-01
		templates : {
			leftArrow: '&laquo;',
			rightArrow: '&raquo;'
		}, //다음달 이전달로 넘어가는 화살표 모양 커스텀 마이징 
		showWeekDays : true ,// 위에 요일 보여주는 옵션 기본값 : true
		title: "",	//캘린더 상단에 보여주는 타이틀
		todayHighlight : true ,	//오늘 날짜에 하이라이팅 기능 기본값 :false 
		toggleActive : true,	//이미 선택된 날짜 선택하면 기본값 : false인경우 그대로 유지 true인 경우 날짜 삭제
		weekStart : 0 ,//달력 시작 요일 선택하는 것 기본값은 0인 일요일 
		language : "ko"	//달력의 언어 선택, 그에 맞는 js로 교체해줘야한다.
		
	});//datepicker end
});//ready end
*/
</script>