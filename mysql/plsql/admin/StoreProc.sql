delimiter $$

create procedure verify_and_insert_usrename(in_user_name varchar(30) )
begin
    if (select id from user_profile where user_name = in_user_name ) then
        select id,user_name,display_name,first_name,last_name,type,about_me,web
          from user_profile where user_name =  in_user_name;
    else
        insert into user_profile(user_name) values(in_user_name);
        select id,user_name,display_name,first_name,last_name,type,about_me,web 
          from user_profile where user_name = in_user_name;
    end if;
end; $$

create procedure varify_username(in_user_name varchar(30))
begin
    if ( select id from user_profile where user_name = in_user_name ) then
        select 'exists';
    else
        select 'does not exists';
    end if;
end; $$

delimiter ;