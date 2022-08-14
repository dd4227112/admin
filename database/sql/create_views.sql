-- View: canossa.users

-- DROP VIEW canossa.users;

CREATE OR REPLACE VIEW canossa.users
 AS
 SELECT a."userID" AS id,
    a.email,
    a.phone,
    a.remember_token,
    a.username,
    a.usertype,
    a.password,
    'user'::character varying AS "table",
    a.name,
    a.role_id,
    a.status,
    a.photo,
    a.payroll_status,
    a.created_at,
    a.updated_at,
    a.sid,
    a.default_password,
    a.dob,
    a.sex,
    a.country_id
   FROM canossa."user" a
UNION ALL
 SELECT t."teacherID" AS id,
    t.email,
    t.phone,
    t.remember_token,
    t.username,
    t.usertype,
    t.password,
    'teacher'::character varying AS "table",
    t.name,
    t.role_id,
    t.status,
    t.photo,
    t.payroll_status,
    t.created_at,
    t.updated_at,
    t.sid,
    t.default_password,
    t.dob,
    t.sex,
    t.country_id
   FROM canossa.teacher t
UNION ALL
 SELECT s.student_id AS id,
    s.email,
    s.phone,
    s.remember_token,
    s.username,
    'Student'::character varying AS usertype,
    s.password,
    'student'::character varying AS "table",
    s.name,
    ( SELECT role.id
           FROM canossa.role
          WHERE lower(role.name::text) = 'student'::text) AS role_id,
    s.status,
    s.photo,
    s.payroll_status,
    s.created_at,
    s.updated_at,
    s.sid,
    'abc123456'::character varying AS default_password,
    s.dob,
    s.sex,
    s.country_id
   FROM canossa.student s
UNION ALL
 SELECT p."parentID" AS id,
    p.email,
    p.phone,
    p.remember_token,
    p.username,
    'Parent'::character varying AS usertype,
    p.password,
    'parent'::character varying AS "table",
    p.name,
    ( SELECT role.id
           FROM canossa.role
          WHERE lower(role.name::text) = 'parent'::text) AS role_id,
    p.status,
    p.photo,
    p.payroll_status,
    p.created_at,
    p.updated_at,
    p.sid,
    p.default_password,
    p.dob,
    p.sex,
    p.country_id
   FROM canossa.parent p
UNION ALL
 SELECT b."settingID" AS id,
    b.email,
    b.phone,
    b.remember_token,
    b.username,
    'Admin'::character varying AS usertype,
    b.password,
    'setting'::character varying AS "table",
    b.name,
    ( SELECT role.id
           FROM canossa.role
          WHERE lower(role.name::text) = 'admin'::text) AS role_id,
    1 AS status,
    b.photo,
    b.payroll_status,
    b.created_at,
    b.updated_at,
    b.sid,
    b.default_password,
    CURRENT_DATE AS dob,
    'Male'::character varying AS sex,
    b.country_id
   FROM canossa.setting b;

ALTER TABLE canossa.users
    OWNER TO postgres;

CREATE OR REPLACE VIEW canossa.wallet_usage
 AS
 SELECT sum(COALESCE(wallets.amount, 0::numeric::double precision))::numeric AS amount,
    wallets.student_id,
    0 AS used_amount
   FROM canossa.wallets
  GROUP BY wallets.student_id
UNION ALL
 SELECT 0 AS amount,
    wallet_uses.user_id AS student_id,
    sum(COALESCE(wallet_uses.amount, 0::numeric)) AS used_amount
   FROM canossa.wallet_uses
  WHERE wallet_uses.user_table::text = 'student'::text
  GROUP BY wallet_uses.user_id;

ALTER TABLE canossa.wallet_usage
    OWNER TO postgres;


CREATE OR REPLACE VIEW canossa.total_mark
 AS
 SELECT sum(mark.mark) AS total,
    mark.student_id,
    mark."examID",
    mark.year,
    mark."classesID"
   FROM canossa.mark
  GROUP BY mark.student_id, mark."examID", mark."classesID", mark.year;

ALTER TABLE canossa.total_mark
    OWNER TO postgres;

