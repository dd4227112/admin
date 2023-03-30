-- View: beta.users

-- DROP VIEW beta.users;

CREATE OR REPLACE VIEW beta.users
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
   FROM beta."user" a
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
   FROM beta.teacher t
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
           FROM beta.role
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
   FROM beta.student s
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
           FROM beta.role
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
   FROM beta.parent p
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
           FROM beta.role
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
   FROM beta.setting b;

ALTER TABLE beta.users
    OWNER TO postgres;

CREATE OR REPLACE VIEW beta.wallet_usage
 AS
 SELECT sum(COALESCE(wallets.amount, 0::numeric::double precision))::numeric AS amount,
    wallets.student_id,
    0 AS used_amount
   FROM beta.wallets
  GROUP BY wallets.student_id
UNION ALL
 SELECT 0 AS amount,
    wallet_uses.user_id AS student_id,
    sum(COALESCE(wallet_uses.amount, 0::numeric)) AS used_amount
   FROM beta.wallet_uses
  WHERE wallet_uses.user_table::text = 'student'::text
  GROUP BY wallet_uses.user_id;

ALTER TABLE beta.wallet_usage
    OWNER TO postgres;


CREATE OR REPLACE VIEW beta.total_mark
 AS
 SELECT sum(mark.mark) AS total,
    mark.student_id,
    mark."examID",
    mark.year,
    mark."classesID"
   FROM beta.mark
  GROUP BY mark.student_id, mark."examID", mark."classesID", mark.year;

ALTER TABLE beta.total_mark
    OWNER TO postgres;

CREATE OR REPLACE VIEW beta.total_revenues
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
           FROM beta.revenues
        UNION
         SELECT payments.id,
            payments.amount,
            payments.created_at,
            payments.date AS payment_date,
            ( SELECT payment_types.name
                   FROM beta.payment_types
                  WHERE payment_types.id = payments.payment_type_id) AS payments_method,
            payments.transaction_id,
            1 AS is_payment,
            payments.bank_account_id,
            payments.student_id AS user_id,
            payments.payment_type_id,
            'student'::character varying AS user_table,
            ( SELECT student.name
                   FROM beta.student
                  WHERE student.student_id = payments.student_id
                 LIMIT 1) AS payer_name,
            payments.payer_name,
            payments.reconciled
           FROM beta.payments) a
     LEFT JOIN beta.bank_accounts b ON b.id = a.bank_account_id;

ALTER TABLE beta.total_revenues
    OWNER TO postgres;
CREATE OR REPLACE VIEW beta.advance_payment_balance
 AS
 SELECT sum(p.amount) AS total_amount,
    sum(COALESCE(p.amount, 0::numeric) - COALESCE(r.total_advance_invoice_fee_amount, 0::numeric)) AS reminder,
    p.fee_id,
    p.student_id
   FROM beta.advance_payments p
     LEFT JOIN ( SELECT sum(advance_payments_invoices_fees_installments.amount) AS total_advance_invoice_fee_amount,
            advance_payments_invoices_fees_installments.advance_payment_id
           FROM beta.advance_payments_invoices_fees_installments
          GROUP BY advance_payments_invoices_fees_installments.advance_payment_id) r ON r.advance_payment_id = p.id
  GROUP BY p.fee_id, p.student_id;

ALTER TABLE beta.advance_payment_balance
    OWNER TO postgres;


-- View: beta.assessment_info

-- DROP VIEW beta.assessment_info;

CREATE OR REPLACE VIEW beta.assessment_info
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

ALTER TABLE beta.assessment_info
    OWNER TO postgres;

-- View: beta.bank_transactions

-- DROP VIEW beta.bank_transactions;

CREATE OR REPLACE VIEW beta.bank_transactions
 AS
 SELECT payments.bank_account_id,
    payments.payment_type_id,
    payments.amount,
    payments.note,
    payments.date,
    payments.transaction_id,
    student.name AS recipient
   FROM beta.payments
     JOIN beta.student ON student.student_id = payments.student_id
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
           FROM beta.expense a
             JOIN beta.refer_expense b ON b.id = a.refer_expense_id
          GROUP BY a.bank_account_id, a.date, a.expense, a.payment_type_id, a.transaction_id, a.recipient) d
UNION ALL
 SELECT revenues.bank_account_id,
    revenues.payment_type_id,
    revenues.amount,
    revenues.note,
    revenues.date,
    revenues.transaction_id,
    revenues.payer_name AS recipient
   FROM beta.revenues;

ALTER TABLE beta.bank_transactions
    OWNER TO postgres;

-- View: beta.college_semester_report

-- DROP VIEW beta.college_semester_report;

CREATE OR REPLACE VIEW beta.college_semester_report
 AS
 SELECT g.id,
    g.name,
    b.student_id,
    c."subjectID",
    c.subject,
    a.semester_id,
    sum(round(d.mark * b.mark / 100::numeric, 1)) AS sum
   FROM beta.exam a
     JOIN beta.mark b ON a."examID" = b."examID"
     JOIN beta.subject c ON b."subjectID" = c."subjectID"
     JOIN beta.exam_subject_mark d ON d."examID" = a."examID"
     JOIN beta.refer_exam f ON f.id = a.refer_exam_id
     JOIN beta.exam_groups g ON g.id = f.exam_group_id
  WHERE b."examID" = d."examID" AND c."subjectID" = d."subjectID" AND b."subjectID" = d."subjectID"
  GROUP BY g.id, g.name, b.student_id, c."subjectID", c.subject, a.semester_id
  ORDER BY b.student_id, c."subjectID";

ALTER TABLE beta.college_semester_report
    OWNER TO postgres;

CREATE OR REPLACE VIEW beta.core_option_subject_count
 AS
 SELECT count(DISTINCT a.subject_id) AS core_subjects,
    b.student_id,
    count(DISTINCT c.subject_id) AS option_subjects,
    count(DISTINCT a.subject_id) + count(DISTINCT c.subject_id) AS total_subjects
   FROM beta.subject_section a
     JOIN beta.student b ON b."sectionID" = a.section_id
     LEFT JOIN beta.subject_student c ON c.student_id = b.student_id
  GROUP BY b.student_id;

ALTER TABLE beta.core_option_subject_count
    OWNER TO postgres;

-- View: beta.current_asset_transactions

-- DROP VIEW beta.current_asset_transactions;

CREATE OR REPLACE VIEW beta.current_asset_transactions
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
           FROM beta.current_assets a
             JOIN beta.refer_expense b ON b.id = a.to_refer_expense_id) d
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
           FROM beta.current_assets a
             JOIN beta.refer_expense b ON b.id = a.from_refer_expense_id) e;

ALTER TABLE beta.current_asset_transactions
    OWNER TO postgres;



CREATE OR REPLACE VIEW beta.dues_balance
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
   FROM beta.due_amounts a
     LEFT JOIN ( SELECT sum(COALESCE(due_amounts_payments.amount, 0::numeric)) AS due_paid_amount,
            due_amounts_payments.due_amount_id
           FROM beta.due_amounts_payments
          GROUP BY due_amounts_payments.due_amount_id) b ON b.due_amount_id = a.id;

ALTER TABLE beta.dues_balance
    OWNER TO postgres;
-- View: beta.exam_mark_info

-- DROP VIEW beta.exam_mark_info;

CREATE OR REPLACE VIEW beta.exam_mark_info
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
   FROM beta.mark a
     JOIN beta.subject d ON d."subjectID" = a."subjectID"
     JOIN beta.exam b ON b."examID" = a."examID"
     JOIN beta.refer_exam c ON b.refer_exam_id = c.id
     JOIN beta.exam_groups e ON c.exam_group_id = e.id
     JOIN beta.student s ON s.student_id = a.student_id
     JOIN beta.academic_year x ON x.id = a.academic_year_id
     JOIN beta.student_archive f ON s.student_id = f.student_id
  WHERE f.academic_year_id = a.academic_year_id AND a.mark IS NOT NULL
  GROUP BY e.id, e.name, d."subjectID", d.subject, d."classesID", a.academic_year_id, b.semester_id, f.student_id, s.name, s.sex, s.roll;

ALTER TABLE beta.exam_mark_info
    OWNER TO postgres;

GRANT ALL ON TABLE beta.exam_mark_info TO postgres;
GRANT ALL ON TABLE beta.exam_mark_info TO azure_admin;

-- View: beta.expense_view

-- DROP VIEW beta.expense_view;

CREATE OR REPLACE VIEW beta.expense_view
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
   FROM beta.expense a
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
   FROM beta.expense a
     JOIN beta.expense_cart b ON b.expense_id = a."expenseID"
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
   FROM beta.expense a
     JOIN beta.product_purchases b ON b.expense_id = a."expenseID"
     JOIN beta.product_alert_quantity c ON c.id = b.product_alert_id;

ALTER TABLE beta.expense_view
    OWNER TO postgres;

CREATE OR REPLACE VIEW beta.fees_installments_amounts
 AS
 SELECT a.fees_installment_id,
    a.amount
   FROM beta.fees_installments_classes a
UNION
 SELECT b.fees_installment_id,
    b.amount
   FROM beta.transport_routes_fees_installments b
UNION
 SELECT c.fees_installment_id,
    c.amount
   FROM beta.hostel_fees_installments c;

ALTER TABLE beta.fees_installments_amounts
    OWNER TO postgres;


-- View: beta.financial_year_expense

-- DROP VIEW beta.financial_year_expense;

CREATE OR REPLACE VIEW beta.financial_year_expense
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
   FROM beta.expense a
     JOIN beta.refer_expense b ON b.id = a.refer_expense_id
  WHERE a.date > (( SELECT max(closing_year_balance.date) AS max
           FROM beta.closing_year_balance));

ALTER TABLE beta.financial_year_expense
    OWNER TO postgres;

-- View: beta.financial_year_payments

-- DROP VIEW beta.financial_year_payments;

CREATE OR REPLACE VIEW beta.financial_year_payments
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
   FROM beta.payments
  WHERE payments.date > (( SELECT max(closing_year_balance.date) AS max
           FROM beta.closing_year_balance));

ALTER TABLE beta.financial_year_payments
    OWNER TO postgres;

CREATE OR REPLACE VIEW beta.financial_year_product_cart
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
   FROM beta.product_cart
  WHERE product_cart.date > (( SELECT max(closing_year_balance.date) AS max
           FROM beta.closing_year_balance));

ALTER TABLE beta.financial_year_product_cart
    OWNER TO postgres;

CREATE OR REPLACE VIEW beta.financial_year_product_purchases
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
   FROM beta.product_purchases
  WHERE product_purchases.date > (( SELECT max(closing_year_balance.date) AS max
           FROM beta.closing_year_balance));

