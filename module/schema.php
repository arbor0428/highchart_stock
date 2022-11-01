create table ks_member (
	uid int(11) PRIMARY KEY auto_increment,
	mtype char(1),
	name varchar(30),
	userid varchar(30),
	passwd varchar(255),
	userip varchar(30),
	rDate varchar(30),
	rTime int(11),
	lastLogin int(11)
);

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


create table ks_payList (
	uid int(11) PRIMARY KEY auto_increment,
	userid varchar(30),
	payMonth varchar(30),
	payMonthTime int(11),
	payType varchar(30),
	name varchar(30),
	pay01 int(11),
	pay02 int(11),
	pay03 int(11),
	userip varchar(30),
	rDate varchar(30),
	rTime int(11)
);