CREATE OR REPLACE VIEW canossa.total_revenues
 AS
 SELECT a.id,
    a.amount,
    a.created_at,
    a.date,
    a.payment_method,
    a.transaction_id,
    a.is_payment,
    a.bank_account_id,
    a.user_id,
    a.user_table,
    a.payer_name,
    a.note,
    a.payment_type_id,
    a.reconciled,
    b.name AS bank_name,
    b.number AS account_number,
    b.currency,
    b.name AS account_name
   FROM ( SELECT revenues.id,
            revenues.amount,
            revenues.created_at,
            revenues.date,
            revenues.payment_method,
            revenues.transaction_id,
            0 AS is_payment,
            revenues.bank_account_id,
            revenues.user_id,
            revenues.payment_type_id,
            revenues.user_table,
            revenues.payer_name,
            revenues.note,
            revenues.reconciled
           FROM canossa.revenues
        UNION
         SELECT payments.id,
            payments.amount,
            payments.created_at,
            payments.date AS payment_date,
            ( SELECT payment_types.name
                   FROM canossa.payment_types
                  WHERE payment_types.id = payments.payment_type_id) AS payments_method,
            payments.transaction_id,
            1 AS is_payment,
            payments.bank_account_id,
            payments.student_id AS user_id,
            payments.payment_type_id,
            'student'::character varying AS user_table,
            ( SELECT student.name
                   FROM canossa.student
                  WHERE student.student_id = payments.student_id
                 LIMIT 1) AS payer_name,
            payments.payer_name,
            payments.reconciled
           FROM canossa.payments) a
     LEFT JOIN canossa.bank_accounts b ON b.id = a.bank_account_id;

ALTER TABLE canossa.total_revenues
    OWNER TO postgres;
CREATE OR REPLACE VIEW canossa.advance_payment_balance
 AS
 SELECT sum(p.amount) AS total_amount,
    sum(COALESCE(p.amount, 0::numeric) - COALESCE(r.total_advance_invoice_fee_amount, 0::numeric)) AS reminder,
    p.fee_id,
    p.student_id
   FROM canossa.advance_payments p
     LEFT JOIN ( SELECT sum(advance_payments_invoices_fees_installments.amount) AS total_advance_invoice_fee_amount,
            advance_payments_invoices_fees_installments.advance_payment_id
           FROM canossa.advance_payments_invoices_fees_installments
          GROUP BY advance_payments_invoices_fees_installments.advance_payment_id) r ON r.advance_payment_id = p.id
  GROUP BY p.fee_id, p.student_id;

ALTER TABLE canossa.advance_payment_balance
    OWNER TO postgres;


-- View: canossa.amount_receivable

-- DROP VIEW canossa.amount_receivable;

CREATE OR REPLACE VIEW canossa.amount_receivable
 AS
 SELECT sum(a.total_amount - a.discount_amount) AS total_amount,
    b.name,
    b.student_id,
    a.created_at::date AS created_at
   FROM canossa.invoice_balances a
     JOIN canossa.student b ON b.student_id = a.student_id
  GROUP BY b.name, b.student_id, a.created_at
UNION ALL
 SELECT sum(a.amount) AS total_amount,
    b.name,
    b.student_id,
    a.created_at::date AS created_at
   FROM canossa.due_amounts a
     JOIN canossa.student b ON b.student_id = a.student_id
  GROUP BY b.name, b.student_id, a.created_at
UNION ALL
 SELECT sum(0::numeric - a.amount) AS total_amount,
    b.name,
    b.student_id,
    a.date AS created_at
   FROM canossa.payments a
     JOIN canossa.student b ON b.student_id = a.student_id
  GROUP BY b.name, b.student_id, a.date
UNION ALL
 SELECT sum(0::numeric - a.amount) AS total_amount,
    b.name,
    b.student_id,
    a.created_at::date AS created_at
   FROM canossa.advance_payments a
     JOIN canossa.student b ON b.student_id = a.student_id AND a.payment_id IS NULL
  GROUP BY b.name, b.student_id, a.created_at;

ALTER TABLE canossa.amount_receivable
    OWNER TO postgres;

-- View: canossa.amount_receivable_per_date

-- DROP VIEW canossa.amount_receivable_per_date;

CREATE OR REPLACE VIEW canossa.amount_receivable_per_date
 AS
 SELECT sum(a.total_amount - a.discount_amount) AS total_amount,
    b.name,
    b.student_id,
    a.created_at::date AS created_at
   FROM canossa.invoice_balances a
     JOIN canossa.student b ON b.student_id = a.student_id
  GROUP BY b.name, b.student_id, a.created_at
UNION ALL
 SELECT sum(a.amount) AS total_amount,
    b.name,
    b.student_id,
    a.created_at::date AS created_at
   FROM canossa.due_amounts a
     JOIN canossa.student b ON b.student_id = a.student_id
  GROUP BY b.name, b.student_id, a.created_at