ALTER TABLE beta.financial_year_product_purchases
    OWNER TO postgres;

CREATE OR REPLACE VIEW beta.financial_year_revenues
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
   FROM beta.revenues a
     JOIN beta.refer_expense b ON b.id = a.refer_expense_id
  WHERE a.date > (( SELECT max(closing_year_balance.date) AS max
           FROM beta.closing_year_balance));

ALTER TABLE beta.financial_year_revenues
    OWNER TO postgres;


CREATE OR REPLACE VIEW beta.hostel_info
 AS
 SELECT b.hostel_id,
    a.student_id,
    a.id,
    b.amount,
    b.fees_installment_id,
    COALESCE(c.amount, 0::numeric(10,2)) AS discount,
    d.name,
    a.installment_id
   FROM beta.hmembers a
     JOIN beta.fees_installments f ON f.installment_id = a.installment_id AND f.fee_id = 2000
     JOIN beta.hostel_fees_installments b ON b.fees_installment_id = f.id AND b.hostel_id = a.hostel_id
     LEFT JOIN beta.discount_fees_installments c ON c.fees_installment_id = b.fees_installment_id AND a.student_id = c.student_id
     JOIN beta.hostels d ON d.id = a.hostel_id
  GROUP BY b.hostel_id, a.student_id, b.amount, b.fees_installment_id, c.amount, d.name, a.id, a.installment_id
  ORDER BY a.student_id DESC;

ALTER TABLE beta.hostel_info
    OWNER TO postgres;


CREATE OR REPLACE VIEW beta.hostel_installment_detail
 AS
 SELECT a.student_id,
    a.hostel_category_id,
    b.amount,
    b.fees_installment_id
   FROM beta.hmembers a
     JOIN beta.hostels d ON d.id = a.hostel_id
     JOIN beta.hostel_fees_installments b ON a.hostel_id = b.hostel_id
     JOIN beta.fees_installments c ON c.id = b.fees_installment_id
     JOIN beta.installments e ON e.id = c.installment_id AND a.installment_id = e.id
     JOIN beta.student_archive s ON s.student_id = a.student_id AND e.academic_year_id = s.academic_year_id
  GROUP BY a.student_id, a.hostel_category_id, b.fees_installment_id, e.id, b.amount;

ALTER TABLE beta.hostel_installment_detail
    OWNER TO postgres;

-- View: beta.hostel_invoices_fees_installments_balance

-- DROP VIEW beta.hostel_invoices_fees_installments_balance;

CREATE OR REPLACE VIEW beta.hostel_invoices_fees_installments_balance
 AS
 SELECT COALESCE(f.amount, 0::numeric) AS total_amount,
    COALESCE(c.total_payment_invoice_amount, 0::numeric) AS total_payment_invoice_fee_amount,
    COALESCE(d.total_advance_invoice_fee_amount, 0::numeric) AS total_advance_invoice_fee_amount,
    COALESCE(e.amount, 0::numeric) AS discount_amount,
    g.student_id,
    g.date AS created_at,
    b.id,
    r.total_amount AS advance_amount,
    b.fees_installment_id,
    h.id AS installment_id,
    h.start_date,
    h.academic_year_id,
    2000 AS fee_id,
    b.invoice_id,
        CASE
            WHEN (f.amount - COALESCE(c.total_payment_invoice_amount, 0::numeric) - COALESCE(d.total_advance_invoice_fee_amount, 0::numeric) - COALESCE(e.amount, 0::numeric)) > 0::numeric THEN 0
            ELSE 1
        END AS status,
    h.end_date
   FROM beta.invoices_fees_installments b
     JOIN beta.invoices g ON g.id = b.invoice_id
     JOIN beta.hostel_installment_detail f ON b.fees_installment_id = f.fees_installment_id AND f.student_id = g.student_id
     JOIN beta.fees_installments k ON k.id = b.fees_installment_id
     JOIN beta.installments h ON h.id = k.installment_id
     LEFT JOIN ( SELECT sum(payments_invoices_fees_installments.amount) AS total_payment_invoice_amount,
            payments_invoices_fees_installments.invoices_fees_installment_id
           FROM beta.payments_invoices_fees_installments
          GROUP BY payments_invoices_fees_installments.invoices_fees_installment_id) c ON c.invoices_fees_installment_id = b.id
     LEFT JOIN ( SELECT sum(advance_payments_invoices_fees_installments.amount) AS total_advance_invoice_fee_amount,
            advance_payments_invoices_fees_installments.invoices_fees_installments_id
           FROM beta.advance_payments_invoices_fees_installments
          GROUP BY advance_payments_invoices_fees_installments.invoices_fees_installments_id) d ON d.invoices_fees_installments_id = b.id
     LEFT JOIN beta.discount_fees_installments e ON e.fees_installment_id = b.fees_installment_id AND g.student_id = e.student_id
     LEFT JOIN beta.advance_payment_balance r ON r.fee_id = 2000 AND r.student_id = g.student_id
  WHERE k.fee_id = 2000
  ORDER BY h.start_date;




CREATE OR REPLACE VIEW beta.invoices_fees_installments_balance
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
   FROM beta.fees_installments_classes a
     JOIN beta.invoices_fees_installments b ON b.fees_installment_id = a.fees_installment_id
     JOIN beta.invoices f ON f.id = b.invoice_id
     JOIN beta.fees_installments g ON g.id = a.fees_installment_id
     JOIN beta.installments h ON h.id = g.installment_id
     JOIN beta.fees i ON i.id = g.fee_id
     JOIN beta.student_archive s ON s.student_id = f.student_id AND (s.section_id IN ( SELECT section."sectionID"
           FROM beta.section
          WHERE section."classesID" = a.class_id)) AND h.academic_year_id = s.academic_year_id
     LEFT JOIN ( SELECT sum(payments_invoices_fees_installments.amount) AS total_payment_invoice_amount,
            payments_invoices_fees_installments.invoices_fees_installment_id
           FROM beta.payments_invoices_fees_installments
          WHERE (payments_invoices_fees_installments.payment_id IN ( SELECT payments.id
                   FROM beta.payments))
          GROUP BY payments_invoices_fees_installments.invoices_fees_installment_id) c ON c.invoices_fees_installment_id = b.id
     LEFT JOIN ( SELECT sum(advance_payments_invoices_fees_installments.amount) AS total_advance_invoice_fee_amount,
            advance_payments_invoices_fees_installments.invoices_fees_installments_id
           FROM beta.advance_payments_invoices_fees_installments
          GROUP BY advance_payments_invoices_fees_installments.invoices_fees_installments_id) d ON d.invoices_fees_installments_id = b.id
     LEFT JOIN beta.discount_fees_installments e ON e.fees_installment_id = a.fees_installment_id AND f.student_id = e.student_id
  ORDER BY h.start_date, i.priority;




CREATE OR REPLACE VIEW beta.transport_installment_detail
 AS
 SELECT a.student_id,
    a.vehicle_id,
    a.is_oneway,
        CASE
            WHEN a.is_oneway = 0 THEN b.amount
            ELSE b.amount * 0.5::numeric(10,2)
        END AS amount,
    b.fees_installment_id
   FROM beta.tmembers a
     JOIN beta.transport_routes d ON d.id = a.transport_route_id
     JOIN beta.transport_routes_fees_installments b ON a.transport_route_id = b.transport_route_id
     JOIN beta.fees_installments c ON c.id = b.fees_installment_id
     JOIN beta.installments e ON e.id = c.installment_id AND a.installment_id = e.id
     JOIN beta.student_archive s ON s.student_id = a.student_id AND e.academic_year_id = s.academic_year_id
  GROUP BY a.student_id, a.vehicle_id, a.is_oneway, b.amount, b.fees_installment_id, e.id;



CREATE OR REPLACE VIEW beta.transport_invoices_fees_installments_balance
 AS
 SELECT COALESCE(f.amount, 0::numeric) AS total_amount,
    COALESCE(c.total_payment_invoice_amount, 0::numeric) AS total_payment_invoice_fee_amount,
    COALESCE(d.total_advance_invoice_fee_amount, 0::numeric) AS total_advance_invoice_fee_amount,
    COALESCE(e.amount, 0::numeric) AS discount_amount,
    g.student_id,
    g.date AS created_at,
    b.id,
    r.total_amount AS advance_amount,
    b.fees_installment_id,
    h.id AS installment_id,
    h.start_date,
    h.academic_year_id,
    1000 AS fee_id,
    b.invoice_id,
        CASE
            WHEN (f.amount - COALESCE(c.total_payment_invoice_amount, 0::numeric) - COALESCE(d.total_advance_invoice_fee_amount, 0::numeric) - COALESCE(e.amount, 0::numeric)) > 0::numeric THEN 0
            ELSE 1
        END AS status,
    h.end_date
   FROM beta.invoices_fees_installments b
     JOIN beta.invoices g ON g.id = b.invoice_id
     JOIN beta.transport_installment_detail f ON b.fees_installment_id = f.fees_installment_id AND f.student_id = g.student_id
     JOIN beta.fees_installments k ON k.id = b.fees_installment_id
     JOIN beta.installments h ON h.id = k.installment_id
     LEFT JOIN ( SELECT sum(payments_invoices_fees_installments.amount) AS total_payment_invoice_amount,
            payments_invoices_fees_installments.invoices_fees_installment_id
           FROM beta.payments_invoices_fees_installments
          GROUP BY payments_invoices_fees_installments.invoices_fees_installment_id) c ON c.invoices_fees_installment_id = b.id
     LEFT JOIN ( SELECT sum(advance_payments_invoices_fees_installments.amount) AS total_advance_invoice_fee_amount,
            advance_payments_invoices_fees_installments.invoices_fees_installments_id
           FROM beta.advance_payments_invoices_fees_installments
          GROUP BY advance_payments_invoices_fees_installments.invoices_fees_installments_id) d ON d.invoices_fees_installments_id = b.id
     LEFT JOIN beta.discount_fees_installments e ON e.fees_installment_id = b.fees_installment_id AND g.student_id = e.student_id
     LEFT JOIN beta.advance_payment_balance r ON r.fee_id = 1000 AND r.student_id = g.student_id
  WHERE k.fee_id = 1000
  ORDER BY h.start_date;




