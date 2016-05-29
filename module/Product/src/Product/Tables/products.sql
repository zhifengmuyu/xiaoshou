create table products(
    p_id serial not null primary key,
    p_xref_u_id integer not null references users (u_id),
    p_type varchar,
    p_name varchar,
    p_description varchar,
    p_creation timestamp default now(),
    p_deleted boolean default false
);
create index products_p_xref_u_id_idx on products (p_xref_u_id);
grant all on products to postgres;
