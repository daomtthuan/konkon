drop database if exists konkon;
create database konkon;
use konkon;

create table table_user (
  user_id varchar(32) not null,
  user_account varchar(100) not null unique,
  user_password varchar(100) not null,
  user_email varchar(100) not null,
  user_status int not null, -- 1: active, 2: not auth, 0: disable,
  user_name varchar(100) not null,
  user_gender bit not null, -- 1: male, 0: female
  user_birthday date not null,
  user_phone varchar(15) not null,
  user_address varchar(200) not null,
  
  primary key (user_id)
);

create table table_scope (
  scope_id varchar(32) not null,
  scope_name varchar(100) not null unique,
  scope_status bit not null, -- 1: enable, 0: disable
  
  primary key (scope_id)
);

create table table_userScope (
	userScope_user varchar(32) not null,
  userScope_scope varchar(32) not null,
  
  primary key (userScope_user, userScope_scope),
  foreign key (userScope_user) references table_user(user_id),
  foreign key (userScope_scope) references table_scope(scope_id)
);

create table table_news (
  news_id varchar(32) not null,
  news_name varchar(100) not null unique,
  news_status bit not null, -- 1: enable, 0: disable
  news_title varchar(100) not null,
	news_date date not null,
  news_intro varchar(500) not null,
  news_auth varchar(32) not null,
  
  primary key (news_id),
  foreign key (news_auth) references table_user(user_id)
);

create table table_categoryGroup (
  categoryGroup_id varchar(32) not null,
  categoryGroup_name varchar(100) not null unique,
  categoryGroup_status bit not null, -- 1: enable, 0: disable
  
  primary key (categoryGroup_id)
);

create table table_category (
  category_id varchar(32) not null,
  category_name varchar(100) not null unique,
  category_status bit not null, -- 1: enable, 0: disable
  category_categoryGroup varchar(32) not null,
  
  primary key (category_id),
  foreign key (category_categoryGroup) references table_categoryGroup(categoryGroup_id)
);

create table table_brand (
  brand_id varchar(32) not null,
  brand_name varchar(100) not null unique,
  brand_status bit not null, -- 1: enable, 0: disable
  
  primary key (brand_id)
);

create table table_product (
  product_id varchar(32) not null,
  product_name varchar(100) not null unique,
  product_status bit not null, -- 1: enable, 0: disable
  product_price int not null,
  product_quantity int not null,
  product_category varchar(32) not null,
	product_brand varchar(32) not null,
  
  primary key (product_id),
  foreign key (product_category) references table_category(category_id),
	foreign key (product_brand) references table_brand(brand_id)
);

-- ------------------------------

create view view_user as (
	select 
		user_id,
    user_account,
    user_email,
    user_status,
    user_name,
    user_gender,
    user_birthday,
    user_phone,
    user_address
  from table_user
);

create view view_scope as (
	select *
  from table_scope
);

create view view_news as (
	select 
		news_id,
    news_name,
    news_status,
    news_title,
    news_date,
    news_intro,
    user_name as news_auth
  from table_news
		join table_user on user_id = news_auth
);

-- ------------------------------

delimiter //
create function createId() returns varchar(32) begin
  return replace(uuid(),'-','');
end //

create procedure getUserScopeByUserId(_id varchar(32), _status int) begin
	select 
    table_scope.*
  from table_userScope
		join table_user on user_id = userScope_user
    join table_scope on scope_id = userScope_scope
	where
		user_id = _id and
    case when _status = -1 then true else scope_status = _status end;
end //

create procedure getUserById(_id varchar(32), _status int) begin
	select *
  from table_user
	where
		user_id = _id and
    case when _status = -1 then true else user_status = _status end;
end //

create procedure getUserByAccount(_account varchar(100), _status int) begin
	select *
  from table_user
	where
		user_account = _account and
    case when _status = -1 then true else user_status = _status end;
end //

create procedure getScopeById(_id varchar(32), _status int) begin
	select *
  from table_scope
	where
		scope_id = _id and
    case when _status = -1 then true else scope_status = _status end;