CREATE OR REPLACE VIEW beta.next_year_invoices_fees_installments_balance
 AS
 SELECT COALESCE(a.amount, 0::numeric) AS total_amount,
    COALESCE(c.total_payment_invoice_amount, 0::numeric) AS total_payment_invoice_fee_amount,
    COALESCE(d.total_advance_invoice_fee_amount, 0::numeric) AS total_advance_invoice_fee_amount,
    COALESCE(e.amount, 0::numeric) AS discount_amount,
    f.student_id,
    f.date AS created_at,
    b.id,
    a.class_id,
    b.fees_installment_id,
    h.id AS installment_id,
    h.start_date,
    h.academic_year_id,
    i.id AS fee_id,
    f.id AS invoice_id,
        CASE
            WHEN (a.amount - COALESCE(c.total_payment_invoice_amount, 0::numeric) - COALESCE(d.total_advance_invoice_fee_amount, 0::numeric) - COALESCE(e.amount, 0::numeric)) > 0::numeric THEN 0
            ELSE 1
        END AS status
   FROM beta.fees_installments_classes a
     JOIN beta.invoices_fees_installments b ON b.fees_installment_id = a.fees_installment_id
     JOIN beta.invoices f ON f.id = b.invoice_id
     JOIN beta.fees_installments g ON g.id = a.fees_installment_id
     JOIN beta.installments h ON h.id = g.installment_id
     JOIN beta.fees i ON i.id = g.fee_id
     JOIN beta.student s ON s.student_id = f.student_id AND s.academic_year_id <> h.academic_year_id AND a.class_id = s."classesID"
     LEFT JOIN ( SELECT sum(payments_invoices_fees_installments.amount) AS total_payment_invoice_amount,
            payments_invoices_fees_installments.invoices_fees_installment_id
           FROM beta.payments_invoices_fees_installments
          GROUP BY payments_invoices_fees_installments.invoices_fees_installment_id) c ON c.invoices_fees_installment_id = b.id
     LEFT JOIN ( SELECT sum(advance_payments_invoices_fees_installments.amount) AS total_advance_invoice_fee_amount,
            advance_payments_invoices_fees_installments.invoices_fees_installments_id
           FROM beta.advance_payments_invoices_fees_installments
          GROUP BY advance_payments_invoices_fees_installments.invoices_fees_installments_id) d ON d.invoices_fees_installments_id = b.id
     LEFT JOIN beta.discount_fees_installments e ON e.fees_installment_id = a.fees_installment_id AND f.student_id = e.student_id
  ORDER BY h.start_date, i.priority;



CREATE OR REPLACE VIEW beta.invoice_balances
 AS
 SELECT transport_invoices_fees_installments_balance.student_id,
    transport_invoices_fees_installments_balance.created_at,
    transport_invoices_fees_installments_balance.total_amount,
    transport_invoices_fees_installments_balance.total_payment_invoice_fee_amount,
    transport_invoices_fees_installments_balance.total_advance_invoice_fee_amount,
    transport_invoices_fees_installments_balance.discount_amount,
    transport_invoices_fees_installments_balance.fees_installment_id,
    transport_invoices_fees_installments_balance.installment_id,
    transport_invoices_fees_installments_balance.start_date,
    transport_invoices_fees_installments_balance.academic_year_id,
    transport_invoices_fees_installments_balance.fee_id,
    transport_invoices_fees_installments_balance.id,
    transport_invoices_fees_installments_balance.invoice_id,
    COALESCE(transport_invoices_fees_installments_balance.total_amount, 0::numeric) - COALESCE(transport_invoices_fees_installments_balance.total_payment_invoice_fee_amount, 0::numeric) - COALESCE(transport_invoices_fees_installments_balance.total_advance_invoice_fee_amount, 0::numeric) - COALESCE(transport_invoices_fees_installments_balance.discount_amount, 0::numeric) AS balance,
    transport_invoices_fees_installments_balance.end_date
   FROM beta.transport_invoices_fees_installments_balance
UNION ALL
 SELECT invoices_fees_installments_balance.student_id,
    invoices_fees_installments_balance.created_at,
    invoices_fees_installments_balance.total_amount,
    invoices_fees_installments_balance.total_payment_invoice_fee_amount,
    invoices_fees_installments_balance.total_advance_invoice_fee_amount,
    invoices_fees_installments_balance.discount_amount,
    invoices_fees_installments_balance.fees_installment_id,
    invoices_fees_installments_balance.installment_id,
    invoices_fees_installments_balance.start_date,
    invoices_fees_installments_balance.academic_year_id,
    invoices_fees_installments_balance.fee_id,
    invoices_fees_installments_balance.id,
    invoices_fees_installments_balance.invoice_id,
    COALESCE(invoices_fees_installments_balance.total_amount, 0::numeric) - COALESCE(invoices_fees_installments_balance.total_payment_invoice_fee_amount, 0::numeric) - COALESCE(invoices_fees_installments_balance.total_advance_invoice_fee_amount, 0::numeric) - COALESCE(invoices_fees_installments_balance.discount_amount, 0::numeric) AS balance,
    invoices_fees_installments_balance.end_date
   FROM beta.invoices_fees_installments_balance
UNION ALL
 SELECT hostel_invoices_fees_installments_balance.student_id,
    hostel_invoices_fees_installments_balance.created_at,
    hostel_invoices_fees_installments_balance.total_amount,
    hostel_invoices_fees_installments_balance.total_payment_invoice_fee_amount,
    hostel_invoices_fees_installments_balance.total_advance_invoice_fee_amount,
    hostel_invoices_fees_installments_balance.discount_amount,
    hostel_invoices_fees_installments_balance.fees_installment_id,
    hostel_invoices_fees_installments_balance.installment_id,
    hostel_invoices_fees_installments_balance.start_date,
    hostel_invoices_fees_installments_balance.academic_year_id,
    hostel_invoices_fees_installments_balance.fee_id,
    hostel_invoices_fees_installments_balance.id,
    hostel_invoices_fees_installments_balance.invoice_id,
    COALESCE(hostel_invoices_fees_installments_balance.total_amount, 0::numeric) - COALESCE(hostel_invoices_fees_installments_balance.total_payment_invoice_fee_amount, 0::numeric) - COALESCE(hostel_invoices_fees_installments_balance.total_advance_invoice_fee_amount, 0::numeric) - COALESCE(hostel_invoices_fees_installments_balance.discount_amount, 0::numeric) AS balance,
    hostel_invoices_fees_installments_balance.end_date
   FROM beta.hostel_invoices_fees_installments_balance;

CREATE OR REPLACE VIEW beta.installment_reminders
 AS
 SELECT a.student_id,
    b.name AS student,
    c.name AS parent,
    c.phone AS phone_number,
    a.balance AS unpaid_amount,
    f.name,
    f.start_date,
    f.end_date,
        CASE
            WHEN f.end_date <= now() THEN 0
            ELSE 1
        END AS status
   FROM beta.invoice_balances a
     JOIN beta.student b ON b.student_id = a.student_id
     JOIN beta.student_parents d ON b.student_id = d.student_id
     JOIN beta.parent c ON c."parentID" = d.parent_id
     JOIN beta.installments f ON f.id = a.installment_id
  WHERE a.balance > 0::numeric
  ORDER BY a.student_id;

ALTER TABLE beta.installment_reminders
    OWNER TO postgres;





CREATE OR REPLACE VIEW beta.amount_receivable
 AS
 SELECT sum(a.total_amount - a.discount_amount) AS total_amount,
    b.name,
    b.student_id,
    a.created_at::date AS created_at
   FROM beta.invoice_balances a
     JOIN beta.student b ON b.student_id = a.student_id
  GROUP BY b.name, b.student_id, a.created_at
UNION ALL
 SELECT sum(a.amount) AS total_amount,
    b.name,
    b.student_id,
    a.created_at::date AS created_at
   FROM beta.due_amounts a
     JOIN beta.student b ON b.student_id = a.student_id
  GROUP BY b.name, b.student_id, a.created_at
UNION ALL
 SELECT sum(0::numeric - a.amount) AS total_amount,
    b.name,
    b.student_id,
    a.date AS created_at
   FROM beta.payments a
     JOIN beta.student b ON b.student_id = a.student_id
  GROUP BY b.name, b.student_id, a.date
UNION ALL
 SELECT sum(0::numeric - a.amount) AS total_amount,
    b.name,
    b.student_id,
    a.created_at::date AS created_at
   FROM beta.advance_payments a
     JOIN beta.student b ON b.student_id = a.student_id AND a.payment_id IS NULL
  GROUP BY b.name, b.student_id, a.created_at;

ALTER TABLE beta.amount_receivable
    OWNER TO postgres;

-- View: beta.amount_receivable_per_date

-- DROP VIEW beta.amount_receivable_per_date;

CREATE OR REPLACE VIEW beta.amount_receivable_per_date
 AS
 SELECT sum(a.total_amount - a.discount_amount) AS total_amount,
    b.name,
    b.student_id,
    a.created_at::date AS created_at
   FROM beta.invoice_balances a
     JOIN beta.student b ON b.student_id = a.student_id
  GROUP BY b.name, b.student_id, a.created_at
UNION ALL
 SELECT sum(a.amount) AS total_amount,
    b.name,
    b.student_id,
    a.created_at::date AS created_at
   FROM beta.due_amounts a
     JOIN beta.student b ON b.student_id = a.student_id
  GROUP BY b.name, b.student_id, a.created_at
UNION ALL
 SELECT sum(0::numeric - a.amount) AS total_amount,
    b.name,
    b.student_id,
    a.created_at::date AS created_at
   FROM beta.payments a
     JOIN beta.student b ON b.student_id = a.student_id
  GROUP BY b.name, b.student_id, a.created_at
UNION ALL
 SELECT sum(0::numeric - a.amount) AS total_amount,
    b.name,
    b.student_id,
    a.created_at::date AS created_at
   FROM beta.advance_payments a
     JOIN beta.student b ON b.student_id = a.student_id AND a.payment_id IS NULL
  GROUP BY b.name, b.student_id, a.created_at;

ALTER TABLE beta.amount_receivable_per_date
    OWNER TO postgres;


CREATE OR REPLACE VIEW beta.invoice_subviews
 AS
 SELECT b.id,
    b.student_id,
    (b.reference::text || 'EA'::text) || a.fee_id AS reference,
    b.prefix,
    b.date,
    b.sync,
    b.return_message,
    b.push_status,
    b.academic_year_id,
    b.created_at,
    b.updated_at,
    a.balance AS amount,
    c.name,
    1 AS sub_invoice,
    a.fee_id
   FROM beta.invoices b
     JOIN beta.student c ON c.student_id = b.student_id
     JOIN beta.invoice_balances a ON a.invoice_id = b.id;

ALTER TABLE beta.invoice_subviews
    OWNER TO postgres;


