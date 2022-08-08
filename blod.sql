create database if not exists blog;
use blog;
drop database blog;
create table if not exists categories(
cat_id int primary key not null auto_increment,
cat_title varchar(255)
);
create table if not exists post(
post_id int auto_increment not null primary key,
post_title varchar(255),
post_desc varchar(255),
post_img BLOB,
post_date date,
post_author varchar(255),
post_cat_id int,
post_status varchar(255),
constraint fkone foreign key (post_cat_id) references categories(cat_id) on delete set null on update cascade
);

create table if not exists comments(
comment_id int primary key auto_increment,
comment_desc text not null,
comment_date datetime,
comment_author varchar(255)not null,
comment_post_id int ,
email varchar(255),
constraint fkcomment foreign key (comment_post_id) references post(post_id) on update cascade on delete set null
);


create table if not exists users(
user_id int not null primary key auto_increment,
user_name varchar(255),
user_email varchar(255),
user_password varchar(255)
);