end //

create procedure getScopeByName(_name varchar(100), _status int) begin
	select *
  from table_scope
	where
		scope_name = _name and
    case when _status = -1 then true else scope_status = _status end;
end //

create procedure getCategoryGroup(_status int) begin
	select *
  from table_categoryGroup
	where
    case when _status = -1 then true else categoryGroup_status = _status end;
end //

create procedure getCategoryByCategoryGroupId(_id int, _status int) begin
	select *
  from table_category
	where
		category_categoryGroup = _id and
    case when _status = -1 then true else category_status = _status end;
end //

create procedure getNewsByPage(_page int, _status int) begin
	declare _from int default (_page * 10 - 10);
	select 
		news_id,
    news_name,
    news_status,
    news_title,
    news_date,
    news_intro,
    user_name as news_auth
  from table_news
		join table_user on user_id = news_auth
  where
    case when _status = -1 then true else news_status = _status end
	order by news_date desc
	limit _from, 10;
end //

create procedure getNewsByName(_name varchar(100), _status int) begin
	select 
		news_id,
    news_name,
    news_status,
    news_title,
    news_date,
    news_intro,
    user_name as news_auth
  from table_news
		join table_user on user_id = news_auth
  where
		news_name = _name and
    case when _status = -1 then true else news_status = _status end;
end //

create procedure getNewsById(_id varchar(32), _status int) begin
	select 
		news_id,
    news_name,
    news_status,
    news_title,
    news_date,
    news_intro,
    user_name as news_auth
  from table_news
		join table_user on user_id = news_auth
  where
		news_id = _id and
    case when _status = -1 then true else news_status = _status end;
end //

-- ------------------------------

create procedure addUser(_account varchar(100), _password varchar(100), _email varchar(100), _name varchar(100), _gender bit, _birthday date, _phone varchar(15), _address varchar(200)) begin
	insert into table_user values(
		createId(), -- id
		_account, -- account
		_password, -- password
		_email, -- email
		2, -- status
		_name, -- name
		_gender, -- gender
		_birthday, -- birthday
		_phone, -- phone
		_address -- address
  );
end //

create procedure addUserWithStatus(_account varchar(100), _password varchar(100), _email varchar(100), _name varchar(100), _gender bit, _birthday date, _phone varchar(15), _address varchar(200), _status int) begin
	declare _id varchar(32) default createId();
  insert into table_user values(
		_id, -- id
		_account, -- account
		_password, -- password
		_email, -- email
		_status, -- status
		_name, -- name
		_gender, -- gender
		_birthday, -- birthday
		_phone, -- phone
		_address -- address
  );
  select _id as id;
end //

create procedure addScope(_name varchar(100), _status int) begin
	declare _id varchar(32) default createId();
  insert into table_scope values(
		_id, -- id
		_name, -- name
		_status -- status
  );
  select _id as id;
end //

create procedure addNews(_name varchar(100), _title varchar(100), _date date, _intro varchar(500), _auth varchar(32), _status int) begin
	declare _id varchar(32) default createId();
	insert into table_news values(
		_id, -- id
		_name, -- name
		_status, -- status
		_title, -- title
		_date, -- date
		_intro, -- intro
		_auth -- auth
	);
  select _id as id;
end //

-- ------------------------------

create procedure setUser(_id varchar(32), _email varchar(100), _name varchar(100), _gender bit, _birthday date, _phone varchar(15), _address varchar(200)) begin
	update table_user set 
		user_email = _email,
		user_name = _name,
		user_gender = _gender,
		user_birthday = _birthday,
		user_phone = _phone,
		user_address = _address
	where user_id = _id;
end //

create procedure setPasswordUser(_id varchar(32), _password varchar(100)) begin
	update table_user set 
		user_password = _password
	where user_id = _id;
end //

create procedure setStatusUser(_id varchar(32), _status int) begin
	update table_user set 
		user_status = _status
	where user_id = _id;
end //