CREATE OR REPLACE VIEW beta.invoice_summary
 AS
 SELECT COALESCE(COALESCE(sum(a.total_amount), 0::numeric) - sum(a.discount_amount), 0::numeric) AS amount,
    COALESCE(COALESCE(sum(a.total_payment_invoice_fee_amount), 0::numeric) + COALESCE(sum(a.total_advance_invoice_fee_amount)), 0::numeric) AS paid_amount,
    sum(a.balance) AS balance,
    a.invoice_id,
    a.student_id,
    c.reference,
    c.sync,
    b.name AS student_name,
    b.roll,
    a.created_at,
    c.academic_year_id,
    c.date,
    c.due_date,
    d.section_id,
    e."classesID"
   FROM beta.invoice_balances a
     JOIN beta.student b ON a.student_id = b.student_id
     JOIN beta.invoices c ON c.id = a.invoice_id
     JOIN beta.student_archive d ON d.academic_year_id = c.academic_year_id AND d.student_id = b.student_id
     JOIN beta.section e ON e."sectionID" = d.section_id
  WHERE b.status = 1
  GROUP BY a.invoice_id, a.created_at, b.name, d.section_id, e."classesID", b.roll, a.student_id, c.reference, c.sync, c.academic_year_id, c.date, c.due_date;

ALTER TABLE beta.invoice_summary
    OWNER TO postgres;

CREATE OR REPLACE VIEW beta.invoice_views
 AS
 SELECT b.id,
    b.student_id,
    b.reference,
    b.prefix,
    b.date,
    b.sync,
    b.return_message,
    b.push_status,
    b.academic_year_id,
    b.created_at,
    b.updated_at,
    a.amount,
    c.name,
    ( SELECT setting.sub_invoice
           FROM beta.setting
         LIMIT 1) AS sub_invoice,
    0 AS fee_id
   FROM beta.invoices b
     JOIN beta.student c ON c.student_id = b.student_id
     JOIN ( SELECT sum(y.balance) AS amount,
            y.invoice_id
           FROM beta.invoice_balances y
          GROUP BY y.invoice_id) a ON a.invoice_id = b.id;


CREATE OR REPLACE VIEW beta.mark_grade
 AS
 SELECT total_mark.student_id,
    total_mark."classesID",
    total_mark.year,
    total_mark."examID",
    total_mark.total,
    row_number() OVER (ORDER BY total_mark.total DESC) AS rank
   FROM beta.total_mark;

ALTER TABLE beta.mark_grade
    OWNER TO postgres;


-- View: beta.mark_info

-- DROP VIEW beta.mark_info;

CREATE OR REPLACE VIEW beta.mark_info
 AS
 SELECT a.student_id,
    d.name,
    d.roll,
    c.subject_name,
    a.mark,
    a."classesID",
    e.section_id AS "sectionID",
    a."examID",
    a."subjectID",
    b.is_counted,
    b.is_penalty,
    b.pass_mark,
    a.academic_year_id,
    p.global_exam_id,
    x.name AS academic_year,
    f.refer_class_id,
    a.created_at,
    d.status AS student_status,
    d.sex,
    ( SELECT setting.region
           FROM beta.setting
         LIMIT 1) AS region
   FROM beta.mark a
     JOIN beta.subject b ON b."subjectID" = a."subjectID"
     JOIN beta.refer_subject c ON c.subject_id = b.subject_id
     JOIN beta.student d ON d.student_id = a.student_id
     JOIN beta.classes f ON f."classesID" = a."classesID"
     JOIN beta.exam p ON p."examID" = a."examID"
     JOIN beta.academic_year x ON x.id = a.academic_year_id
     JOIN beta.student_archive e ON a.student_id = e.student_id AND a.academic_year_id = e.academic_year_id
  WHERE a.mark IS NOT NULL AND (d.status = 1 OR d.status = 2);

ALTER TABLE beta.mark_info
    OWNER TO postgres;


CREATE OR REPLACE VIEW beta.mark_ranking
 AS
 SELECT mark.student_id,
    mark.mark,
    rank() OVER (PARTITION BY mark."subjectID" ORDER BY mark.mark DESC) AS dense_rank,
    mark."examID",
    mark."subjectID"
   FROM beta.mark;

ALTER TABLE beta.mark_ranking
    OWNER TO postgres;

-- View: beta.media_videos

-- DROP VIEW beta.media_videos;

CREATE OR REPLACE VIEW beta.media_videos
 AS
 SELECT a.media_id,
    b.title,
    b.description,
    b.name AS media_name,
    b.status,
    b.syllabus_topic_id,
    c.title AS topic,
    d.subject_id,
    g.subject_name,
    f.classes,
    f.refer_class_id,
    b.created_by,
    e.name AS teacher,
    a.start_time,
    a.end_time,
    a.streaming_url,
    a.source,
    a.date,
    a.created_at
   FROM beta.medias b
     JOIN beta.media_live a ON a.media_id = b.id
     JOIN beta.syllabus_topics c ON b.syllabus_topic_id = c.id
     JOIN beta.subject d ON d."subjectID" = c.subject_id
     JOIN beta.teacher e ON e."teacherID" = b.created_by
     JOIN beta.classes f ON f."classesID" = d."classesID"
     JOIN beta.refer_subject g ON d.subject_id = g.subject_id;


CREATE OR REPLACE VIEW beta.digital_invoices
 AS
 SELECT a.reference,
    a.student_id,
    a.sync,
    b.name AS student_name,
    a.prefix,
    c.total_amount AS amount,
    c.balance,
    a.status
   FROM beta.invoices a
     JOIN beta.student b ON a.student_id = b.student_id
     JOIN beta.invoice_balances c ON c.student_id = a.student_id
  WHERE c.fee_id = 3000;


CREATE OR REPLACE VIEW beta.next_year_transport_installment_detail
 AS
 SELECT a.student_id,
    a.vehicle_id,
    a.is_oneway,
        CASE
            WHEN a.is_oneway = 0 THEN b.amount
            ELSE b.amount * 0.5::numeric(10,2)
        END AS amount,
    b.fees_installment_id
   FROM beta.tmembers a
     JOIN beta.transport_routes d ON d.id = a.transport_route_id
     JOIN beta.transport_routes_fees_installments b ON a.transport_route_id = b.transport_route_id
     JOIN beta.fees_installments c ON c.id = b.fees_installment_id
     JOIN beta.installments e ON e.id = c.installment_id
     JOIN beta.student_archive s ON s.student_id = a.student_id AND e.academic_year_id <> s.academic_year_id
  GROUP BY a.student_id, a.vehicle_id, a.is_oneway, b.amount, b.fees_installment_id, e.id;



CREATE OR REPLACE VIEW beta.next_year_transport_invoices_fees_installments_balance
 AS
 SELECT COALESCE(f.amount, 0::numeric) AS total_amount,
    COALESCE(c.total_payment_invoice_amount, 0::numeric) AS total_payment_invoice_fee_amount,
    COALESCE(d.total_advance_invoice_fee_amount, 0::numeric) AS total_advance_invoice_fee_amount,
    COALESCE(e.amount, 0::numeric) AS discount_amount,
    g.student_id,
    g.date AS created_at,
    b.id,
    r.total_amount AS advance_amount,
    b.fees_installment_id,
    h.id AS installment_id,
    h.start_date,
    h.academic_year_id,
    1000 AS fee_id,
    b.invoice_id,
        CASE
            WHEN (f.amount - COALESCE(c.total_payment_invoice_amount, 0::numeric) - COALESCE(d.total_advance_invoice_fee_amount, 0::numeric) - COALESCE(e.amount, 0::numeric)) > 0::numeric THEN 0
            ELSE 1
        END AS status
   FROM beta.invoices_fees_installments b
     JOIN beta.invoices g ON g.id = b.invoice_id
     JOIN beta.next_year_transport_installment_detail f ON b.fees_installment_id = f.fees_installment_id AND f.student_id = g.student_id
     JOIN beta.fees_installments k ON k.id = b.fees_installment_id
     JOIN beta.installments h ON h.id = k.installment_id
     LEFT JOIN ( SELECT sum(payments_invoices_fees_installments.amount) AS total_payment_invoice_amount,
            payments_invoices_fees_installments.invoices_fees_installment_id
           FROM beta.payments_invoices_fees_installments
          GROUP BY payments_invoices_fees_installments.invoices_fees_installment_id) c ON c.invoices_fees_installment_id = b.id
     LEFT JOIN ( SELECT sum(advance_payments_invoices_fees_installments.amount) AS total_advance_invoice_fee_amount,
            advance_payments_invoices_fees_installments.invoices_fees_installments_id
           FROM beta.advance_payments_invoices_fees_installments
          GROUP BY advance_payments_invoices_fees_installments.invoices_fees_installments_id) d ON d.invoices_fees_installments_id = b.id
     LEFT JOIN beta.discount_fees_installments e ON e.fees_installment_id = b.fees_installment_id AND g.student_id = e.student_id
     LEFT JOIN beta.advance_payment_balance r ON r.fee_id = 1000 AND r.student_id = g.student_id
  WHERE k.fee_id = 1000
  ORDER BY h.start_date;

ALTER TABLE beta.next_year_transport_invoices_fees_installments_balance
    OWNER TO postgres;


CREATE OR REPLACE VIEW beta.next_year_invoice_balances
 AS
 SELECT next_year_transport_invoices_fees_installments_balance.student_id,
    next_year_transport_invoices_fees_installments_balance.created_at,
    next_year_transport_invoices_fees_installments_balance.total_amount,
    next_year_transport_invoices_fees_installments_balance.total_payment_invoice_fee_amount,
    next_year_transport_invoices_fees_installments_balance.total_advance_invoice_fee_amount,
    next_year_transport_invoices_fees_installments_balance.discount_amount,
    next_year_transport_invoices_fees_installments_balance.fees_installment_id,
    next_year_transport_invoices_fees_installments_balance.installment_id,
    next_year_transport_invoices_fees_installments_balance.start_date,
    next_year_transport_invoices_fees_installments_balance.academic_year_id,
    next_year_transport_invoices_fees_installments_balance.fee_id,
    next_year_transport_invoices_fees_installments_balance.id,
    next_year_transport_invoices_fees_installments_balance.invoice_id,
    COALESCE(next_year_transport_invoices_fees_installments_balance.total_amount, 0::numeric) - COALESCE(next_year_transport_invoices_fees_installments_balance.total_payment_invoice_fee_amount, 0::numeric) - COALESCE(next_year_transport_invoices_fees_installments_balance.total_advance_invoice_fee_amount, 0::numeric) - COALESCE(next_year_transport_invoices_fees_installments_balance.discount_amount, 0::numeric) AS balance
   FROM beta.next_year_transport_invoices_fees_installments_balance