UNION ALL
 SELECT sum(0::numeric - a.amount) AS total_amount,
    b.name,
    b.student_id,
    a.created_at::date AS created_at
   FROM canossa.payments a
     JOIN canossa.student b ON b.student_id = a.student_id
  GROUP BY b.name, b.student_id, a.created_at
UNION ALL
 SELECT sum(0::numeric - a.amount) AS total_amount,
    b.name,
    b.student_id,
    a.created_at::date AS created_at
   FROM canossa.advance_payments a
     JOIN canossa.student b ON b.student_id = a.student_id AND a.payment_id IS NULL
  GROUP BY b.name, b.student_id, a.created_at;

ALTER TABLE canossa.amount_receivable_per_date
    OWNER TO postgres;

-- View: canossa.assessment_info

-- DROP VIEW canossa.assessment_info;

CREATE OR REPLACE VIEW canossa.assessment_info
 AS
 SELECT a.id AS character_category_id,
    a.character_category,
    g.student_id,
    j.id AS semester_id,
    j.name AS semester_name,
    c.name AS student_name,
    l."sectionID" AS section_id,
    l.section,
    g.teacher_id,
    a.based_on,
    b.id AS character_id,
    b.code,
    b.description,
    d."classesID" AS classes_id,
    d.classes,
    e.classlevel_id,
    e.name AS class_level_name,
    f.id AS academic_year_id,
    f.name AS academic_year,
    h.id AS grade1_id,
    i.id AS grade2_id,
    h.grade_remark AS remark1,
    h.grade AS grade1,
    i.grade_remark AS remark2,
    i.grade AS grade2
   FROM student_characters g
     JOIN student c ON c.student_id = g.student_id
     JOIN characters b ON g.character_id = b.id
     JOIN character_categories a ON b.character_category_id = a.id
     JOIN refer_character_grading_systems h ON g.grade1 = h.id
     LEFT JOIN refer_character_grading_systems i ON g.grade2 = i.id
     JOIN classes d ON g.classes_id = d."classesID"
     JOIN section l ON l."classesID" = d."classesID"
     JOIN classlevel e ON e.classlevel_id = d.classlevel_id
     JOIN academic_year f ON f.class_level_id = e.classlevel_id
     JOIN semester j ON j.class_level_id = e.classlevel_id
  WHERE g.grade1 IS NOT NULL
  ORDER BY e.classlevel_id, d."classesID", f.id, j.id, l."sectionID" DESC;

ALTER TABLE canossa.assessment_info
    OWNER TO postgres;

-- View: canossa.bank_transactions

-- DROP VIEW canossa.bank_transactions;

CREATE OR REPLACE VIEW canossa.bank_transactions
 AS
 SELECT payments.bank_account_id,
    payments.payment_type_id,
    payments.amount,
    payments.note,
    payments.date,
    payments.transaction_id,
    student.name AS recipient
   FROM canossa.payments
     JOIN canossa.student ON student.student_id = payments.student_id
UNION ALL
 SELECT d.bank_account_id,
    d.payment_type_id,
    d.amount,
    d.note,
    d.date,
    d.transaction_id,
    d.recipient
   FROM ( SELECT a.bank_account_id,
            a.date,
            a.transaction_id,
            a.expense AS note,
            a.payment_type_id,
            a.recipient,
            sum(
                CASE
                    WHEN b.financial_category_id = ANY (ARRAY[2, 3, 4]) THEN 0::numeric - COALESCE(a.amount, 0::numeric)
                    ELSE a.amount
                END) AS amount
           FROM canossa.expense a
             JOIN canossa.refer_expense b ON b.id = a.refer_expense_id
          GROUP BY a.bank_account_id, a.date, a.expense, a.payment_type_id, a.transaction_id, a.recipient) d
UNION ALL
 SELECT revenues.bank_account_id,
    revenues.payment_type_id,
    revenues.amount,
    revenues.note,
    revenues.date,
    revenues.transaction_id,
    revenues.payer_name AS recipient
   FROM canossa.revenues;

ALTER TABLE canossa.bank_transactions
    OWNER TO postgres;

-- View: canossa.college_semester_report

-- DROP VIEW canossa.college_semester_report;

