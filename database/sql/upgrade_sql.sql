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