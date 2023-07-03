create function shulesoft.linker(schema_, column__,table_) 
returns integer;

--classlevel
(select classlevel_id from shulesoft.classlevel where uuid=(select uuid from %I.classlevel where classlevel_id=a.class_level_id))

--classlevel--2
(select classlevel_id from shulesoft.classlevel where uuid=(select uuid from %I.classlevel where classlevel_id=a.classlevel_id))

--academic year
(select id from shulesoft.academic_year where uuid=(select uuid from %I.academic_year where id=a.academic_year_id))

--teacher
(select "teacherID" from shulesoft.teacher where uuid=(select uuid from %I.teacher where "teacherID"=a."teacherID"))

--special grade
(select id from shulesoft.special_grade_names where uuid=(select uuid from %I.special_grade_names where id=a.special_grade_name_id))

--classes
(select "classesID" from shulesoft.classes where uuid=(select uuid from %I.classes where "classesID"=a."classesID"))

--refer subject
(select subject_id from shulesoft.refer_subject where uuid=(select uuid from %I.refer_subject where subject_id=a.subject_id))

--subjectID
(select "subjectID" from shulesoft.subject where uuid=(select uuid from %I.subject where "subjectID"=a."subjectID"))
--sectionID
(select "sectionID" from shulesoft.section where uuid=(select uuid from %I.section where "sectionID"=a."sectionID"))
--exam group
(select id from shulesoft.exam_groups where uuid=(select uuid from %I.exam_groups where id=a.exam_group_id))
--semester
(select id from shulesoft.semester where uuid=(select uuid from %I.semester where id=a.semester_id))
--refer exam
(select id from shulesoft.refer_exam where uuid=(select uuid from %I.refer_exam where id=a.refer_exam_id))
--examID
(select "examID" from shulesoft.exam where uuid=(select uuid from %I.exam where "examID"=a."examID"))
--student_id
(select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id))

--PARENT id
(select "parentID" from shulesoft.parent where uuid=(select uuid from %I.parent where "parentID"=a."parentID"))
--userID id
(select "userID" from shulesoft.user where uuid=(select uuid from %I.user where "userID"=a."userID"))

(select id from shulesoft.role where uuid=(select uuid from %I.role where id=a.roll_id))

(select id from shulesoft.characters where uuid=(select uuid from %I.characters where id=a.character_id))

(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "id"=a."created_by"))

(select id from shulesoft.medias where uuid=(select uuid from %I.medias where id=a.media_id))

(select id from shulesoft.book where uuid=(select uuid from %I.book where id=a.book_id))


(select id from shulesoft.fees where uuid=(select uuid from %I.fees where id=a.fee_id))

(select id from shulesoft.bank_accounts where uuid=(select uuid from %I.bank_accounts where id=a.bank_account_id))

(select id from shulesoft.payments where uuid=(select uuid from %I.payments where id=a.payment_id))

(select id from shulesoft.account_groups where uuid=(select uuid from %I.account_groups where id=a.account_group_id))

(select id from shulesoft.hostels where uuid=(select uuid from %I.hostels where id=a.hostel_id))


(select id from shulesoft.invoices where uuid=(select uuid from %I.invoices where id=a.invoice_id))

(select id from shulesoft.installments where uuid=(select uuid from %I.installments where id=a.installment_id))

(select "id" from shulesoft.forum_questions where uuid=(select uuid from %I.forum_questions where "id"=a."forum_question_id"))

(select id from shulesoft.assignments where uuid=(select uuid from %I.assignments where id=a.assignment_id))


(select id from shulesoft.fees_installments where uuid=(select uuid from %I.fees_installments where id=a.fees_installment_id))

(select id from shulesoft.invoices_fees_installments where uuid=(select uuid from %I.invoices_fees_installments where id=a.invoices_fees_installment_id))

(select id from shulesoft.refer_expense where uuid=(select uuid from %I.refer_expense where id=a.refer_expense_id))

(select id from shulesoft.salaries where uuid=(select uuid from %I.salaries where id=a.salary_id))

(select id from shulesoft.allowances where uuid=(select uuid from %I.allowances where id=a.allowance_id))

(select id from shulesoft.transport_routes where uuid=(select uuid from %I.transport_routes where id=a.transport_route_id))

