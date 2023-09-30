-- sequence 
CREATE SEQUENCE IF NOT EXISTS admin.lineshop_clients_id_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1
    -- sequence 
CREATE SEQUENCE IF NOT EXISTS admin.pharmacies_id_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1

        -- sequence 
CREATE SEQUENCE IF NOT EXISTS admin.lineshop_contracts_types_id_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1

            -- sequence 
CREATE SEQUENCE IF NOT EXISTS admin.lineshop_contact_id_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1

 -- sequence 
    CREATE SEQUENCE IF NOT EXISTS admin.lineshop_events_id_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1


 -- sequence 

    CREATE SEQUENCE IF NOT EXISTS admin.lineshop_event_attendees_id_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1
    
  -- table
  CREATE TABLE IF NOT EXISTS admin.lineshop_clients
(
    id integer NOT NULL DEFAULT nextval('admin.lineshop_clients_id_seq'::regclass),
    name character varying COLLATE pg_catalog."default",
    email character varying COLLATE pg_catalog."default",
    phone character varying COLLATE pg_catalog."default",
    address character varying COLLATE pg_catalog."default",
    created_at timestamp without time zone DEFAULT now(),
    updated_at timestamp without time zone,
    lat character varying COLLATE pg_catalog."default",
    "long" character varying COLLATE pg_catalog."default",
    google_map character varying COLLATE pg_catalog."default",
    username character varying COLLATE pg_catalog."default",
    code character varying COLLATE pg_catalog."default",
    email_verified smallint DEFAULT 0,
    phone_verified smallint DEFAULT 0,
    created_by integer,
    estimated_students integer,
    special_trial_code character varying COLLATE pg_catalog."default",
    status integer,
    registration_number character varying COLLATE pg_catalog."default",
    region_id integer,
    ward_id integer,
    invoice_start_date date,
    invoice_end_date date,
    start_usage_date date,
    payment_option character varying COLLATE pg_catalog."default",
    trial smallint,
    owner_phone character varying COLLATE pg_catalog."default",
    owner_email character varying COLLATE pg_catalog."default",
    note text COLLATE pg_catalog."default",
    account_name character varying COLLATE pg_catalog."default",
    country_id integer DEFAULT 1,
    CONSTRAINT lineshop_clients_id_primary PRIMARY KEY (id),
    CONSTRAINT lineshop_clients_username_id UNIQUE (username)
);

CREATE TABLE IF NOT EXISTS admin.pharmacies
(
    id integer NOT NULL DEFAULT nextval('admin.pharmacies_id_seq'::regclass),
    name character varying COLLATE pg_catalog."default",
    ownership character varying COLLATE pg_catalog."default",
    account_number character varying COLLATE pg_catalog."default",
    created_at timestamp without time zone DEFAULT now(),
    updated_at timestamp without time zone,
    ward_id integer,
    status integer,
    registered character varying COLLATE pg_catalog."default",
    ward character varying COLLATE pg_catalog."default",
    region character varying COLLATE pg_catalog."default",
    district character varying COLLATE pg_catalog."default"
);


CREATE TABLE IF NOT EXISTS admin.lineshop_contracts_types
(
    id integer NOT NULL DEFAULT nextval('admin.lineshop_contracts_types_id_seq'::regclass),
    name character varying COLLATE pg_catalog."default",
    note text COLLATE pg_catalog."default",
    created_at timestamp without time zone DEFAULT now(),
    updated_at timestamp without time zone
);

CREATE TABLE IF NOT EXISTS admin.lineshop_contacts
(
    id integer NOT NULL DEFAULT nextval('admin.lineshop_contact_id_seq'::regclass),
    name character varying COLLATE pg_catalog."default",
    email character varying COLLATE pg_catalog."default",
    phone character varying COLLATE pg_catalog."default",
    pharmacy_id integer,
    created_at timestamp without time zone DEFAULT now(),
    updated_at timestamp without time zone,
    user_id integer,
    title character varying COLLATE pg_catalog."default"
);


CREATE TABLE IF NOT EXISTS admin.lineshop_events
(
    id integer NOT NULL DEFAULT nextval('admin.lineshop_events_id_seq'::regclass),
    title character varying COLLATE pg_catalog."default",
    note text COLLATE pg_catalog."default",
    attach text COLLATE pg_catalog."default",
    event_date date NOT NULL,
    start_time character varying COLLATE pg_catalog."default",
    end_time character varying COLLATE pg_catalog."default",
    status integer DEFAULT 0,
    user_id integer,
    created_at timestamp without time zone DEFAULT now(),
    updated_at timestamp without time zone,
    department_id integer,
    image text COLLATE pg_catalog."default",
    category character varying COLLATE pg_catalog."default" DEFAULT 'event'::character varying,
    file_id integer,
    attach_id integer,
    meeting_link character varying COLLATE pg_catalog."default",
    CONSTRAINT lineshop_events_pkey PRIMARY KEY (id)
);


CREATE TABLE IF NOT EXISTS admin.lineshop_event_attendees
(
    id integer NOT NULL DEFAULT nextval('admin.lineshop_event_attendees_id_seq'::regclass),
    name character varying COLLATE pg_catalog."default",
    phone character varying COLLATE pg_catalog."default",
    email character varying COLLATE pg_catalog."default",
    "position" character varying COLLATE pg_catalog."default",
    pharmacy_id integer,
    event_id integer,
    created_at timestamp without time zone DEFAULT now(),
    updated_at timestamp without time zone,
    source character varying COLLATE pg_catalog."default",
    status smallint DEFAULT 1
);
