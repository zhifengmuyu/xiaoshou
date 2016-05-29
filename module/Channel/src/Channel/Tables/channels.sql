create table channels(
    c_id serial not null primary key,
    c_xref_u_id integer not null references users (u_id),
    c_type varchar,
    c_name varchar,
    c_description varchar,
    c_creation timestamp default now(),
    c_deleted boolean default false
);
create index channels_c_xref_u_id_idx on channels (c_xref_u_id);
grant all on channels to postgres;
