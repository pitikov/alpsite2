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
  `pwdhash` varchar(64) default null comment 'hash of passowrd',
  `name` varchar(32) not null comment 'realy user name',
  `email` varchar(128) not null unique comment 'user email to communication and notification',
  `dob` date comment 'date of bethday', 
  `regdata` timestamp default now() comment 'date of registration',
  `sign` text default null comment 'user sign',
  `avatar` varchar(128) default null comment 'avatar pixmap path',
  `role` varchar(64) default null comment 'user role hash'
) engine = 'InnoDb';

-- Таблица восстановления пароля и/или окончания регистрации
create table `pwdrestore` (
  `uid` integer primary key not null unique comment 'user unique id',
  `ctrlhash` varchar(64) not null comment 'hash of restore passowrd text',
  constraint `fk_pwdrestore` foreign key (`uid`) references `user` (`uid`) on update cascade on delete cascade
) engine = 'InnoDb';

-- User tags
create table `tags` (
  `id` integer primary key not null unique auto_increment,
  `user` integer not null,
  `tag` varchar(128) not null,
  constraint `uq_tag_user` unique key (`user`, `tag`),
  constraint `fk_tag_user` foreign key (`user`) references `user` (`uid`) on update cascade on delete cascade
) engine = 'InnoDb';

-- Должности в федерации
create table `federation_role` (
  `id` integer primary key not null unique auto_increment,
  `title` varchar(128) not null comment 'title of role',
  `position` integer not null unique comment 'Position on top'
) engine = 'InnoDb';

-- Члены федерации
create table `federation_member` (
  `id` integer primary key not null unique auto_increment,
  `user` integer default null,
  `name` varchar(128) not null,
  `dob` date default null,
  `photo` varchar(128) default null comment 'photo path',
  `description` text default null,
  `role` integer default null,
  `memberfrom` date default null,
  `memberto` date default null,
  constraint `fk_federation_role` foreign key (`role`) references `federation_role` (`id`) on update cascade on delete restrict,
  constraint `fk_federation_member` foreign key (`user`) references `user` (`uid`) on update cascade on delete set null
) engine = 'InnoDb';

-- Статьи на сайте
create table `article` (
  `artid` integer primary key not null unique auto_increment comment 'unique article id',
  `author` integer not null comment 'author uid',
  `dop` timestamp not null default now() comment 'published date',
  `title` varchar(254) not null comment 'Article title',
  `body` text not null comment 'Article body',
  `art_location` enum('about','federation','club','calendar') not null default 'federation',
  `comment_cnt` integer default 0,
  `rating` integer default 0,
  constraint `fk_article_author` foreign key (`author`) references `user`(`uid`) on update cascade on delete restrict
) engine = 'InnoDb' comment 'Articles and posts';

-- Коммнтарии
create table `comment` (
  `cid` integer primary key not null unique auto_increment comment 'unique article id',
  `article` integer not null comment 'article id',
  `parent` integer default null comment 'parent comment',
  `author` integer not null comment 'author uid',
  `dop` timestamp not null default now() comment 'published date',
  `title` varchar(254) not null comment 'Article title',
  `body` text not null comment 'Article body',
  `rating` integer default 0,
  constraint `fk_comment_article` foreign key (`article`) references `article`(`artid`) on update cascade on delete cascade,
  constraint `fk_comment_author` foreign key (`author`) references `user`(`uid`) on update cascade on delete restrict,
  constraint `fk_comment_parent` foreign key (`parent`) references `comment`(`cid`) on update cascade on delete cascade
) engine = 'InnoDb';

create table `article_tags` (
  `id` integer primary key not null unique auto_increment,
  `article` integer not null,
  `tag` integer not null,
  constraint `uq_article_tag` unique key (`article`, `tag`),
  constraint `fk_tag_article` foreign key (`article`) references `article`(`artid`) on update cascade on delete cascade,
  constraint `fk_tag_tag` foreign key (`article`) references `tags`(`id`) on update cascade on delete cascade
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
  `article` int not null comment 'Description of mountaring action',
  constraint `fk_fcal_article` foreign key (`article`) references `article`(`artid`) on update cascade on delete restrict
) engine = 'InnoDb' comment 'calendar of mountaring actions';

-- Календарь мероприятий клуба
create table `c_calendar` (
  `aid` integer primary key not null unique auto_increment comment 'unique number of club actions',
  `title` varchar(128) not null comment 'title of action',
  `begin` timestamp not null comment 'timestamp of begin club action',
    -- tutoral на использование google maps смотри на http://habrahabr.ru/post/110460/
  `location_lat` float comment 'position from latitude',
  `location_lng` float comment 'position from logitude',
  `manager` integer not null comment 'action manager',
  `article` int not null comment 'Description of club action',
  constraint `fk_ccal_article` foreign key (`article`) references `article`(`artid`) on update cascade on delete restrict,
  constraint `fk_club_action_manager` foreign key (`manager`) references `user`(`uid`) on update cascade on delete restrict
) engine = 'InnoDb' comment 'calendar club actions';