CREATE OR REPLACE VIEW canossa.college_semester_report
 AS
 SELECT g.id,
    g.name,
    b.student_id,
    c."subjectID",
    c.subject,
    a.semester_id,
    sum(round(d.mark * b.mark / 100::numeric, 1)) AS sum
   FROM canossa.exam a
     JOIN canossa.mark b ON a."examID" = b."examID"
     JOIN canossa.subject c ON b."subjectID" = c."subjectID"
     JOIN canossa.exam_subject_mark d ON d."examID" = a."examID"
     JOIN canossa.refer_exam f ON f.id = a.refer_exam_id
     JOIN canossa.exam_groups g ON g.id = f.exam_group_id
  WHERE b."examID" = d."examID" AND c."subjectID" = d."subjectID" AND b."subjectID" = d."subjectID"
  GROUP BY g.id, g.name, b.student_id, c."subjectID", c.subject, a.semester_id
  ORDER BY b.student_id, c."subjectID";

ALTER TABLE canossa.college_semester_report
    OWNER TO postgres;

CREATE OR REPLACE VIEW canossa.core_option_subject_count
 AS
 SELECT count(DISTINCT a.subject_id) AS core_subjects,
    b.student_id,
    count(DISTINCT c.subject_id) AS option_subjects,
    count(DISTINCT a.subject_id) + count(DISTINCT c.subject_id) AS total_subjects
   FROM canossa.subject_section a
     JOIN canossa.student b ON b."sectionID" = a.section_id
     LEFT JOIN canossa.subject_student c ON c.student_id = b.student_id
  GROUP BY b.student_id;

ALTER TABLE canossa.core_option_subject_count
    OWNER TO postgres;

-- View: canossa.current_asset_transactions

-- DROP VIEW canossa.current_asset_transactions;

CREATE OR REPLACE VIEW canossa.current_asset_transactions
 AS
 SELECT d.amount,
    d.refer_expense_id,
    d.id,
    d.predefined,
    d.transaction_id,
    d.note,
    d.date,
    d.name,
    d.code,
    d.recipient
   FROM ( SELECT a.amount,
            b.id AS refer_expense_id,
            a.id,
            b.predefined,
            a.transaction_id,
            a.note,
            a.date,
            a.recipient,
            b.name,
            b.code
           FROM canossa.current_assets a
             JOIN canossa.refer_expense b ON b.id = a.to_refer_expense_id) d
UNION ALL
 SELECT e.amount,
    e.refer_expense_id,
    e.id,
    e.predefined,
    e.transaction_id,
    e.note,
    e.date,
    e.name,
    e.code,
    e.recipient
   FROM ( SELECT
                CASE
                    WHEN a.from_refer_expense_id = b.id THEN 0::numeric - a.amount
                    ELSE a.amount
                END AS amount,
            a.id,
            b.id AS refer_expense_id,
            b.predefined,
            a.transaction_id,
            a.note,
            a.date,
            a.recipient,
            b.name,
            b.code
           FROM canossa.current_assets a
             JOIN canossa.refer_expense b ON b.id = a.from_refer_expense_id) e;

ALTER TABLE canossa.current_asset_transactions
    OWNER TO postgres;

-- View: canossa.digital_invoices

-- DROP VIEW canossa.digital_invoices;

CREATE OR REPLACE VIEW canossa.digital_invoices
 AS
 SELECT a.reference,
    a.student_id,
    a.sync,
    b.name AS student_name,
    a.prefix,
    c.total_amount AS amount,
    c.balance,
    a.status
   FROM canossa.invoices a
     JOIN canossa.student b ON a.student_id = b.student_id
     JOIN canossa.invoice_balances c ON c.student_id = a.student_id
  WHERE c.fee_id = 3000;

ALTER TABLE canossa.digital_invoices
    OWNER TO postgres;

CREATE OR REPLACE VIEW canossa.dues_balance
 AS
 SELECT COALESCE(a.amount, 0::numeric) AS amount,
    a.id,
    COALESCE(b.due_paid_amount, 0::numeric) AS due_paid_amount,
    a.fee_id,
    a.student_id,
        CASE
            WHEN (COALESCE(a.amount, 0::numeric) - COALESCE(b.due_paid_amount, 0::numeric)) > 0::numeric THEN 0
            ELSE 1
        END AS status
   FROM canossa.due_amounts a
     LEFT JOIN ( SELECT sum(COALESCE(due_amounts_payments.amount, 0::numeric)) AS due_paid_amount,
            due_amounts_payments.due_amount_id
           FROM canossa.due_amounts_payments
          GROUP BY due_amounts_payments.due_amount_id) b ON b.due_amount_id = a.id;

