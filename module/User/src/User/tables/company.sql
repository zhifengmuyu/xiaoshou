create table company_users(
    cu_id serial not null primary key,
    cu_xref_u_id integer not null references users (u_id),
    cu_name varchar,
    cu_description varchar,
    cu_fixed_phone varchar,
    cu_location varchar,
    cu_labels varchar
);
create unique index company_users_cu_xref_u_id_idx on company_users (cu_xref_u_id);
grant all on company_users to postgres;