UNION ALL
 SELECT next_year_invoices_fees_installments_balance.student_id,
    next_year_invoices_fees_installments_balance.created_at,
    next_year_invoices_fees_installments_balance.total_amount,
    next_year_invoices_fees_installments_balance.total_payment_invoice_fee_amount,
    next_year_invoices_fees_installments_balance.total_advance_invoice_fee_amount,
    next_year_invoices_fees_installments_balance.discount_amount,
    next_year_invoices_fees_installments_balance.fees_installment_id,
    next_year_invoices_fees_installments_balance.installment_id,
    next_year_invoices_fees_installments_balance.start_date,
    next_year_invoices_fees_installments_balance.academic_year_id,
    next_year_invoices_fees_installments_balance.fee_id,
    next_year_invoices_fees_installments_balance.id,
    next_year_invoices_fees_installments_balance.invoice_id,
    COALESCE(next_year_invoices_fees_installments_balance.total_amount, 0::numeric) - COALESCE(next_year_invoices_fees_installments_balance.total_payment_invoice_fee_amount, 0::numeric) - COALESCE(next_year_invoices_fees_installments_balance.total_advance_invoice_fee_amount, 0::numeric) - COALESCE(next_year_invoices_fees_installments_balance.discount_amount, 0::numeric) AS balance
   FROM beta.next_year_invoices_fees_installments_balance;

ALTER TABLE beta.next_year_invoice_balances
    OWNER TO postgres;





CREATE OR REPLACE VIEW beta.next_year_transport_installment_detail
 AS
 SELECT a.student_id,
    a.vehicle_id,
    a.is_oneway,
        CASE
            WHEN a.is_oneway = 0 THEN b.amount
            ELSE b.amount * 0.5::numeric(10,2)
        END AS amount,
    b.fees_installment_id
   FROM beta.tmembers a
     JOIN beta.transport_routes d ON d.id = a.transport_route_id
     JOIN beta.transport_routes_fees_installments b ON a.transport_route_id = b.transport_route_id
     JOIN beta.fees_installments c ON c.id = b.fees_installment_id
     JOIN beta.installments e ON e.id = c.installment_id
     JOIN beta.student_archive s ON s.student_id = a.student_id AND e.academic_year_id <> s.academic_year_id
  GROUP BY a.student_id, a.vehicle_id, a.is_oneway, b.amount, b.fees_installment_id, e.id;

ALTER TABLE beta.next_year_transport_installment_detail
    OWNER TO postgres;


-- View: beta.payment_distribution_status

-- DROP VIEW beta.payment_distribution_status;

CREATE OR REPLACE VIEW beta.payment_distribution_status
 AS
 SELECT
        CASE
            WHEN (a.amount - COALESCE(b.amount, 0::numeric) - COALESCE(c.amount, 0::numeric) - COALESCE(d.amount, 0::numeric)) > 0::numeric THEN 0
            ELSE 1
        END AS status,
    a.status AS type,
    a.id,
    a.student_id,
    a.amount AS original_amount,
    a.date,
    a.amount - (COALESCE(b.amount, 0::numeric) + COALESCE(c.amount, 0::numeric) + COALESCE(d.amount, 0::numeric)) AS undistributed_amount
   FROM beta.payments a
     LEFT JOIN ( SELECT sum(advance_payments.amount) AS amount,
            advance_payments.payment_id
           FROM beta.advance_payments
          GROUP BY advance_payments.payment_id) b ON b.payment_id = a.id
     LEFT JOIN ( SELECT sum(due_amounts_payments.amount) AS amount,
            due_amounts_payments.payment_id
           FROM beta.due_amounts_payments
          GROUP BY due_amounts_payments.payment_id) c ON c.payment_id = a.id
     LEFT JOIN ( SELECT sum(payments_invoices_fees_installments.amount) AS amount,
            payments_invoices_fees_installments.payment_id
           FROM beta.payments_invoices_fees_installments
          GROUP BY payments_invoices_fees_installments.payment_id) d ON d.payment_id = a.id;

ALTER TABLE beta.payment_distribution_status
    OWNER TO postgres;

-- View: beta.product_items_balance

-- DROP VIEW beta.product_items_balance;

CREATE OR REPLACE VIEW beta.product_items_balance
 AS
 SELECT
        CASE
            WHEN a.from_warehouse_id = b.warehouse_id THEN 0::numeric - a.quantity::numeric
            ELSE a.quantity::numeric
        END AS quantity,
    b.id AS product_alert_quantity_id,
    b.warehouse_id,
    a.date,
    2 AS status
   FROM beta.warehouse_transfers a
     JOIN beta.product_alert_quantity b ON b.id = a.product_alert_quantity_id
UNION ALL
 SELECT a.quantity,
    b.id AS product_alert_quantity_id,
    b.warehouse_id,
    a.date,
    1 AS status
   FROM beta.product_purchases a
     JOIN beta.product_alert_quantity b ON b.id = a.product_alert_id
UNION ALL
 SELECT 0::double precision - a.quantity AS quantity,
    b.id AS product_alert_quantity_id,
    b.warehouse_id,
    a.date,
    3 AS status
   FROM beta.product_sales a
     JOIN beta.product_alert_quantity b ON b.id = a.product_alert_id
UNION ALL
 SELECT
        CASE
            WHEN b.open_blance IS NULL THEN 0::double precision
            ELSE b.open_blance
        END AS quantity,
    b.id AS product_alert_quantity_id,
    b.warehouse_id,
    b.created_at AS date,
    4 AS status
   FROM beta.product_alert_quantity b;

ALTER TABLE beta.product_items_balance
    OWNER TO postgres;

-- View: beta.product_quantities

-- DROP VIEW beta.product_quantities;

CREATE OR REPLACE VIEW beta.product_quantities
 AS
 SELECT b.id,
    a.name AS category,
    b.name,
    b.note,
    b.alert_quantity,
    c.account_group_id,
    c.financial_category_id,
    c.name AS inventory,
    e.name AS metrics,
    e.abbreviation,
    b.open_blance + COALESCE(( SELECT sum(product_purchases.quantity) AS sum
           FROM beta.product_purchases
          WHERE product_purchases.product_alert_id = b.id), 0::bigint::double precision) AS total_quantity,
    b.open_blance + COALESCE(( SELECT sum(product_purchases.quantity) AS sum
           FROM beta.product_purchases
          WHERE product_purchases.product_alert_id = b.id), 0::bigint::double precision) - COALESCE(( SELECT sum(product_sales.quantity) AS sum
           FROM beta.product_sales
          WHERE product_sales.product_alert_id = b.id), 0::bigint::double precision) AS remain_quantity
   FROM beta.product_alert_quantity b
     LEFT JOIN constant.product_registers a ON a.id = b.product_register_id
     LEFT JOIN beta.refer_expense c ON c.id = b.refer_expense_id
     LEFT JOIN constant.metrics e ON e.id = b.metric_id;

ALTER TABLE beta.product_quantities
    OWNER TO postgres;

-- View: beta.revenue_view

-- DROP VIEW beta.revenue_view;

CREATE OR REPLACE VIEW beta.revenue_view
 AS
 SELECT a.id,
    a.created_at,
    a.date,
    a.note,
    b.amount,
    a.user_id,
    a.number,
    a.user_in_shulesoft,
    a.invoice_number,
    a.payment_method,
    a.bank_account_id,
    a.transaction_id,
    a.user_table,
    a.payer_name,
    a.payer_phone,
    a.payment_type_id,
    b.refer_expense_id
   FROM beta.revenues a
     JOIN beta.revenue_cart b ON b.revenue_id = a.id
UNION ALL
 SELECT a.id,
    a.created_at,
    a.date,
    a.note,
    b.amount,
    a.user_id,
    a.number,
    a.user_in_shulesoft,
    a.invoice_number,
    a.payment_method,
    a.bank_account_id,
    a.transaction_id,
    a.user_table,
    a.payer_name,
    a.payer_phone,
    a.payment_type_id,
    c.refer_expense_id
   FROM beta.revenues a
     JOIN beta.product_cart b ON a.id = b.revenue_id
     JOIN beta.product_alert_quantity c ON c.id = b.product_alert_id;

ALTER TABLE beta.revenue_view
    OWNER TO postgres;

-- View: beta.school_fees

-- DROP VIEW beta.school_fees;

CREATE OR REPLACE VIEW beta.school_fees
 AS
 SELECT a.round,
    a.class_id,
    b.classes
   FROM ( SELECT round(sum(fees_installments_classes.amount), 0) AS round,
            fees_installments_classes.class_id
           FROM beta.fees_installments_classes
          WHERE (fees_installments_classes.fees_installment_id IN ( SELECT fees_installments.id
                   FROM beta.fees_installments
                  WHERE (fees_installments.installment_id IN ( SELECT installments.id
                           FROM beta.installments
                          WHERE (installments.academic_year_id IN ( SELECT academic_year.id
                                   FROM beta.academic_year
                                  WHERE academic_year.name::text = '2020'::text))))))
          GROUP BY fees_installments_classes.class_id) a
     JOIN beta.classes b ON b."classesID" = a.class_id;

ALTER TABLE beta.school_fees
    OWNER TO postgres;

CREATE OR REPLACE VIEW beta.school_price
 AS
 SELECT count(a.*)::numeric * b.price_per_student::numeric
   FROM beta.student a,
    beta.setting b
  WHERE a.status = 1
  GROUP BY b.price_per_student;

ALTER TABLE beta.school_price
    OWNER TO postgres;

-- View: beta.student_ages

-- DROP VIEW beta.student_ages;

CREATE OR REPLACE VIEW beta.student_ages
 AS
 SELECT upper("left"(b.sex::text, 1)) AS sex,
    a."classesID",
    a.classes,
    count(date_part('year'::text, b.dob)) AS total,
    date_part('year'::text, age(b.dob::timestamp with time zone)) AS age
   FROM beta.classes a
     JOIN beta.student b ON a."classesID" = b."classesID"
  WHERE b.status = 1
  GROUP BY (upper("left"(b.sex::text, 1))), (date_part('year'::text, age(b.dob::timestamp with time zone))), a."classesID", a.classes
  ORDER BY a.classes;

ALTER TABLE beta.student_ages
    OWNER TO postgres;

-- View: beta.student_all_fees_subscribed

-- DROP VIEW beta.student_all_fees_subscribed;

CREATE OR REPLACE VIEW beta.student_all_fees_subscribed
 AS
 SELECT a.id AS fees_installment_id,
    a.fee_id,
    a.installment_id,
    b.class_id,
    e.student_id,
    e.academic_year_id
   FROM beta.fees_installments a
     JOIN beta.fees_installments_classes b ON a.id = b.fees_installment_id
     JOIN beta.installments c ON c.id = a.installment_id
     JOIN beta.section d ON d."classesID" = b.class_id
     JOIN beta.student_archive e ON e.section_id = d."sectionID"
  WHERE NOT (EXISTS ( SELECT 1
           FROM beta.student_fees_installments_unsubscriptions f
          WHERE f.fees_installment_id = a.id AND f.student_id = e.student_id));

ALTER TABLE beta.student_all_fees_subscribed
    OWNER TO postgres;

