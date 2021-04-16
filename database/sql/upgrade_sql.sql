--Show all:

SELECT oid::regclass::text
FROM   pg_class
WHERE  relkind = 'm';

-- Names are automatically double-quoted and schema-qualified where needed according to your current search_path in the cast from regclass to text.
-- In the system catalog pg_class materialized views are tagged with relkind = 'm'.

-- m = materialized view
-- To drop all, you can generate the needed SQL script with this query:

SELECT 'DROP MATERIALIZED VIEW ' || string_agg(oid::regclass::text, ', ') 
FROM   pg_class WHERE  relkind = 'm';


CREATE TABLE admin.standing_orders
(
    id serial NOT NULL,
    client_id integer NOT NULL,
    branch_id integer NOT NULL,
    company_file_id integer NOT NULL,
    school_contact_id integer NOT NULL,
    user_id integer NOT NULL,
    occurrence integer,
    basis character(255) COLLATE pg_catalog."default",
    total_amount double precision,
    occurance_amount double precision,
    date date,
    status integer DEFAULT 0,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    CONSTRAINT standing_order_id_primary PRIMARY KEY (id),
    CONSTRAINT standing_orders_client_id_foreign FOREIGN KEY (client_id)
        REFERENCES admin.clients (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT standing_orders_company_file_id_foreign FOREIGN KEY (company_file_id)
        REFERENCES admin.company_files (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT standing_orders_user_id_foreign FOREIGN KEY (user_id)
        REFERENCES admin.users (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)

TABLESPACE pg_default;

ALTER TABLE admin.standing_orders
    OWNER to postgres;
-- Index: fki_standing_orders_client_id_foreign

-- DROP INDEX admin.fki_standing_orders_client_id_foreign;

CREATE INDEX fki_standing_orders_client_id_foreign
    ON admin.standing_orders USING btree
    (client_id ASC NULLS LAST)
    TABLESPACE pg_default;
-- Index: fki_standing_orders_company_file_id_foreign

-- DROP INDEX admin.fki_standing_orders_company_file_id_foreign;

CREATE INDEX fki_standing_orders_company_file_id_foreign
    ON admin.standing_orders USING btree
    (company_file_id ASC NULLS LAST)
    TABLESPACE pg_default;
-- Index: fki_standing_orders_user_id_foreign

-- DROP INDEX admin.fki_standing_orders_user_id_foreign;

CREATE INDEX fki_standing_orders_user_id_foreign
    ON admin.standing_orders USING btree
    (user_id ASC NULLS LAST)
    TABLESPACE pg_default;


ALTER TABLE admin.allowances
    ALTER COLUMN amount SET NOT NULL;

ALTER TABLE admin.absents
    RENAME CONSTRAINT absent_absent_reason_id_foreign TO absents_absent_reason_id_foreign;

ALTER TABLE admin.absents
    RENAME CONSTRAINT absent_user_id_foreign TO absents_user_id_foreign;

ALTER TABLE admin.absents
    RENAME CONSTRAINT absent_id_primary TO absents_id_primary;

ALTER TABLE admin.absents
    RENAME CONSTRAINT absents_company_file_id_foreign TO absents_company_file_id_foreign;

ALTER TABLE admin.allowances
    ADD CONSTRAINT allowances_percent_check CHECK (percent >= 0 AND percent <= 100)
     VALID;

ALTER TABLE admin.absents
    RENAME CONSTRAINT absent_approved_by_foreign TO absents_approved_by_foreign;

ALTER TABLE admin.attendances
    RENAME CONSTRAINT attendance_approved_by_id TO attendances_approved_by_foreign;

ALTER TABLE admin.attendances
    RENAME CONSTRAINT attendance_user_id TO attendances_user_id_foreign;

ALTER TABLE admin.bank_accounts
    ADD CONSTRAINT bank_accounts_account_name_unique UNIQUE (account_name);

ALTER TABLE admin.bank_accounts_integrations
    RENAME CONSTRAINT bank_accounts_integration_bank_id_foreign TO bank_accounts_integrations_bank_account_id_foreign;

ALTER TABLE admin.bank_accounts_integrations
    ADD CONSTRAINT bank_accounts_integrations_refer_currency_id_foreign FOREIGN KEY (refer_currency_id)
    REFERENCES constant.refer_currencies (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
    NOT VALID;
CREATE INDEX fki_bank_accounts_integrations_refer_currency_id_foreign
    ON admin.bank_accounts_integrations(refer_currency_id);

ALTER TABLE admin.bank_accounts_integrations
    ADD CONSTRAINT bank_accounts_integrations_refer_bank_id_foreign FOREIGN KEY (refer_bank_id)
    REFERENCES constant.refer_banks (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
    NOT VALID;
CREATE INDEX fki_bank_accounts_integrations_refer_bank_id_foreign
    ON admin.bank_accounts_integrations(refer_bank_id);

ALTER TABLE admin.bank_accounts_integrations
    ADD CONSTRAINT bank_accounts_integrations_integration_request_id_foreign FOREIGN KEY (integration_request_id)
    REFERENCES admin.integration_requests (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
    NOT VALID;
CREATE INDEX fki_bank_accounts_integrations_integration_request_id_foreign
    ON admin.bank_accounts_integrations(integration_request_id);

ALTER TABLE admin.bank_accounts_integrations
    ADD CONSTRAINT bank_accounts_integrations_client_id_foreign FOREIGN KEY (client_id)
    REFERENCES admin.clients (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
    NOT VALID;
    
CREATE INDEX fki_bank_accounts_integrations_client_id_foreign
    ON admin.bank_accounts_integrations(client_id);

ALTER TABLE admin.budget_ratios
    RENAME CONSTRAINT budget_rations_project_id_foreign TO budget_ratios_project_id_foreign;

ALTER TABLE admin.budget_ratios
    RENAME CONSTRAINT budget_ratios_pkey TO budget_ratios_id_primary;


ALTER TABLE admin.calls
    ADD CONSTRAINT calls_created_by_foreign FOREIGN KEY (created_by)
    REFERENCES admin.users (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE;
CREATE INDEX fki_calls_created_by_foreign
    ON admin.calls(created_by);


ALTER TABLE admin.chat_users
    ADD CONSTRAINT chat_users_message_id_foreign FOREIGN KEY (message_id)
    REFERENCES public.message ("messageID")
    ON UPDATE CASCADE
    ON DELETE CASCADE;


ALTER TABLE admin.chat_users
    RENAME CONSTRAINT chat_users_id_foreign TO chat_users_user_id_foreign;

ALTER TABLE admin.chat_users
    RENAME message_id TO chat_id;

ALTER TABLE admin.chat_users
    RENAME CONSTRAINT chats_foreign TO chat_users_chat_id_foreign;

ALTER TABLE admin.chat_users
    ADD CONSTRAINT chat_users_to_user_id_foreign FOREIGN KEY (to_user_id)
    REFERENCES admin.users (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_chat_users_to_user_id_foreign
    ON admin.chat_users(to_user_id);


ALTER TABLE admin.client_schools
    RENAME CONSTRAINT pk_school_client_id TO client_schools_id_primary;


ALTER TABLE admin.client_schools
    ADD CONSTRAINT client_schools_school_id_foreign FOREIGN KEY (school_id)
    REFERENCES admin.schools (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_client_schools_school_id_foreign
    ON admin.client_schools(school_id);


ALTER TABLE admin.client_schools
    ADD CONSTRAINT client_schools_client_id_foreign FOREIGN KEY (client_id)
    REFERENCES admin.clients (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_client_schools_client_id_foreign
    ON admin.client_schools(client_id);


ALTER TABLE admin.contracts
    ADD CONSTRAINT contracts_dates_check CHECK (start_date < end_date);


ALTER TABLE admin.deductions
    ADD CONSTRAINT deductions_percent_check CHECK (percent >= 0 AND percent <=100);

ALTER TABLE admin.departments
    RENAME CONSTRAINT departments_pkey TO departments_id_primary;


ALTER TABLE admin.designs
    RENAME CONSTRAINT designs_pkey TO designs_id_primary;

ALTER TABLE admin.designs
    ADD CONSTRAINT designs_user_id_foreign FOREIGN KEY (user_id)
    REFERENCES admin.users (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_designs_user_id_foreign
    ON admin.designs(user_id);

ALTER TABLE admin.event_attendees
    RENAME CONSTRAINT event_attendee_id_primary TO event_attendees_id_primary;


ALTER TABLE admin.events
    RENAME CONSTRAINT events_pkey TO events_id_primary;

ALTER TABLE admin.events
    ADD CONSTRAINT events_time_check CHECK (start_time < end_time);

ALTER TABLE admin.events
    ADD CONSTRAINT events_user_id_foreign FOREIGN KEY (user_id)
    REFERENCES admin.users (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_events_user_id_foreign
    ON admin.events(user_id);


ALTER TABLE admin.events
    ADD CONSTRAINT events_department_id_foreign FOREIGN KEY (department_id)
    REFERENCES admin.departments (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_events_department_id_foreign
    ON admin.events(department_id);

ALTER TABLE admin.expense
    RENAME TO expenses;

ALTER TABLE admin.expense
    RENAME CONSTRAINT expense_refer_expense_fkey TO expenses_refer_expense_foreign;


ALTER TABLE admin.expenses
    RENAME CONSTRAINT expense_user_id TO expenses_user_id_foreign;

ALTER TABLE admin.expenses
    RENAME CONSTRAINT expense_transaction_id_unique TO expenses_transaction_id_unique;


ALTER TABLE admin.expenses
    RENAME CONSTRAINT expense_id_primary TO expenses_id_primary;


ALTER TABLE admin.expenses
    RENAME CONSTRAINT expenses_bank_account_id_foreign TO expenses_bank_account_id_foreign;

ALTER TABLE admin.expenses
    ADD CONSTRAINT expenses_payment_type_id_foreign FOREIGN KEY (payment_type_id)
    REFERENCES admin.payment_types (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;

ALTER TABLE admin.failed_jobs
    RENAME CONSTRAINT failed_jobs_pkey TO failed_jobs_id_primary;

ALTER TABLE admin.faq
    ADD CONSTRAINT faq_created_by_foreign FOREIGN KEY (created_by)
    REFERENCES admin.users (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_faq_created_by_foreign
    ON admin.faq(created_by);

ALTER TABLE admin.integration_request_comments
    RENAME CONSTRAINT integration_request_comment_pkey TO integration_request_comment_id_primary;


ALTER TABLE admin.integration_request_comments
    RENAME CONSTRAINT integration_comment_requests_id TO integration_requests_comments_integration_request_id;


ALTER TABLE admin.integration_request_comments
    ADD CONSTRAINT integration_request_comments_user_id_foreign FOREIGN KEY (user_id)
    REFERENCES admin.users (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_integration_request_comments_user_id_foreign
    ON admin.integration_request_comments(user_id);


ALTER TABLE admin.integration_requests
    RENAME CONSTRAINT integration_requests_pkey TO integration_requests_id_primary;

ALTER TABLE admin.integration_requests
    ADD CONSTRAINT integration_requests_bank_account_id_foreign FOREIGN KEY (bank_account_id)
    REFERENCES admin.bank_accounts (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;


ALTER TABLE admin.integration_requests
    ADD CONSTRAINT integration_request_user_id_foreign FOREIGN KEY (user_id)
    REFERENCES admin.users (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_integration_request_user_id_foreign
    ON admin.integration_requests(user_id);


ALTER TABLE admin.integration_requests
    ADD CONSTRAINT integration_requests_bank_accounts_integration_id_foreign FOREIGN KEY (bank_accounts_integration_id)
    REFERENCES admin.bank_accounts_integrations (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_integration_requests_bank_accounts_integration_id_foreign
    ON admin.integration_requests(bank_accounts_integration_id);


ALTER TABLE admin.integration_requests
    RENAME CONSTRAINT integration_request_user_id_foreign TO integration_requests_user_id_foreign;


ALTER TABLE admin.integration_requests
    ADD CONSTRAINT integration_request_approval_user_id_foreign FOREIGN KEY (approval_user_id)
    REFERENCES admin.users (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_integration_request_approval_user_id_foreign
    ON admin.integration_requests(approval_user_id);


ALTER TABLE admin.integration_requests_documents
    RENAME CONSTRAINT integration_requests_documents_pkey TO integration_requests_documents_id_primary;

ALTER TABLE admin.integration_requests_documents
    RENAME CONSTRAINT integration_document_requests_id TO integration_requests_documents_integration_request_id_foreign;


ALTER TABLE admin.integration_requests_documents
    RENAME CONSTRAINT integration_request_document_id TO integration_requests_documents_integration_bank_document_t_id_foreign;

ALTER TABLE admin.integration_requests_documents
    ADD CONSTRAINT integration_requests_documents_company_file_id_foreign FOREIGN KEY (company_file_id)
    REFERENCES admin.company_files (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_integration_requests_documents_company_file_id_foreign
    ON admin.integration_requests_documents(company_file_id);

ALTER TABLE admin.invoice_fees
    RENAME CONSTRAINT invoice_fee_invoice_id_foreign TO invoice_fees_invoice_id_foreign;


ALTER TABLE admin.invoice_fees
    RENAME CONSTRAINT invoice_fees_pkey TO invoice_fees_id_primary;

ALTER TABLE admin.invoice_fees_payments
    RENAME CONSTRAINT invoice_fees_payments_invoice_id_foreign TO invoice_fees_payments_invoice_fee_id_foreign;


ALTER TABLE admin.invoices
    ADD CONSTRAINT invoices_account_year_id_foreign FOREIGN KEY (account_year_id)
    REFERENCES admin.account_years (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_invoices_account_year_id_foreign
    ON admin.invoices(account_year_id);


ALTER TABLE admin.invoices_sent
    RENAME CONSTRAINT invoices_sent_pkey TO invoices_sent_id_primary;


ALTER TABLE admin.invoices_sent
    RENAME CONSTRAINT invoices_sent_id_foreign TO invoices_sent_user_id_foreign;

ALTER TABLE admin.jobs
    RENAME CONSTRAINT jobs_pkey TO jobs_id_primary;


ALTER TABLE admin.leads
    ADD CONSTRAINT leads_school_id_foreign FOREIGN KEY (school_id)
    REFERENCES admin.users (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_leads_school_id_foreign
    ON admin.leads(school_id);



ALTER TABLE admin.leads
    ADD CONSTRAINT leads_school_id_foreign FOREIGN KEY (school_id)
    REFERENCES admin.schools (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;


ALTER TABLE admin.leads
    ADD CONSTRAINT leads_user_id_foreign FOREIGN KEY (user_id)
    REFERENCES admin.users (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_leads_user_id_foreign
    ON admin.leads(user_id);


ALTER TABLE admin.leads
    ADD CONSTRAINT leads_prospect_id_foreign FOREIGN KEY (prospect_id)
    REFERENCES admin.prospects (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_leads_prospect_id_foreign
    ON admin.leads(prospect_id);


ALTER TABLE admin.leads
    ADD CONSTRAINT leads_task_id FOREIGN KEY (task_id)
    REFERENCES admin.tasks (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_leads_task_id
    ON admin.leads(task_id);


ALTER TABLE admin.locations
    RENAME CONSTRAINT locations_pkey TO locations_id_primary;


ALTER TABLE admin.marks
    RENAME CONSTRAINT marks_subject_id TO marks_subject_id_foreign;


ALTER TABLE admin.marks
    RENAME CONSTRAINT name_global_exam_id_class_id_subject_id TO name_global_exam_id_class_id_subject_id_unique;

ALTER TABLE admin.mediapost
    RENAME CONSTRAINT mediapost_pkey TO mediapost_id_primary;

ALTER TABLE admin.mediapost
    ADD CONSTRAINT mediapost_user_id_foreign FOREIGN KEY (user_id)
    REFERENCES admin.users (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_mediapost_user_id_foreign
    ON admin.mediapost(user_id);


ALTER TABLE admin.meeting_minutes
    RENAME CONSTRAINT meeting_minutes_pkey TO meeting_minutes_id_primary;

ALTER TABLE admin.meeting_minutes
    RENAME CONSTRAINT departments_foreign TO meeting_minutes_department_id_foreign;

ALTER TABLE admin.meeting_minutes
    ADD CONSTRAINT meeting_minutes_time_check CHECK (start_time < end_time);

ALTER TABLE admin.migrations
    RENAME CONSTRAINT migrations_pkey TO migrations_id_primary;

ALTER TABLE admin.minute_users
    RENAME CONSTRAINT minute_user_foreign TO minute_user_minute_id_foreign;

ALTER TABLE admin.minute_users
    RENAME CONSTRAINT minute_id_primary TO minute_users_id_primary;

ALTER TABLE admin.minute_users
    RENAME CONSTRAINT user_minute_foreign_id TO minute_users_user_id_foreign;

ALTER TABLE admin.module_tasks
    RENAME CONSTRAINT module_task_foreign TO module_task_module_id_foreign;

ALTER TABLE admin.module_tasks
    RENAME CONSTRAINT task_module_foreign_id TO module_tasks_task_id_foreign;

ALTER TABLE admin.module_tasks
    RENAME CONSTRAINT module_task_module_id_foreign TO module_tasks_module_id_foreign;

ALTER TABLE admin.new_integration_requests
    RENAME CONSTRAINT new_integration_requests_pkey TO new_integration_requests_id_primary;

ALTER TABLE admin.new_integration_requests
    ADD CONSTRAINT new_integration_requests_client_id_foreign FOREIGN KEY (client_id)
    REFERENCES admin.clients (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_new_integration_requests_client_id_foreign
    ON admin.new_integration_requests(client_id);

ALTER TABLE admin.new_integration_requests
    ADD CONSTRAINT new_integration_requests_bank_id_foreign FOREIGN KEY (bank_id)
    REFERENCES admin.bank_accounts (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_new_integration_requests_bank_id_foreign
    ON admin.new_integration_requests(bank_id);

ALTER TABLE admin.new_integration_requests
    ADD CONSTRAINT new_integration_requests_user_id_foreign FOREIGN KEY (user_id)
    REFERENCES admin.users (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_new_integration_requests_user_id_foreign
    ON admin.new_integration_requests(user_id);

ALTER TABLE admin.nmb_schools
    RENAME CONSTRAINT nmb_schools_pkey TO nmb_schools_id_primary;

ALTER TABLE admin.page_tips
    RENAME CONSTRAINT page_tips_pkey TO page_tips_id_primary;

ALTER TABLE admin.partner_branches
    RENAME CONSTRAINT partner_branches_id_foreign TO partner_branches_partner_id_foreign;

ALTER TABLE admin.partner_schools
    RENAME CONSTRAINT partner_schools_id_foreign TO partner_schools_branch_id_foreign;

ALTER TABLE admin.partner_schools
    RENAME CONSTRAINT partner_schools_districs_id_foreign TO partner_schools_school_id_foreign;

ALTER TABLE admin.partner_users
    RENAME CONSTRAINT partner_branches_users_id_foreign TO partner_branches_branch_id_foreign;

ALTER TABLE admin.partner_users
    RENAME CONSTRAINT partner_users_id_foreign TO partner_users_user_id_foreign;

ALTER TABLE admin.partner_users
    RENAME CONSTRAINT partner_branches_branch_id_foreign TO partner_users_branch_id_foreign;

ALTER TABLE admin.payments
    RENAME CONSTRAINT payments_pkey TO payments_id_primary;

ALTER TABLE admin.payments
    ADD CONSTRAINT payments_bank_id_foreign FOREIGN KEY (bank_account_id)
    REFERENCES admin.bank_accounts (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_payments_bank_id_foreign
    ON admin.payments(bank_account_id);

ALTER TABLE admin.payments
    ADD CONSTRAINT payments_clients_id_foreign FOREIGN KEY (client_id)
    REFERENCES admin.clients (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_payments_clients_id_foreign
    ON admin.payments(client_id);

ALTER TABLE admin.payments_budget_ratios
    RENAME CONSTRAINT payments_budget_ratios_pkey TO payments_budget_ratios_id_primary;

ALTER TABLE admin.payments_budget_ratios
    RENAME CONSTRAINT payments_budget_rations_budget_ration_id_foreign TO payments_budget_ratios_budget_ratio_id_foreign;

ALTER TABLE admin.payments_budget_ratios
    VALIDATE CONSTRAINT payments_budget_ratios_budget_ratio_id_foreign;

ALTER TABLE admin.payments_budget_ratios
    RENAME CONSTRAINT payments_budget_rations_payment_id_foreign TO payments_budget_ratios_payment_id_foreign;

ALTER TABLE admin.permission_role
    RENAME CONSTRAINT permission_role_pkey TO permission_role_id_primary;

ALTER TABLE admin.permissions
    RENAME CONSTRAINT permissions_pkey TO permissions_id_primary;

ALTER TABLE admin.prospects
    ADD CONSTRAINT prospects_school_id_foreign FOREIGN KEY (school_id)
    REFERENCES admin.schools (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_prospects_school_id_foreign
    ON admin.prospects(school_id);

ALTER TABLE admin.prospects
    ADD CONSTRAINT prospects_task_id_foreign FOREIGN KEY (task_id)
    REFERENCES admin.tasks (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_prospects_task_id_foreign
    ON admin.prospects(task_id);

ALTER TABLE admin.prospects
    ADD CONSTRAINT prospects_user_id_foreign FOREIGN KEY (user_id)
    REFERENCES admin.users (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_prospects_user_id_foreign
    ON admin.prospects(user_id);

ALTER TABLE admin.request
    RENAME CONSTRAINT pk_request_id TO request_id_primary;

ALTER TABLE admin.requirements
    ADD CONSTRAINT requirements_school_id_foreign FOREIGN KEY (school_id)
    REFERENCES admin.schools (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_requirements_school_id_foreign
    ON admin.requirements(school_id);

ALTER TABLE admin.requirements
    ADD CONSTRAINT requirements_to_user_id_foreign FOREIGN KEY (to_user_id)
    REFERENCES admin.users (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_requirements_to_user_id_foreign
    ON admin.requirements(to_user_id);

ALTER TABLE admin.revenues
    RENAME CONSTRAINT revenues_pkey TO revenues_id_primary;

ALTER TABLE admin.revenues
    RENAME CONSTRAINT revenues__bank_account_id TO revenues_bank_account_id_foreign;

ALTER TABLE admin.revenues
    RENAME CONSTRAINT revenues_refer_expense_id TO revenues_refer_expense_id_foreign;

ALTER TABLE admin.salaries
    RENAME CONSTRAINT salaries_user_id TO salaries_user_id_foreign;

ALTER TABLE admin.salary_deductions
    RENAME CONSTRAINT salary_deductions_deduction_id TO salary_deductions_deduction_id_foreign;

ALTER TABLE admin.salary_deductions
    RENAME CONSTRAINT salary_deductions_salary_id TO salary_deductions_salary_id_foreign;

ALTER TABLE admin.salary_pensions
    RENAME CONSTRAINT salary_pensions_pkey TO salary_pensions_id_primary;

ALTER TABLE admin.salary_pensions
    RENAME CONSTRAINT fk_pension_id TO salary_pensions_pension_id_foreign;

ALTER TABLE admin.salary_pensions
    RENAME CONSTRAINT fk_salary_id TO salary_pensions_salary_id_foreign;

ALTER TABLE admin.school_associations
    RENAME CONSTRAINT school_association_association_id_foreign TO school_associations_association_id_foreign;

ALTER TABLE admin.school_levels
    RENAME CONSTRAINT school_levels_pkey TO school_levels_id_primary;


ALTER TABLE admin.school_levels
    ADD CONSTRAINT school_levels_client_id_foreign FOREIGN KEY (client_id)
    REFERENCES admin.clients (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;

ALTER TABLE admin.schools
    RENAME CONSTRAINT pk_school_id TO schools_id_foreign;

ALTER TABLE admin.schools
    ADD CONSTRAINT schools_ward_id_foreign FOREIGN KEY (ward_id)
    REFERENCES admin.wards (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_schools_ward_id_foreign
    ON admin.schools(ward_id);

ALTER TABLE admin.socialmedia
    RENAME CONSTRAINT socialmedia_pkey TO socialmedia_id_primary;

ALTER TABLE admin.socialmedia_post
    RENAME CONSTRAINT socialmedia_post_pkey TO socialmedia_post_id_primary;

ALTER TABLE admin.standing_orders
    ADD CONSTRAINT standing_order_id_primary PRIMARY KEY (id);

ALTER TABLE admin.standing_orders
    ADD CONSTRAINT standing_orders_client_id_foreign FOREIGN KEY (client_id)
    REFERENCES admin.clients (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_standing_orders_client_id_foreign
    ON admin.standing_orders(client_id);

ALTER TABLE admin.standing_orders
    ADD CONSTRAINT standing_orders_company_file_id_foreign FOREIGN KEY (company_file_id)
    REFERENCES admin.company_files (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_standing_orders_company_file_id_foreign
    ON admin.standing_orders(company_file_id);

ALTER TABLE admin.standing_orders
    ADD CONSTRAINT standing_orders_user_id_foreign FOREIGN KEY (user_id)
    REFERENCES admin.users (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_standing_orders_user_id_foreign
    ON admin.standing_orders(user_id);


ALTER TABLE admin.subjects
    ADD CONSTRAINT subjects_class_id_foreign FOREIGN KEY (class_id)
    REFERENCES public.classes ("classesID") MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;

ALTER TABLE admin.task_staffs
    ADD CONSTRAINT task_staffs_user_id_foreign FOREIGN KEY (user_id)
    REFERENCES admin.users (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_task_staffs_user_id_foreign
    ON admin.task_staffs(user_id);

ALTER TABLE admin.task_staffs
    ADD CONSTRAINT task_staff_time_check CHECK (start_time < end_time);

ALTER TABLE admin.tasks
    ADD CONSTRAINT tasks_school_id_foreign FOREIGN KEY (school_id)
    REFERENCES admin.schools (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_tasks_school_id_foreign
    ON admin.tasks(school_id);

ALTER TABLE admin.telegram_users
    ADD CONSTRAINT telegram_users_user_id_foreign FOREIGN KEY (user_id)
    REFERENCES admin.users (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_telegram_users_user_id_foreign
    ON admin.telegram_users(user_id);


ALTER TABLE admin.train_items
    ADD CONSTRAINT train_items_training_id_foreign FOREIGN KEY (training_id)
    REFERENCES admin.trainings (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_train_items_training_id_foreign
    ON admin.train_items(training_id);

ALTER TABLE admin.training_checklist
    RENAME CONSTRAINT training_checklist_created_by_id_foreign TO training_checklist_created_by_foreign;

ALTER TABLE admin.training_checklist
    RENAME CONSTRAINT training_section_id_foreign TO training_checklist_training_section_id_foreign;

ALTER TABLE admin.training_modules
    RENAME CONSTRAINT training_modules_created_by_id_foreign TO training_modules_created_by_foreign;

ALTER TABLE admin.updates
    RENAME CONSTRAINT updates_pkey TO updates_id_primary;

ALTER TABLE admin.user_allowances
    RENAME CONSTRAINT user_allowances_pkey TO user_allowances_id_primary;

ALTER TABLE admin.user_allowances
    RENAME CONSTRAINT user_allowances_allowance_id TO user_allowances_allowance_id_foreign;

ALTER TABLE admin.user_allowances
    RENAME CONSTRAINT user_allowances_user_id TO user_allowances_user_id_foreign;

ALTER TABLE admin.user_deductions
    RENAME CONSTRAINT user_deductions_deduction_id TO user_deductions_deduction_id_foreign;

ALTER TABLE admin.user_deductions
    RENAME CONSTRAINT user_deductions_pkey TO user_deductions_id_primary;

ALTER TABLE admin.user_deductions
    RENAME CONSTRAINT user_deductions_user_id TO user_deductions_user_id_foreign;

ALTER TABLE admin.user_pensions
    RENAME CONSTRAINT user_pensions_pension_id TO user_pensions_pension_id_foreign;

ALTER TABLE admin.user_pensions
    RENAME CONSTRAINT user_pensions_user_id TO user_pensions_user_id_foreign;

ALTER TABLE admin.users
    ADD CONSTRAINT users_role_id_foreign FOREIGN KEY (role_id)
    REFERENCES admin.roles (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_users_role_id_foreign
    ON admin.users(role_id);

ALTER TABLE admin.vendors
    ADD CONSTRAINT vendors_id_primary PRIMARY KEY (id);

ALTER TABLE admin.vendors
    ADD CONSTRAINT vendors_country_id_foreign FOREIGN KEY (country_id)
    REFERENCES constant.refer_countries (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_vendors_country_id_foreign
    ON admin.vendors(country_id);

ALTER TABLE admin.vendors
    ADD CONSTRAINT vendors_bank_id_foreign FOREIGN KEY (bank_id)
    REFERENCES admin.bank_accounts (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_vendors_bank_id_foreign
    ON admin.vendors(bank_id);

ALTER TABLE admin.website_demo_requests
    ADD CONSTRAINT website_demo_requests_school_id_foreign FOREIGN KEY (school_id)
    REFERENCES admin.schools (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_website_demo_requests_school_id_foreign
    ON admin.website_demo_requests(school_id);






////////////////////////////////////////
//New

*.
ALTER TABLE admin.user_deductions
    ADD CONSTRAINT user_deductions_loan_application_id_foreign FOREIGN KEY (loan_application_id)
    REFERENCES admin.loan_applications (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_user_deductions_loan_application_id_foreign
    ON admin.user_deductions(loan_application_id);


ALTER TABLE admin.revenues
    ADD COLUMN loan_application_id integer;
    

ALTER TABLE admin.revenues
    ADD CONSTRAINT revenues_loan_application_id_foreign FOREIGN KEY (loan_application_id)
    REFERENCES admin.loan_applications (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
CREATE INDEX fki_revenues_loan_application_id_foreign
    ON admin.revenues(loan_application_id);

ALTER TABLE admin.clients
    ADD COLUMN invoice_start_date date;

ALTER TABLE admin.clients
    ADD COLUMN invoice_end_date date;

ALTER TABLE admin.invoices_sent
    ADD COLUMN message text;

ALTER TABLE admin.phone_number
    ADD COLUMN message text;

-- receipt_settings
-- product_cart
-- setting






--09/04/2021
-- (select * from admin.allschools where id not in (
--  select a.id from admin.allschools a join admin.schools b on b.name=a.school_name AND b.ward=a.ward
-- ))


-- ALTER TABLE admin.schools
--     ADD COLUMN region character varying COLLATE pg_catalog."default";

-- ALTER TABLE admin.schools
--     ADD COLUMN district character varying COLLATE pg_catalog."default";

-- ALTER TABLE admin.schools
--     ADD COLUMN ward character varying COLLATE pg_catalog."default";


-- 11/04/2021

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