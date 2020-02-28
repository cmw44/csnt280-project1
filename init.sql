
-- init.sql for project1_db
-- Cameron Wertelka


drop table if exists users cascade;

create table users(
	id serial,
	first_name text,
	last_name text,
	e_mail text unique,
	salt text,
	enc_pass text,
	primary key(id)
);
