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

create procedure get_count_posttype(in_post varchar(30))
begin
    select count(id) from post
     where post_type = in_post
       and root = 1;
end; $$

create procedure get_postview_for_admin(in_offset int,in_max_row int,in_post_type varchar(30))
begin
    if (select count(id) from post where post_type = in_post_type) then
        select p.title as title,u.user_name as user_name,p.creation_date as creation_date,p.lastedit_date as lastedit_date,p.post_type as post_type,p.book_count as book_count,p.view as view
          from post p
          inner join user_profile u
         on p.author_id = u.id
         and p.post_type = in_post_type
         and p.root = 1
         order by creation_date
         limit in_offset,in_max_row;
    else
        select '0';
    end if;
end; $$



create procedure get_postviewtags_for_admin(in_offset int,in_max_row int,in_post_type varchar(30))
begin
    if (select count(id) from post where post_type = in_post_type) then
        select p.title as title,u.user_name as user_name,p.creation_date as creation_date,p.lastedit_date as lastedit_date,p.post_type as post_type,p.book_count as book_count,p.view as view
          from post p
         inner join user_profile u
            on p.author_id = u.id
           and p.post_type = in_post_type
           and p.root = 1
         order by p.creation_date
         limit in_offset,in_max_row;
    else
        select '0';
    end if;
end; $$
delimiter ;

--select tag_name from tag t where t.id in (select tag_id from tag_post_rel where post_id = p.id),
