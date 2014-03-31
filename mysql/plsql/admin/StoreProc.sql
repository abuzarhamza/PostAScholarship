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
    if (select user_name from user_profile where user_name = in_user_name ) then
        update user_profile set display_name = display_name,
                                first_name = in_first_name,
                                last_name = in_last_name,
                                about_me = in_about_me,
                                web = in_web
         where user_name  = in_user_name;
        select '1';
    else
        select 'does not exists';
    end if;
end; $$

delimiter ;