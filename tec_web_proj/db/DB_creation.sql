create table user (
     email char(150) not null,
     password char(20) not null,
     username char(20) not null,
     constraint ID_User_ID primary key (username));

create table profile (
     ID_profile bigint not null AUTO_INCREMENT,
     username char(20) not null,
     private tinyint(1) default '0' not null,
     constraint ID_profile_ID primary key (ID_profile),
     constraint FKown_profile_ID unique (username),
     constraint FKown_profile_FK foreign key (username) references user (username));

create table teacher (
     name char(20) not null,
     surname char(20) not null,
     CF char(20) not null,
     username char(20) not null,
     bday date not null,
     constraint ID_Teacher_ID primary key (CF),
     constraint FKuse_Tea_ID unique (username),
     constraint FKuse_Tea_FK foreign key (username) references user (username));

create table friendship (
     user_1 char(20) not null,
     user_2 char(20) not null,
     date date not null,
     constraint IDfriendship_ID primary key (user_1, user_2),
     constraint FKuser_1 foreign key (user_2) references user (username),
     constraint FKuser_2 foreign key (user_1) references user (username));

create table post (
     ID_profile bigint not null,
     username char(20) not null,
     content text not null,
     date date not null,
     time time not null,
     n_comments bigint default 0 not null,
     constraint ID_Post_ID primary key (ID_profile, username, date, time),
     constraint FKcreation_post foreign key (username) references user (username) on delete cascade,
     constraint FKownership_profile foreign key (ID_profile) references profile (ID_profile) on delete cascade);

create table comment (
     post_ID_profile bigint not null,
     post_username char(20) not null,
     post_date date not null,
     post_time time not null,
     username char(20) not null,
     date date not null,
     time time not null,
     content text not null,
     constraint ID_comment_ID primary key (username, post_ID_profile, post_username, post_date, post_time, date, time),
     constraint FKcreation_comment foreign key (username) references user (username) on delete cascade,
     constraint FKabout_post_FK foreign key (post_ID_profile, post_username, post_date, post_time) references post (ID_profile, username, date, time) on delete cascade);

create table `group` (
     name char(20) not null,
     ID_group bigint not null AUTO_INCREMENT,
     constraint IDgroup_ID primary key (ID_group));

create table `collaboration` (
     ID_group bigint not null,
     CF char(20) not null,
     constraint IDcollaboration primary key (ID_group, CF),
     constraint FKcol_tea foreign key (CF) references teacher (CF),
     constraint FKcol_gro foreign key (ID_group) references `group` (ID_group));
     
create table `category` (
     name char(20) not null,
     constraint IDcategory primary key (name));

create table `teaching` (
     ID_content bigint not null AUTO_INCREMENT,
     name char(20) not null,
     price float(7,2) not null,
     creation_date date not null,
     description text not null,
     category_detail char(20) not null,
     category char(20) not null,
     ID_group bigint not null,
     type CHAR(20) NOT NULL,
     active tinyint(1) default '0' not null,
     constraint IDteaching_ID primary key (ID_content),
     constraint FKabout_category foreign key (category) references category (name),
     constraint FKcreation_teaching foreign key (ID_group) references `group` (ID_group));

create table `course` (
     ID_content bigint not null,
     constraint FKis_course_ID primary key (ID_content),
     constraint FKis_course_FK foreign key (ID_content) references teaching (ID_content));

create table `lesson` (
     title char(20) not null,
     topic tinytext not null,
     ID_content bigint not null,
     date date not null,
     time time not null,
     time_span time not null,
     constraint IDlesson primary key (ID_content, date, time),
     constraint FKcomposition_lessons foreign key (ID_content) references course (ID_content));

create table `masterclass` (
     ID_content bigint not null,
     content longtext not null,
     constraint FKis_masterclass_ID primary key (ID_content),
     constraint FKis_masterclass_FK foreign key (ID_content) references teaching (ID_content));

create table `webinair` (
     ID_content bigint not null,
     n_presences int,
     date date not null,
     time time not null,
     constraint FKis_webinair_ID primary key (ID_content),
     constraint FKis_webinair_FK foreign key (ID_content) references teaching (ID_content));

create table `transaction` (
     amount float(7,2) not null,
     discount float(7,2) not null,
     ID_transaction bigint not null AUTO_INCREMENT,
     date date not null,
     time time not null,
     username char(20) not null,
     constraint IDtransaction primary key (ID_transaction),
     constraint FKmaking_transaction foreign key (username) references user (username));

create table `purchase` (
     ID_content bigint not null,
     ID_transaction bigint not null,
     price float(7,2) not null,
     constraint IDpurchase primary key (ID_transaction, ID_content),
     constraint FKabout_purchase foreign key (ID_transaction) references transaction (ID_transaction),
     constraint FKabout_content foreign key (ID_content) references teaching (ID_content));

-- Constraints Section
-- ___________________ 

-- Not implemented
-- alter table `group` add constraint IDgruppo_lavoro_CHK
--     check(exists(select * from collaboration
--                  where collaboration.ID_group = ID_group)); 

-- Not implemented
-- alter table teaching add constraint IDteaching_CHK
--     check(exists(select * from purchase
--                  where purchase.ID_content = ID_content)); 

-- Not implemented
-- alter table user add constraint ID_User_CHK
--     check(exists(select * from profile
--                  where profile.username = username)); 

-- Index Section
-- _____________ 

create unique index ID_comment_IND
     on comment (username, post_ID_profile, post_username, post_date, post_time, date, time);

create index FKabout_post_IND
     on comment (post_ID_profile, post_username, post_date, post_time);

create unique index ID_Post_IND
     on post (ID_profile, username, date, time);

create unique index ID_profile_IND
     on profile (ID_profile);

create unique index ID_Teacher_IND
     on teacher (CF);

create unique index FKUse_Tea_IND
     on teacher (username);

create unique index ID_user_IND
     on user (username);

create unique index IDfriendship_IND
     on friendship (user_1, user_2);