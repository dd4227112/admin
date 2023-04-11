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




-- FUNCTION: anazak.test()

-- DROP FUNCTION anazak.test();

CREATE OR REPLACE FUNCTION anazak.test(
    )
    RETURNS text
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE PARALLEL UNSAFE
AS $BODY$
DECLARE r record; j record; h record; status text; 
BEGIN status='No any Change';
if exists(select 1 from setting where sub_invoice=1) THEN
 SELECT invoice_views UNION ALL select invoice_subviews;
ELSE
 select invoice_view;
 END IF; RETURN status; END;
$BODY$;

ALTER FUNCTION anazak.test()
    OWNER TO postgres;


-- FUNCTION: rightwayschools.foo()
CREATE OR REPLACE FUNCTION rightwayschools.foo(
    )
    RETURNS void
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE PARALLEL UNSAFE
AS $BODY$
DECLARE r record; _sql text;
BEGIN

FOR r IN SELECT student_id from rightwayschools.student where status=1
LOOP
   PERFORM rightwayschools.redistribute_student_payments(student_id);
END LOOP;

END;
$BODY$;

ALTER FUNCTION rightwayschools.foo()
    OWNER TO postgres;















-- FUNCTION: testing.optimize_payment_distribution()

-- DROP FUNCTION testing.optimize_payment_distribution();

-- FUNCTION: rightwayschools.distribute_amount()

-- DROP FUNCTION rightwayschools.distribute_amount();

-- FUNCTION: rightwayschools.balance_paid_amount()

-- DROP FUNCTION rightwayschools.balance_paid_amount();

CREATE OR REPLACE FUNCTION testing.balance_paid_amount(
    )
    RETURNS integer
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE PARALLEL UNSAFE
AS $BODY$
DECLARE
    r record;
    j record;
BEGIN
FOR r IN
select (cur_paid-paid_amount) as diffe,amount,cur_paid,paid_amount,id from(select a.paid_amount,a.amount,b.cur_paid,a.id from  (select invoice_fee_id,sum(current_paid_amount) as cur_paid from payment_fee group by invoice_fee_id) as b join 
invoice_fee a on a.id=b.invoice_fee_id) as l where l.paid_amount<cur_paid
LOOP
IF exists(select 1 from payment_fee where invoice_fee_id=r.id and current_paid_amount> r.diffe limit 1)
THEN
FOR j IN
select * from payment_fee where invoice_fee_id=r.id and current_paid_amount> r.diffe limit 1
LOOP
update payment_fee set current_paid_amount=current_paid_amount-r.diffe where id=j.id;
END LOOP;
ELSE
END IF;  
END LOOP;
RETURN 1;  
END;
$BODY$;
ALTER FUNCTION testing.balance_paid_amount()
    OWNER TO postgres






-- FUNCTION: rightwayschools.balance_paid_amount()

-- DROP FUNCTION rightwayschools.balance_paid_amount();

CREATE OR REPLACE FUNCTION rightwayschools.balance_paid_amount(
    )
    RETURNS integer
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE PARALLEL UNSAFE
AS $BODY$
DECLARE
    r record;
    j record;
BEGIN
FOR r IN
select (cur_paid-paid_amount) as diffe,amount,cur_paid,paid_amount,id from(select a.paid_amount,a.amount,b.cur_paid,a.id from  (select invoice_fee_id,sum(current_paid_amount) as cur_paid from payment_fee group by invoice_fee_id) as b join 
invoice_fee a on a.id=b.invoice_fee_id) as l where l.paid_amount<cur_paid
LOOP
IF exists(select 1 from payment_fee where invoice_fee_id=r.id and current_paid_amount> r.diffe limit 1)
THEN
FOR j IN
select * from payment_fee where invoice_fee_id=r.id and current_paid_amount> r.diffe limit 1
LOOP
update payment_fee set current_paid_amount=current_paid_amount-r.diffe where id=j.id;
END LOOP;
ELSE
END IF;  
END LOOP;
RETURN 1;
END;
$BODY$;

ALTER FUNCTION rightwayschools.balance_paid_amount()
    OWNER TO postgres;





















    -- FUNCTION: testing.balance_paid_amount()

-- DROP FUNCTION testing.balance_paid_amount();

