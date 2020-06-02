use konkon;

delete from user_scope;
delete from user;
delete from scope;
delete from category;
delete from category_group;
delete from brand;

insert into user values(
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

insert into user values(
	'486e8b6fa21811eaa97b00ffe7dc46aa', -- id
  'employee', -- account
  '$2y$10$wiL.EoH5/z0ZErb1Yd0/NOaVG8.lOaa8B6HYi8atZhUuFxV25pEMC', -- password
  'employee.konkon.computerstore@gmail.com', -- email
  1, -- status
  'Donna Suhr', -- name
  0, -- gender
  '1986-02-06', -- birthday
  '04405234749', -- phone
  '1613 Glenwood Avenue, Cleveland, Ohio' -- address
);

insert into user values(
	'552c6852a21811eaa97b00ffe7dc46aa', -- id
  'customer', -- account
  '$2y$10$wiL.EoH5/z0ZErb1Yd0/NOaVG8.lOaa8B6HYi8atZhUuFxV25pEMC', -- password
  'customer.konkon.computerstore@gmail.com', -- email
  1, -- status
  'Will Dunn', -- name
  1, -- gender
  '1983-11-30', -- birthday
  '08473994873', -- phone
  '3143 Apple Lane, Macomb, Illinois' -- address
);

insert into scope values(
	'48dc4747a21911eaa97b00ffe7dc46aa', -- id
  'manager', -- name
  1 -- status
);

insert into scope values(
	'5cc7b62ea21911eaa97b00ffe7dc46aa', -- id
  'employee', -- name
  1 -- status
);

insert into user_scope values(
	'B41725D3966F11EA87F700FFE7DC46AA', -- user_id
  '48dc4747a21911eaa97b00ffe7dc46aa' -- scope_id
);

insert into user_scope values(
	'486e8b6fa21811eaa97b00ffe7dc46aa', -- user_id
  '5cc7b62ea21911eaa97b00ffe7dc46aa' -- scope_id
);

insert into category_group values(
	'0eb4fac3a21d11eaa97b00ffe7dc46aa', -- id
  'Computer Components', -- name
  1 -- status
);

insert into category_group values(
	'1ea145b6a21d11eaa97b00ffe7dc46aa', -- id
  'Monitors - Keyboards - Mice', -- name
  1 -- status
);

insert into category_group values(
	'29556008a21d11eaa97b00ffe7dc46aa', -- id
  'Headphones - Speakers', -- name
  1 -- status
);

insert into category_group values(
	'38b086f6a21d11eaa97b00ffe7dc46aa', -- id
  'Gaming Desks - Chairs', -- name
  1 -- status
);

insert into category_group values(
	'3f5cbae9a21d11eaa97b00ffe7dc46aa', -- id
  'Network Equipments', -- name
  1 -- status
);

insert into category_group values(
	'4ed9e74ea21d11eaa97b00ffe7dc46aa', -- id
  'Game Machines', -- name
  1 -- status
);

insert into category_group values(
	'5b2b0482a21d11eaa97b00ffe7dc46aa', -- id
  'Accessories', -- name
  1 -- status
);

insert into category_group values(
	'62261f23a21d11eaa97b00ffe7dc46aa', -- id
  'Computers', -- name
  1 -- status
);

insert into category values(
	'b7792688a21d11eaa97b00ffe7dc46aa', -- id
  'Processors', -- name
  1, -- status
  '0eb4fac3a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into category values(
	'dabdf49da21d11eaa97b00ffe7dc46aa', -- id
  'Mainboards', -- name
  1, -- status
  '0eb4fac3a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into category values(
	'f13710a4a21d11eaa97b00ffe7dc46aa', -- id
  'Graphics Cards', -- name
  1, -- status
  '0eb4fac3a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into category values(
	'0e44d120a21e11eaa97b00ffe7dc46aa', -- id
  'Memories', -- name
  1, -- status
  '0eb4fac3a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into category values(
	'25687a56a21e11eaa97b00ffe7dc46aa', -- id
  'Radiators', -- name
  1, -- status
	'0eb4fac3a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into category values(
	'32323760a21e11eaa97b00ffe7dc46aa', -- id
  'Storage Devices', -- name
  1, -- status
  '0eb4fac3a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into category values(
	'472e24fda21e11eaa97b00ffe7dc46aa', -- id
  'Computer Case', -- name
  1, -- status
  '0eb4fac3a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into category values(
	'53ddb6f3a21e11eaa97b00ffe7dc46aa', -- id
  'Power Supply', -- name
  1, -- status
  '0eb4fac3a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into category values(
	'7c7ad947a21e11eaa97b00ffe7dc46aa', -- id
  'Monitors', -- name
  1, -- status
  '1ea145b6a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into category values(
	'840d0081a21e11eaa97b00ffe7dc46aa', -- id
  'Keyboards', -- name
  1, -- status
  '1ea145b6a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into category values(
	'8cd63f23a21e11eaa97b00ffe7dc46aa', -- id
  'Mice', -- name
  1, -- status
  '1ea145b6a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into category values(
	'9ffe6645a21e11eaa97b00ffe7dc46aa', -- id
  'Headphones', -- name
  1, -- status
  '29556008a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into category values(
	'aab17881a21e11eaa97b00ffe7dc46aa', -- id
  'Speakers', -- name
  1, -- status
  '29556008a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into category values(
	'0310a8fca21f11eaa97b00ffe7dc46aa', -- id
  'Gaming Desks', -- name
  1, -- status
  '38b086f6a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into category values(
	'0f2cfbfca21f11eaa97b00ffe7dc46aa', -- id
  'Gaming Chairs', -- name
  1, -- status
  '38b086f6a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into category values(
	'21810609a21f11eaa97b00ffe7dc46aa', -- id
  'Gaming Wifi', -- name
  1, -- status
  '3f5cbae9a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into category values(
	'32f11a8ca21f11eaa97b00ffe7dc46aa', -- id
  'Mesh Wifi', -- name
  1, -- status
  '3f5cbae9a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into category values(
	'4066024ca21f11eaa97b00ffe7dc46aa', -- id
  'Wifi 6', -- name
  1, -- status
  '3f5cbae9a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into category values(
	'5f14482da21f11eaa97b00ffe7dc46aa', -- id
  'Game Machines',
  1, -- status
  '4ed9e74ea21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into category values(
	'7470f176a21f11eaa97b00ffe7dc46aa', -- id
  'Gamepads', -- name
  1, -- status
  '4ed9e74ea21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into category values(
	'7fe9cae7a21f11eaa97b00ffe7dc46aa', -- id
  'Game Discs', -- name
  1, -- status
  '4ed9e74ea21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into category values(
	'a3dfc293a21f11eaa97b00ffe7dc46aa', -- id
  'PS4 Accessories', -- name
  1, -- status
  '4ed9e74ea21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into category values(
	'b18b5853a21f11eaa97b00ffe7dc46aa', -- id
  'Backpacks', -- name
  1, -- status
  '5b2b0482a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into category values(
	'b99bf752a21f11eaa97b00ffe7dc46aa', -- id
  'Hub - Cable - AIC', -- name
  1, -- status
  '5b2b0482a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into category values(
	'c27dc617a21f11eaa97b00ffe7dc46aa', -- id
  'Led Lights', -- name
  1, -- status
  '5b2b0482a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into category values(
	'd15b6e9ba21f11eaa97b00ffe7dc46aa', -- id
  'Microphones', -- name
  1, -- status
  '5b2b0482a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into category values(
	'db4ba355a21f11eaa97b00ffe7dc46aa', -- id
  'Webcams', -- name
  1, -- status
  '5b2b0482a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into category values(
	'e937d8e0a21f11eaa97b00ffe7dc46aa', -- id
  'Laptops', -- name
  1, -- status
  '5b2b0482a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into category values(
	'ed225fb4a21f11eaa97b00ffe7dc46aa', -- id
  'Computers', -- name
  1, -- status
  '5b2b0482a21d11eaa97b00ffe7dc46aa' -- category_group
);

insert into brand values(
	'20c549a7a22111eaa97b00ffe7dc46aa', -- id
  'ASUS', -- name
  1 -- status
);

insert into brand values(
	'2ca1c919a22111eaa97b00ffe7dc46aa', -- id
  'Acer', -- name
  1 -- status
);

insert into brand values(
	'32203b45a22111eaa97b00ffe7dc46aa', -- id
  'Alienware', -- name
  1 -- status
);

insert into brand values(
	'3a5bdc6ca22111eaa97b00ffe7dc46aa', -- id
  'BenQ', -- name
  1 -- status
);

insert into brand values(
	'4545f031a22111eaa97b00ffe7dc46aa', -- id
  'Dell', -- name
  1 -- status
);

insert into brand values(
	'4be54b9fa22111eaa97b00ffe7dc46aa', -- id
  'GIGABYTE', -- name
  1 -- status
);

insert into brand values(
	'5417d4f8a22111eaa97b00ffe7dc46aa', -- id
  'LG', -- name
  1 -- status
);

insert into brand values(
	'72f20616a22111eaa97b00ffe7dc46aa', -- id
  'MSI', -- name
  1 -- status
);

insert into brand values(
	'7bea051fa22111eaa97b00ffe7dc46aa', -- id
  'ViewSonic', -- name
  1 -- status
);

insert into brand values(
	'8993fa6fa22111eaa97b00ffe7dc46aa', -- id
  'Cooler Master', -- name
  1 -- status
);

insert into brand values(
	'94c43befa22111eaa97b00ffe7dc46aa', -- id
  'Akko', -- name
  1 -- status
);

insert into brand values(
	'9bd31147a22111eaa97b00ffe7dc46aa', -- id
  'Leopold', -- name
  1 -- status
);

insert into brand values(
	'a3c7afa8a22111eaa97b00ffe7dc46aa', -- id
  'CORSAIR', -- name
  1 -- status
);

insert into brand values(
	'b07b604ca22111eaa97b00ffe7dc46aa', -- id
  'Varmilo', -- name
  1 -- status
);

insert into brand values(
	'b8e97271a22111eaa97b00ffe7dc46aa', -- id
  'Ducky', -- name
  1 -- status
);

insert into brand values(
	'c4c69f28a22111eaa97b00ffe7dc46aa', -- id
  'Vortex', -- name
  1 -- status
);

insert into brand values(
	'cca1a92fa22111eaa97b00ffe7dc46aa', -- id
  'SteelSeries', -- name
  1 -- status
);

insert into brand values(
	'd4aba81fa22111eaa97b00ffe7dc46aa', -- id
  'Logitech', -- name
  1 -- status
);

insert into brand values(
	'dac56319a22111eaa97b00ffe7dc46aa', -- id
  'Razer', -- name
  1 -- status
);

insert into brand values(
	'e2844af6a22111eaa97b00ffe7dc46aa', -- id
  'Durgod', -- name
  1 -- status
);

insert into brand values(
	'f7ef7e79a22211eaa97b00ffe7dc46aa', -- id
  'Ikbc', -- name
  1 -- status
);

insert into brand values(
	'f5969289a22111eaa97b00ffe7dc46aa', -- id
  'DareU', -- name
  1 -- status
);

insert into brand values(
	'00cb7739a22211eaa97b00ffe7dc46aa', -- id
  'Kingston', -- name
  1 -- status
);

insert into brand values(
	'0cfd750ba22211eaa97b00ffe7dc46aa', -- id
  'GAMDIAS', -- name
  1 -- status
);

insert into brand values(
	'130555f6a22211eaa97b00ffe7dc46aa', -- id
  'Glorious', -- name
  1 -- status
);

insert into brand values(
	'25ccb4bfa22211eaa97b00ffe7dc46aa', -- id
  'AKRacing', -- name
  1 -- status
);

insert into brand values(
	'2dfebb85a22211eaa97b00ffe7dc46aa', -- id
  'Alpha Gamer', -- name
  1 -- status
);

insert into brand values(
	'34b20043a22211eaa97b00ffe7dc46aa', -- id
  'DXRacer', -- name
  1 -- status
);

insert into brand values(
	'3bf103fca22211eaa97b00ffe7dc46aa', -- id
  'Noblechairs', -- name
  1 -- status
);

insert into brand values(
	'4209d7bda22211eaa97b00ffe7dc46aa', -- id
  'SADES', -- name
  1 -- status
);

insert into brand values(
	'48fcd995a22211eaa97b00ffe7dc46aa', -- id
  'Soleseat', -- name
  1 -- status
);

insert into brand values(
	'4fc9c5c5a22211eaa97b00ffe7dc46aa', -- id
  'VGS', -- name
  1 -- status
);

insert into brand values(
	'57442461a22211eaa97b00ffe7dc46aa', -- id
  'Intel', -- name
  1 -- status
);

insert into brand values(
	'5f848548a22211eaa97b00ffe7dc46aa', -- id
  'AMD', -- name
  1 -- status
);

insert into brand values(
	'64e29397a22211eaa97b00ffe7dc46aa', -- id
  'Nvidia', -- name
  1 -- status
);

insert into news values(
	'3aae98e6a22311eaa97b00ffe7dc46aa', -- id
	'free-ationwide-delivery-of-covid-19-season', -- name
	1, -- status
  'Free nationwide delivery of Covid-19 season', -- title
  '2020-05-22', -- date
  'In order to create favorable conditions and ensure your health.', -- intro
  '7954040aa22311eaa97b00ffe7dc46aa' -- auth
);

insert into news values(
	'c3e355bda22311eaa97b00ffe7dc46aa', -- id
	'stylish-rog-t-shirt-with-tuf-ax3000', -- name
	1, -- status
  'Stylish ROG T-shirt with TUF-AX3000', -- title
  '2020-05-19', -- date
  'Buy an ASUS TUF Gaming AX3000 Wi-Fi router and get a limited edition ROG T-shirt right away.', -- intro
  '7954040aa22311eaa97b00ffe7dc46aa' -- auth
);

insert into news values(
	'e29ffc08a22311eaa97b00ffe7dc46aa', -- id
	'buy-z490-aorus-motherboard-get-the-ultimate-gift', -- name
	1, -- status
  'Buy Z490 AORUS Motherboard - Get the ultimate gift', -- title
  '2020-05-11', -- date
  'GIGABYTE "awesome" Z490 motherboard has officially launched, along with extremely attractive gifts.', -- intro
  '7954040aa22311eaa97b00ffe7dc46aa' -- auth
);

insert into news values(
	'e709b726a22311eaa97b00ffe7dc46aa', -- id
	'buy-an-asus-router-to-get-a-cool-rog-mask', -- name
	1, -- status
  'Buy an ASUS Router to get a cool ROG mask', -- title
  '2020-05-05', -- date
  'Buy an ASUS Router to get a cool ROG mask', -- intro
  '7954040aa22311eaa97b00ffe7dc46aa' -- auth
);

-- select replace(uuid(),'-','')