create procedure setScope(_id varchar(32), _name varchar(100), _status int) begin
	update table_scope set 
		scope_name = _name,
		scope_status = _status
	where scope_id = _id;
end //

create procedure setNews(_id varchar(32), _name varchar(100), _title varchar(100), _date date, _intro varchar(500), _status int) begin
	update table_news set 
		news_name = _name,
		news_title = _title,
    news_date = _date,
    news_intro = _intro,
    news_status = _status
	where news_id = _id;	
end //

-- ------------------------------             

create procedure deleteUser(_id varchar(32)) begin
	delete from table_news
  where news_auth = _id;
  
	delete from table_userScope
  where userScope_user = _id;
  
	delete from table_user
  where user_id = _id;
end //

create procedure deleteScope(_id varchar(32)) begin
	delete from table_userScope
  where userScope_scope = _id;
  
	delete from table_scope
  where scope_id = _id;
end //

delimiter ;

-- ------------------------------

insert into table_user values(
	'7954040aa22311eaa97b00ffe7dc46aa', -- id
  'manager', -- account
  '$2y$10$M7teb7LXXGkvZKrQS4tJQOqGG6tVN089tj3WDF.oas8fQgvCrrmDO', -- password
  'konkon.computerstore@gmail.com', -- email
  1, -- status
  'Dao Minh Trung Thuan', -- name
  1, -- gender
  '1999-09-18', -- birthday
  '0939908568', -- phone
  'Can Tho, Viet Nam' -- address
);

insert into table_user values(
	'486e8b6fa21811eaa97b00ffe7dc46aa', -- id
  'employee', -- account
  '$2y$10$M7teb7LXXGkvZKrQS4tJQOqGG6tVN089tj3WDF.oas8fQgvCrrmDO', -- password
  'employee.konkon.computerstore@gmail.com', -- email
  1, -- status
  'Donna Suhr', -- name
  0, -- gender
  '1986-02-06', -- birthday
  '04405234749', -- phone
  '1613 Glenwood Avenue, Cleveland, Ohio' -- address
);

insert into table_user values(
	'552c6852a21811eaa97b00ffe7dc46aa', -- id
  'customer1', -- account
  '$2y$10$M7teb7LXXGkvZKrQS4tJQOqGG6tVN089tj3WDF.oas8fQgvCrrmDO', -- password
  'customer.konkon.computerstore@gmail.com', -- email
  1, -- status
  'Will Dunn', -- name
  1, -- gender
  '1983-11-30', -- birthday
  '08473994873', -- phone
  '3143 Apple Lane, Macomb, Illinois' -- address
);

insert into table_user values(
	createId(), -- id
  'customer2', -- account
  '$2y$10$M7teb7LXXGkvZKrQS4tJQOqGG6tVN089tj3WDF.oas8fQgvCrrmDO', -- password
  'customer.konkon.computerstore@gmail.com', -- email
  1, -- status
  'Will Dunn', -- name
  1, -- gender
  '1983-11-30', -- birthday
  '08473994873', -- phone
  '3143 Apple Lane, Macomb, Illinois' -- address
);

insert into table_user values(
	createId(), -- id
  'customer3', -- account
  '$2y$10$M7teb7LXXGkvZKrQS4tJQOqGG6tVN089tj3WDF.oas8fQgvCrrmDO', -- password
  'customer.konkon.computerstore@gmail.com', -- email
  1, -- status
  'Will Dunn', -- name
  1, -- gender
  '1983-11-30', -- birthday
  '08473994873', -- phone
  '3143 Apple Lane, Macomb, Illinois' -- address
);

insert into table_user values(
	createId(), -- id
  'customer4', -- account
  '$2y$10$M7teb7LXXGkvZKrQS4tJQOqGG6tVN089tj3WDF.oas8fQgvCrrmDO', -- password
  'customer.konkon.computerstore@gmail.com', -- email
  1, -- status
  'Will Dunn', -- name
  1, -- gender
  '1983-11-30', -- birthday
  '08473994873', -- phone
  '3143 Apple Lane, Macomb, Illinois' -- address
);