-- View: beta.student_classes

-- DROP VIEW beta.student_classes;

CREATE OR REPLACE VIEW beta.student_classes
 AS
 SELECT count(a.*) AS count,
    b.classes
   FROM beta.student a
     JOIN beta.classes b ON b."classesID" = a."classesID"
  WHERE a.status = 1
  GROUP BY b.classes;

ALTER TABLE beta.student_classes
    OWNER TO postgres;

-- View: beta.student_exams

-- DROP VIEW beta.student_exams;

CREATE OR REPLACE VIEW beta.student_exams
 AS
 SELECT DISTINCT mark."examID",
    mark.academic_year_id,
    mark."classesID",
    mark.student_id
   FROM beta.mark
  WHERE mark.mark IS NOT NULL;

ALTER TABLE beta.student_exams
    OWNER TO postgres;

-- View: beta.student_gps

-- DROP VIEW beta.student_gps;

CREATE OR REPLACE VIEW beta.student_gps
 AS
 SELECT c.parent_id,
    g.phone,
    b.name,
    b.lat,
    b.lng,
    a.transport_route_id,
    d.imeis
   FROM beta.tmembers a
     JOIN beta.student b ON b.student_id = a.student_id
     JOIN beta.student_parents c ON c.student_id = b.student_id
     JOIN beta.vehicles d ON d.id = a.vehicle_id
     JOIN beta.installments e ON e.id = a.installment_id
     JOIN beta.academic_year f ON f.id = e.academic_year_id
     JOIN beta.parent g ON g."parentID" = c.parent_id
  WHERE date_part('year'::text, f.start_date) = date_part('year'::text, CURRENT_DATE);

ALTER TABLE beta.student_gps
    OWNER TO postgres;

-- View: beta.student_next_class

-- DROP VIEW beta.student_next_class;

CREATE OR REPLACE VIEW beta.student_next_class
 AS
 SELECT a.student_id,
    ( SELECT academic_year.id
           FROM academic_year
          WHERE academic_year.id > (( SELECT student.academic_year_id
                   FROM student
                  WHERE student.student_id = a.student_id AND student.status = 1)) AND (academic_year.class_level_id IN ( SELECT classes.classlevel_id
                   FROM classes
                  WHERE classes."classesID" = (( SELECT student."classesID"
                           FROM student
                          WHERE student.student_id = a.student_id))))
         LIMIT 1) AS next_academic_year_id,
    ( SELECT section."sectionID"
           FROM section
          WHERE (section."classesID" IN ( SELECT classes."classesID"
                   FROM classes
                  WHERE classes.classes_numeric = (( SELECT classes_1.classes_numeric + 1
                           FROM classes classes_1
                          WHERE classes_1."classesID" = (( SELECT student."classesID"
                                   FROM student
                                  WHERE student.student_id = a.student_id)))) AND classes.classlevel_id = (( SELECT classes_1.classlevel_id
                           FROM classes classes_1
                          WHERE classes_1."classesID" = (( SELECT student."classesID"
                                   FROM student
                                  WHERE student.student_id = a.student_id)))) AND section.section::text ~~ (('%'::text || ((( SELECT section_1.section
                           FROM section section_1
                          WHERE (section_1."sectionID" IN ( SELECT student_archive.section_id
                                   FROM student_archive
                                  WHERE student_archive.student_id = a.student_id
                                 LIMIT 1))))::text)) || '%'::text)))
         LIMIT 1) AS next_section_id,
    ( SELECT section."classesID"
           FROM section
          WHERE (section."classesID" IN ( SELECT classes."classesID"
                   FROM classes
                  WHERE classes.classes_numeric = (( SELECT classes_1.classes_numeric + 1
                           FROM classes classes_1
                          WHERE classes_1."classesID" = (( SELECT student."classesID"
                                   FROM student
                                  WHERE student.student_id = a.student_id)))) AND classes.classlevel_id = (( SELECT classes_1.classlevel_id
                           FROM classes classes_1
                          WHERE classes_1."classesID" = (( SELECT student."classesID"
                                   FROM student
                                  WHERE student.student_id = a.student_id))))))
         LIMIT 1) AS next_class_id,
    1 AS status
   FROM student_archive a
  WHERE a.status = 1;

ALTER TABLE beta.student_next_class
    OWNER TO postgres;

-- View: beta.student_next_year_all_fees_subscribed

-- DROP VIEW beta.student_next_year_all_fees_subscribed;

CREATE OR REPLACE VIEW beta.student_next_year_all_fees_subscribed
 AS
 SELECT a.id AS fees_installment_id,
    a.fee_id,
    a.installment_id,
    e.classes_numeric + 1 AS classes_numeric,
    b.class_id,
    c.academic_year_id,
    d.student_id
   FROM beta.fees_installments a
     JOIN beta.fees_installments_classes b ON a.id = b.fees_installment_id
     JOIN beta.installments c ON c.id = a.installment_id
     JOIN beta.student d ON d."classesID" = b.class_id AND d.status = 1
     JOIN beta.classes e ON e."classesID" = d."classesID"
  WHERE NOT (EXISTS ( SELECT 1
           FROM beta.student_fees_installments_unsubscriptions f
          WHERE f.fees_installment_id = a.id AND f.student_id = d.student_id));

ALTER TABLE beta.student_next_year_all_fees_subscribed
    OWNER TO postgres;

-- View: beta.student_parents_info

-- DROP VIEW beta.student_parents_info;

CREATE OR REPLACE VIEW beta.student_parents_info
 AS
 SELECT a.name AS student_name,
    b.classes,
    c.name AS parent_name,
    c.phone,
    c.email,
    a.status,
    a.username AS student_username,
    c.username AS parent_username,
    c.default_password
   FROM beta.student a
     JOIN beta.classes b ON b."classesID" = a."classesID"
     JOIN beta.student_parents d ON d.student_id = a.student_id
     JOIN beta.parent c ON c."parentID" = d.parent_id;

ALTER TABLE beta.student_parents_info
    OWNER TO postgres;

-- View: beta.student_remain_balances

-- DROP VIEW beta.student_remain_balances;

CREATE OR REPLACE VIEW beta.student_remain_balances
 AS
 SELECT COALESCE(a.amount, 0::numeric) - COALESCE(c.total_payment_invoice_amount, 0::numeric) - COALESCE(d.total_advance_invoice_fee_amount, 0::numeric) - COALESCE(e.amount, 0::numeric) AS amount_remain,
    f.student_id,
    i.id AS fee_id,
    f.id AS invoice_id,
    h.academic_year_id
   FROM beta.fees_installments_classes a
     JOIN beta.invoices_fees_installments b ON b.fees_installment_id = a.fees_installment_id
     JOIN beta.invoices f ON f.id = b.invoice_id
     JOIN beta.fees_installments g ON g.id = a.fees_installment_id
     JOIN beta.installments h ON h.id = g.installment_id
     JOIN beta.fees i ON i.id = g.fee_id
     LEFT JOIN ( SELECT sum(x.amount) AS total_payment_invoice_amount,
            x.invoices_fees_installment_id
           FROM beta.payments_invoices_fees_installments x
          WHERE (x.payment_id IN ( SELECT payments.id
                   FROM beta.payments))
          GROUP BY x.invoices_fees_installment_id) c ON c.invoices_fees_installment_id = b.id
     LEFT JOIN ( SELECT sum(y.amount) AS total_advance_invoice_fee_amount,
            y.invoices_fees_installments_id
           FROM beta.advance_payments_invoices_fees_installments y
          GROUP BY y.invoices_fees_installments_id) d ON d.invoices_fees_installments_id = b.id
     LEFT JOIN beta.discount_fees_installments e ON e.fees_installment_id = a.fees_installment_id AND f.student_id = e.student_id
  ORDER BY h.start_date, i.priority;

ALTER TABLE beta.student_remain_balances
    OWNER TO postgres;

-- View: beta.student_statisctical_report

-- DROP VIEW beta.student_statisctical_report;

CREATE OR REPLACE VIEW beta.student_statisctical_report
 AS
 SELECT a.academic_year_id,
    b.name,
    c.classes,
    d.id AS status_id,
    d.reason,
    count(a.student_id) AS total_student
   FROM beta.student a
     JOIN constant.student_status d ON d.id = a.status_id
     JOIN beta.academic_year b ON b.id = a.academic_year_id
     JOIN beta.classes c ON c."classesID" = a."classesID"
  GROUP BY a.academic_year_id, b.name, d.reason, c.classes, d.id
  ORDER BY a.academic_year_id;

ALTER TABLE beta.student_statisctical_report
    OWNER TO postgres;

-- View: beta.student_subject_option

-- DROP VIEW beta.student_subject_option;

CREATE OR REPLACE VIEW beta.student_subject_option
 AS
 SELECT DISTINCT m.subject_id,
    m.student_id,
    s.subject,
    'Option'::character varying AS subject_type,
    s.is_counted,
    s.is_penalty,
    s.pass_mark,
    s.grade_mark,
    m.academic_year_id,
    s."classesID" AS class_id,
    s.is_counted_indivision,
    c.section_id,
    ( SELECT d."teacherID" AS teacher_id
           FROM beta.section_subject_teacher d
          WHERE d.subject_id = m.subject_id AND d.academic_year_id = c.academic_year_id AND d."sectionID" = c.section_id
         LIMIT 1) AS teacher_id,
    r.arrangement,
    r.code,
    ma."examID"
   FROM beta.subject_student m
     JOIN beta.subject s ON s."subjectID" = m.subject_id
     JOIN beta.refer_subject r ON r.subject_id = s.subject_id
     JOIN beta.student_archive c ON c.student_id = m.student_id
     JOIN beta.mark ma ON s."subjectID" = ma."subjectID"
     JOIN beta.exam ex ON ex."examID" = ma."examID"
     JOIN beta.semester se ON ex.semester_id = se.id AND se.academic_year_id = ma.academic_year_id AND m.academic_year_id = c.academic_year_id AND ma.student_id = m.student_id AND ma.academic_year_id = c.academic_year_id AND ma.student_id = c.student_id AND ma.student_id = m.student_id AND ma."classesID" = s."classesID" AND ma.mark IS NOT NULL;

ALTER TABLE beta.student_subject_option
    OWNER TO postgres;

-- View: beta.student_total_subject

-- DROP VIEW beta.student_total_subject;


-- View: beta.subject_count

-- DROP VIEW beta.subject_count;

