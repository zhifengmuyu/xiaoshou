create table users(
    u_id serial not null primary key,
    u_email varchar, --used as login id.
    u_password varchar,
    u_type varchar, --seller or buyer
    u_mobile_phone varchar,
    u_activated boolean default true,
    u_creation timestamp default now(),
    u_deleted boolean default false
);
create unique index users_u_email_idx on users (u_email);
create unique index users_u_mobile_phone_idx on users (u_mobile_phone);
grant all on users to postgres;