insert into table_user values(
	createId(), -- id
  'customer5', -- account
  '$2y$10$M7teb7LXXGkvZKrQS4tJQOqGG6tVN089tj3WDF.oas8fQgvCrrmDO', -- password
  'customer.konkon.computerstore@gmail.com', -- email
  1, -- status
  'Will Dunn', -- name
  1, -- gender
  '1983-11-30', -- birthday
  '08473994873', -- phone
  '3143 Apple Lane, Macomb, Illinois' -- address
);

insert into table_user values(
	createId(), -- id
  'customer6', -- account
  '$2y$10$M7teb7LXXGkvZKrQS4tJQOqGG6tVN089tj3WDF.oas8fQgvCrrmDO', -- password
  'customer.konkon.computerstore@gmail.com', -- email
  2, -- status
  'Will Dunn', -- name
  1, -- gender
  '1983-11-30', -- birthday
  '08473994873', -- phone
  '3143 Apple Lane, Macomb, Illinois' -- address
);

insert into table_user values(
	createId(), -- id
  'customer7', -- account
  '$2y$10$M7teb7LXXGkvZKrQS4tJQOqGG6tVN089tj3WDF.oas8fQgvCrrmDO', -- password
  'customer.konkon.computerstore@gmail.com', -- email
  1, -- status
  'Will Dunn', -- name
  1, -- gender
  '1983-11-30', -- birthday
  '08473994873', -- phone
  '3143 Apple Lane, Macomb, Illinois' -- address
);

insert into table_user values(
	createId(), -- id
  'customer8', -- account
  '$2y$10$M7teb7LXXGkvZKrQS4tJQOqGG6tVN089tj3WDF.oas8fQgvCrrmDO', -- password
  'customer.konkon.computerstore@gmail.com', -- email
  1, -- status
  'Will Dunn', -- name
  1, -- gender
  '1983-11-30', -- birthday
  '08473994873', -- phone
  '3143 Apple Lane, Macomb, Illinois' -- address
);

insert into table_user values(
	createId(), -- id
  'customer9', -- account
  '$2y$10$M7teb7LXXGkvZKrQS4tJQOqGG6tVN089tj3WDF.oas8fQgvCrrmDO', -- password
  'customer.konkon.computerstore@gmail.com', -- email
  2, -- status
  'Will Dunn', -- name
  1, -- gender
  '1983-11-30', -- birthday
  '08473994873', -- phone
  '3143 Apple Lane, Macomb, Illinois' -- address
);

insert into table_user values(
	createId(), -- id
  'customer10', -- account
  '$2y$10$M7teb7LXXGkvZKrQS4tJQOqGG6tVN089tj3WDF.oas8fQgvCrrmDO', -- password
  'customer.konkon.computerstore@gmail.com', -- email
  2, -- status
  'Will Dunn', -- name
  1, -- gender
  '1983-11-30', -- birthday
  '08473994873', -- phone
  '3143 Apple Lane, Macomb, Illinois' -- address
);

insert into table_user values(
	createId(), -- id
  'customer11', -- account
  '$2y$10$M7teb7LXXGkvZKrQS4tJQOqGG6tVN089tj3WDF.oas8fQgvCrrmDO', -- password
  'customer.konkon.computerstore@gmail.com', -- email
  1, -- status
  'Will Dunn', -- name
  1, -- gender
  '1983-11-30', -- birthday
  '08473994873', -- phone
  '3143 Apple Lane, Macomb, Illinois' -- address
);

insert into table_user values(
	createId(), -- id
  'customer12', -- account
  '$2y$10$M7teb7LXXGkvZKrQS4tJQOqGG6tVN089tj3WDF.oas8fQgvCrrmDO', -- password
  'customer.konkon.computerstore@gmail.com', -- email
  1, -- status
  'Will Dunn', -- name
  1, -- gender
  '1983-11-30', -- birthday
  '08473994873', -- phone
  '3143 Apple Lane, Macomb, Illinois' -- address
);