CREATE OR REPLACE VIEW beta.subject_count
 AS
 SELECT m.subject_id,
    m.student_id,
    s.subject,
    'Option'::character varying AS subject_type,
    s.is_counted,
    s.is_penalty,
    s.pass_mark,
    s.grade_mark,
    m.academic_year_id,
    s."classesID" AS class_id,
    s.is_counted_indivision,
    c.section_id,
    ( SELECT d."teacherID" AS teacher_id
           FROM beta.section_subject_teacher d
          WHERE d.subject_id = m.subject_id AND d.academic_year_id = c.academic_year_id AND d."sectionID" = c.section_id
         LIMIT 1) AS teacher_id,
    r.arrangement,
    r.code
   FROM beta.subject_student m
     JOIN beta.subject s ON s."subjectID" = m.subject_id
     JOIN beta.refer_subject r ON r.subject_id = s.subject_id
     JOIN beta.student_archive c ON c.student_id = m.student_id AND m.academic_year_id = c.academic_year_id
     JOIN beta.section t ON t."sectionID" = c.section_id AND s."classesID" = t."classesID"
UNION
 SELECT a.subject_id,
    c.student_id,
    s.subject,
    'Core'::character varying AS subject_type,
    s.is_counted,
    s.is_penalty,
    s.pass_mark,
    s.grade_mark,
    c.academic_year_id,
    s."classesID" AS class_id,
    s.is_counted_indivision,
    a.section_id,
    ( SELECT d."teacherID" AS teacher_id
           FROM beta.section_subject_teacher d
          WHERE d.subject_id = a.subject_id AND d.academic_year_id = c.academic_year_id AND d."sectionID" = a.section_id
         LIMIT 1) AS teacher_id,
    r.arrangement,
    r.code
   FROM beta.subject_section a
     JOIN beta.student_archive c ON c.section_id = a.section_id
     JOIN beta.subject s ON s."subjectID" = a.subject_id AND (a.section_id IN ( SELECT section."sectionID"
           FROM beta.section
          WHERE (section."classesID" IN ( SELECT subject."classesID"
                   FROM beta.subject
                  WHERE subject."subjectID" = a.subject_id))))
     JOIN beta.refer_subject r ON r.subject_id = s.subject_id;

CREATE OR REPLACE VIEW beta.student_total_subject
 AS
 SELECT count(*) AS subject_count,
    a.student_id,
    a.academic_year_id,
    a.class_id
   FROM beta.subject_count a
  GROUP BY a.student_id, a.academic_year_id, a.class_id;

ALTER TABLE beta.student_total_subject
    OWNER TO postgres;


CREATE OR REPLACE VIEW beta.subject_mark_info
 AS
 SELECT a.student_id,
    d.name,
    d.roll,
    c.subject_name,
    a.grade_mark,
    a.id,
    a.effort_mark,
    a.achievement_mark,
    a."classesID",
    e.section_id AS "sectionID",
    a."examID",
    a."subjectID",
    b.is_counted,
    b.is_penalty,
    b.pass_mark,
    a.academic_year_id
   FROM beta.subject_mark a
     JOIN beta.subject b ON b."subjectID" = a."subjectID"
     JOIN beta.refer_subject c ON c.subject_id = b.subject_id
     JOIN beta.student d ON d.student_id = a.student_id
     JOIN beta.student_archive e ON a.student_id = e.student_id AND a.academic_year_id = e.academic_year_id
  WHERE a.grade_mark IS NOT NULL AND a.effort_mark IS NOT NULL AND a.achievement_mark IS NOT NULL;

ALTER TABLE beta.subject_mark_info
    OWNER TO postgres;

-- View: beta.subjects_excluded

-- DROP VIEW beta.subjects_excluded;

CREATE OR REPLACE VIEW beta.subjects_excluded
 AS
 SELECT a.student_id,
    a."examID" AS exam_id,
    count(a."subjectID") AS subjects_excluded,
    sum(a.mark) AS total
   FROM beta.mark a
     JOIN beta.subject b ON b."subjectID" = a."subjectID"
  WHERE b.is_counted = 0
  GROUP BY a.student_id, a."examID"
  ORDER BY a.student_id;

ALTER TABLE beta.subjects_excluded
    OWNER TO postgres;

-- View: beta.sum_exam_average

-- DROP VIEW beta.sum_exam_average;

CREATE OR REPLACE VIEW beta.sum_exam_average
 AS
 SELECT sum(a.mark) -
        CASE
            WHEN s.total IS NULL THEN 0::numeric
            ELSE s.total
        END AS sum,
    a."examID",
    a.student_id,
    b.subject_count -
        CASE
            WHEN s.subjects_excluded IS NULL THEN 0::bigint
            ELSE s.subjects_excluded
        END AS subject_count,
    round((sum(a.mark) -
        CASE
            WHEN s.total IS NULL THEN 0::numeric
            ELSE s.total
        END) / (b.subject_count::numeric -
        CASE
            WHEN s.subjects_excluded IS NULL THEN 0::bigint
            ELSE s.subjects_excluded
        END::numeric), 1) AS average,
    b.academic_year_id,
    a."classesID"
   FROM beta.mark_info a
     JOIN beta.student_total_subject b ON b.student_id = a.student_id
     LEFT JOIN beta.subjects_excluded s ON s.exam_id = a."examID" AND s.student_id = a.student_id
  WHERE a.academic_year_id = b.academic_year_id
  GROUP BY a."examID", a.student_id, b.subject_count, b.academic_year_id, a."classesID", s.subjects_excluded, s.total;

ALTER TABLE beta.sum_exam_average
    OWNER TO postgres;

-- View: beta.sum_exam_average_done

-- DROP VIEW beta.sum_exam_average_done;

CREATE OR REPLACE VIEW beta.sum_exam_average_done
 AS
 SELECT count(mark_info."subjectID") AS subject_count,
    mark_info.student_id,
    mark_info."examID",
    sum(mark_info.mark) AS sum,
    mark_info.academic_year_id,
    round(sum(mark_info.mark) / count(mark_info."subjectID")::numeric, 1) AS average,
    mark_info."classesID",
    mark_info.global_exam_id,
    mark_info.refer_class_id
   FROM beta.mark_info
  WHERE mark_info.is_counted = 1 AND mark_info.mark IS NOT NULL
  GROUP BY mark_info."examID", mark_info.academic_year_id, mark_info.student_id, mark_info."classesID", mark_info.global_exam_id, mark_info.refer_class_id;

ALTER TABLE beta.sum_exam_average_done
    OWNER TO postgres;

-- View: beta.sum_rank

-- DROP VIEW beta.sum_rank;

CREATE OR REPLACE VIEW beta.sum_rank
 AS
 SELECT a."examID",
    a."classesID",
    a.student_id,
    a."subjectID",
    c.is_counted,
    c.is_penalty,
    sum(a.mark) AS sum,
    rank() OVER (ORDER BY (sum(a.mark)) DESC) AS rank
   FROM beta.mark a
     JOIN beta.subject c ON c."subjectID" = a."subjectID"
  WHERE a.mark IS NOT NULL
  GROUP BY a."examID", a."classesID", a.student_id, a."subjectID", c.is_counted, c.is_penalty;

ALTER TABLE beta.sum_rank
    OWNER TO postgres;

-- View: beta.teacher_on_duty

-- DROP VIEW beta.teacher_on_duty;

CREATE OR REPLACE VIEW beta.teacher_on_duty
 AS
 SELECT a.name,
    a.phone,
    a.email,
    b.duty_id
   FROM beta.teacher a
     JOIN beta.teacher_duties b ON b.teacher_id = a."teacherID"
     JOIN beta.duties c ON c.id = b.duty_id
  WHERE c.start_date <= now() AND c.end_date >= now();

ALTER TABLE beta.teacher_on_duty
    OWNER TO postgres;

-- View: beta.total_current_assets

-- DROP VIEW beta.total_current_assets;

CREATE OR REPLACE VIEW beta.total_current_assets
 AS
 SELECT p.id,
    p.amount,
    p.created_at,
    p.date,
    p.payment_method,
    p.transaction_id,
    5 AS is_payment,
    p.bank_account_id,
    p.user_id,
    p.user_table,
    p.payer_name,
    p.note,
    p.reconciled,
    p.bank_name,
    p.account_number,
    p.currency,
    p.account_name
   FROM ( SELECT a.id,
            a.amount,
            b.created_at,
            a.date,
            NULL::text AS payment_method,
            a.transaction_id,
            5 AS is_payment,
            b.predefined AS bank_account_id,
            a."userID" AS user_id,
            'user'::text AS user_table,
            ( SELECT "user".name
                   FROM beta."user"
                  WHERE "user"."userID" = a."userID") AS payer_name,
            a.note,
            0 AS reconciled,
            d.name AS bank_name,
            d.number AS account_number,
            d.currency,
            d.name AS account_name
           FROM beta.current_assets a
             LEFT JOIN beta.refer_expense b ON a.to_refer_expense_id = b.id
             LEFT JOIN beta.bank_accounts d ON d.id = b.predefined) p
UNION ALL
 SELECT e.id,
    e.amount,
    e.created_at,
    e.date,
    e.payment_method,
    e.transaction_id,
    5 AS is_payment,
    e.predefined AS bank_account_id,
    e."userID" AS user_id,
    'user'::text AS user_table,
    ( SELECT "user".name
           FROM beta."user"
          WHERE "user"."userID" = e."userID") AS payer_name,
    e.note,
    e.reconciled,
    e.bank_name,
    e.account_number,
    e.currency,
    e.account_name
   FROM ( SELECT
                CASE
                    WHEN a.from_refer_expense_id = b.id THEN 0::numeric - a.amount
                    ELSE a.amount
                END AS amount,
            a.id,
            b.created_at,
            a.note,
            a.date,
            NULL::text AS payment_method,
            a.transaction_id,
            b.predefined,
            a."userID",
            0 AS reconciled,
            d.name AS bank_name,
            d.number AS account_number,
            d.currency,
            d.name AS account_name
           FROM beta.current_assets a
             JOIN beta.refer_expense b ON b.id = a.from_refer_expense_id
             JOIN beta.bank_accounts d ON d.id = b.predefined) e;

ALTER TABLE beta.total_current_assets
    OWNER TO postgres;

-- View: beta.total_expenses

-- DROP VIEW beta.total_expenses;

CREATE OR REPLACE VIEW beta.total_expenses
 AS
 SELECT a."expenseID" AS id,
    a.amount,
    a.created_at,
    a.date,
    a.payment_method,
    a.transaction_id,
    2 AS is_payment,
    a.bank_account_id,
    a."userID" AS user_id,
    'user'::text AS user_table,
    ( SELECT "user".name
           FROM beta."user"
          WHERE "user"."userID" = a."userID") AS payer_name,
    a.note,
    a.reconciled,
    a.payment_type_id,
    r.name AS bank_name,
    b.number AS account_number,
    b.currency,
    b.name AS account_name
   FROM beta.expense a
     LEFT JOIN beta.bank_accounts b ON b.id = a.bank_account_id
     JOIN constant.refer_banks r ON r.id = b.refer_bank_id;

