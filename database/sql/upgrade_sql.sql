
--09/04/2021
-- (select * from admin.allschools where id not in (
--  select a.id from admin.allschools a join admin.schools b on b.name=a.school_name AND b.ward=a.ward
-- ))



ALTER TABLE admin.absents
    ADD COLUMN end_date timestamp without time zone;


 -- 12/04/2021
 ALTER TABLE admin.users
    ADD COLUMN bank_name character varying;
-- select count(X.*) from (select b.*,w.name as ward, d.name as district,r.name as region from (select a.*, (select count(*) from admin.tasks where school_id=a.id) 
-- 		as activities from admin.schools a  where lower(a.ownership) <>'government') as b join 
-- 		admin.wards as w on b.ward_id = w.id join admin.districts as d on d.id=w.district_id
-- 		join admin.regions as r on r.id=d.region_id) X


ALTER TABLE admin.absents
    ADD COLUMN status character varying;


--  select C.*,D.username from 
--  (select A.*,B.* from (
--  select b.*,w.name as ward, d.name as district,r.name as region from (select a.*, (select count(*) from admin.tasks where school_id=a.id) 
--  as activities from admin.schools a  where lower(a.ownership) <>'government') as b join 
--  admin.wards as w on b.ward_id = w.id join admin.districts as d on d.id=w.district_id
--  join admin.regions as r on r.id=d.region_id) A
--  LEFT JOIN (select school_id,client_id from admin.client_schools) B
-- on A.id = B.school_id) C  left  join (select id,username from admin.clients) D on C.client_id = D.id 



ALTER TABLE admin.tasks
    ADD COLUMN ticket_no bigint;

ALTER TABLE admin.tasks
    ADD CONSTRAINT task_ticket_no_unique UNIQUE (ticket_no);

-- 09/05/2021
ALTER TABLE admin.recruiments
    ADD COLUMN company_file_id integer;


ALTER TABLE admin.recruiments
    ADD CONSTRAINT recruiments_company_file_id_foreign FOREIGN KEY (company_file_id)
    REFERENCES admin.company_files (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
    NOT VALID;
CREATE INDEX fki_recruiments_company_file_id_foreign
    ON admin.recruiments(company_file_id);


ALTER TABLE admin.recruiments
    ADD CONSTRAINT recruiments_country_id_foreign FOREIGN KEY (country)
    REFERENCES constant.refer_countries (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE;
CREATE INDEX fki_recruiments_country_id_foreign
    ON admin.recruiments(country);

ALTER TABLE admin.recruiments
    ADD COLUMN country integer;



-- 11/05/2021
ALTER TABLE admin.recruiment_answers
    ADD COLUMN answer integer;

ALTER TABLE admin.recruiments
    ADD COLUMN score bigint;

ALTER TABLE admin.recruiments
    ADD COLUMN status smallint;


    -- 13/05/2021
    CREATE TABLE admin."sheetTest"
(
    id serial,
    "Timestamp" timestamp without time zone,
    "Name" character varying,
    "Email" character varying,
    "Address" character varying,
    "Phone number" character varying,
    "Comments" character varying,
    PRIMARY KEY (id)
);

ALTER TABLE admin."sheetTest"
    OWNER to postgres;




    -- 18/05/2021

    select count (DISTINCT school_id) from admin.tasks

    select * from admin.all_exam_report


    select * from admin.join_all('tmember','student_id,transport_route_id,tjoindate,
							 vehicle_id,is_oneway');

   select count (distinct schema_name) from admin.all_tmembers


--  26/05/2021
 Job-card

 client_job_cards


ALTER TABLE admin.clients
    ADD COLUMN start_usage_date date;


-- 08/06/2021


CREATE TABLE constant.refer_company_designations
(
    id serial,
    name character varying,
    abbreviation character varying,
    created_at time without time zone,
    updated_at timestamp without time zone,
    PRIMARY KEY (id)
);

ALTER TABLE constant.refer_company_designations
    OWNER to postgres;


CREATE TABLE admin.user_designation
(
    id serial,
    user_id integer,
    designation_id integer,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    PRIMARY KEY (id)
);

ALTER TABLE admin.user_designation
    OWNER to postgres;


ALTER TABLE admin.user_designation
    RENAME CONSTRAINT user_designation_pkey TO user_designation_id_primary;


ALTER TABLE admin.user_designation
    ADD CONSTRAINT user_designation_designation_id_foreign FOREIGN KEY (designation_id)
    REFERENCES constant.refer_company_designations (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE;
CREATE INDEX fki_user_designation_designation_id_foreign
    ON admin.user_designation(designation_id);


ALTER TABLE admin.user_designation
    ADD CONSTRAINT user_designation_user_id_foreign FOREIGN KEY (user_id)
    REFERENCES admin.users (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE;
CREATE INDEX fki_user_designation_user_id_foreign
    ON admin.user_designation(user_id);

 