insert into table_user values(
	createId(), -- id
  'customer13', -- account
  '$2y$10$M7teb7LXXGkvZKrQS4tJQOqGG6tVN089tj3WDF.oas8fQgvCrrmDO', -- password
  'customer.konkon.computerstore@gmail.com', -- email
  2, -- status
  'Will Dunn', -- name
  1, -- gender
  '1983-11-30', -- birthday
  '08473994873', -- phone
  '3143 Apple Lane, Macomb, Illinois' -- address
);

insert into table_user values(
	createId(), -- id
  'customer14', -- account
  '$2y$10$M7teb7LXXGkvZKrQS4tJQOqGG6tVN089tj3WDF.oas8fQgvCrrmDO', -- password
  'customer.konkon.computerstore@gmail.com', -- email
  2, -- status
  'Will Dunn', -- name
  1, -- gender
  '1983-11-30', -- birthday
  '08473994873', -- phone
  '3143 Apple Lane, Macomb, Illinois' -- address
);

insert into table_user values(
	createId(), -- id
  'customer15', -- account
  '$2y$10$M7teb7LXXGkvZKrQS4tJQOqGG6tVN089tj3WDF.oas8fQgvCrrmDO', -- password
  'customer.konkon.computerstore@gmail.com', -- email
  2, -- status
  'Will Dunn', -- name
  1, -- gender
  '1983-11-30', -- birthday
  '08473994873', -- phone
  '3143 Apple Lane, Macomb, Illinois' -- address
);

insert into table_scope values(
	'48dc4747a21911eaa97b00ffe7dc46aa', -- id
  'manager', -- name
  1 -- status
);

insert into table_scope values(
	'5cc7b62ea21911eaa97b00ffe7dc46aa', -- id
  'employee', -- name
  1 -- status
);

insert into table_userScope values(
	'7954040aa22311eaa97b00ffe7dc46aa', -- user_id
  '48dc4747a21911eaa97b00ffe7dc46aa' -- scope_id
);

insert into table_userScope values(
	'7954040aa22311eaa97b00ffe7dc46aa', -- user_id
  '5cc7b62ea21911eaa97b00ffe7dc46aa' -- scope_id
);

insert into table_userScope values(
	'486e8b6fa21811eaa97b00ffe7dc46aa', -- user_id
  '5cc7b62ea21911eaa97b00ffe7dc46aa' -- scope_id
);

insert into table_categoryGroup values(
	'0eb4fac3a21d11eaa97b00ffe7dc46aa', -- id
  'Computer Components', -- name
  1 -- status
);

insert into table_categoryGroup values(
	'1ea145b6a21d11eaa97b00ffe7dc46aa', -- id
  'Monitors - Keyboards - Mice', -- name
  1 -- status
);

insert into table_categoryGroup values(
	'29556008a21d11eaa97b00ffe7dc46aa', -- id
  'Headphones - Speakers', -- name
  1 -- status
);

insert into table_categoryGroup values(
	'38b086f6a21d11eaa97b00ffe7dc46aa', -- id
  'Gaming Desks - Chairs', -- name
  1 -- status
);

insert into table_categoryGroup values(
	'3f5cbae9a21d11eaa97b00ffe7dc46aa', -- id
  'Network Equipments', -- name
  1 -- status
);

insert into table_categoryGroup values(
	'4ed9e74ea21d11eaa97b00ffe7dc46aa', -- id
  'Game Machines', -- name
  1 -- status
);

insert into table_categoryGroup values(
	'5b2b0482a21d11eaa97b00ffe7dc46aa', -- id
  'Accessories', -- name
  1 -- status
);

insert into table_categoryGroup values(
	'62261f23a21d11eaa97b00ffe7dc46aa', -- id
  'Computers', -- name
  1 -- status
);