ALTER TABLE beta.total_expenses
    OWNER TO postgres;

-- View: beta.total_financial_categories

-- DROP VIEW beta.total_financial_categories;

CREATE OR REPLACE VIEW beta.total_financial_categories
 AS
 SELECT d.bank_account_id,
    d.payment_type_id,
    d.amount,
    d.note,
    d.financial_category_id,
    d.date
   FROM ( SELECT a.bank_account_id,
            a.date,
            a.note,
            b.financial_category_id,
            a.payment_type_id,
            sum(
                CASE
                    WHEN b.financial_category_id = ANY (ARRAY[4, 5, 6, 7]) THEN 0::numeric - COALESCE(a.amount, 0::numeric)
                    ELSE a.amount
                END) AS amount
           FROM beta.expense a
             JOIN beta.refer_expense b ON b.id = a.refer_expense_id
          GROUP BY a.bank_account_id, a.date, a.note, a.payment_type_id, b.financial_category_id) d
UNION ALL
 SELECT rev.bank_account_id,
    rev.payment_type_id,
    rev.amount,
    rev.note,
    re.financial_category_id,
    rev.date
   FROM beta.revenues rev
     JOIN beta.refer_expense re ON rev.refer_expense_id = re.id;

ALTER TABLE beta.total_financial_categories
    OWNER TO postgres;

-- View: beta.total_fixed_assets

-- DROP VIEW beta.total_fixed_assets;

CREATE OR REPLACE VIEW beta.total_fixed_assets
 AS
 SELECT b."expenseID" AS id,
    b.amount,
    b.created_at,
    b.date,
    b.payment_method,
    b.transaction_id,
    6 AS is_payment,
    b.bank_account_id,
    b."userID" AS user_id,
    'user'::text AS user_table,
    ( SELECT "user".name
           FROM beta."user"
          WHERE "user"."userID" = b."userID") AS payer_name,
    a.note,
    b.reconciled,
    b.payment_type_id,
    c.name AS bank_name,
    c.number AS account_number,
    c.currency,
    c.name AS account_name
   FROM beta.refer_expense a
     JOIN beta.expense b ON b.refer_expense_id = a.id
     LEFT JOIN beta.bank_accounts c ON b.bank_account_id = c.id
  WHERE a.financial_category_id = 4;

ALTER TABLE beta.total_fixed_assets
    OWNER TO postgres;

-- View: beta.total_liabilities

-- DROP VIEW beta.total_liabilities;

CREATE OR REPLACE VIEW beta.total_liabilities
 AS
 SELECT b."expenseID" AS id,
    b.amount,
    b.created_at,
    b.date,
    b.payment_method,
    b.transaction_id,
    6 AS is_payment,
    b.bank_account_id,
    b."userID" AS user_id,
    'user'::text AS user_table,
    ( SELECT "user".name
           FROM beta."user"
          WHERE "user"."userID" = b."userID") AS payer_name,
    a.note,
    b.reconciled,
    b.payment_type_id,
    c.name AS bank_name,
    c.number AS account_number,
    c.currency,
    c.name AS account_name
   FROM beta.refer_expense a
     JOIN beta.expense b ON b.refer_expense_id = a.id
     LEFT JOIN beta.bank_accounts c ON b.bank_account_id = c.id
  WHERE a.financial_category_id = 6;

ALTER TABLE beta.total_liabilities
    OWNER TO postgres;

-- View: beta.total_mark

-- DROP VIEW beta.total_mark;

CREATE OR REPLACE VIEW beta.total_mark
 AS
 SELECT sum(mark.mark) AS total,
    mark.student_id,
    mark."examID",
    mark.year,
    mark."classesID"
   FROM beta.mark
  GROUP BY mark.student_id, mark."examID", mark."classesID", mark.year;

ALTER TABLE beta.total_mark
    OWNER TO postgres;

-- View: beta.total_revenues

-- DROP VIEW beta.total_revenues;

CREATE OR REPLACE VIEW beta.total_revenues
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
           FROM beta.revenues
        UNION
         SELECT payments.id,
            payments.amount,
            payments.created_at,
            payments.date AS payment_date,
            ( SELECT payment_types.name
                   FROM beta.payment_types
                  WHERE payment_types.id = payments.payment_type_id) AS payments_method,
            payments.transaction_id,
            1 AS is_payment,
            payments.bank_account_id,
            payments.student_id AS user_id,
            payments.payment_type_id,
            'student'::character varying AS user_table,
            ( SELECT student.name
                   FROM beta.student
                  WHERE student.student_id = payments.student_id
                 LIMIT 1) AS payer_name,
            payments.payer_name,
            payments.reconciled
           FROM beta.payments) a
     LEFT JOIN beta.bank_accounts b ON b.id = a.bank_account_id;

ALTER TABLE beta.total_revenues
    OWNER TO postgres;

-- View: beta.total_transactions

-- DROP VIEW beta.total_transactions;

CREATE OR REPLACE VIEW beta.total_transactions
 AS
 SELECT total_expenses.id,
    total_expenses.amount,
    total_expenses.created_at,
    total_expenses.date,
    total_expenses.payment_method,
    total_expenses.transaction_id,
    total_expenses.is_payment,
    total_expenses.bank_account_id,
    total_expenses.user_id,
    total_expenses.user_table,
    total_expenses.payer_name,
    total_expenses.note,
    total_expenses.reconciled,
    total_expenses.bank_name,
    total_expenses.account_number,
    total_expenses.currency,
    total_expenses.account_name,
    1 AS is_expense
   FROM beta.total_expenses
UNION ALL
 SELECT total_revenues.id,
    total_revenues.amount,
    total_revenues.created_at,
    total_revenues.date,
    total_revenues.payment_method,
    total_revenues.transaction_id,
    total_revenues.is_payment,
    total_revenues.bank_account_id,
    total_revenues.user_id,
    total_revenues.user_table,
    total_revenues.payer_name,
    total_revenues.note,
    total_revenues.reconciled,
    total_revenues.bank_name,
    total_revenues.account_number,
    total_revenues.currency,
    total_revenues.account_name,
    0 AS is_expense
   FROM beta.total_revenues
UNION ALL
 SELECT total_current_assets.id,
    total_current_assets.amount,
    total_current_assets.created_at,
    total_current_assets.date,
    total_current_assets.payment_method,
    total_current_assets.transaction_id,
    total_current_assets.is_payment,
    total_current_assets.bank_account_id,
    total_current_assets.user_id,
    total_current_assets.user_table,
    total_current_assets.payer_name,
    total_current_assets.note,
    total_current_assets.reconciled,
    total_current_assets.bank_name,
    total_current_assets.account_number,
    total_current_assets.currency,
    total_current_assets.account_name,
    5 AS is_expense
   FROM beta.total_current_assets
UNION ALL
 SELECT total_liabilities.id,
    total_liabilities.amount,
    total_liabilities.created_at,
    total_liabilities.date,
    total_liabilities.payment_method,
    total_liabilities.transaction_id,
    total_liabilities.is_payment,
    total_liabilities.bank_account_id,
    total_liabilities.user_id,
    total_liabilities.user_table,
    total_liabilities.payer_name,
    total_liabilities.note,
    total_liabilities.reconciled,
    total_liabilities.bank_name,
    total_liabilities.account_number,
    total_liabilities.currency,
    total_liabilities.account_name,
    6 AS is_expense
   FROM beta.total_liabilities
UNION ALL
 SELECT total_fixed_assets.id,
    total_fixed_assets.amount,
    total_fixed_assets.created_at,
    total_fixed_assets.date,
    total_fixed_assets.payment_method,
    total_fixed_assets.transaction_id,
    total_fixed_assets.is_payment,
    total_fixed_assets.bank_account_id,
    total_fixed_assets.user_id,
    total_fixed_assets.user_table,
    total_fixed_assets.payer_name,
    total_fixed_assets.note,
    total_fixed_assets.reconciled,
    total_fixed_assets.bank_name,
    total_fixed_assets.account_number,
    total_fixed_assets.currency,
    total_fixed_assets.account_name,
    7 AS is_expense
   FROM beta.total_fixed_assets;

ALTER TABLE beta.total_transactions
    OWNER TO postgres;

-- View: beta.transport_info

-- DROP VIEW beta.transport_info;

CREATE OR REPLACE VIEW beta.transport_info
 AS
 SELECT b.transport_route_id,
    a.student_id,
    a.id,
    b.amount,
    b.fees_installment_id,
    COALESCE(c.amount, 0::numeric(10,2)) AS discount,
    d.name AS route_name,
    e.name AS vehicle_name,
    e.plate_number,
    a.is_oneway,
    a.vehicle_id,
    a.installment_id
   FROM beta.tmembers a
     JOIN beta.fees_installments f ON f.installment_id = a.installment_id AND f.fee_id = 1000
     JOIN beta.transport_routes_fees_installments b ON b.fees_installment_id = f.id AND b.transport_route_id = a.transport_route_id
     JOIN beta.vehicles e ON e.id = a.vehicle_id
     LEFT JOIN beta.discount_fees_installments c ON c.fees_installment_id = b.fees_installment_id AND a.student_id = c.student_id
     JOIN beta.transport_routes d ON d.id = a.transport_route_id
  GROUP BY b.transport_route_id, a.student_id, b.amount, b.fees_installment_id, c.amount, d.name, e.name, e.plate_number, a.is_oneway, a.id, a.vehicle_id, a.installment_id
  ORDER BY a.student_id DESC;

ALTER TABLE beta.transport_info
    OWNER TO postgres;


CREATE OR REPLACE VIEW beta.users
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
   FROM beta."user" a
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
   FROM beta.teacher t
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
           FROM beta.role
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
   FROM beta.student s
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
           FROM beta.role
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
   FROM beta.parent p
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
           FROM beta.role
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
   FROM beta.setting b;

ALTER TABLE beta.users
    OWNER TO postgres;


-- View: beta.wallet_usage

-- DROP VIEW beta.wallet_usage;

CREATE OR REPLACE VIEW beta.wallet_usage
 AS
 SELECT sum(COALESCE(wallets.amount, 0::numeric::double precision))::numeric AS amount,
    wallets.student_id,
    0 AS used_amount
   FROM beta.wallets
  GROUP BY wallets.student_id
UNION ALL
 SELECT 0 AS amount,
    wallet_uses.user_id AS student_id,
    sum(COALESCE(wallet_uses.amount, 0::numeric)) AS used_amount
   FROM beta.wallet_uses
  WHERE wallet_uses.user_table::text = 'student'::text
  GROUP BY wallet_uses.user_id;

ALTER TABLE beta.wallet_usage
    OWNER TO postgres;
