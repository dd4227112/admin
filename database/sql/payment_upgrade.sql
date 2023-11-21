CREATE TABLE IF NOT EXISTS admin.payments_invoice_fees
(
    id serial,
	payment_id integer,
    invoice_fee_id integer NOT NULL,
    amount double precision NOT NULL,
    status smallint NOT NULL DEFAULT (0)::smallint,
    note text COLLATE pg_catalog."default",
    created_at timestamp without time zone DEFAULT now(),
    updated_at timestamp without time zone,
	uuid uuid NOT NULL DEFAULT admin.uuid_generate_v4(),
    CONSTRAINT payments_invoices_fees_primary PRIMARY KEY (id),
    CONSTRAINT payment_invoices_fees_payment_id_foreign FOREIGN KEY (payment_id)
        REFERENCES admin.payments (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT payments_invoices_fees_invoice_id FOREIGN KEY (invoice_fee_id)
        REFERENCES admin.invoice_fees (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

ALTER TABLE IF EXISTS admin.invoice_fees RENAME project_id TO fee_id;

ALTER TABLE IF EXISTS admin.addons RENAME TO fees;

ALTER TABLE IF EXISTS admin.addons_payments RENAME addon_id TO fee_id;

ALTER TABLE IF EXISTS admin.fees
    ADD COLUMN IF NOT EXISTS uuid uuid NOT NULL DEFAULT admin.uuid_generate_v4();

ALTER TABLE IF EXISTS admin.invoice_fees
    ADD COLUMN IF NOT EXISTS note text;