ALTER TABLE canossa.dues_balance
    OWNER TO postgres;
-- View: canossa.exam_mark_info

-- DROP VIEW canossa.exam_mark_info;

CREATE OR REPLACE VIEW canossa.exam_mark_info
 AS
 SELECT sum(a.mark) AS mark,
    e.id,
    e.name,
    d."subjectID",
    d.subject,
    d."classesID",
    a.academic_year_id,
    b.semester_id,
    f.student_id,
    s.name AS student,
    s.sex,
    s.roll
   FROM canossa.mark a
     JOIN canossa.subject d ON d."subjectID" = a."subjectID"
     JOIN canossa.exam b ON b."examID" = a."examID"
     JOIN canossa.refer_exam c ON b.refer_exam_id = c.id
     JOIN canossa.exam_groups e ON c.exam_group_id = e.id
     JOIN canossa.student s ON s.student_id = a.student_id
     JOIN canossa.academic_year x ON x.id = a.academic_year_id
     JOIN canossa.student_archive f ON s.student_id = f.student_id
  WHERE f.academic_year_id = a.academic_year_id AND a.mark IS NOT NULL
  GROUP BY e.id, e.name, d."subjectID", d.subject, d."classesID", a.academic_year_id, b.semester_id, f.student_id, s.name, s.sex, s.roll;

ALTER TABLE canossa.exam_mark_info
    OWNER TO postgres;

GRANT ALL ON TABLE canossa.exam_mark_info TO postgres;
GRANT ALL ON TABLE canossa.exam_mark_info TO azure_admin;

-- View: canossa.expense_view

-- DROP VIEW canossa.expense_view;

CREATE OR REPLACE VIEW canossa.expense_view
 AS
 SELECT a."expenseID",
    a.created_at,
    a.date,
    a.expense,
    a.amount,
    a."userID",
    a.uname,
    a.usertype,
    a.expenseyear,
    a.note,
    a."categoryID",
    a.is_depreciation,
    a.depreciation,
    a.ref_no,
    a.payment_method,
    a.created_by,
    a.bank_account_id,
    a.transaction_id,
    a.created_by_table,
    a.voucher_no,
    a.payer_name,
    a.recipient,
    a.payment_type_id,
    a.refer_expense_id
   FROM canossa.expense a
     JOIN refer_expense b ON b.id = a.refer_expense_id AND (b.financial_category_id <> ALL (ARRAY[2, 3]))
UNION ALL
 SELECT a."expenseID",
    a.created_at,
    a.date,
    a.expense,
    b.amount,
    a."userID",
    a.uname,
    a.usertype,
    a.expenseyear,
    a.note,
    a."categoryID",
    a.is_depreciation,
    a.depreciation,
    a.ref_no,
    a.payment_method,
    a.created_by,
    a.bank_account_id,
    a.transaction_id,
    a.created_by_table,
    a.voucher_no,
    a.payer_name,
    a.recipient,
    a.payment_type_id,
    b.refer_expense_id
   FROM canossa.expense a
     JOIN canossa.expense_cart b ON b.expense_id = a."expenseID"
UNION ALL
 SELECT a."expenseID",
    a.created_at,
    a.date,
    a.expense,
    b.amount,
    a."userID",
    a.uname,
    a.usertype,
    a.expenseyear,
    a.note,
    a."categoryID",
    a.is_depreciation,
    a.depreciation,
    a.ref_no,
    a.payment_method,
    a.created_by,
    a.bank_account_id,
    a.transaction_id,
    a.created_by_table,
    a.voucher_no,
    a.payer_name,
    a.recipient,
    a.payment_type_id,
    c.refer_expense_id
   FROM canossa.expense a
     JOIN canossa.product_purchases b ON b.expense_id = a."expenseID"
     JOIN canossa.product_alert_quantity c ON c.id = b.product_alert_id;

ALTER TABLE canossa.expense_view
    OWNER TO postgres;

CREATE OR REPLACE VIEW canossa.fees_installments_amounts
 AS
 SELECT a.fees_installment_id,
    a.amount
   FROM canossa.fees_installments_classes a
UNION
 SELECT b.fees_installment_id,
    b.amount
   FROM canossa.transport_routes_fees_installments b
UNION
 SELECT c.fees_installment_id,
    c.amount
   FROM canossa.hostel_fees_installments c;

ALTER TABLE canossa.fees_installments_amounts
    OWNER TO postgres;


