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
  `sign` text default null comment 'user sign'
) engine = 'InnoDb';

-- Таблица восстановления пароля и/или окончания регистрации
create table `pwdrestore` (
  `uid` integer primary key not null unique comment 'user unique id',
  `ctrlhash` varchar(32) not null comment 'hash of restore passowrd text',
  constraint `fk_pwdrestore` foreign key (`uid`) references `user` (`uid`) on update cascade on delete cascade
) engine = 'InnoDb';