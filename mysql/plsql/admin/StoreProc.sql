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



delimiter ;