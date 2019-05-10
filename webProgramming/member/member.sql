create table member(
id char(15) not null,
password char(15) not null,
password_confirm char(15) not null,
password_confirm_query char(30),
confirm_answer char(15),
name char(10) not null,
address char(80),
hp char(20) not null,
email char(80),
regist_day char(20),
visit_number int,
primary key(id)
);