create table `links` (
  `id` integer primary key not null unique auto_increment,
  `title` varchar(128) not null unique comment 'popup text and alter text',
  `url` varchar(254) not null unique comment 'Link url',
  `image` varchar(254) not null unique comment 'Image url',
  `on_show` boolean not null default true,
  `position` integer not null unique comment 'Position on top'
) engine = 'InnoDb';

create table `baners` (
  `id` integer primary key not null unique auto_increment,
  `body` text not null,
  `on_show` boolean not null default true,
  `position` integer unique comment 'Position on top'
) engine = 'InnoDb';

-- Классификатор
create table `region` (
  `id` integer primary key not null unique auto_increment,
  `title` varchar(128) not null unique comment 'Region title',
  `description` text default null
) engine = 'InnoDb';

create table `subregion` (
    `id` integer primary key not null unique auto_increment,
    `region` integer not null,
    `title` varchar(255) not null unique,
    `description` text default null,
    constraint `fk_subregion_region` foreign key (`region`) references `region`(`id`) on update cascade on delete restrict
) engine = 'InnoDb';

create table `mountain` 
(
  `id` integer primary key not null unique auto_increment,
  `subregion` integer not null,
  `title` varchar(128) not null unique comment 'mountain title',
  `height` int not null comment 'absolute height',
  -- tutoral на использование google maps смотри на http://habrahabr.ru/post/110460/
  `location_lat` float comment 'position from latitude',
  `location_lng` float comment 'position from logitude',
  `description` text default null,
  constraint `fk_mountain_subregion` foreign key (`subregion`) references `subregion`(`id`) on update cascade on delete restrict
) engine = 'InnoDb';

create table `route` (
  `id` integer primary key not null unique auto_increment,
  `mountain` integer not null,
  `title` varchar(128) not null unique comment 'mountaring route title',
  `difficulty` enum ('1Б', '2А', '2Б', '3А', '3Б', '4А', '4Б', '5А', '5Б', '6А', '6Б') not null default '1Б',
  `winter` boolean not null default false,
  `author` varchar(64) default null comment 'first mountaring author',
  `year` date default null,
  `type` enum ('Ск','ЛС','К') default 'К',
  `description` text default null,
  constraint `fk_route_mountain` foreign key (`mountain`) references `mountain`(`id`) on update cascade on delete cascade
) engine = 'InnoDb';

-- Восхождения (Книга выходов)
create table `mountaring` (
  `id` integer primary key not null unique auto_increment,
  `date` date not null,
  `route` integer not null,
  `description` text default null,
  constraint `fk_mountaring_route` foreign key (`route`) references `route`(`id`) on update cascade on delete restrict
) engine = 'InnoDb';

create table `mountaring_members` (
  `id` integer primary key not null unique auto_increment,
  `mountaring` integer not null,
  `member` integer default null,
  `name` varchar (32) default null,
  `role` enum ('руководитель', 'участник', 'в двойке', 'спасработы') default 'участник',
  constraint `fk_mountaring` foreign key (`mountaring`) references `mountaring` (`id`) on update cascade on delete cascade,
  constraint `fk_mountaring_member` foreign key (`member`) references `federation_member` (`id`) on update cascade on delete restrict,
  constraint `uq_mountaring_member` unique key (`mountaring`, `member`, `name`)  
) engine = 'InnoDb';

-- site mail
create table `mail` (
  `id` integer primary key not null unique auto_increment,
  `user` integer not null,
  `sender` integer not null,
  `receiver` integer not null,
  `subject` varchar(128) not null,
  `body` text not null,
  `sended` timestamp default now() not null,
  `folder` enum('inbox', 'outbox') not null,
  `trash` boolean default false,
  `unread` boolean default true,
  constraint `uq_mail` unique key (`subject`, `sender`, `sended`, `receiver`, `user`, `folder`),
  constraint `fk_mail_user` foreign key (`user`) references `user` (`uid`) on update cascade on delete restrict,
  constraint `fk_mail_sender` foreign key (`sender`) references `user` (`uid`) on update cascade on delete restrict,
  constraint `fk_mail_receiver` foreign key (`receiver`) references `user` (`uid`) on update cascade on delete restrict
) engine = 'InnoDb';

-- documents description
create table `document` (
  `document` varchar(128) not null unique primary key comment 'document name in server FS',
  `owner` integer not null,
  `description` text not null,
  `private` boolean default true,
  `type` enum ('jpg', 'png', 'pdf', 'doc', 'xls') default 'pdf',
  `file_name` varchar(128) comment 'original file name',
  constraint `fk_document_owner` foreign key (`owner`) references `user` (`uid`) on update cascade on delete restrict  
) engine = 'InnoDb';

-- OpenId & OpenAuth
create table `social_network_auth` (
    `id` integer primary key not null unique auto_increment,
    `uid` integer not null,
    `email` varchar(128) not null unique,
    `auth_key` varchar (128) not null,
    constraint `fk_sna_uid` foreign key (`uid`) references `user` (`uid`) on update cascade on delete cascade
) engine = 'InnoDb';