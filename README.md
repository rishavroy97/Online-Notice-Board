# Online-Notice-Board
The following are the queries for mysql
The details of the superuser account is as follows:
  Name : Admin
  Email-id : superuser@admin.com
  Password : superuser12345

#sql queries

CREATE DATABASE `noticeboard`;

USE `noticeboard`;

CREATE TABLE `noticeboard`.`notice` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `Subject` TEXT NOT NULL , `Note` TEXT NOT NULL , `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) ENGINE = MyISAM CHARSET=utf8 COLLATE utf8_unicode_ci;

CREATE TABLE `noticeboard`.`users` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `name` VARCHAR(255) NOT NULL , `email` VARCHAR(255) NOT NULL , `password` VARCHAR(255) NOT NULL , `Access` VARCHAR(255) NOT NULL DEFAULT 'student' , `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) ENGINE = MyISAM CHARSET=utf8 COLLATE utf8_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `password`, `Access`, `date`) VALUES (NULL, 'Admin', 'superuser@admin.com', '78406c7ef0d6c18d3f2acec1e541a464', 'admin', CURRENT_TIMESTAMP);