-- View: canossa.financial_year_expense

-- DROP VIEW canossa.financial_year_expense;

CREATE OR REPLACE VIEW canossa.financial_year_expense
 AS
 SELECT a."expenseID",
    a.create_date,
    a.date,
    a.expense,
    a.amount,
    a."userID",
    a.uname,
    a.usertype,
    a.expenseyear,
    a.note,
    a.created_at,
    a."categoryID",
    a.is_depreciation,
    a.depreciation,
    a.refer_expense_id,
    a.ref_no,
    a.payment_method,
    a.created_by,
    a.bank_account_id,
    a.transaction_id,
    a.created_by_table,
    a.reconciled,
    a.voucher_no,
    a.payer_name,
    a.recipient,
    a.updated_at,
    a.payment_type_id,
    a.voucher
   FROM canossa.expense a
     JOIN canossa.refer_expense b ON b.id = a.refer_expense_id
  WHERE a.date > (( SELECT max(closing_year_balance.date) AS max
           FROM canossa.closing_year_balance));

ALTER TABLE canossa.financial_year_expense
    OWNER TO postgres;

-- View: canossa.financial_year_payments

-- DROP VIEW canossa.financial_year_payments;

CREATE OR REPLACE VIEW canossa.financial_year_payments
 AS
 SELECT payments.id,
    payments.student_id,
    payments.amount,
    payments.payment_type_id,
    payments.date,
    payments.transaction_id,
    payments.created_at,
    payments.cheque_number,
    payments.bank_account_id,
    payments.payer_name,
    payments.mobile_transaction_id,
    payments.transaction_time,
    payments.account_number,
    payments.token,
    payments.reconciled,
    payments.receipt_code,
    payments.updated_at,
    payments.channel,
    payments.amount_entered,
    payments.created_by,
    payments.created_by_table,
    payments.note,
    payments.invoice_id,
    payments.status,
    payments.sid,
    payments.priority,
    payments.comment
   FROM canossa.payments
  WHERE payments.date > (( SELECT max(closing_year_balance.date) AS max
           FROM canossa.closing_year_balance));

ALTER TABLE canossa.financial_year_payments
    OWNER TO postgres;

CREATE OR REPLACE VIEW canossa.financial_year_product_cart
 AS
 SELECT product_cart.id,
    product_cart.name,
    product_cart.product_alert_id,
    product_cart.revenue_id,
    product_cart.created_at,
    product_cart.updated_at,
    product_cart.quantity,
    product_cart.amount,
    product_cart.date
   FROM canossa.product_cart
  WHERE product_cart.date > (( SELECT max(closing_year_balance.date) AS max
           FROM canossa.closing_year_balance));

ALTER TABLE canossa.financial_year_product_cart
    OWNER TO postgres;

CREATE OR REPLACE VIEW canossa.financial_year_product_purchases
 AS
 SELECT product_purchases.id,
    product_purchases.created_by,
    product_purchases.product_alert_id,
    product_purchases.quantity,
    product_purchases.amount,
    product_purchases.vendor_id,
    product_purchases.created_at,
    product_purchases.note,
    product_purchases.created_by_table,
    product_purchases.updated_at,
    product_purchases.expense_id,
    product_purchases.date,
    product_purchases.unit_price,
    product_purchases.status
   FROM canossa.product_purchases
  WHERE product_purchases.date > (( SELECT max(closing_year_balance.date) AS max
           FROM canossa.closing_year_balance));

ALTER TABLE canossa.financial_year_product_purchases
    OWNER TO postgres;

CREATE OR REPLACE VIEW canossa.financial_year_revenues
 AS
 SELECT a.id,
    a.payer_name,
    a.payer_phone,
    a.payer_email,
    a.refer_expense_id,
    a.amount,
    a.created_by_id,
    a.created_by_table,
    a.created_at,
    a.updated_at,
    a.payment_method,
    a.transaction_id,
    a.bank_account_id,
    a.invoice_number,
    a.note,
    a.date,
    a.user_in_shulesoft,
    a.user_id,
    a.user_table,
    a.reconciled,
    a.number,
    a.payment_type_id,
    a.loan_application_id
   FROM canossa.revenues a
     JOIN canossa.refer_expense b ON b.id = a.refer_expense_id
  WHERE a.date > (( SELECT max(closing_year_balance.date) AS max
           FROM canossa.closing_year_balance));

ALTER TABLE canossa.financial_year_revenues
    OWNER TO postgres;