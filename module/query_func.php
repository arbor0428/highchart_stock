<?
function sqlExe($sql){
	$result = mysql_query($sql);
	if(mysql_errno()){
		mysql_query("insert into error_query set 
			userid='$_SESSION[ses_member_id]'
			,request_uri='$_SERVER[REQUEST_URI]'
			,http_referer='$_SERVER[HTTP_REFERER]'
			,postdata='".addslashes(var_export($_POST,true))."'
			,query='".addslashes($sql)."'
			,errmsg='".addslashes(mysql_error())."'
			,userip='$_SERVER[REMOTE_ADDR]'
			,regdate=now()
		");
		echo "<script>alert('오류가 발생하였습니다.');</script>";
		exit;
	}
	return $result;
}

function sqlExeMsg($sql){
	$result = mysql_query($sql);
	if(mysql_errno()){
		mysql_query("insert into error_query set 
			userid='$_SESSION[ses_member_id]'
			,request_uri='$_SERVER[REQUEST_URI]'
			,http_referer='$_SERVER[HTTP_REFERER]'
			,postdata='".addslashes(var_export($_POST,true))."'
			,query='".addslashes($sql)."'
			,errmsg='".addslashes(mysql_error())."'
			,userip='$_SERVER[REMOTE_ADDR]'
			,regdate=now()
		");
		echo addslashes($sql);
//		exit;
	}
	return $result;
}

function sqlArray( $sql, $idx='', $idx_array=false ) {
	$result = sqlExe($sql);
	$data = Array();
	while( $row = mysql_fetch_array($result) ) {
		if( $idx ) {
			if( $idx_array )	$data[$row[$idx]][] = $row;
			else				$data[$row[$idx]] = $row;
		}
		else $data[] = $row;
	}
	return $data;
}

function sqlArrayOne($sql) {
	$result = sqlExe($sql);
	while( $row = mysql_fetch_array($result) ) $data[] = $row[0];
	return $data;
}

function sqlRow( $sql ) {
	$result = sqlExe($sql);
	$row = mysql_fetch_array($result);
	return $row;
}

function sqlRowOne( $sql ) {
	$result = sqlExe($sql);
	$row = mysql_fetch_array($result);
	return $row[0];
}

// 쿼리
function sql_query($sql, $error=false) {
    if ($error) $result = @mysql_query($sql) or die(mysql_errno().' : '.mysql_error());
    else $result = @mysql_query($sql);
    return $result;
}

// 쿼리를 실행한 후 결과값에서 한행을 얻는다.
function sql_fetch($sql, $error=true) {
    $result = sql_query($sql, $error);
    $row = sql_fetch_array($result);
    return $row;
}

// 결과값에서 한행 연관배열(이름으로)로 얻는다.
function sql_fetch_array($result) {
    $row = @mysql_fetch_assoc($result);
    return $row;
}


/*
create table error_query (
	uid int(11) PRIMARY KEY auto_increment,
	userid varchar(50),
	request_uri varchar(255),
	http_referer varchar(255),
	postdata text,
	query text,
	errmsg text,
	userip varchar(50),
	regdate datetime
);
*/
?>