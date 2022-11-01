<?
if($datalist_ID){
?>

<datalist id="<?=$datalist_ID?>">
<?
	foreach($slistArr as $v){
		$labelTxt = '';
		
		//Company_Profile
		if($v['name']){
			$labelTxt = $v['name'];

			if($v['nameKor']){
				if($labelTxt)		$labelTxt .= '('.$v['nameKor'].')';
				else				$labelTxt = $v['nameKor'];
			}

		//ETFs_Profile
		}elseif($v['eftName']){
			$labelTxt = $v['eftName'];
		}
		echo "<option value='".$v['symbol']."' label='".$labelTxt."'>".$v['symbol']."</option>";
	}
?>
</datalist>

<?
}
?>