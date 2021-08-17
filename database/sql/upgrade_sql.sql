ALTER TABLE admin.due_amounts
    ADD COLUMN id serial;

ALTER TABLE admin.due_amounts
    ADD CONSTRAINT due_amounts_id_primary PRIMARY KEY (id);


ALTER TABLE admin.due_amounts
    ADD CONSTRAINT due_amounts_client_id_foreign FOREIGN KEY (client_id)
    REFERENCES admin.clients (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE;
CREATE INDEX fki_due_amounts_client_id_foreign
    ON admin.due_amounts(client_id);


CREATE TABLE admin.due_amounts_payments
(
    id serial,
    payment_id integer,
    due_amount_id integer,
    amount character varying,
    PRIMARY KEY (id)
);

ALTER TABLE admin.due_amounts_payments
    OWNER to postgres;

ALTER TABLE admin.due_amounts_payments
    RENAME CONSTRAINT due_amounts_payments_pkey TO due_amounts_payments_id_primary;

ALTER TABLE admin.due_amounts_payments
    ADD CONSTRAINT due_amounts_payments_payment_id_foreign FOREIGN KEY (payment_id)
    REFERENCES admin.payments (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE;
CREATE INDEX fki_due_amounts_payments_payment_id_foreign
    ON admin.due_amounts_payments(payment_id);


ALTER TABLE admin.due_amounts_payments
    ADD CONSTRAINT due_amounts_payments_due_amount_id_foreign FOREIGN KEY (due_amount_id)
    REFERENCES admin.due_amounts (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE;
CREATE INDEX fki_due_amounts_payments_due_amount_id_foreign
    ON admin.due_amounts_payments(due_amount_id);





    CREATE VIEW admin.client_invoice_balance as (
select b.amount as total_amount,b.created_at,a.invoice_fee_id,sum(a.paid_amount) as paid_amount,c.client_id from 
admin.invoice_fees_payments a join  admin.invoice_fees b on a.invoice_fee_id = b.id 
join admin.invoices c on c.id = b.invoice_id 
group by a.invoice_fee_id,c.client_id,b.amount,b.created_at
)





-- select A.id,A.name,A.client_id,A.students,A.username,A.activities,A.ward,A.district,A.region from
-- admin.schools B left join 
-- (select s.id,s.ward_id,s.name,c.client_id,n.estimated_students as students,n.username,count(t.*) as activities, w.name as ward, d.name as district,r.name as region
-- from admin.schools s  join admin.client_schools c on c.school_id = s.id join admin.clients n on n.id = c.client_id join admin.tasks t on t.school_id = s.id join admin.wards w on w.id = s.ward_id join admin.districts as d on d.id= w.district_id join admin.regions r on  r.id=d.region_id 
-- where s.ownership <> 'Government'  group by s.id,c.client_id,n.estimated_students,n.username,w.name,d.name,
-- r.name) A on B.id = A.id




delete from admin.invoices where id in (
select invoice_id from admin.invoice_fees where amount = 0 )


select A.client_id,C.username,sum(B.amount) from
(select * from admin.invoices where  account_year_id = '4' and id in ( select invoice_id from admin.invoice_fees where project_id = '1') ) A join admin.invoice_fees  B 
on A.id = B.invoice_id join admin.clients C on A.client_id = C.id group by A.client_id,C.username


select * from admin.payments ,,, id = 24




///////////////////////////////////

ALTER TABLE admin.standing_orders
    ADD COLUMN file character varying;

    ALTER TABLE admin.standing_orders
    ADD COLUMN branch_id integer;



-- alter table admin.tasks_users
-- drop constraint tasks_users_task_id_foreign,
-- add constraint tasks_users_task_id_foreign
--    foreign key (task_id)
--    references admin.tasks(id)
--    on update cascade
--    on delete cascade;


ALTER TABLE admin.whatsapp_messages
    ADD COLUMN created_at timestamp without time zone;

    ALTER TABLE admin.whatsapp_messages
    ADD COLUMN updated_at timestamp without time zone;





-- DATABASE OPERATIONS
select a.specific_schema,function_name from (
SELECT specific_schema, count(specific_name) as function_name
FROM information_schema.routines
WHERE (routines.specific_schema::name <> ALL (ARRAY['admin'::name, 'constant'::name, 'academy'::name, 'api'::name, 'forum'::name, 'public'::name,'pg_catalog'::name,'information_schema'::name])) AND routines.data_type::text <> 'trigger'::text group by specific_schema )a where a.function_name > 31 
