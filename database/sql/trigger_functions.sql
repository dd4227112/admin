CREATE OR REPLACE FUNCTION activetots.create_invoice_prefix()
    RETURNS trigger
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE NOT LEAKPROOF
AS $BODY$
 BEGIN INSERT INTO invoice_prefix (invoice_id, reference, bank_accounts_integration_id) SELECT a.id, c.invoice_prefix||a.student_id||a.academic_year_id, c.id FROM invoices a, bank_accounts_integrations c where a.id=NEW.id; RETURN NEW; END; 
$BODY$;

ALTER FUNCTION activetots.create_invoice_prefix()
    OWNER TO postgres;


CREATE OR REPLACE FUNCTION activetots.create_revenue_reference()
    RETURNS trigger
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE NOT LEAKPROOF
AS $BODY$
 BEGIN UPDATE activetots.revenues a SET status=0, reference=b.reference FROM (SELECT a.invoice_prefix||NEW.id||'0R' as reference, NEW.id FROM activetots.bank_accounts_integrations a, activetots.bank_accounts c where c.refer_bank_id=22 AND c.id=a.bank_account_id limit 1) AS subquery where subquery.id=a.id; RETURN NEW; END; 
$BODY$;

ALTER FUNCTION activetots.create_revenue_reference()
    OWNER TO postgres;


CREATE OR REPLACE FUNCTION activetots.function_create_receipt_code()
    RETURNS trigger
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE NOT LEAKPROOF
AS $BODY$
 BEGIN new.receipt_code := 'SS-'||extract(doy from CURRENT_DATE)||''||EXTRACT(month FROM CURRENT_DATE)||'-'||date_part('year', CURRENT_DATE)||'-'||(SELECT last_value FROM payments_id_seq); RETURN new; END; 
$BODY$;

ALTER FUNCTION activetots.function_create_receipt_code()
    OWNER TO postgres;


CREATE OR REPLACE FUNCTION activetots.function_create_reference_number()
    RETURNS trigger
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE NOT LEAKPROOF
AS $BODY$
 BEGIN new.reference := (select case when institution_code is null then number else institution_code end from setting)||new.reference; RETURN new; END; 
$BODY$;

ALTER FUNCTION activetots.function_create_reference_number()
    OWNER TO postgres;

CREATE OR REPLACE FUNCTION activetots.function_unique_schema_number()
    RETURNS trigger
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE NOT LEAKPROOF
AS $BODY$
 BEGIN new.number := 'SS'||new.number; RETURN new; END; 
$BODY$;

ALTER FUNCTION activetots.function_unique_schema_number()
    OWNER TO postgres;

CREATE OR REPLACE FUNCTION activetots.function_update_fee_percent()
    RETURNS trigger
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE NOT LEAKPROOF
AS $BODY$
 BEGIN new.fee_percent := (new.amount/nullif(new.total_amount,0))*100; RETURN new; END; 
$BODY$;

ALTER FUNCTION activetots.function_update_fee_percent()
    OWNER TO postgres;

CREATE TRIGGER triggerinsert
    BEFORE INSERT
    ON alpha.payments
    FOR EACH ROW
    EXECUTE FUNCTION alpha.function_create_receipt_code();