(select id from shulesoft.deductions where uuid=(select uuid from %I.deductions where id=a.deduction_id))


sql_=format('INSERT into shulesoft.expenses (,schema_name) select , ''%I'' from %I.expenses',schema_,schema_);

execute sql_;

sql_=format('INSERT into shulesoft.fixed_assets (,schema_name) select , ''%I'' from %I.fixed_assets',schema_,schema_);

execute sql_;

sql_=format('INSERT into shulesoft.revenue (,schema_name) select , ''%I'' from %I.revenue',schema_,schema_);

execute sql_;

sql_=format('INSERT into shulesoft.liabilities (,schema_name) select , ''%I'' from %I.liabilities',schema_,schema_);

execute sql_;

sql_=format('INSERT into shulesoft.capital (,schema_name) select , ''%I'' from %I.capital',schema_,schema_);

execute sql_;

sql_=format('INSERT into shulesoft.closing_year_balance (,schema_name) select , ''%I'' from %I.closing_year_balance',schema_,schema_);

execute sql_;

sql_=format('INSERT into shulesoft.wallet_uses (,schema_name) select , ''%I'' from %I.wallet_uses',schema_,schema_);

execute sql_;

sql_=format('INSERT into shulesoft.routine_daily (,schema_name) select , ''%I'' from %I.routine_daily',schema_,schema_);

execute sql_;

sql_=format('INSERT into shulesoft.tattendances (,schema_name) select , ''%I'' from %I.tattendances',schema_,schema_);

execute sql_;

sql_=format('INSERT into shulesoft.staff_report (,schema_name) select , ''%I'' from %I.staff_report',schema_,schema_);

execute sql_;

sql_=format('INSERT into shulesoft.user_devices (,schema_name) select , ''%I'' from %I.user_devices',schema_,schema_);

execute sql_;



sql_=format('INSERT into shulesoft.configurations (,schema_name) select , ''%I'' from %I.configurations',schema_,schema_);

execute sql_;

sql_=format('INSERT into shulesoft.valid_emails (,schema_name) select , ''%I'' from %I.valid_emails',schema_,schema_);

execute sql_;

sql_=format('INSERT into shulesoft.staff_targets_reports (,schema_name) select , ''%I'' from %I.staff_targets_reports',schema_,schema_);

execute sql_;

sql_=format('INSERT into shulesoft.staff_targets (,schema_name) select , ''%I'' from %I.staff_targets',schema_,schema_);

execute sql_;

sql_=format('INSERT into shulesoft.financial_year (,schema_name) select , ''%I'' from %I.financial_year',schema_,schema_);

execute sql_;




sql_=format('INSERT into shulesoft.discount (,schema_name) select , ''%I'' from %I.discount',schema_,schema_);

execute sql_;


--this table does not exists in old version
sql_=format('INSERT into shulesoft.current_assets ("uuid","refer_expense_id","account_id","transaction_id","amount","user_sid","created_by_id","note","reconciled","number","sms_sent","date","created_at","updated_at",schema_name) select "uuid",(select id from shulesoft.refer_expense where uuid=(select uuid from %I.refer_expense where id=a.refer_expense_id)),"account_id","transaction_id","amount","user_sid","created_by_id","note","reconciled","number","sms_sent","date","created_at","updated_at", ''%I'' from %I.current_assets',schema_,schema_);

execute sql_;

sql_=format('INSERT into shulesoft.journals (,schema_name) select , ''%I'' from %I.journals',schema_,schema_);

execute sql_;

sql_=format('INSERT into shulesoft.budgets (,schema_name) select , ''%I'' from %I.budgets',schema_,schema_);

execute sql_;

sql_=format('INSERT into shulesoft.warehouses (,schema_name) select , ''%I'' from %I.warehouses',schema_,schema_);

execute sql_;

sql_=format('INSERT into shulesoft.warehouse_transfers (,schema_name) select , ''%I'' from %I.warehouse_transfers',schema_,schema_);

execute sql_;

sql_=format('INSERT into shulesoft.invoice_prefix (,schema_name) select , ''%I'' from %I.invoice_prefix',schema_,schema_);

execute sql_;

