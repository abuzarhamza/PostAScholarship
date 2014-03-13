create table if not exists user_profile (
    id int not null auto_increment primary key,
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
    status varchar(30), -- suspended or active
    email_varified tinyint default 0,
    addver_disable tinyint default 0, -- user will be able to disable addversitesment after certain point level
    mytags text 
) engine =innodb;


create table if not exists privalege (
    id int not null auto_increment primary key,
    name varchar(30),
    description text,
) engine=myisam;

create table if not exists user_privalege_rel (
    id int not null auto_increment primary key,
    privalege_id int,
    user_id int,
    foreign key privalege_id references privalege(id),
    foreign key user_id references user_profile(id)
) engine=innodb;


create table if not exists badge (
    id int not null auto_increment primary key,
    name varchar(50),
    description varchar(250),
    type varchar(30), -- gold silver bronze iron
    unique tinyint , -- unique badge can be earn once
    secret tinyint , -- are not listed
    count int default 0 -- total number of times awarded
) engine= myisam;


create table if not exists user_badge_rel (
    id int not null auto_increment primary key,
    badge_id int not null,
    user_id int not null,
    date datetime,
    foreign key badge_id references badge(id),
    foreign key user_id references user_profile(id)
) engine=myisam;


create table if not exists notes (
    id int not null auto_increment primary key,
    note_sender_id int not null,
    note_target_id int not null,
    content text, --mark down
    html text, -- html for better display
    date datetime,
    unread tinyint default 0, -- 1 or 0
    type varchar(30), -- note type,
    foreign key (note_sender_id) references user_profile(id),
    foreign key (note_target_id) references user_profile(id)
) engine=innodb;



create table if not exists tag (
    id int not null auto_increment primary key,
    tag_name varchar(60) not null,
    tag_description varchar(250),
    tag_count int default 0,
    alias tinyint default 0, -- 0 or 1
    parent tinyint default 1,-- 0 or 1
    child tinyint default 0,
    tag_enable tinyint default 0 -- user suggested tag to be ebabled.
);

create table if not exists tag_alias (
    id int not null auto_increment primary key,
    alias_id1 int not null,
    alias_id2 int  not null,
    foreign key (alias_id1) references tag(id),
    foreign key (alias_id2) references tag(id)
);


create table if not exists tag_post_rel (
    id int not null auto_increment primary key,
    tag_id int not null,
    post_id not null,
    date datetime,
    foreign key (tag_id) references tag(id),
    foreign key (post_id) references post(id)
);


create table if not exists follow_tag (
     id int not null auto_increment primary key,
     regex text, -- trigger need to be used for sending email to end user. 
     user_id int ,
     foreign key (user_id) refernce user_profile(id)
);


create table if not exists post (
    id int auto_increment not null primary key,
    author_id int not null foreign key (author_id) references user_profile(id),
    title varchar(250),
    content text, --mark down content
    html text, --sanitize html content for display
    slug varchar(250),
    view int not null default 0,
    score int not null default 0,
    full_score int ,
    flag tinyint default 0, -- if he post is marked for spamming etc
    creation_date datetime,
    lastedit_date datetime,
    lastedit_user_id int  foreign key (lastedit_user_id) references user_profile(id),
    changed tinyint ,-- keep track of which post has changed
    post_type varchar(50),
    root tinyint not null default 1, --this will maintain the ancestor/descendant relationship between posts
    parent int unique key references post(id),  --maintain parent child relation ship
    context text , -- use to display the context the post was created/edited 
    answer_count int not null default 0,
    book_count int not null default 0,
    accepted_answer tinyint , -- weather answer was accepted
    url varchar(255), -- used for post with linkouts
    sticky int not null default 0 -- stickiness of the post
);

create table if not exists post_view (
    ip varchar(50),
    post_id int,
    datetime datetime.
    foreign key (post_id) references post(id),
    primary key (ip,post_id)
);

create table if not exists related_post (
    id int not null auto_increment primary key,
    post_id int ,
    target_id int,
    foreign key post_id references post(id),
    foreign key target_id references post(id),
);

create table if not exists post_revision (
    id int not null auto_increment primary key,
    post_id int ,
    diff text,
    context text,
    author_id int ,
    datetime datetime,
    foreign key post_id references post(id),
    foreign key author_id references user_profile(id),  
);

create table if not exists vote (
    id int not null auto_increment primary key,
    post_id int ,
    type varchar(30),--type VOTE_UP|VOTE_DOWN|VOTE_ACCEPT|VOTE_BOOKMARK|VOTE_FLAG 
    datetime datetime,
    author_id int ,
    foreign key post_id references post(id),
    foreign key author_id references user_profile(id)
);


create table if not exists flag (
    id int not null auto_increment primary key,
    post_id int , 
    datetime datetime,
    author_id int ,
    context text default null,
    foreign key post_id references post(id),
    foreign key author_id references user_profile(id) 
);


create table if not exists flag_status (
    id int not null auto_increment primary key,
    post_id int , 
    moderator_id int ,
    approved tinyint not null default 0,
    foreign key post_id references post(id),
    foreign key moderator_id references user_profile(id)  
);
