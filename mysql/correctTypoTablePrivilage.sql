set foreign_key_checks = 0;

create table if not exists privalege (
    id int not null auto_increment primary key,
    name varchar(30),
    description text
) engine=innodb;

drop table if exists privalege;

create table if not exists user_privalege_rel (
    id int not null auto_increment primary key,
    privalege_id int,
    user_id int,
    foreign key (privalege_id) references privalege(id),
    foreign key (user_id) references user_profile(id)
) engine=innodb;

drop table if exists user_privalege_rel;

set foreign_key_checks = 1;