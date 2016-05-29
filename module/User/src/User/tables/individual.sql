create table individual_users(
    iu_id serial not null primary key,
    iu_xref_u_id integer not null references users (u_id),
    iu_nickname varchar,
    iu_wechat varchar,
    iu_fixed_phone varchar,
    iu_labels varchar
);
create unique index individual_users_iu_xref_u_id_idx on individual_users (iu_xref_u_id);
grant all on individual_users to postgres;