CREATE OR REPLACE FUNCTION testing.distribute_payment(
    )
    RETURNS integer
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE PARALLEL UNSAFE
AS $BODY$
DECLARE r record; j record; h record; f record; amount_paid integer; cur_amount_paid integer; BEGIN amount_paid := 0; FOR r IN select paymentamount::numeric,"paymentID" as payment_id,"invoiceID" as invoice_id FROM payment where "paymentID" not in(select distinct payment_id from payment_fee) ORDER BY "invoiceID" ASC LOOP IF exists(select 1 from invoice_fee where invoices_id=r.invoice_id and status !='1') THEN FOR f IN select sum(current_paid_amount) as total_cur_paid from payment_fee where payment_id=r.payment_id LOOP IF exists(select 1 from payment_fee where payment_id=r.payment_id) THEN amount_paid=r.paymentamount-f.total_cur_paid; ELSE amount_paid=r.paymentamount; END IF; END LOOP; FOR j IN select * from invoice_fee where invoices_id =r.invoice_id and status !='1' LOOP IF(amount_paid>0) THEN FOR h IN select sum(current_paid_amount) as total_cur_paid from payment_fee where invoice_fee_id=j.id LOOP IF exists(select 1 from payment_fee where invoice_fee_id=j.id) THEN cur_amount_paid=j.amount-h.total_cur_paid; ELSE cur_amount_paid=j.amount; END IF; IF(cur_amount_paid <>0) THEN IF(amount_paid >= cur_amount_paid) THEN INSERT INTO payment_fee(invoice_fee_id, payment_id, date, current_paid_amount) VALUES (j.id, r.payment_id, 'now()', cur_amount_paid); update invoice_fee set status='1' where id=j.id; amount_paid=amount_paid-(cur_amount_paid); ELSE INSERT INTO payment_fee(invoice_fee_id, payment_id, date, current_paid_amount) VALUES (j.id, r.payment_id, 'now()', amount_paid); update invoice_fee set status='2' where id=j.id; amount_paid=0; END IF; ELSE END IF; END LOOP; END IF; END LOOP; ELSE amount_paid=r.paymentamount; END IF; END LOOP; RETURN amount_paid; END;
$BODY$;

ALTER FUNCTION testing.distribute_payment()
    OWNER TO postgres;

-- View: canossa.invoices_fees_installments_balance

-- DROP VIEW canossa.invoices_fees_installments_balance;

CREATE OR REPLACE VIEW canossa.invoices_fees_installments_balance
 AS
 SELECT COALESCE(a.amount, 0::numeric) AS total_amount,
    COALESCE(c.total_payment_invoice_amount, 0::numeric) AS total_payment_invoice_fee_amount,
    COALESCE(d.total_advance_invoice_fee_amount, 0::numeric) AS total_advance_invoice_fee_amount,
    COALESCE(e.amount, 0::numeric) AS discount_amount,
    f.student_id,
    f.date AS created_at,
    b.id,
    b.fees_installment_id,
    h.id AS installment_id,
    h.start_date,
    h.academic_year_id,
    i.id AS fee_id,
    f.id AS invoice_id,
        CASE
            WHEN (a.amount - COALESCE(c.total_payment_invoice_amount, 0::numeric) - COALESCE(d.total_advance_invoice_fee_amount, 0::numeric) - COALESCE(e.amount, 0::numeric)) > 0::numeric THEN 0
            ELSE 1
        END AS status,
    h.end_date
   FROM canossa.fees_installments_classes a
     JOIN canossa.invoices_fees_installments b ON b.fees_installment_id = a.fees_installment_id
     JOIN canossa.invoices f ON f.id = b.invoice_id
     JOIN canossa.fees_installments g ON g.id = a.fees_installment_id
     JOIN canossa.installments h ON h.id = g.installment_id
     JOIN canossa.fees i ON i.id = g.fee_id
     JOIN canossa.student_archive s ON s.student_id = f.student_id AND (s.section_id IN ( SELECT section."sectionID"
           FROM canossa.section
          WHERE section."classesID" = a.class_id)) AND h.academic_year_id = s.academic_year_id
     LEFT JOIN ( SELECT sum(payments_invoices_fees_installments.amount) AS total_payment_invoice_amount,
            payments_invoices_fees_installments.invoices_fees_installment_id
           FROM canossa.payments_invoices_fees_installments
          WHERE (payments_invoices_fees_installments.payment_id IN ( SELECT payments.id
                   FROM canossa.payments))
          GROUP BY payments_invoices_fees_installments.invoices_fees_installment_id) c ON c.invoices_fees_installment_id = b.id
     LEFT JOIN ( SELECT sum(advance_payments_invoices_fees_installments.amount) AS total_advance_invoice_fee_amount,
            advance_payments_invoices_fees_installments.invoices_fees_installments_id
           FROM canossa.advance_payments_invoices_fees_installments
          GROUP BY advance_payments_invoices_fees_installments.invoices_fees_installments_id) d ON d.invoices_fees_installments_id = b.id
     LEFT JOIN canossa.discount_fees_installments e ON e.fees_installment_id = a.fees_installment_id AND f.student_id = e.student_id
  ORDER BY h.start_date, i.priority;

