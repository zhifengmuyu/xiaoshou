create table products(
    p_id serial not null primary key,
    p_xref_u_id integer not null references users (id),
    p_type varchar,
    p_name varchar,
    p_description varchar,
    p_creation timestamp default now(),
    p_deleted boolean default false
);
grant all on products to postgres;
