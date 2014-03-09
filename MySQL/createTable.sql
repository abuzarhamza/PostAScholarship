create table if not exists user_profile (
    id int not null auto increment primary key,
    user_name varchar(30),
    display_name varchar(30),
    first_name varchar(30),
    last_name varchar(30),
    type varchar(30), -- moderator or admin
    about_me varchar(250),
    web varchar(250),
    gold_badge int not null default 0,
    silver_badge int not null default 0,
    bronze_badge int not null default 0,
    new_message_count int not null default 0,
    score int not null default 0,
    rank int not null default 0,
    about_me_html varchar(700),
    status varchar(30) -- suspended or active
    email_varified tinyint default 0,
    mytags text 
)database=Innodb;


create table if not exists badge (
    id int not null auto increment primary key,
    name varchar(50),
    description varchar(250),
    type varchar(30), -- gold silver bronze iron
    unique tinyint , -- unique badge can be earn once
    secret tinyint , -- are not listed
    count int default 0 -- total number of times awarded
);


create table if not exists user_badge_rel (
    id int not null auto increment primary key,
    badge_id int not null,
    user_id int not null,
    date datetime,
    foreign key badge_id references badge(id),
    foreign key user_id references user_profile(id)
);



create table if not exists notes (
    id int not null auto increment primary key,
    note_sender_id int not null,
    note_target_id int not null,
    content text,
    html text,
    date datetime,
    unread tinyint, -- 1 or 0
    type varchar(30), -- note type,
    foreign key (note_sender_id) references user_profile(id),
    foreign key (note_target_id) references user_profile(id)
);



create table if not exists tag (
    id int not null auto increment primary key,
    tag_name varchar(60) not null,
    tag_description varchar(250),
    tag_count int default 0,
    alias tinyint default 0, -- 0 or 1
    main tinyint default 0 -- 0 or 1
);

create table if not exists tag_alias (
    id int not null auto increment primary key,
    alias_id1 int not null,
    alias_id2 int  not null,
    foreign key (alias_id1) references tag(id),
    foreign key (alias_id2) references tag(id)
);


create table if not exists tag_post_rel (
    id int not null auto increment primary key,
    tag_id int not null,
    post_id not null,
    date datetime,
    foreign key (tag_id) references tag(id),
    foreign key (post_id) references post(id)
);

create table if not exists post (
    id int not null auto increment primary key,

)