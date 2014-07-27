-- Скрипт создания БД сайта альпклуба и федерации

-- Грохаем имеющуюся БД
drop database if exists `alpsite`;

-- Создаем БД
create schema `alpsite` character set = 'utf8' collate = 'utf8_general_ci';

-- Используем БД
use `alpsite`;

-- Создаем таблицу пользователей
create table `user` (
  `uid` integer primary key auto_increment not null unique comment 'user unique id',
  `login` varchar(16) not null unique comment 'login',
  `pwdhash` varchar(32) default null comment 'hash of passowrd',
  `name` varchar(32) not null comment 'realy user name',
  `email` varchar(128) not null unique comment 'user email to communication and notification',
  `dob` date comment 'date of bethday', 
  `regdata` timestamp default now() comment 'date of registration',
  `sign` text default null comment 'user sign',
  `role` varchar(32) default null comment 'user role hash'
) engine = 'InnoDb';

-- Таблица восстановления пароля и/или окончания регистрации
create table `pwdrestore` (
  `uid` integer primary key not null unique comment 'user unique id',
  `ctrlhash` varchar(32) not null comment 'hash of restore passowrd text',
  constraint `fk_pwdrestore` foreign key (`uid`) references `user` (`uid`) on update cascade on delete cascade
) engine = 'InnoDb';

-- Календарь альпмероприятий ФАПО
create table `f_calendar` (
  `aid` integer primary key not null unique auto_increment comment 'unique number of mountaring actions',
  `title` varchar(128) not null comment 'title of action',
  `begin` date not null comment 'date of begin mountaring action',
  `finish` date not null comment 'date of finish mountaring action',
  -- tutoral на использование google maps смотри на http://habrahabr.ru/post/110460/
  `location_lat` float comment 'position from latitude',
  `location_lng` float comment 'position from logitude',
  `description` text not null comment 'Description of mountaring action' 
) engine = 'InnoDb' comment 'calendar of mountaring actions';

create table `c_calendar` (
  `aid` integer primary key not null unique auto_increment comment 'unique number of club actions',
  `title` varchar(128) not null comment 'title of action',
  `begin` timestamp not null comment 'timestamp of begin club action',
    -- tutoral на использование google maps смотри на http://habrahabr.ru/post/110460/
  `location_lat` float comment 'position from latitude',
  `location_lng` float comment 'position from logitude',
  `manager` integer not null comment 'action manager',
  `description` text not null comment 'Description of mountaring action',
  constraint `fk_club_action_manager` foreign key (`manager`) references `user`(`uid`) on update cascade on delete restrict
) engine = 'InnoDb' comment 'calendar club actions';