ALTER TABLE canossa.invoices_fees_installments_balance
    OWNER TO postgres;

CREATE OR REPLACE VIEW canossa.mark_grade
 AS
 SELECT total_mark.student_id,
    total_mark."classesID",
    total_mark.year,
    total_mark."examID",
    total_mark.total,
    row_number() OVER (ORDER BY total_mark.total DESC) AS rank
   FROM canossa.total_mark;

ALTER TABLE canossa.mark_grade
    OWNER TO postgres;





-- EXCEPT ALL 
select a.tables from (SELECT   table_name as tables FROM information_schema.tables 
WHERE (tables.table_schema::name <> ALL (ARRAY['admin'::name, 'constant'::name, 'academy'::name, 'api'::name, 'forum'::name, 'pg_catalog'::name, 'information_schema'::name])) AND tables.table_type::text = 'BASE TABLE'::text AND table_schema = 'amka' ) a   EXCEPT ALL
(select b.tables  from (SELECT   table_name as tables FROM information_schema.tables
 WHERE (tables.table_schema::name <> ALL (ARRAY['admin'::name, 'constant'::name, 'academy'::name, 'api'::name, 'forum'::name, 'pg_catalog'::name, 'information_schema'::name])) AND tables.table_type::text = 'BASE TABLE'::text AND table_schema = 'betatwo' )  b );

CREATE MATERIALIZED VIEW IF NOT EXISTS admin.all_table_merge
TABLESPACE pg_default
AS
 SELECT x.table_name,
    ( SELECT string_agg((('"'::text || columns.column_name::text) || '"::'::text) || columns.data_type::text, ','::text) AS string_agg
           FROM information_schema.columns
          WHERE columns.table_name::text = x.table_name::text AND columns.table_schema::text = 'canossa'::text) AS lists
   FROM information_schema.tables x
  WHERE x.table_schema::text = 'canossa'::text AND lower(x.table_type::text) <> 'view'::text
WITH DATA;

ALTER TABLE IF EXISTS admin.all_table_merge
    OWNER TO postgres;


insert into public.sms (body, phone_number, type,sms_keys_id)
select 'Hello '||schema_name||' 

Leo (11/04/2023), saa 6 na nusu mchana,  ShuleSoft tutafanya training fupi kwa wahasibu wote ya namna ya kuandaa invoice za quarter.

Ili kuhudhuria, fungua hii link: https://meet.google.com/ukg-svtc-qef

Usipange kukosa', admin.format_phone_number(phone),1, (select id from public.sms_keys limit 1) from admin.all_users where "table" not in ('parent','setting','student') and status=1 and schema_name in (select username from admin.clients where status=1) and  usertype not in ('Student','Parent','Driver','Matron','Cooks','Cleaner','Secreatry','Conductor','Gardener','Normal','Nurse','Dormitory','Cook','Gatekeeper','Sanitation','Doctor','Attendant','Janitor','Security guard','Usafi','Watchman','cook','Cow boy','Cowboy','Cooker','DRIVER','Driver and carpenter','Farmer','Nesi','Mpishi','Mlinzi','Maids','Garden','Gate keeper','Gaderner') and lower(usertype) not like '%academic%' and lower(usertype) not like '%teacher%' 
        and lower(usertype) not like '%cleaner%'  and lower(usertype) not like '%driver%'   and lower(usertype) not like '%matron%'  and lower(usertype) not like '%patron%'  and lower(usertype) not like '%aunt%'   and lower(usertype) not like '%car%'  and lower(usertype) not like '%cook%'  and lower(usertype) not like '%clean%'  and lower(usertype) not like '%doct%'   and lower(usertype) not like '%fund%' and lower(usertype) not like '%tay%'  and lower(usertype) not like '%shamba%'  and lower(usertype) not like '%security%'  and lower(usertype) not like '%plumb%'  and lower(usertype) not like '%nurse%'   and lower(usertype) not like '%exam%'  and lower(usertype) not like '%env%' --limit 5