insert into table_category values(
	'b7792688a21d11eaa97b00ffe7dc46aa', -- id
  'Processors', -- name
  1, -- status
  '0eb4fac3a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into table_category values(
	'dabdf49da21d11eaa97b00ffe7dc46aa', -- id
  'Mainboards', -- name
  1, -- status
  '0eb4fac3a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into table_category values(
	'f13710a4a21d11eaa97b00ffe7dc46aa', -- id
  'Graphics Cards', -- name
  1, -- status
  '0eb4fac3a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into table_category values(
	'0e44d120a21e11eaa97b00ffe7dc46aa', -- id
  'Memories', -- name
  1, -- status
  '0eb4fac3a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into table_category values(
	'25687a56a21e11eaa97b00ffe7dc46aa', -- id
  'Radiators', -- name
  1, -- status
	'0eb4fac3a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into table_category values(
	'32323760a21e11eaa97b00ffe7dc46aa', -- id
  'Storage Devices', -- name
  1, -- status
  '0eb4fac3a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into table_category values(
	'472e24fda21e11eaa97b00ffe7dc46aa', -- id
  'Computer Case', -- name
  1, -- status
  '0eb4fac3a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into table_category values(
	'53ddb6f3a21e11eaa97b00ffe7dc46aa', -- id
  'Power Supply', -- name
  1, -- status
  '0eb4fac3a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into table_category values(
	'7c7ad947a21e11eaa97b00ffe7dc46aa', -- id
  'Monitors', -- name
  1, -- status
  '1ea145b6a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into table_category values(
	'840d0081a21e11eaa97b00ffe7dc46aa', -- id
  'Keyboards', -- name
  1, -- status
  '1ea145b6a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into table_category values(
	'8cd63f23a21e11eaa97b00ffe7dc46aa', -- id
  'Mice', -- name
  1, -- status
  '1ea145b6a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into table_category values(
	'9ffe6645a21e11eaa97b00ffe7dc46aa', -- id
  'Headphones', -- name
  1, -- status
  '29556008a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into table_category values(
	'aab17881a21e11eaa97b00ffe7dc46aa', -- id
  'Speakers', -- name
  1, -- status
  '29556008a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into table_category values(
	'0310a8fca21f11eaa97b00ffe7dc46aa', -- id
  'Gaming Desks', -- name
  1, -- status
  '38b086f6a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into table_category values(
	'0f2cfbfca21f11eaa97b00ffe7dc46aa', -- id
  'Gaming Chairs', -- name
  1, -- status
  '38b086f6a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into table_category values(
	'21810609a21f11eaa97b00ffe7dc46aa', -- id
  'Gaming Wifi', -- name
  1, -- status
  '3f5cbae9a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into table_category values(
	'32f11a8ca21f11eaa97b00ffe7dc46aa', -- id
  'Mesh Wifi', -- name
  1, -- status
  '3f5cbae9a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into table_category values(
	'4066024ca21f11eaa97b00ffe7dc46aa', -- id
  'Wifi 6', -- name
  1, -- status
  '3f5cbae9a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into table_category values(
	'5f14482da21f11eaa97b00ffe7dc46aa', -- id
  'Game Machines',
  1, -- status
  '4ed9e74ea21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into table_category values(
	'7470f176a21f11eaa97b00ffe7dc46aa', -- id
  'Gamepads', -- name
  1, -- status
  '4ed9e74ea21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into table_category values(
	'7fe9cae7a21f11eaa97b00ffe7dc46aa', -- id
  'Game Discs', -- name
  1, -- status
  '4ed9e74ea21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into table_category values(
	'a3dfc293a21f11eaa97b00ffe7dc46aa', -- id
  'PS4 Accessories', -- name
  1, -- status
  '4ed9e74ea21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into table_category values(
	'b18b5853a21f11eaa97b00ffe7dc46aa', -- id
  'Backpacks', -- name
  1, -- status
  '5b2b0482a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into table_category values(
	'b99bf752a21f11eaa97b00ffe7dc46aa', -- id
  'Hub - Cable - AIC', -- name
  1, -- status
  '5b2b0482a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into table_category values(
	'c27dc617a21f11eaa97b00ffe7dc46aa', -- id
  'Led Lights', -- name
  1, -- status
  '5b2b0482a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into table_category values(
	'd15b6e9ba21f11eaa97b00ffe7dc46aa', -- id
  'Microphones', -- name
  1, -- status
  '5b2b0482a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into table_category values(
	'db4ba355a21f11eaa97b00ffe7dc46aa', -- id
  'Webcams', -- name
  1, -- status
  '5b2b0482a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into table_category values(
	'e937d8e0a21f11eaa97b00ffe7dc46aa', -- id
  'Laptops', -- name
  1, -- status
  '62261f23a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into table_category values(
	'ed225fb4a21f11eaa97b00ffe7dc46aa', -- id
  'Computers', -- name
  1, -- status
  '62261f23a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into table_brand values(
	'20c549a7a22111eaa97b00ffe7dc46aa', -- id
  'ASUS', -- name
  1 -- status
);

