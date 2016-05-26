create table users(
    u_id serial not null primary key,
    u_email varchar, --used as login id.
    u_password varchar,
    u_type varchar, --seller or buyer
    u_channels varchar, --I know which company has cheapest computer, etc...
    u_products varchar, --I have a lot of computer to sell.
    u_nickname varchar, -- show in website.
    u_mobile_phone varchar,
    u_fixed_phone varchar,
    u_wechat varchar,
    u_creation timestamp default now(),
    u_deleted boolean default false
);
grant all on users to postgres;