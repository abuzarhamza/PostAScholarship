delimiter $$

---- to insert the tag
drop procedure if exists validate_and_insert_tag;
create procedure validate_and_insert_tag(in_tag_name varchar(250))
begin
    declare tag_flag int default 0;
    select count(*) into tag_flag from tag where tag_name = in_tag_name ;
    if ( tag_flag = 0 ) then
      insert into tag (tag_name) values(in_tag_name);
    end if;
end; $$

---- to insert the badge
drop procedure if exists validate_and_insert_badge;
create procedure validate_and_insert_badge(in_name varchar(50),in_description varchar(250),in_type varchar(30))
  begin
    declare badge_flag int default 0;
    select count(*) into badge_flag from badge where name = in_name;
    if ( badge_flag = 0 )  then
      insert into badge(name,description,type) values(in_name,in_description,in_type);
    end if;
  end; $$

---- add post with author id
drop procedure if exists add_post;
create procedure add_post(  in_author_id int ,in_title varchar(150),in_content text , in_html text, in_slug varchar(250),in_post_type varchar(50) , in_url tinyint)  
begin
    declare post_id int default 0;

    insert into post (title,content,html,slug,post_type,url,author_id)
            values (in_title,in_content,in_html,in_slug,in_post_type,in_url);
    select id into post_id from post where id = last_insert_id();

    if ( in_post_type = 'SCHOLARSHIP' or in_post_type = 'JOB'
        or in_post_type = 'QUESTION' or in_post_type = 'BLOG' or in_post_type = 'SOCIAL BOOKMARK' ) then
        insert into post_hierarchy_rel (child_post_id) values (post_id);
    end if;

    select post_id;
end;$$

---- add post with user name
drop procedure if exists add_post_with_name;
create procedure add_post_with_name(  in_author_name int ,in_title varchar(150),in_content text , in_html text, in_slug varchar(250),in_post_type varchar(50) , in_url tinyint)  
begin
    declare post_id int default 0;
    declare author_id int default 0;

    select id into author_id from user_profile where user_name = in_author_name;
    if ( author_id ) then
      insert into post (title,content,html,slug,post_type,url,author_id)
              values (in_title,in_content,in_html,in_slug,in_post_type,in_url,author_id);
      select id into post_id from post where id = last_insert_id();
      if ( in_post_type = 'SCHOLARSHIP' or in_post_type = 'JOB'
          or in_post_type = 'QUESTION' or in_post_type = 'BLOG' or in_post_type = 'SOCIAL BOOKMARK' ) then
          insert into post_hierarchy_rel (child_post_id) values (post_id);
      end if;
      select post_id;
    else
      select 0 as 'post_id';
    end if;

end;$$



---- add tag for post
---- add scholarship_tag function
drop procedure if exists add_tag_for_post;
create procedure add_tag_for_post( in_post_id int, in_tag_name varchar(60))
begin
    declare in_tag_id int default null;
    declare in_rel_flag int default null;

    select id into in_tag_id from tag where tag_name = in_tag_name;
    select id into in_rel_flag from tag_post_rel where tag_id = in_tag_id and post_id = in_post_id;

      if ( (in_tag_id is not null) and (in_rel_flag is null) ) then
        insert into tag_post_rel (tag_id,post_id) values (in_tag_id,in_post_id);
        select 1 as 'tag_flag';
      else
        if ( in_tag_id is null) then
          insert into tag_suggestion (tag_name,post_id) values (in_tag_name,in_post_id);
        end if;
        select 0 as 'tag_flag';
      end if;
end;$$


---- add comment
drop procedure if exists add_comment;
create procedure add_comment(  in_author_id int ,in_title varchar(150),in_content text , in_html text, in_slug varchar(250),in_post_type varchar(50) , in_url tinyint , in_partent_post_id int)  
begin
    declare in_post_id int default 0;

    insert into post (title,content,html,slug,post_type,url,author_id) 
            values (in_title,in_content,in_html,in_slug,in_post_type,in_url);
    select id into in_post_id from post where id = last_insert_id();

    if ( in_post_type = 'COMMENT') then
        insert into post_hierarchy_rel (parent_post_id,child_post_id) values (in_partent_post_id,in_post_id);
    end if;

    select in_post_id;
end;$$

---- to varify the user name
drop procedure if exists varify_username;
create procedure varify_username(in_user_name varchar(30))
begin
    if exists ( select id from user_profile where user_name = in_user_name ) then
        select 'exists';
    else
        select 'does not exists';
    end if;
end; $$

----
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
create procedure get_postview_for_admin(in_offset int,in_max_row int)
begin
    if (select count(id) from post where root = 1 ) then
        select p.id as id, p.title as title,p.creation_date as creation_date,p.lastedit_date as lastedit_date,p.post_type as post_type,p.book_count as book_count,p.view as view, u.user_name as author_name
          from post p
          inner join user_profile u on
          p.root = 1
          and p.author_id = u.id
          order by p.creation_date
          limit in_offset,in_max_row;
    else
        select 0 as 'post_count';
    end if;
end;$$


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