insert into table_brand values(
	'2ca1c919a22111eaa97b00ffe7dc46aa', -- id
  'Acer', -- name
  1 -- status
);

insert into table_brand values(
	'32203b45a22111eaa97b00ffe7dc46aa', -- id
  'Alienware', -- name
  1 -- status
);

insert into table_brand values(
	'3a5bdc6ca22111eaa97b00ffe7dc46aa', -- id
  'BenQ', -- name
  1 -- status
);

insert into table_brand values(
	'4545f031a22111eaa97b00ffe7dc46aa', -- id
  'Dell', -- name
  1 -- status
);

insert into table_brand values(
	'4be54b9fa22111eaa97b00ffe7dc46aa', -- id
  'GIGABYTE', -- name
  1 -- status
);

insert into table_brand values(
	'5417d4f8a22111eaa97b00ffe7dc46aa', -- id
  'LG', -- name
  1 -- status
);

insert into table_brand values(
	'72f20616a22111eaa97b00ffe7dc46aa', -- id
  'MSI', -- name
  1 -- status
);

insert into table_brand values(
	'7bea051fa22111eaa97b00ffe7dc46aa', -- id
  'ViewSonic', -- name
  1 -- status
);

insert into table_brand values(
	'8993fa6fa22111eaa97b00ffe7dc46aa', -- id
  'Cooler Master', -- name
  1 -- status
);

insert into table_brand values(
	'94c43befa22111eaa97b00ffe7dc46aa', -- id
  'Akko', -- name
  1 -- status
);

insert into table_brand values(
	'9bd31147a22111eaa97b00ffe7dc46aa', -- id
  'Leopold', -- name
  1 -- status
);

insert into table_brand values(
	'a3c7afa8a22111eaa97b00ffe7dc46aa', -- id
  'CORSAIR', -- name
  1 -- status
);

insert into table_brand values(
	'b07b604ca22111eaa97b00ffe7dc46aa', -- id
  'Varmilo', -- name
  1 -- status
);

insert into table_brand values(
	'b8e97271a22111eaa97b00ffe7dc46aa', -- id
  'Ducky', -- name
  1 -- status
);

insert into table_brand values(
	'c4c69f28a22111eaa97b00ffe7dc46aa', -- id
  'Vortex', -- name
  1 -- status
);

insert into table_brand values(
	'cca1a92fa22111eaa97b00ffe7dc46aa', -- id
  'SteelSeries', -- name
  1 -- status
);

insert into table_brand values(
	'd4aba81fa22111eaa97b00ffe7dc46aa', -- id
  'Logitech', -- name
  1 -- status
);

insert into table_brand values(
	'dac56319a22111eaa97b00ffe7dc46aa', -- id
  'Razer', -- name
  1 -- status
);

insert into table_brand values(
	'e2844af6a22111eaa97b00ffe7dc46aa', -- id
  'Durgod', -- name
  1 -- status
);

insert into table_brand values(
	'f7ef7e79a22211eaa97b00ffe7dc46aa', -- id
  'Ikbc', -- name
  1 -- status
);

