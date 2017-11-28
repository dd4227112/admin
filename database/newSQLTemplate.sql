CREATE TABLE public.payment
(
    "paymentID" bigint NOT NULL DEFAULT nextval('payment_paymentid_seq'::regclass),
    "invoiceID" integer NOT NULL,
    "studentID" integer NOT NULL,
    paymentamount character varying(20) COLLATE pg_catalog."default" NOT NULL,
    paymenttype character varying(128) COLLATE pg_catalog."default" NOT NULL,
    paymentdate date NOT NULL,
    paymentmonth character varying(10) COLLATE pg_catalog."default" NOT NULL,
    paymentyear integer NOT NULL,
    created_at timestamp without time zone DEFAULT now(),
    slipfile character varying(250) COLLATE pg_catalog."default",
    approved integer DEFAULT 0,
    approved_date timestamp without time zone,
    approved_user_id bigint,
    transaction_id character varying(120) COLLATE pg_catalog."default",
    "userID" bigint,
    cheque_number character varying COLLATE pg_catalog."default",
    bank_name character varying COLLATE pg_catalog."default",
    payer_name character varying COLLATE pg_catalog."default",
    mobile_transaction_id character varying COLLATE pg_catalog."default",
    transaction_time character varying COLLATE pg_catalog."default",
    account_number character varying COLLATE pg_catalog."default",
    CONSTRAINT "primary key29" PRIMARY KEY ("paymentID"),
    CONSTRAINT pk_payment UNIQUE ("paymentID"),
    CONSTRAINT fk_payment_invoices FOREIGN KEY ("invoiceID")
        REFERENCES public.invoices (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
)