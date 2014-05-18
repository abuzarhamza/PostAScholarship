delimiter $$
drop procedure if exists varify_username;
create procedure varify_username(in_user_name varchar(30))
begin
    if ( select id from user_profile where user_name = in_user_name ) then
        select 'exists';
    else
        select 'does not exists';
    end if;
end; $$


drop procedure if exists verify_and_insert_username;
create procedure verify_and_insert_username(in_user_name varchar(30) )
begin
    if (select id from user_profile where user_name = in_user_name ) then
        select id,display_name,first_name,last_name,about_me,web
          from user_profile where user_name =  in_user_name;
    else
        insert into user_profile(user_name) values(in_user_name);
        select id,display_name,first_name,last_name,about_me,web
          from user_profile where user_name = in_user_name;
    end if;
end; $$

drop procedure if exists verify_and_update_adminprofile;
create procedure verify_and_update_adminprofile(in_user_name varchar(30), in_display_name varchar(30),
    in_first_name varchar(30),in_last_name varchar(30),in_about_me varchar(250),in_web varchar(250))
begin
    if (select id from user_profile where user_name = in_user_name ) then
        update user_profile set display_name = in_display_name,
                                first_name = in_first_name,
                                last_name = in_last_name,
                                about_me = in_about_me,
                                web = in_web
         where user_name  = in_user_name;
        select '1';
    else
        select '0';
    end if;
end; $$

drop procedure if exists get_count_posttype;
create procedure get_count_posttype(in_post varchar(30))
begin
    select count(id) from post
     where post_type = in_post
       and root = 1
       order by creation_date;
end; $$

drop procedure if exists get_postview_for_admin;
create procedure get_postview_for_admin(in_offset int,in_max_row int,in_post_type varchar(30))
begin
    if (select count(id) from post where post_type = in_post_type) then
        select p.id as id, p.title as title,p.creation_date as creation_date,p.lastedit_date as lastedit_date,p.post_type as post_type,p.book_count as book_count,p.view as view, u.user_name as author_name
          from post p
          inner join user_profile u
          on p.post_type = in_post_type
         and p.root = 1
         order by p.creation_date
         limit in_offset,in_max_row;
    else
        select '0';
    end if;
end; $$

drop procedure if exists insert_post_for_admin;
create procedure insert_post_for_admin(in_user_name varchar(30) , in_title varchar(250), in_content text, in_html text,in_slug varchar(250) , in_post_type varchar(50))
    begin
        declare in_post_id int;
        declare in_author_id int;
        declare in_lastedit_user_id int;
        declare in_creation_date datetime;
        declare in_lastedit_date datetime;
        if ( select id from user_profile where user_name = in_user_name )  then
            select id into in_author_id from user_profile where user_name = in_user_name;
            select now() into in_creation_date;
            set in_lastedit_user_id = in_author_id;
            set in_lastedit_date    = in_creation_date;
            insert into post(author_id,title,content,html,slug,post_type,creation_date,lastedit_date,lastedit_user_id)
            values (in_author_id,in_title,in_content,in_html,in_slug,in_post_type,in_creation_date,in_lastedit_date,in_lastedit_user_id);
            select last_insert_id() from post;
        else
            select '0';
        end if;
    end; $$

drop function if exists get_count_posttype_for_admin;
create function get_count_posttype_for_admin(in_post varchar(30))
  returns int
begin
    declare out_count_post int default 0;
    select count(id) into out_count_post
      from post
     where post_type = in_post
       and root = 1
       order by creation_date;
    return(out_count_pos);
end; $$

delimiter ;

----select tag_name from tag t where t.id in (select tag_id from tag_post_rel where post_id = p.id),