insert into table_brand values(
	'f5969289a22111eaa97b00ffe7dc46aa', -- id
  'DareU', -- name
  1 -- status
);

insert into table_brand values(
	'00cb7739a22211eaa97b00ffe7dc46aa', -- id
  'Kingston', -- name
  1 -- status
);

insert into table_brand values(
	'0cfd750ba22211eaa97b00ffe7dc46aa', -- id
  'GAMDIAS', -- name
  1 -- status
);

insert into table_brand values(
	'130555f6a22211eaa97b00ffe7dc46aa', -- id
  'Glorious', -- name
  1 -- status
);

insert into table_brand values(
	'25ccb4bfa22211eaa97b00ffe7dc46aa', -- id
  'AKRacing', -- name
  1 -- status
);

insert into table_brand values(
	'2dfebb85a22211eaa97b00ffe7dc46aa', -- id
  'Alpha Gamer', -- name
  1 -- status
);

insert into table_brand values(
	'34b20043a22211eaa97b00ffe7dc46aa', -- id
  'DXRacer', -- name
  1 -- status
);

insert into table_brand values(
	'3bf103fca22211eaa97b00ffe7dc46aa', -- id
  'Noblechairs', -- name
  1 -- status
);

insert into table_brand values(
	'4209d7bda22211eaa97b00ffe7dc46aa', -- id
  'SADES', -- name
  1 -- status
);

insert into table_brand values(
	'48fcd995a22211eaa97b00ffe7dc46aa', -- id
  'Soleseat', -- name
  1 -- status
);

insert into table_brand values(
	'4fc9c5c5a22211eaa97b00ffe7dc46aa', -- id
  'VGS', -- name
  1 -- status
);

insert into table_brand values(
	'57442461a22211eaa97b00ffe7dc46aa', -- id
  'Intel', -- name
  1 -- status
);

insert into table_brand values(
	'5f848548a22211eaa97b00ffe7dc46aa', -- id
  'AMD', -- name
  1 -- status
);

insert into table_brand values(
	'64e29397a22211eaa97b00ffe7dc46aa', -- id
  'Nvidia', -- name
  1 -- status
);

insert into table_news values(
	'3aae98e6a22311eaa97b00ffe7dc46aa', -- id
	'free-ationwide-delivery-of-covid-19-season', -- name
	1, -- status
  'Free nationwide delivery of Covid-19 season', -- title
  '2020-05-22', -- date
  'In order to create favorable conditions and ensure your health.', -- intro
  '7954040aa22311eaa97b00ffe7dc46aa' -- auth
);

insert into table_news values(
	'c3e355bda22311eaa97b00ffe7dc46aa', -- id
	'stylish-rog-t-shirt-with-tuf-ax3000', -- name
	1, -- status
  'Stylish ROG T-shirt with TUF-AX3000', -- title
  '2020-05-19', -- date
  'Buy an ASUS TUF Gaming AX3000 Wi-Fi router and get a limited edition ROG T-shirt right away.', -- intro
  '7954040aa22311eaa97b00ffe7dc46aa' -- auth
);

insert into table_news values(
	'e29ffc08a22311eaa97b00ffe7dc46aa', -- id
	'buy-z490-aorus-motherboard-get-the-ultimate-gift', -- name
	1, -- status
  'Buy Z490 AORUS Motherboard - Get the ultimate gift', -- title
  '2020-05-11', -- date
  'GIGABYTE "awesome" Z490 motherboard has officially launched, along with extremely attractive gifts.', -- intro
  '7954040aa22311eaa97b00ffe7dc46aa' -- auth
);

insert into table_news values(
	'e709b726a22311eaa97b00ffe7dc46aa', -- id
	'buy-an-asus-router-to-get-a-cool-rog-mask', -- name
	1, -- status
  'Buy an ASUS Router to get a cool ROG mask', -- title
  '2020-05-05', -- date
  'Buy an ASUS Router to get a cool ROG mask', -- intro
  '7954040aa22311eaa97b00ffe7dc46aa' -- auth
);