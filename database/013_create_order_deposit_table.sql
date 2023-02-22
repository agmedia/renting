create table order_deposit
(
    id             bigint unsigned auto_increment
        primary key,
    order_id       bigint unsigned   not null,
    amount         decimal(10, 2)    not null,
    signature      varchar(191)      not null,
    payment_method varchar(191)      not null,
    payment_code   varchar(191)      null,
    paid           tinyint default 0 not null,
    expire         datetime          null,
    status_id      int unsigned      not null,
    invoice        varchar(191)      null,
    comment        varchar(191)      null,
    created_at     timestamp         null,
    updated_at     timestamp         null,
    constraint order_deposit_order_id_foreign
        foreign key (order_id) references renting.orders (id)
)
    collate = utf8mb4_unicode_ci;

