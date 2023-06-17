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
