/* 
@author: evilnapsis
@brief: updated 2018 
*/
create database blogelin;
use blogelin;

create table category(
	id int not null auto_increment primary key,
	name varchar(255)
);


create table post(
	id int not null auto_increment primary key,
	title varchar(255),
	brief varchar(511),
	content text,
	image varchar(255),
	created_at datetime,
	status int default 1,
	category_id int not null,
	foreign key (category_id) references category(id)
);


create table comment(
	id int not null auto_increment primary key,
	name varchar(255),
	comment varchar(255),
	email varchar(255),
	post_id int not null,
	created_at datetime,
	status int default 1,
	foreign key (post_id) references post(id)
);



create table user(
	id int not null auto_increment primary key,
	name varchar(50),
	lastname varchar(50),
	username varchar(50),
	email varchar(255),
	password varchar(60),
	image varchar(255),
	status int default 1,
	kind int default 1, 
	created_at datetime
);

/**
* password: encrypted using sha1(md5("mypassword"))
* status: 1. active, 2. inactive, 3. other, ...
* kind: 1. root, 2. other, ...
**/

insert into user (name,username,password,kind,created_at) value ("Administrator","admin",sha1(md5("admin")),1,NOW());


