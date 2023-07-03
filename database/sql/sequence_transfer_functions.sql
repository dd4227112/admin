CREATE OR REPLACE FUNCTION shulesoft.transfer_stage_one(
	schema_ text)
    RETURNS numeric
    LANGUAGE 'plpgsql'
AS $BODY$

 DECLARE 
	sql_ text;
 BEGIN 
-- we set statement timeout =0. This will cost our cpu and memory but for the sake of effective transfer, this is  almost a mandatory statement
  SET statement_timeout = 0;
  
 -- to prevent db reset during running a long query, we set this to infinity
  SET idle_in_transaction_session_timeout = 0;
 --delete any data for that particular schema_name if exists
 

 perform shulesoft.delete_schema_details_from_shulesoft_schema(schema_);
--1. Setting 
sql_=format('INSERT into shulesoft.setting ("settingID","sname","name","phone","address","email","sid","currency_code","currency_symbol","footer","photo","username","password","usertype","created_at","api_key","api_secret","box","payment_integrated","pass_mark","website","academic_year_id","motto","sms_enabled","email_enabled","sms_type","headname","signature","signature_path","exam_avg_format","school_format","registration_number","salary","id_number","empty_mark","institution_code","price_per_student","api_username","api_password","default_password","shulesoft_comission","nmb_comission","transaction_fee","bank_account_number","bank_name","updated_at","remember_token","show_report_to","custom_to","custom_to_amount","payment_status","payment_deadline_date","show_report_to_all","show_zero_in_report","school_gender","currency_rounding","email_list","invoice_guide","transaction_charges_to_parents","publish_exam","number","show_payment_plan","estimated_students","account_manager_id","show_bank","enable_payment_delete","total_paid_amount","region","school_id","roll_no_initial","online_admission","email_valid","payroll_status","pay_live_session","other_learning_material","enable_parent_charging","enable_self_registration","collection_method","fcm_token","sub_invoice","source","last_payment_date","next_payment_date","school_status","default_lang","country_id","sms_lang","gender","category","uuid","vfd_serial_number","vfd_password","tin","vrn","tax_group","vfd_approved","income_tax","vfd_enabled","allow_insurance",schema_name) select "settingID","sname","name","phone","address","email","sid","currency_code","currency_symbol","footer","photo","username","password","usertype","created_at","api_key","api_secret","box","payment_integrated","pass_mark","website","academic_year_id","motto","sms_enabled","email_enabled","sms_type","headname","signature","signature_path","exam_avg_format","school_format","registration_number","salary","id_number","empty_mark","institution_code","price_per_student","api_username","api_password","default_password","shulesoft_comission","nmb_comission","transaction_fee","bank_account_number","bank_name","updated_at","remember_token","show_report_to","custom_to","custom_to_amount","payment_status","payment_deadline_date","show_report_to_all","show_zero_in_report","school_gender","currency_rounding","email_list","invoice_guide","transaction_charges_to_parents","publish_exam","number","show_payment_plan","estimated_students","account_manager_id","show_bank","enable_payment_delete","total_paid_amount","region","school_id","roll_no_initial","online_admission","email_valid","payroll_status","pay_live_session","other_learning_material","enable_parent_charging","enable_self_registration","collection_method","fcm_token","sub_invoice","source","last_payment_date","next_payment_date","school_status","default_lang","country_id","sms_lang","gender","category","uuid","vfd_serial_number","vfd_password","tin","vrn","tax_group","vfd_approved","income_tax","vfd_enabled","allow_insurance", ''%I'' from %I.setting',schema_,schema_);

execute sql_;

--2. exam report settings
sql_=format('INSERT into shulesoft.exam_report_settings ("exam_type","average_column_name","show_teacher","show_remarks","show_teacher_sign","show_grade","show_pos_in_stream","show_csee_division","show_acsee_division","show_subject_point","show_division_by_exam","show_division_total_points","show_overall_division","show_pos_in_class","show_pos_in_section","show_subject_pos_in_class","show_subject_pos_in_section","semester_average_name","single_semester_avg_name","overall_semester_avg_name","show_classteacher_name","show_classteacher_phone","class_teacher_remark","head_teacher_remark","show_all_signature_on_the_footer","show_student_attendance","show_overall_grade","created_at","updated_at","show_average_row","show_percentage_on_mark_column","subject_order_by_arrangement","show_total_marks","show_subject_total_across_exams","classlevel_id","show_parent_comment","show_marks","uuid",schema_name) select "exam_type","average_column_name","show_teacher","show_remarks","show_teacher_sign","show_grade","show_pos_in_stream","show_csee_division","show_acsee_division","show_subject_point","show_division_by_exam","show_division_total_points","show_overall_division","show_pos_in_class","show_pos_in_section","show_subject_pos_in_class","show_subject_pos_in_section","semester_average_name","single_semester_avg_name","overall_semester_avg_name","show_classteacher_name","show_classteacher_phone","class_teacher_remark","head_teacher_remark","show_all_signature_on_the_footer","show_student_attendance","show_overall_grade","created_at","updated_at","show_average_row","show_percentage_on_mark_column","subject_order_by_arrangement","show_total_marks","show_subject_total_across_exams","classlevel_id","show_parent_comment","show_marks","uuid", ''%I'' from %I.exam_report_settings',schema_,schema_);

execute sql_;
--3. receipt settings
sql_=format('INSERT into shulesoft.receipt_settings ("show_installment","created_at","updated_at","show_class","template","available_templates","show_single_fee","copy_to_print","show_balance","show_digital_signature","show_school_stamp","show_stream","show_fee_amount","uuid",schema_name) select "show_installment","created_at","updated_at","show_class","template","available_templates","show_single_fee","copy_to_print","show_balance","show_digital_signature","show_school_stamp","show_stream","show_fee_amount","uuid", ''%I'' from %I.receipt_settings',schema_,schema_);

execute sql_;
--4. invoice settings
sql_=format('INSERT into shulesoft.invoice_settings ("title","reference_naming","show_banks","show_payment_plan","created_at","updated_at","show_different_header","uuid",schema_name) select "title","reference_naming","show_banks","show_payment_plan","created_at","updated_at","show_different_header","uuid", ''%I'' from %I.invoice_settings',schema_,schema_);

execute sql_;
--5. payslip settings
sql_=format('INSERT into shulesoft.payslip_settings ("show_employee_signature","show_employer_signature","created_at","updated_at","show_employee_digital_signature","show_employer_digital_signature","show_address","show_employer_contribution","show_tax_summary","uuid",schema_name) select "show_employee_signature","show_employer_signature","created_at","updated_at","show_employee_digital_signature","show_employer_digital_signature","show_address","show_employer_contribution","show_tax_summary","uuid", ''%I'' from %I.payslip_settings',schema_,schema_);

execute sql_;

--6. certificate settings
sql_=format('INSERT into shulesoft.certificate_setting ("certificate_type","show_remarks","show_grade","final_date","uuid",schema_name) select "certificate_type","show_remarks","show_grade","final_date","uuid", ''%I'' from %I.certificate_setting',schema_,schema_);

execute sql_;

--7. payroll settings


--8. insert into teachers table
sql_=format('INSERT into shulesoft.teacher ("name","designation","dob","sex","email","phone","address","jod","photo","username","password","usertype","created_at","employment_type","signature","signature_path","id_number","library","health_insurance_id","health_status_id","education_id","designation_id","education_level_id","updated_at","physical_condition_id","religion_id","nationality","salary","default_password","status","status_id","bank_account_number","bank_name","remember_token","email_valid","number","location","region","sid","city_id","national_id","country_id","qualification","payroll_status","fcm_token","role_id","uuid",schema_name) select "name","designation","dob","sex","email","phone","address","jod","photo","username","password","usertype","created_at","employment_type","signature","signature_path","id_number","library","health_insurance_id","health_status_id","education_id","designation_id","education_level_id","updated_at","physical_condition_id","religion_id","nationality","salary","default_password","status","status_id","bank_account_number","bank_name","remember_token","email_valid","number","location","region","sid","city_id","national_id","country_id","qualification","payroll_status","fcm_token","role_id","uuid", ''%I'' from %I.teacher',schema_,schema_);

execute sql_;

--START ACADEMIC DATA TRANSFER
--9. insert into classlevel 
sql_=format('INSERT into shulesoft.classlevel ("name","start_date","end_date","span_number","created_at","updated_at","note","result_format","terms","level_numeric","school_level_id","stamp","head_teacher_title","school_id","leaving_certificate","pass_mark","reg_form","gender","category","religion","education_level_id","uuid",schema_name) select "name","start_date","end_date","span_number","created_at","updated_at","note","result_format","terms","level_numeric","school_level_id","stamp","head_teacher_title","school_id","leaving_certificate","pass_mark","reg_form","gender","category","religion","education_level_id","uuid", ''%I'' from %I.classlevel',schema_,schema_);

execute sql_;
--10. Insert academic years with data from classlevel above
sql_=format('INSERT into shulesoft.academic_year ("name","class_level_id","created_at","updated_at","status","start_date","end_date","uuid",schema_name) select "name",(select classlevel_id from shulesoft.classlevel where uuid=(select uuid from %I.classlevel where classlevel_id=a.class_level_id)),"created_at","updated_at","status","start_date","end_date","uuid", ''%I'' from %I.academic_year a',schema_,schema_,schema_);

execute sql_;

--11. insert special grade names first
sql_=format('INSERT into shulesoft.special_grade_names ("name","note","created_at","updated_at","special_for","global_grade_id","association_id","uuid",schema_name) select "name","note","created_at","updated_at","special_for","global_grade_id","association_id","uuid", ''%I'' from %I.special_grade_names',schema_,schema_);

execute sql_;

--12. insert special grades if available
sql_=format('INSERT into shulesoft.special_grades ("grade","point","gradefrom","gradeupto","note","created_at","classlevel_id","overall_note","overall_academic_note","special_grade_name_id","updated_at","uuid",schema_name) select "grade","point","gradefrom","gradeupto","note","created_at",(select classlevel_id from shulesoft.classlevel where uuid=(select uuid from %I.classlevel where classlevel_id=a.classlevel_id)),"overall_note","overall_academic_note",(select id from shulesoft.special_grade_names where uuid=(select uuid from %I.special_grade_names where id=a.special_grade_name_id)),"updated_at","uuid", ''%I'' from %I.special_grades a',schema_,schema_,schema_,schema_);

execute sql_;

--13. Insert classes with classlevel and teacher information above
sql_=format('INSERT into shulesoft.classes ("classes","classes_numeric","teacherID","note","created_at","classlevel_id","special_grade_name_id","refer_class_id","updated_at","uuid",schema_name) select "classes","classes_numeric",(select "teacherID" from shulesoft.teacher where uuid=(select uuid from %I.teacher where "teacherID"=a."teacherID")),"note","created_at",(select classlevel_id from shulesoft.classlevel where uuid=(select uuid from %I.classlevel where classlevel_id=a.classlevel_id)),(select id from shulesoft.special_grade_names where uuid=(select uuid from %I.special_grade_names where id=a.special_grade_name_id)),"refer_class_id","updated_at","uuid", ''%I'' from %I.classes a',schema_,schema_,schema_,schema_,schema_);

execute sql_;
--14. insert grades as it depends on classlevel as well
sql_=format('INSERT into shulesoft.grade ("grade","point","gradefrom","gradeupto","note","created_at","classlevel_id","overall_note","overall_academic_note","gpa_points","updated_at","uuid",schema_name) select "grade","point","gradefrom","gradeupto","note","created_at",(select classlevel_id from shulesoft.classlevel where uuid=(select uuid from %I.classlevel where classlevel_id=a.classlevel_id)),"overall_note","overall_academic_note","gpa_points","updated_at","uuid", ''%I'' from %I.grade a',schema_,schema_,schema_);

execute sql_;
--15. insert sections as they depends on classes, and teachers
sql_=format('INSERT into shulesoft.section ("section","category","classesID","teacherID","note","extra","created_at","updated_at","special_grade_name_id","uuid",schema_name) select "section","category",(select "classesID" from shulesoft.classes where uuid=(select uuid from %I.classes where "classesID"=a."classesID")),(select "teacherID" from shulesoft.teacher where uuid=(select uuid from %I.teacher where "teacherID"=a."teacherID")),"note","extra","created_at","updated_at",(select id from shulesoft.special_grade_names where uuid=(select uuid from %I.special_grade_names where id=a.special_grade_name_id)),"uuid", ''%I'' from %I.section a',schema_,schema_,schema_,schema_,schema_);

execute sql_;
--16. insert semester as it depends on academic year and classlevel
sql_=format('INSERT into shulesoft.semester ("name","class_level_id","created_at","updated_at","academic_year_id","start_date","end_date","study_days","uuid",schema_name) select "name",(select classlevel_id from shulesoft.classlevel where uuid=(select uuid from %I.classlevel where classlevel_id=a.class_level_id)),"created_at","updated_at",(select id from shulesoft.academic_year where uuid=(select uuid from %I.academic_year where id=a.academic_year_id)),"start_date","end_date","study_days","uuid", ''%I'' from %I.semester a',schema_,schema_,schema_,schema_);

execute sql_;

--17. insert refer subjects
sql_=format('INSERT into shulesoft.refer_subject ("subject_name","code","arrangement","created_at","updated_at","uuid",schema_name) select "subject_name","code","arrangement","created_at","updated_at","uuid", ''%I'' from %I.refer_subject',schema_,schema_);

execute sql_;
--18. insert subjects as they refer to class,teacher and refer subject
sql_=format('INSERT into shulesoft.subject ("classesID","teacherID","subject","subject_author","teacher_name","created_at","is_counted","is_penalty","grade_mark","pass_mark","subject_id","subject_type","is_counted_indivision","updated_at","uuid",schema_name) select (select "classesID" from shulesoft.classes where uuid=(select uuid from %I.classes where "classesID"=a."classesID")),(select "teacherID" from shulesoft.teacher where uuid=(select uuid from %I.teacher where "teacherID"=a."teacherID")),"subject","subject_author","teacher_name","created_at","is_counted","is_penalty","grade_mark","pass_mark",(select subject_id from shulesoft.refer_subject where uuid=(select uuid from %I.refer_subject where subject_id=a.subject_id)),"subject_type","is_counted_indivision","updated_at","uuid", ''%I'' from %I.subject a',schema_,schema_,schema_,schema_,schema_);

execute sql_;

--19. insert section subject
sql_=format('INSERT into shulesoft.subject_section ("subject_id","section_id","created_at","uuid",schema_name) select (select "subjectID" from shulesoft.subject where uuid=(select uuid from %I.subject where "subjectID"=a."subject_id")),(select "sectionID" from shulesoft.section where uuid=(select uuid from %I.section where "sectionID"=a."section_id")),"created_at","uuid", ''%I'' from %I.subject_section a',schema_,schema_,schema_,schema_);

execute sql_;
--20. exam groups
sql_=format('INSERT into shulesoft.exam_groups ("name","note","weight","created_at","updated_at","predefined","uuid",schema_name) select "name","note","weight","created_at","updated_at","predefined","uuid", ''%I'' from %I.exam_groups',schema_,schema_);
execute sql_;
 RETURN 0; 
 END; 

$BODY$;


CREATE OR REPLACE FUNCTION shulesoft.transfer_stage_two(
	schema_ text)
    RETURNS numeric
    LANGUAGE 'plpgsql'
AS $BODY$

 DECLARE 
	sql_ text;
 BEGIN 
-- we set statement timeout =0. This will cost our cpu and memory but for the sake of effective transfer, this is  almost a mandatory statement
  SET statement_timeout = 0; 
 -- to prevent db reset during running a long query, we set this to infinity
  SET idle_in_transaction_session_timeout = 0;
--21. refer exam
sql_=format('INSERT into shulesoft.refer_exam ("name","classlevel_id","note","created_at","abbreviation","exam_group_id","updated_at","uuid",schema_name) select "name",(select classlevel_id from shulesoft.classlevel where uuid=(select uuid from %I.classlevel where classlevel_id=a.classlevel_id)),"note","created_at","abbreviation",(select id from shulesoft.exam_groups where uuid=(select uuid from %I.exam_groups where id=a.exam_group_id)),"updated_at","uuid", ''%I'' from %I.refer_exam a',schema_,schema_,schema_,schema_);

execute sql_;

--22. exams
sql_=format('INSERT into shulesoft.exam ("exam","date","note","created_at","abbreviation","semester_id","refer_exam_id","show_division","special_grade_name_id","global_exam_id","uuid","semister_id",schema_name) select "exam","date","note","created_at","abbreviation",(select id from shulesoft.semester where uuid=(select uuid from %I.semester where id=a.semester_id)),(select id from shulesoft.refer_exam where uuid=(select uuid from %I.refer_exam where id=a.refer_exam_id)),"show_division",(select id from shulesoft.special_grade_names where uuid=(select uuid from %I.special_grade_names where id=a.special_grade_name_id)),"global_exam_id","uuid","semister_id", ''%I'' from %I.exam a',schema_,schema_,schema_,schema_,schema_);

execute sql_;
--23. exam_report
sql_=format('INSERT into shulesoft.exam_report ("classes_id","combined_exams","name","created_at","updated_at","sms_sent","exam_id","email_sent","academic_year_id","combined_exam_array","reporting_date","percent","semester_id","rank_per_stream","show_division","show_reporting_date","rank_per_class","uuid",schema_name) select (select "classesID" from shulesoft.classes where uuid=(select uuid from %I.classes where "classesID"=a."classes_id")),"combined_exams","name","created_at","updated_at","sms_sent",(select "examID" from shulesoft.exam where uuid=(select uuid from %I.exam where "examID"=a."exam_id")),"email_sent",(select id from shulesoft.academic_year where uuid=(select uuid from %I.academic_year where id=a.academic_year_id)),"combined_exam_array","reporting_date","percent",(select id from shulesoft.semester where uuid=(select uuid from %I.semester where id=a.semester_id)),"rank_per_stream","show_division","show_reporting_date","rank_per_class","uuid", ''%I'' from %I.exam_report a',schema_,schema_,schema_,schema_,schema_,schema_);

execute sql_;
--24. class exam
sql_=format('INSERT into shulesoft.class_exam ("class_id","exam_id","academic_year_id","uuid",schema_name) select (select "classesID" from shulesoft.classes where uuid=(select uuid from %I.classes where "classesID"=a."class_id")),(select "examID" from shulesoft.exam where uuid=(select uuid from %I.exam where "examID"=a."exam_id")),(select id from shulesoft.academic_year where uuid=(select uuid from %I.academic_year where id=a.academic_year_id)),"uuid", ''%I'' from %I.class_exam a',schema_,schema_,schema_,schema_,schema_);

execute sql_;

--25. role
sql_=format('INSERT into shulesoft.role ("name","sys_role","is_super","created_at","updated_at","uuid",schema_name) select "name","sys_role","is_super","created_at","updated_at","uuid", ''%I'' from %I.role',schema_,schema_);

execute sql_;
--26. role permission
sql_=format('INSERT into shulesoft.role_permission ("role_id","permission_id","created_at","updated_at","uuid",schema_name) select (select id from shulesoft.role where uuid=(select uuid from %I.role where id=a.role_id)),"permission_id","created_at","updated_at","uuid", ''%I'' from %I.role_permission a',schema_,schema_,schema_);

execute sql_;
--27. insert parents
sql_=format('INSERT into shulesoft.parent ("name","father_name","mother_name","father_profession","mother_profession","email","phone","address","photo","username","password","usertype","created_at","other_phone","status","employer","guardian_profession","professionals","dob","sex","relation","physical_condition_id","default_password","updated_at","language","denomination","box","remember_token","profession_id","status_id","location","region","sid","employer_type_id","city_id","signature","national_id","country_id","email_valid","payroll_status","fcm_token","uuid",schema_name) select "name","father_name","mother_name","father_profession","mother_profession","email","phone","address","photo","username","password","usertype","created_at","other_phone","status","employer","guardian_profession","professionals","dob","sex","relation","physical_condition_id","default_password","updated_at","language","denomination","box","remember_token","profession_id","status_id","location","region","sid","employer_type_id","city_id","signature","national_id","country_id","email_valid","payroll_status","fcm_token","uuid", ''%I'' from %I.parent',schema_,schema_);

execute sql_;
--28. insert students
sql_=format('INSERT into shulesoft.student ("name","dob","sex","email","phone","address","classesID","sectionID","roll","create_date","photo","year","username","password","usertype","created_at","academic_year_id","status","health","health_other","status_id","religion_id","updated_at","city_id","health_condition_id","parent_type_id","health_insurance_id","physical_condition_id","birth_certificate_number","distance_from_school","remember_token","jod","joining_status","number","government_number","sid","location","health_status_id","national_id","country_id","index","email_valid","payroll_status","is_hostel","tribe","denomination","signature","nationality","school_phone_number","school_id","head_teacher_name","fcm_token","uuid",schema_name) select "name","dob","sex","email","phone","address",(select "classesID" from shulesoft.classes where uuid=(select uuid from %I.classes where "classesID"=a."classesID")),(select "sectionID" from shulesoft.section where uuid=(select uuid from %I.section where "sectionID"=a."sectionID")),"roll","create_date","photo","year","username","password","usertype","created_at",(select id from shulesoft.academic_year where uuid=(select uuid from %I.academic_year where id=a.academic_year_id)),"status","health","health_other","status_id","religion_id","updated_at","city_id","health_condition_id","parent_type_id","health_insurance_id","physical_condition_id","birth_certificate_number","distance_from_school","remember_token","jod","joining_status","number","government_number","sid","location","health_status_id","national_id","country_id","index","email_valid","payroll_status","is_hostel","tribe","denomination","signature","nationality","school_phone_number","school_id","head_teacher_name","fcm_token","uuid", ''%I'' from %I.student a',schema_,schema_,schema_,schema_,schema_);

execute sql_;
--29. student addresses
sql_=format('INSERT into shulesoft.student_addresses ("district_id","ward","village","studentid","uuid",schema_name) select "district_id","ward","village",(select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.studentid)),"uuid", ''%I'' from %I.student_addresses a',schema_,schema_,schema_);

execute sql_;
--30. student archive
sql_=format('INSERT into shulesoft.student_archive ("student_id","academic_year_id","section_id","created_at","updated_at","due_amount","status","status_id","uuid",schema_name) select (select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),(select id from shulesoft.academic_year where uuid=(select uuid from %I.academic_year where id=a.academic_year_id)),(select "sectionID" from shulesoft.section where uuid=(select uuid from %I.section where "sectionID"=a."section_id")),"created_at","updated_at","due_amount","status","status_id","uuid", ''%I'' from %I.student_archive a',schema_,schema_,schema_,schema_,schema_);

execute sql_;
--31. student parents
sql_=format('INSERT into shulesoft.student_parents ("student_id","parent_id","created_at","updated_at","uuid",schema_name) select (select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),(select "parentID" from shulesoft.parent where uuid=(select uuid from %I.parent where "parentID"=a."parent_id")),"created_at","updated_at","uuid", ''%I'' from %I.student_parents a',schema_,schema_,schema_,schema_);

execute sql_;
--32. student other
sql_=format('INSERT into shulesoft.student_other ("admitted_from","reg_number","student_id","created_at","year_finished","other_subject","school_id","updated_at","uuid",schema_name) select "admitted_from","reg_number",(select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),"created_at","year_finished","other_subject","school_id","updated_at","uuid", ''%I'' from %I.student_other a',schema_,schema_,schema_);

execute sql_;


--34. insert user
sql_=format('INSERT into shulesoft.user ("name","dob","sex","email","phone","address","jod","photo","username","password","usertype","created_at","signature","signature_path","role_id","salary","id_number","default_password","status","status_id","bank_account_number","bank_name","remember_token","number","sid","location","education_level_id","employment_type_id","physical_condition_id","health_status_id","health_insurance_id","religion_id","town","national_id","country_id","qualification","email_valid","payroll_status","fcm_token","updated_at","uuid",schema_name) select "name","dob","sex","email","phone","address","jod","photo","username","password","usertype","created_at","signature","signature_path",(select id from shulesoft.role where uuid=(select uuid from %I.role where id=a.role_id)),"salary","id_number","default_password","status","status_id","bank_account_number","bank_name","remember_token","number","sid","location","education_level_id","employment_type_id","physical_condition_id","health_status_id","health_insurance_id","religion_id","town","national_id","country_id","qualification","email_valid","payroll_status","fcm_token","updated_at","uuid", ''%I'' from %I.user a',schema_,schema_,schema_);

execute sql_;
--35. insert emails
sql_=format('INSERT into shulesoft.email ("email_id","body","subject","user_id","created_at","status","email","table","uuid",schema_name) select "email_id","body","subject","user_id","created_at","status","email","table","uuid", ''%I'' from %I.email',schema_,schema_);

execute sql_;
--33. exam special case
sql_=format('INSERT into shulesoft.exam_special_cases ("student_id","exam_id","description","special_exam_reason_id","created_by","created_by_table","created_at","updated_at","subjects_excluded","subjects_ids_excluded","uuid",schema_name) select (select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),(select "examID" from shulesoft.exam where uuid=(select uuid from %I.exam where "examID"=a."exam_id")),"description","special_exam_reason_id",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."created_by_table" and  "id"=a."created_by")),"created_by_table","created_at","updated_at","subjects_excluded","subjects_ids_excluded","uuid", ''%I'' from %I.exam_special_cases a',schema_,schema_,schema_,schema_,schema_);

execute sql_;
--36. sms keys
sql_=format('INSERT into shulesoft.sms_keys ("api_secret","api_key","phone_number","name","uuid",schema_name) select "api_secret","api_key","phone_number","name","uuid", ''%I'' from %I.sms_keys',schema_,schema_);

execute sql_;
--37. sms 
sql_=format('INSERT into shulesoft.sms ("body","user_id","created_at","status","return_code","phone_number","type","table","priority","updated_at","opened","sms_keys_id","sms_count","sms_content_id","subject","department_id","sent_from","source","uuid",schema_name) select "body","user_id","created_at","status","return_code","phone_number","type","table","priority","updated_at","opened","sms_keys_id","sms_count","sms_content_id","subject","department_id","sent_from","source","uuid", ''%I'' from %I.sms',schema_,schema_);

execute sql_;

--38. insert rest passwords
sql_=format('INSERT into shulesoft.reset ("keyID","email","created_at","code","uuid",schema_name) select "keyID","email","created_at","code","uuid", ''%I'' from %I.reset',schema_,schema_);

execute sql_;
--39. insert sms settings
sql_=format('INSERT into shulesoft.smssettings ("types","field_names","field_values","smssettings_extra","created_at","uuid",schema_name) select "types","field_names","field_values","smssettings_extra","created_at","uuid", ''%I'' from %I.smssettings',schema_,schema_);

execute sql_;
--40. insert student_status
sql_=format('INSERT into shulesoft.student_status ("reason","created_at","is_report","uuid",schema_name) select "reason","created_at","is_report","uuid", ''%I'' from %I.student_status',schema_,schema_);

execute sql_;
--41. user roles
sql_=format('INSERT into shulesoft.user_role ("user_id","role_id","created_at","updated_at","table","uuid",schema_name) select (select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."table" and "id"=a."user_id" limit 1) limit 1),(select id from shulesoft.role where uuid=(select uuid from %I.role where id=a.role_id) limit 1),"created_at","updated_at","table","uuid", ''%I'' from %I.user_role a',schema_,schema_,schema_,schema_);

execute sql_;
--42. reminders
sql_=format('INSERT into shulesoft.reminders ("user_id","role_id","date","time","mailandsmstemplate_id","title","is_repeated","days","created_at","updated_at","message","type","category","student_id","last_schedule_date","uuid",schema_name) select user_id,role_id,"date","time","mailandsmstemplate_id","title","is_repeated","days","created_at","updated_at","message","type","category",(select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),"last_schedule_date","uuid", ''%I'' from %I.reminders a',schema_,schema_,schema_);

execute sql_;
--43. file folder
sql_=format('INSERT into shulesoft.file_folder ("user_id","table","name","created_at","uuid",schema_name) select (select "userID" from shulesoft.user where uuid=(select uuid from %I.user where "userID"=a."user_id")),"table","name","created_at","uuid", ''%I'' from %I.file_folder a',schema_,schema_,schema_);

execute sql_;
 RETURN 0; 
 END; 

$BODY$;

CREATE OR REPLACE FUNCTION shulesoft.transfer_stage_three(
	schema_ text)
    RETURNS numeric
    LANGUAGE 'plpgsql'
AS $BODY$

 DECLARE 
	sql_ text;
 BEGIN 
-- we set statement timeout =0. This will cost our cpu and memory but for the sake of effective transfer, this is  almost a mandatory statement
  SET statement_timeout = 0; 
 -- to prevent db reset during running a long query, we set this to infinity
  SET idle_in_transaction_session_timeout = 0;
--45. files 
sql_=format('INSERT into shulesoft.files ("mime","file_folder_id","name","display_name","created_at","user_id","table","size","caption","path","uuid",schema_name) select "mime",(select "id" from shulesoft.file_folder where uuid=(select uuid from %I.file_folder where "id"=a."file_folder_id")),"name","display_name","created_at",(select "userID" from shulesoft.user where uuid=(select uuid from %I.user where "userID"=a."user_id")),"table","size","caption","path","uuid", ''%I'' from %I.files a',schema_,schema_,schema_,schema_);

execute sql_;
--46. id_cards
sql_=format('INSERT into shulesoft.id_cards ("show_gender","show_birthday","show_admission_number","show_class","show_issue_date","show_barcode","show_payment_status","created_at","updated_at","show_watermark","show_year_range","uuid",schema_name) select "show_gender","show_birthday","show_admission_number","show_class","show_issue_date","show_barcode","show_payment_status","created_at","updated_at","show_watermark","show_year_range","uuid", ''%I'' from %I.id_cards',schema_,schema_);

execute sql_;
--47. email_lists
sql_=format('INSERT into shulesoft.email_lists ("email","created_at","updated_at","created_by","uuid",schema_name) select "email","created_at","updated_at",(select "userID" from shulesoft.user where uuid=(select uuid from %I.user where "userID"=a."created_by"::bigint)),"uuid", ''%I'' from %I.email_lists a',schema_,schema_,schema_);

execute sql_;
--48. payment types
sql_=format('INSERT into shulesoft.payment_types ("name","created_at","updated_at","uuid",schema_name) select "name","created_at","updated_at","uuid", ''%I'' from %I.payment_types',schema_,schema_);

execute sql_;
--49. media categories
sql_=format('INSERT into shulesoft.media_categories ("name","updated_at","created_at","uuid",schema_name) select "name","updated_at","created_at","uuid", ''%I'' from %I.media_categories',schema_,schema_);

execute sql_;
--50. books
sql_=format('INSERT into shulesoft.book ("name","author","rack","created_at","edition","user_id","serial_no","subject_code","subject_id","classesID","whois","quantity","book_for","due_quantity","updated_at","uuid",schema_name) select "name","author","rack","created_at","edition",(select "userID" from shulesoft.user where uuid=(select uuid from %I.user where "userID"=a."user_id")),"serial_no","subject_code",(select "subjectID" from shulesoft.subject where uuid=(select uuid from %I.subject where "subjectID"=a."subject_id")),(select "classesID" from shulesoft.classes where uuid=(select uuid from %I.classes where "classesID"=a."classesID")),"whois","quantity","book_for","due_quantity","updated_at","uuid", ''%I'' from %I.book a',schema_,schema_,schema_,schema_,schema_);

execute sql_;

--51. diaries
sql_=format('INSERT into shulesoft.diaries ("student_id","teacher_id","work_title","created_at","updated_at","start_date","description","end_date","subject_id","book_id","book_chapter","uuid",schema_name) select (select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),(select "teacherID" from shulesoft.teacher where uuid=(select uuid from %I.teacher where "teacherID"=a."teacher_id")),"work_title","created_at","updated_at","start_date","description","end_date",(select "subjectID" from shulesoft.subject where uuid=(select uuid from %I.subject where "subjectID"=a."subject_id")),(select "id" from shulesoft.book where uuid=(select uuid from %I.book where "id"=a."book_id")),"book_chapter","uuid", ''%I'' from %I.diaries a',schema_,schema_,schema_,schema_,schema_,schema_);

execute sql_;
--52. diary comments
sql_=format('INSERT into shulesoft.diary_comments ("user_id","table","comment","diary_id","created_at","updated_at","opened","uuid",schema_name) select (select "userID" from shulesoft.user where uuid=(select uuid from %I.user where "userID"=a."user_id")),"table","comment",(select "id" from shulesoft.diaries where uuid=(select uuid from %I.diaries where "id"=a."diary_id")),"created_at","updated_at","opened","uuid", ''%I'' from %I.diary_comments a',schema_,schema_,schema_,schema_);

execute sql_;
--53. messages
sql_=format('INSERT into shulesoft.message ("email","receiverID","receiverType","subject","message","attach","attach_file_name","userID","usertype","useremail","year","date","create_date","read_status","from_status","to_status","fav_status","fav_status_sent","reply_status","created_at","receiverTable","uuid",schema_name) select "email","receiverID","receiverType","subject","message","attach","attach_file_name",(select "id" from shulesoft.users where uuid=(select uuid from %I.users where "id"=a."userID" and lower(usertype)=lower(a.usertype) limit 1) limit 1),"usertype","useremail","year","date","create_date","read_status","from_status","to_status","fav_status","fav_status_sent","reply_status","created_at","receiverTable","uuid", ''%I'' from %I.message a',schema_,schema_,schema_);

execute sql_;
--54. login locations
sql_=format('INSERT into shulesoft.login_locations ("ip","city","region","country","latitude","longtude","timezone","user_id","table","continent","currency_code","currency_symbol","currency_convert","location_radius_accuracy","created_at","updated_at","action","uuid",schema_name) select "ip","city","region","country","latitude","longtude","timezone",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."table" and  "id"=a."user_id" limit 1) limit 1),"table","continent","currency_code","currency_symbol","currency_convert","location_radius_accuracy","created_at","updated_at","action","uuid", ''%I'' from %I.login_locations a',schema_,schema_,schema_);

execute sql_;

--55. tempfiles
sql_=format('INSERT into shulesoft.tempfiles ("data","filename","created_at","updated_at","method","controller","created_by","created_by_table","processed","status","uuid",schema_name) select "data","filename","created_at","updated_at","method","controller",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."created_by_table" and  "id"=a."created_by")),"created_by_table","processed","status","uuid", ''%I'' from %I.tempfiles a',schema_,schema_,schema_);

execute sql_;
--59. sms templates
sql_=format('INSERT into shulesoft.mailandsmstemplate ("name","user","type","template","create_date","created_at","status","uuid",schema_name) select "name","user","type","template","create_date","created_at","status","uuid", ''%I'' from %I.mailandsmstemplate',schema_,schema_);

execute sql_;
--60. tags
sql_=format('INSERT into shulesoft.mailandsmstemplatetag ("usersID","name","tagname","mailandsmstemplatetag_extra","create_date","created_at","uuid",schema_name) select "usersID","name","tagname","mailandsmstemplatetag_extra","create_date","created_at","uuid", ''%I'' from %I.mailandsmstemplatetag a',schema_,schema_,schema_);

execute sql_;
--61. appointments
sql_=format('INSERT into shulesoft.appointments ("date","time","to_user_id","to_table","from_user_id","from_table","message","created_at","updated_at","status","uuid",schema_name) select "date","time",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."to_table" and  "id"=a."to_user_id")),"to_table",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."from_table" and  "id"=a."from_user_id")),"from_table","message","created_at","updated_at","status","uuid", ''%I'' from %I.appointments a',schema_,schema_,schema_,schema_);

execute sql_;
--62. reply sms
sql_=format('INSERT into shulesoft.reply_sms ("secret","from","message_id","message","sent_to","device_id","created_at","table","user_id","sent_timestamp","opened","updated_at","uuid",schema_name) select "secret","from","message_id","message","sent_to","device_id","created_at","table",(select "userID" from shulesoft.user where uuid=(select uuid from %I.user where "userID"=a."user_id")),"sent_timestamp","opened","updated_at","uuid", ''%I'' from %I.reply_sms a',schema_,schema_,schema_);

execute sql_;
--63. cash requests
sql_=format('INSERT into shulesoft.cash_requests ("amount","requested_by","requested_by_table","requested_date","checked_by","checked_by_table","checked_date","approved_by","approved_by_table","approved_date","received_by","received_by_table","received_date","created_at","updated_at","particulars","uuid",schema_name) select "amount",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."requested_by_table" and  "id"=a."requested_by" limit 1) limit 1),"requested_by_table","requested_date",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."checked_by_table" and  "id"=a."checked_by"  limit 1)  limit 1),"checked_by_table","checked_date",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."approved_by_table" and  "id"=a."approved_by"  limit 1)  limit 1),"approved_by_table","approved_date",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."received_by_table" and  "id"=a."received_by"  limit 1)  limit 1),"received_by_table","received_date","created_at","updated_at","particulars","uuid", ''%I'' from %I.cash_requests a',schema_,schema_,schema_,schema_,schema_,schema_);

execute sql_;
--64. mark
sql_=format('INSERT into shulesoft.mark ("examID","exam","student_id","classesID","subjectID","subject","mark","year","created_at","postion","academic_year_id","status","created_by","table","updated_at","uuid",schema_name) select (select "examID" from shulesoft.exam where uuid=(select uuid from %I.exam where "examID"=a."examID")),"exam",(select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),(select "classesID" from shulesoft.classes where uuid=(select uuid from %I.classes where "classesID"=a."classesID")),(select "subjectID" from shulesoft.subject where uuid=(select uuid from %I.subject where "subjectID"=a."subjectID")),"subject","mark","year","created_at","postion",(select id from shulesoft.academic_year where uuid=(select uuid from %I.academic_year where id=a.academic_year_id)),"status",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."table" and  "id"=a."created_by") limit 1),"table","updated_at","uuid", ''%I'' from %I.mark a',schema_,schema_,schema_,schema_,schema_,schema_,schema_,schema_);

execute sql_;
--65. subject student
sql_=format('INSERT into shulesoft.subject_student ("subject_id","student_id","created_at","academic_year_id","uuid",schema_name) select (select "subjectID" from shulesoft.subject where uuid=(select uuid from %I.subject where "subjectID"=a."subject_id")),(select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),"created_at",(select id from shulesoft.academic_year where uuid=(select uuid from %I.academic_year where id=a.academic_year_id)),"uuid", ''%I'' from %I.subject_student a',schema_,schema_,schema_,schema_,schema_);

execute sql_;
--66. subject mark
sql_=format('INSERT into shulesoft.subject_mark ("grade_mark","effort_mark","achievement_mark","student_id","subjectID","classesID","academic_year_id","examID","created_at","updated_at","sectionID","year","exam","subject","status","uuid",schema_name) select "grade_mark","effort_mark","achievement_mark",(select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),(select "subjectID" from shulesoft.subject where uuid=(select uuid from %I.subject where "subjectID"=a."subjectID")),(select "classesID" from shulesoft.classes where uuid=(select uuid from %I.classes where "classesID"=a."classesID")),(select id from shulesoft.academic_year where uuid=(select uuid from %I.academic_year where id=a.academic_year_id)),(select "examID" from shulesoft.exam where uuid=(select uuid from %I.exam where "examID"=a."examID")),"created_at","updated_at",(select "sectionID" from shulesoft.section where uuid=(select uuid from %I.section where "sectionID"=a."sectionID")),"year","exam","subject","status","uuid", ''%I'' from %I.subject_mark a',schema_,schema_,schema_,schema_,schema_,schema_,schema_,schema_);

execute sql_;
--67. subject topic
sql_=format('INSERT into shulesoft.subject_topic ("subject_id","subjectID","topic_name","status","semester_id","academic_year_id","classesID","uuid",schema_name) select (select subject_id from shulesoft.refer_subject where uuid=(select uuid from %I.refer_subject where subject_id=a.subject_id)),(select "subjectID" from shulesoft.subject where uuid=(select uuid from %I.subject where "subjectID"=a."subjectID")),"topic_name","status",(select id from shulesoft.semester where uuid=(select uuid from %I.semester where id=a.semester_id)),(select id from shulesoft.academic_year where uuid=(select uuid from %I.academic_year where id=a.academic_year_id)),(select "classesID" from shulesoft.classes where uuid=(select uuid from %I.classes where "classesID"=a."classesID")),"uuid", ''%I'' from %I.subject_topic a',schema_,schema_,schema_,schema_,schema_,schema_,schema_);

execute sql_;
--68. examschedule
sql_=format('INSERT into shulesoft.examschedule ("examID","classesID","sectionID","subjectID","edate","examfrom","examto","room","year","created_at","uuid",schema_name) select (select "examID" from shulesoft.exam where uuid=(select uuid from %I.exam where "examID"=a."examID")),(select "classesID" from shulesoft.classes where uuid=(select uuid from %I.classes where "classesID"=a."classesID")),(select "sectionID" from shulesoft.section where uuid=(select uuid from %I.section where "sectionID"=a."sectionID")),(select "subjectID" from shulesoft.subject where uuid=(select uuid from %I.subject where "subjectID"=a."subjectID")),"edate","examfrom","examto","room","year","created_at","uuid", ''%I'' from %I.examschedule a',schema_,schema_,schema_,schema_,schema_,schema_);

execute sql_;
--69. tours
sql_=format('INSERT into shulesoft.tours ("location","name","created_at","updated_at","uuid",schema_name) select "location","name","created_at","updated_at","uuid", ''%I'' from %I.tours',schema_,schema_);

execute sql_;
--70. duties
sql_=format('INSERT into shulesoft.duties ("start_date","end_date","name","created_at","updated_at","created_by","uuid",schema_name) select "start_date","end_date","name","created_at","updated_at","created_by","uuid", ''%I'' from %I.duties',schema_,schema_);

execute sql_;
--71. duty reports
sql_=format('INSERT into shulesoft.duty_reports ("date","transport","feed","special_event","tod_comment","headteacher_comment","created_at","updated_at","created_by","created_by_table","duty_id","uuid",schema_name) select "date","transport","feed","special_event","tod_comment","headteacher_comment","created_at","updated_at",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."created_by_table" and  "id"=a."created_by"::bigint)),"created_by_table",(select id from shulesoft.duties where uuid=(select uuid from %I.duties where id=a.duty_id)),"uuid", ''%I'' from %I.duty_reports a',schema_,schema_,schema_,schema_);

execute sql_;
--72. youtube access tokens
sql_=format('INSERT into shulesoft.youtube_access_tokens ("access_token","created_at","updated_at","uuid",schema_name) select "access_token","created_at","updated_at","uuid", ''%I'' from %I.youtube_access_tokens',schema_,schema_);

execute sql_;
 RETURN 0; 
 END; 

$BODY$;

CREATE OR REPLACE FUNCTION shulesoft.transfer_stage_four(
	schema_ text)
    RETURNS numeric
    LANGUAGE 'plpgsql'
AS $BODY$

 DECLARE 
	sql_ text;
 BEGIN 
-- we set statement timeout =0. This will cost our cpu and memory but for the sake of effective transfer, this is  almost a mandatory statement
  SET statement_timeout = 0; 
 -- to prevent db reset during running a long query, we set this to infinity
  SET idle_in_transaction_session_timeout = 0;
--73. syllabus topics
sql_=format('INSERT into shulesoft.syllabus_topics ("code","title","subject_id","start_date","end_date","created_at","updated_at","uuid",schema_name) select "code","title",(select "subjectID" from shulesoft.subject where uuid=(select uuid from %I.subject where "subjectID"=a."subject_id")),"start_date","end_date","created_at","updated_at","uuid", ''%I'' from %I.syllabus_topics a',schema_,schema_,schema_);

execute sql_;
--74. forum questions
sql_=format('INSERT into shulesoft.forum_questions ("syllabus_topic_id","title","question","created_by","created_by_table","created_at","updated_at","status","uuid",schema_name) select (select "id" from shulesoft.syllabus_topics where uuid=(select uuid from %I.syllabus_topics where "id"=a."syllabus_topic_id")),"title","question",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."created_by_table" and  "id"=a."created_by")),"created_by_table","created_at","updated_at","status","uuid", ''%I'' from %I.forum_questions a',schema_,schema_,schema_,schema_);

execute sql_;
--75. forum questions viewers
sql_=format('INSERT into shulesoft.forum_question_viewers ("forum_question_id","created_by","created_by_table","created_at","updated_at","uuid",schema_name) select (select "id" from shulesoft.forum_questions where uuid=(select uuid from %I.forum_questions where "id"=a."forum_question_id")),(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."created_by_table" and  "id"=a."created_by")),"created_by_table","created_at","updated_at","uuid", ''%I'' from %I.forum_question_viewers a',schema_,schema_,schema_,schema_);

execute sql_;
--76. log table
--sql_=format('INSERT into shulesoft.log ("url","user_agent","platform","platform_name","source","created_at","updated_at","user","user_id","country","city","region","isp","table","controller","method","is_ajax","request","uuid",schema_name) select "url","user_agent","platform","platform_name","source","created_at","updated_at","user",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."table" and  "id"=a."user_id")),"country","city","region","isp","table","controller","method","is_ajax","request","uuid", ''%I'' from %I.log a',schema_,schema_,schema_);

--execute sql_;
--77. minor exams
sql_=format('INSERT into shulesoft.minor_exams ("subject_id","exam_group_id","date","note","created_by","created_by_table","created_at","updated_at","total_question","publish_exam","publish_result","syllabus_topic_id","total_time","uuid",schema_name) select (select "subjectID" from shulesoft.subject where uuid=(select uuid from %I.subject where "subjectID"=a."subject_id")),(select "id" from shulesoft.exam_groups where uuid=(select uuid from %I.exam_groups where "id"=a."exam_group_id")),"date","note",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."created_by_table" and  "id"=a."created_by")),"created_by_table","created_at","updated_at","total_question","publish_exam","publish_result",(select "id" from shulesoft.syllabus_topics where uuid=(select uuid from %I.syllabus_topics where "id"=a."syllabus_topic_id")),"total_time","uuid", ''%I'' from %I.minor_exams a',schema_,schema_,schema_,schema_,schema_,schema_);

execute sql_;
--78. minor exams marks
sql_=format('INSERT into shulesoft.minor_exam_marks ("minor_exam_id","student_id","mark","academic_year_id","status","created_by","created_by_table","created_at","updated_at","uuid",schema_name) select (select "id" from shulesoft.minor_exams where uuid=(select uuid from %I.minor_exams where "id"=a."minor_exam_id")),(select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),"mark",(select id from shulesoft.academic_year where uuid=(select uuid from %I.academic_year where id=a.academic_year_id)),"status",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."created_by_table" and  "id"=a."created_by")),"created_by_table","created_at","updated_at","uuid", ''%I'' from %I.minor_exam_marks a',schema_,schema_,schema_,schema_,schema_,schema_);

execute sql_;
--79. questions
sql_=format('INSERT into shulesoft.questions ("minor_exam_id","question","weight","created_at","updated_at","attach","type","uuid",schema_name) select (select "id" from shulesoft.minor_exams where uuid=(select uuid from %I.minor_exams where "id"=a."minor_exam_id")),"question","weight","created_at","updated_at","attach","type","uuid", ''%I'' from %I.questions a',schema_,schema_,schema_);

execute sql_;
--80. valid answers
sql_=format('INSERT into shulesoft.valid_answers ("question_id","answer","status","created_at","updated_at","uuid",schema_name) select (select "id" from shulesoft.questions where uuid=(select uuid from %I.questions where "id"=a."question_id")),"answer","status","created_at","updated_at","uuid", ''%I'' from %I.valid_answers a',schema_,schema_,schema_);

execute sql_;
--81. exam comments
sql_=format('INSERT into shulesoft.exam_comments ("body","student_id","exam_report_id","created_at","updated_at","user_id","name","academic_year_id","status","user_table","uuid",schema_name) select "body",(select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)), (select "id" from shulesoft.exam_report where uuid=(select uuid from %I.exam_report where "id"=a."exam_report_id")),"created_at","updated_at",(select "userID" from shulesoft.user where uuid=(select uuid from %I.user where "userID"=a."user_id")),"name",(select id from shulesoft.academic_year where uuid=(select uuid from %I.academic_year where id=a.academic_year_id)),"status","user_table","uuid", ''%I'' from %I.exam_comments a',schema_,schema_,schema_,schema_,schema_,schema_);

execute sql_;

--82. sponsors
sql_=format('INSERT into shulesoft.sponsors ("name","location_address","phone_no","email","created_at","uuid",schema_name) select "name","location_address","phone_no","email","created_at","uuid", ''%I'' from %I.sponsors',schema_,schema_);

execute sql_;
--83. student sponsors
sql_=format('INSERT into shulesoft.student_sponsors ("student_id","sponsor_id","uuid",schema_name) select (select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),(select student_id from shulesoft.sponsors where uuid=(select uuid from %I.sponsors where id=a.sponsor_id)),"uuid", ''%I'' from %I.student_sponsors a',schema_,schema_,schema_,schema_);

execute sql_;
--84. special promotion
sql_=format('INSERT into shulesoft.special_promotion ("student_id","from_academic_year_id","to_academic_year_id","pass_mark","remark","created_at","updated_at","status","uuid",schema_name) select (select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),(select id from shulesoft.academic_year where uuid=(select uuid from %I.academic_year where id=a.from_academic_year_id)),(select id from shulesoft.academic_year where uuid=(select uuid from %I.academic_year where id=a.to_academic_year_id)),"pass_mark","remark","created_at","updated_at","status","uuid", ''%I'' from %I.special_promotion a',schema_,schema_,schema_,schema_,schema_);

execute sql_;
--85. characters
sql_=format('INSERT into shulesoft.characters ("code","description","created_by","created_by_id","created_at","updated_at","character_category_id","position","uuid",schema_name) select "code","description",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."created_by" and  "id"=a."created_by_id")),"created_by_id","created_at","updated_at","character_category_id","position","uuid", ''%I'' from %I.characters a',schema_,schema_,schema_);

execute sql_;
--86. student duties
sql_=format('INSERT into shulesoft.student_duties ("duty_id","student_id","created_at","updated_at","uuid",schema_name) select (select id from shulesoft.duties where uuid=(select uuid from %I.duties where id=a.duty_id)),(select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),"created_at","updated_at","uuid", ''%I'' from %I.student_duties a',schema_,schema_,schema_, schema_);

execute sql_;
--87. application
sql_=format('INSERT into shulesoft.application ("student_id","apply_for","created_at","created_by","uuid",schema_name) select (select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),"apply_for","created_at",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "id"=a."created_by" limit 1)),"uuid", ''%I'' from %I.application a',schema_,schema_,schema_,schema_);

execute sql_;
--88. student characters
sql_=format('INSERT into shulesoft.student_characters ("student_id","semester_id","character_id","teacher_id","grade1","grade2","remark","created_at","updated_at","classes_id","status","grade3","grade4","grade5","grade","exam_id","uuid",schema_name) select (select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),(select id from shulesoft.semester where uuid=(select uuid from %I.semester where id=a.semester_id)),(select id from shulesoft.characters where uuid=(select uuid from %I.characters where id=a.character_id)),(select "teacherID" from shulesoft.teacher where uuid=(select uuid from %I.teacher where "teacherID"=a."teacher_id")),"grade1","grade2","remark","created_at","updated_at",(select "classesID" from shulesoft.classes where uuid=(select uuid from %I.classes where "classesID"=a."classes_id")),"status","grade3","grade4","grade5","grade",(select "examID" from shulesoft.exam where uuid=(select uuid from %I.exam where "examID"=a."exam_id")),"uuid", ''%I'' from %I.student_characters a',schema_,schema_,schema_,schema_,schema_,schema_,schema_,schema_);

execute sql_;
--89. syllabus sub topics
sql_=format('INSERT into shulesoft.syllabus_subtopics ("syllabus_topic_id","code","subtitle","start_date","end_date","created_at","updated_at","uuid",schema_name) select(select id from shulesoft.syllabus_topics where uuid=(select uuid from %I.syllabus_topics where id=a.syllabus_topic_id)),"code","subtitle","start_date","end_date","created_at","updated_at","uuid", ''%I'' from %I.syllabus_subtopics a',schema_,schema_,schema_);

execute sql_;
--90. syllabus objectives
sql_=format('INSERT into shulesoft.syllabus_objectives ("syllabus_subtopic_id","objective","activities","resources","assessment_criteria","remarks","periods","created_at","updated_at","uuid",schema_name) select (select id from shulesoft.syllabus_subtopics where uuid=(select uuid from %I.syllabus_subtopics where id=a.syllabus_subtopic_id)),"objective","activities","resources","assessment_criteria","remarks","periods","created_at","updated_at","uuid", ''%I'' from %I.syllabus_objectives a',schema_,schema_,schema_);

execute sql_;
--91. syllabus benchmarks
sql_=format('INSERT into shulesoft.syllabus_benchmarks ("grade_remark","grade","description","points","created_at","updated_at","uuid",schema_name) select "grade_remark","grade","description","points","created_at","updated_at","uuid", ''%I'' from %I.syllabus_benchmarks',schema_,schema_);

execute sql_;
--92. syllabus student benchmarking
sql_=format('INSERT into shulesoft.syllabus_student_benchmarking ("student_id","syllabus_benchmark_id","syllabus_objective_id","created_by_id","created_by_table","created_at","updated_at","semester_id","syllabus_topic_id","uuid",schema_name) select (select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),(select id from shulesoft.syllabus_benchmarks where uuid=(select uuid from %I.syllabus_benchmarks where id=a.syllabus_benchmark_id)), (select id from shulesoft.syllabus_objectives where uuid=(select uuid from %I.syllabus_objectives where id=a.syllabus_objective_id)),(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."created_by_table" and  "id"=a."created_by_id")),"created_by_table","created_at","updated_at",(select id from shulesoft.semester where uuid=(select uuid from %I.semester where id=a.semester_id)),(select id from shulesoft.syllabus_topics where uuid=(select uuid from %I.syllabus_topics where id=a.syllabus_topic_id)),"uuid", ''%I'' from %I.syllabus_student_benchmarking a',schema_,schema_,schema_,schema_,schema_,schema_,schema_,schema_);

execute sql_;
--93. syllabus objective reference
sql_=format('INSERT into shulesoft.syllabus_objective_references ("syllabus_objective_id","book_id","page_description","reference_type","created_by_id","created_by_table","created_at","updated_at","uuid",schema_name) select (select id from shulesoft.syllabus_objectives where uuid=(select uuid from %I.syllabus_objectives where id=a.syllabus_objective_id)),(select id from shulesoft.book where uuid=(select uuid from %I.book where id=a.book_id)),"page_description","reference_type",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."created_by_table" and  "id"=a."created_by_id")),"created_by_table","created_at","updated_at","uuid", ''%I'' from %I.syllabus_objective_references a',schema_,schema_,schema_,schema_,schema_);

execute sql_;
--94 syllabus subtopics teachers
sql_=format('INSERT into shulesoft.syllabus_subtopics_teachers ("syllabus_subtopic_id","teacher_id","year","created_at","updated_at","uuid",schema_name) select (select id from shulesoft.syllabus_subtopics where uuid=(select uuid from %I.syllabus_subtopics where id=a.syllabus_subtopic_id)),(select "teacherID" from shulesoft.teacher where uuid=(select uuid from %I.teacher where "teacherID"=a."teacher_id")),"year","created_at","updated_at","uuid", ''%I'' from %I.syllabus_subtopics_teachers a',schema_,schema_,schema_,schema_);

execute sql_;
--95. lesson plan
sql_=format('INSERT into shulesoft.lesson_plan ("syllabus_objective_id","stage_position","stage_name","activity","time_taken","resource","teacher_id","created_by_id","created_by_table","created_at","updated_at","uuid",schema_name) select (select id from shulesoft.syllabus_objectives where uuid=(select uuid from %I.syllabus_objectives where id=a.syllabus_objective_id)),"stage_position","stage_name","activity","time_taken","resource",(select "teacherID" from shulesoft.teacher where uuid=(select uuid from %I.teacher where "teacherID"=a."teacher_id")),(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."created_by_table" and  "id"=a."created_by_id")),"created_by_table","created_at","updated_at","uuid", ''%I'' from %I.lesson_plan a',schema_,schema_,schema_,schema_,schema_);

execute sql_;
--96. teacher duties
sql_=format('INSERT into shulesoft.teacher_duties ("duty_id","teacher_id","created_at","updated_at","uuid",schema_name) select (select id from shulesoft.duties where uuid=(select uuid from %I.duties where id=a.duty_id)),(select "teacherID" from shulesoft.teacher where uuid=(select uuid from %I.teacher where "teacherID"=a."teacher_id")),"created_at","updated_at","uuid", ''%I'' from %I.teacher_duties a',schema_,schema_,schema_,schema_);

execute sql_;
--97. media category
sql_=format('INSERT into shulesoft.media_category ("folder_name","create_time","created_at","uuid",schema_name) select "folder_name","create_time","created_at","uuid", ''%I'' from %I.media_category',schema_,schema_);

execute sql_;
 RETURN 0; 
 END; 

$BODY$;

CREATE OR REPLACE FUNCTION shulesoft.transfer_stage_five(
	schema_ text)
    RETURNS numeric
    LANGUAGE 'plpgsql'
AS $BODY$

 DECLARE 
	sql_ text;
 BEGIN 
-- we set statement timeout =0. This will cost our cpu and memory but for the sake of effective transfer, this is  almost a mandatory statement
  SET statement_timeout = 0; 
 -- to prevent db reset during running a long query, we set this to infinity
  SET idle_in_transaction_session_timeout = 0;
--98. media table
sql_=format('INSERT into shulesoft.media ("userID","usertype","mcategoryID","file_name","file_name_display","created_at","table","class","name","uuid",schema_name) select (select "userID" from shulesoft.user where uuid=(select uuid from %I.user where "userID"=a."userID")),"usertype",(select id from shulesoft.media_category where uuid=(select uuid from %I.media_category where id=a."mcategoryID")),"file_name","file_name_display","created_at","table","class","name","uuid", ''%I'' from %I.media a',schema_,schema_,schema_,schema_);

execute sql_;
--99. media option
sql_=format('INSERT into shulesoft.medias ("created_by","size","media_category_id","title","description","created_at","created_by_table","url","name","syllabus_topic_id","updated_at","status","syllabus_subtopic_id","media_link","uuid",schema_name) select (select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."created_by_table" and  "id"=a."created_by")),"size",(select id from shulesoft.media_category where uuid=(select uuid from %I.media_category where id=a."media_category_id")),"title","description","created_at","created_by_table","url","name",(select id from shulesoft.syllabus_topics where uuid=(select uuid from %I.syllabus_topics where id=a."syllabus_topic_id")),"updated_at","status",(select id from shulesoft.syllabus_subtopics where uuid=(select uuid from %I.syllabus_subtopics where id=a."syllabus_subtopic_id")),"media_link","uuid", ''%I'' from %I.medias a',schema_,schema_,schema_,schema_,schema_,schema_);

execute sql_;

--100. media comments
sql_=format('INSERT into shulesoft.media_comments ("media_id","comment","created_by","created_by_table","created_at","updated_at","uuid",schema_name) select (select id from shulesoft.medias where uuid=(select uuid from %I.medias where id=a.media_id)),"comment",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."created_by_table" and  "id"=a."created_by")),"created_by_table","created_at","updated_at","uuid", ''%I'' from %I.media_comments a',schema_,schema_,schema_,schema_);

execute sql_;
--101. media comment reply
sql_=format('INSERT into shulesoft.media_comment_reply ("user_id","table","comment","comment_id","created_at","updated_at","opened","uuid",schema_name) select (select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."table" and  "id"=a."user_id")),"table","comment",(select id from shulesoft.media_comments where uuid=(select uuid from %I.media_comments where id=a.comment_id)),"created_at","updated_at","opened","uuid", ''%I'' from %I.media_comment_reply a',schema_,schema_,schema_,schema_);

execute sql_;

--102. assignement downloads

sql_=format('INSERT into shulesoft.assignments ("subject_id","note","created_at","updated_at","title","attach","attach_file_name","due_date","exam_group_id","uuid",schema_name) select (select "subjectID" from shulesoft.subject where uuid=(select uuid from %I.subject where "subjectID"=a."subject_id")),"note","created_at","updated_at","title","attach","attach_file_name","due_date",(select id from shulesoft.exam_groups where uuid=(select uuid from %I.exam_groups where id=a.exam_group_id)),"uuid", ''%I'' from %I.assignments a',schema_,schema_,schema_,schema_);

execute sql_;


sql_=format('INSERT into shulesoft.assignment_downloads ("assignment_id","counter","created_by","created_by_table","created_at","updated_at","uuid",schema_name) select (select id from shulesoft.assignments where uuid=(select uuid from %I.assignments where id=a.assignment_id)),"counter",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."created_by_table" and  "id"=a."created_by")),"created_by_table","created_at","updated_at","uuid", ''%I'' from %I.assignment_downloads a',schema_,schema_,schema_,schema_);

execute sql_;
--103. media likes
sql_=format('INSERT into shulesoft.media_likes ("media_id","created_by","created_by_table","created_at","updated_at","type","uuid",schema_name) select (select id from shulesoft.medias where uuid=(select uuid from %I.medias where id=a.media_id)),(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."created_by_table" and  "id"=a."created_by")),"created_by_table","created_at","updated_at","type","uuid", ''%I'' from %I.media_likes a',schema_,schema_,schema_,schema_);

execute sql_;
--104. media live
sql_=format('INSERT into shulesoft.media_live ("media_id","start_time","streaming_url","created_at","updated_at","end_time","source","date","uuid",schema_name) select (select id from shulesoft.medias where uuid=(select uuid from %I.medias where id=a.media_id)),"start_time","streaming_url","created_at","updated_at","end_time","source","date","uuid", ''%I'' from %I.media_live a',schema_,schema_,schema_);

execute sql_;
--105. media live comments
sql_=format('INSERT into shulesoft.media_live_comments ("media_live_id","comment","created_by","created_by_table","created_at","updated_at","uuid",schema_name) select (select id from shulesoft.media_live where uuid=(select uuid from %I.media_live where id=a.media_live_id)),"comment",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."created_by_table" and  "id"=a."created_by")),"created_by_table","created_at","updated_at","uuid", ''%I'' from %I.media_live_comments a',schema_,schema_,schema_,schema_);

execute sql_;
--106. media viewers
sql_=format('INSERT into shulesoft.media_viewers ("media_id","created_by","created_by_table","created_at","updated_at","uuid",schema_name) select (select id from shulesoft.medias where uuid=(select uuid from %I.medias where id=a.media_id)),(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."created_by_table" and  "id"=a."created_by")),"created_by_table","created_at","updated_at","uuid", ''%I'' from %I.media_viewers a',schema_,schema_,schema_,schema_);

execute sql_;
--107.necta
sql_=format('INSERT into shulesoft.necta ("name","class_level_id","url","year","regional_position","national_position","candidate_type","centre_gpa","created_at","updated_at","created_by_id","created_by_user_table","uuid",schema_name) select "name",(select classlevel_id from shulesoft.classlevel where uuid=(select uuid from %I.classlevel where classlevel_id=a.class_level_id)),"url","year","regional_position","national_position","candidate_type","centre_gpa","created_at","updated_at","created_by_id","created_by_user_table","uuid", ''%I'' from %I.necta a',schema_,schema_,schema_);

execute sql_;
--108. page tips
sql_=format('INSERT into shulesoft.page_tips_viewers ("user_id","table","page_tip_id","created_at","updated_at","is_helpful","not_helpful_comment","uuid",schema_name) select (select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."table" and  "id"=a."user_id")),"table","page_tip_id","created_at","updated_at","is_helpful","not_helpful_comment","uuid", ''%I'' from %I.page_tips_viewers a',schema_,schema_,schema_);

execute sql_;
--109. files share
sql_=format('INSERT into shulesoft.file_share ("classesID","public","file_or_folder","item_id","created_at","uuid",schema_name) select (select "classesID" from shulesoft.classes where uuid=(select uuid from %I.classes where "classesID"=a."classesID")),"public","file_or_folder","item_id","created_at","uuid", ''%I'' from %I.file_share a',schema_,schema_,schema_);

execute sql_;
--110. forum categories
sql_=format('INSERT into shulesoft.forum_categories ("parent_id","class_id","order","name","color","slug","created_at","updated_at","uuid",schema_name) select (select "parentID" from shulesoft.parent where uuid=(select uuid from %I.parent where "parentID"=a."parent_id")),(select "classesID" from shulesoft.classes where uuid=(select uuid from %I.classes where "classesID"=a."class_id")),"order","name","color","slug","created_at","updated_at","uuid", ''%I'' from %I.forum_categories a',schema_,schema_,schema_,schema_);

execute sql_;
--111. forum discussion
sql_=format('INSERT into shulesoft.forum_discussion ("forum_category_id","title","user_table","user_id","sticky","views","answered","created_at","updated_at","slug","color","deleted_at","last_reply_at","uuid",schema_name) select (select "id" from shulesoft.forum_categories where uuid=(select uuid from %I.forum_categories where "id"=a."forum_category_id")),"title","user_table",(select "userID" from shulesoft.user where uuid=(select uuid from %I.user where "userID"=a."user_id")),"sticky","views","answered","created_at","updated_at","slug","color","deleted_at","last_reply_at","uuid", ''%I'' from %I.forum_discussion a',schema_,schema_,schema_,schema_);

execute sql_;
--112. forum user discussions
sql_=format('INSERT into shulesoft.forum_user_discussion ("user_id","user_table","discussion_id","uuid",schema_name) select (select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."user_table" and  "id"=a."user_id")),"user_table",(select id from shulesoft.forum_discussion where uuid=(select uuid from %I.forum_discussion where id=a.discussion_id)),"uuid", ''%I'' from %I.forum_user_discussion a',schema_,schema_,schema_,schema_);

execute sql_;

--113. posts
sql_=format('INSERT into shulesoft.forum_post ("forum_discussion_id","user_id","user_table","body","created_at","updated_at","markdown","locked","deleted_at","uuid",schema_name) select (select id from shulesoft.forum_discussion where uuid=(select uuid from %I.forum_discussion where id=a.forum_discussion_id)),(select "id" from shulesoft.users where uuid=(select uuid from %I.users where "table"=a."user_table" and "id"=a."user_id")),"user_table","body","created_at","updated_at","markdown","locked","deleted_at","uuid", ''%I'' from %I.forum_post a',schema_,schema_,schema_,schema_);

execute sql_;
--114. forum answers
sql_=format('INSERT into shulesoft.forum_answers ("forum_question_id","answer","created_by","created_by_table","created_at","updated_at","is_correct","teacher_id","uuid",schema_name) select (select "id" from shulesoft.forum_questions where uuid=(select uuid from %I.forum_questions where "id"=a."forum_question_id")),"answer",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."created_by_table" and  "id"=a."created_by")),"created_by_table","created_at","updated_at","is_correct",(select "teacherID" from shulesoft.teacher where uuid=(select uuid from %I.teacher where "teacherID"=a."teacher_id")),"uuid", ''%I'' from %I.forum_answers a',schema_,schema_,schema_,schema_,schema_);

execute sql_;
--115. answer votes
sql_=format('INSERT into shulesoft.forum_answer_votes ("forum_answer_id","vote_type","created_by","created_by_table","created_at","updated_at","uuid",schema_name) select (select "id" from shulesoft.forum_answers where uuid=(select uuid from %I.forum_answers where "id"=a."forum_answer_id")),"vote_type",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."created_by_table" and  "id"=a."created_by")),"created_by_table","created_at","updated_at","uuid", ''%I'' from %I.forum_answer_votes a',schema_,schema_,schema_,schema_);

execute sql_;

--116. forum question commnets
sql_=format('INSERT into shulesoft.forum_questions_comments ("forum_question_id","content","created_by","created_by_table","created_at","updated_at","uuid",schema_name) select (select "id" from shulesoft.forum_questions where uuid=(select uuid from %I.forum_questions where "id"=a."forum_question_id")),"content",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."created_by_table" and  "id"=a."created_by")),"created_by_table","created_at","updated_at","uuid", ''%I'' from %I.forum_questions_comments a',schema_,schema_,schema_,schema_);

execute sql_;
--117 forum question votes
sql_=format('INSERT into shulesoft.forum_questions_votes ("forum_question_answer_id","vote_type","created_by","created_by_table","created_at","updated_at","uuid",schema_name) select (select "id" from shulesoft.forum_answers where uuid=(select uuid from %I.forum_answers where "id"=a."forum_question_answer_id")),"vote_type",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."created_by_table" and  "id"=a."created_by")),"created_by_table","created_at","updated_at","uuid", ''%I'' from %I.forum_questions_votes a',schema_,schema_,schema_,schema_);

execute sql_;

--118
sql_=format('INSERT into shulesoft.mailandsms ("users","type","message","create_date","year","created_at","uuid",schema_name) select "users","type","message","create_date","year","created_at","uuid", ''%I'' from %I.mailandsms',schema_,schema_);

execute sql_;
--119
sql_=format('INSERT into shulesoft.media_share ("classesID","public","file_or_folder","item_id","create_time","created_at","uuid",schema_name) select (select "classesID" from shulesoft.classes where uuid=(select uuid from %I.classes where "classesID"=a."classesID")),"public","file_or_folder","item_id","create_time","created_at","uuid", ''%I'' from %I.media_share a',schema_,schema_,schema_);

execute sql_;
 RETURN 0; 
 END; 

$BODY$;

CREATE OR REPLACE FUNCTION shulesoft.transfer_stage_six(
	schema_ text)
    RETURNS numeric
    LANGUAGE 'plpgsql'
AS $BODY$

 DECLARE 
	sql_ text;
 BEGIN 
-- we set statement timeout =0. This will cost our cpu and memory but for the sake of effective transfer, this is  almost a mandatory statement
  SET statement_timeout = 0; 
 -- to prevent db reset during running a long query, we set this to infinity
  SET idle_in_transaction_session_timeout = 0;
--120
sql_=format('INSERT into shulesoft.refer_character_grading_systems ("grade_remark","grade","description","points","created_at","updated_at","uuid",schema_name) select "grade_remark","grade","description","points","created_at","updated_at","uuid", ''%I'' from %I.refer_character_grading_systems',schema_,schema_);

execute sql_;

--121
sql_=format('INSERT into shulesoft.reply_msg ("messageID","reply_msg","status","create_time","created_at","sender_id","sender_table","updated_at","uuid",schema_name) select (select "messageID" from shulesoft.message where uuid=(select uuid from %I.message where "messageID"=a."messageID")),"reply_msg","status","create_time","created_at",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."sender_table" and  "id"=a."sender_id")),"sender_table","updated_at","uuid", ''%I'' from %I.reply_msg a',schema_,schema_,schema_,schema_);

execute sql_;
--122
sql_=format('INSERT into shulesoft.assignment_files ("assignment_id","attach","attach_file_name","created_at","updated_at","status","uuid",schema_name) select (select id from shulesoft.assignments where uuid=(select uuid from %I.assignments where id=a.assignment_id)),"attach","attach_file_name","created_at","updated_at","status","uuid", ''%I'' from %I.assignment_files a',schema_,schema_,schema_);

execute sql_;
--123
sql_=format('INSERT into shulesoft.assignments_submitted ("assignment_id","created_at","updated_at","student_id","score_mark","attach","attach_file_name","note","uuid",schema_name) select (select id from shulesoft.assignments where uuid=(select uuid from %I.assignments where id=a.assignment_id)),"created_at","updated_at",(select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),"score_mark","attach","attach_file_name","note","uuid", ''%I'' from %I.assignments_submitted a',schema_,schema_,schema_,schema_);

execute sql_;
--124
sql_=format('INSERT into shulesoft.submit_files ("attach","attach_file_name","created_at","updated_at","status","uuid",schema_name) select "attach","attach_file_name","created_at","updated_at","status","uuid", ''%I'' from %I.submit_files',schema_,schema_);

execute sql_;
--123
sql_=format('INSERT into shulesoft.assignment_viewers ("assignment_id","created_by","created_by_table","created_at","updated_at","uuid",schema_name) select (select id from shulesoft.assignments where uuid=(select uuid from %I.assignments where id=a.assignment_id)),(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."created_by_table" and  "id"=a."created_by")),"created_by_table","created_at","updated_at","uuid", ''%I'' from %I.assignment_viewers a',schema_,schema_,schema_,schema_);

execute sql_;
--124
sql_=format('INSERT into shulesoft.book_quantity ("book_id","status","book_condition","bID","updated_at","created_at","uuid",schema_name) select (select id from shulesoft.book where uuid=(select uuid from %I.book where id=a.book_id)),"status","book_condition","bID","updated_at","created_at","uuid", ''%I'' from %I.book_quantity a',schema_,schema_,schema_);

execute sql_;
--125
sql_=format('INSERT into shulesoft.book_class ("classes_id","created_at",book_id,"updated_at","uuid",schema_name) select (select "classesID" from shulesoft.classes where uuid=(select uuid from %I.classes where "classesID"=a."classes_id")),"created_at",(select id from shulesoft.book where uuid=(select uuid from %I.book where id=a.book_id)),"updated_at","uuid", ''%I'' from %I.book_class a',schema_,schema_,schema_,schema_);

execute sql_;
--126
sql_=format('INSERT into shulesoft.attendance ("student_id","classesID","userID","usertype","monthyear","a1","a2","a3","a4","a5","a6","a7","a8","a9","a10","a11","a12","a13","a14","a15","a16","a17","a18","a19","a20","a21","a22","a23","a24","a25","a26","a27","a28","a29","a30","a31","created_at","uuid",schema_name) select (select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),(select "classesID" from shulesoft.classes where uuid=(select uuid from %I.classes where "classesID"=a."classesID")),(select "userID" from shulesoft.user where uuid=(select uuid from %I.user where "userID"=a."userID")),"usertype","monthyear","a1","a2","a3","a4","a5","a6","a7","a8","a9","a10","a11","a12","a13","a14","a15","a16","a17","a18","a19","a20","a21","a22","a23","a24","a25","a26","a27","a28","a29","a30","a31","created_at","uuid", ''%I'' from %I.attendance a',schema_,schema_,schema_,schema_,schema_);

execute sql_;
--127
sql_=format('INSERT into shulesoft.eattendance ("examID","classesID","subjectID","date","student_id","s_name","eattendance","year","eextra","created_at","uuid",schema_name) select  (select "examID" from shulesoft.exam where uuid=(select uuid from %I.exam where "examID"=a."examID")),(select "classesID" from shulesoft.classes where uuid=(select uuid from %I.classes where "classesID"=a."classesID")),(select "subjectID" from shulesoft.subject where uuid=(select uuid from %I.subject where "subjectID"=a."subjectID")),"date",(select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),"s_name","eattendance","year","eextra","created_at","uuid", ''%I'' from %I.eattendance a',schema_,schema_,schema_,schema_,schema_,schema_);

execute sql_;
--128
sql_=format('INSERT into shulesoft.character_classes ("character_id","class_id","created_at","updated_at","created_by","created_by_table","uuid",schema_name) select (select id from shulesoft.characters where uuid=(select uuid from %I.characters where id=a.character_id)),(select "classesID" from shulesoft.classes where uuid=(select uuid from %I.classes where "classesID"=a."class_id")),"created_at","updated_at",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."created_by_table" and  "id"=a."created_by")),"created_by_table","uuid", ''%I'' from %I.character_classes a',schema_,schema_,schema_,schema_,schema_);

execute sql_;
--129
sql_=format('INSERT into shulesoft.character_categories ("character_category","based_on","position","uuid",schema_name) select "character_category","based_on","position","uuid", ''%I'' from %I.character_categories',schema_,schema_);

execute sql_;


--ACCOUNT MODULE

--130
sql_=format('INSERT into shulesoft.fees ("name","priority","created_at","updated_at","uuid",schema_name) select "name","priority","created_at","updated_at","uuid", ''%I'' from %I.fees',schema_,schema_);

execute sql_;

--131
sql_=format('INSERT into shulesoft.bank_accounts ("name","number","currency","branch","refer_bank_id","opening_balance","note","created_at","updated_at","refer_currency_id","uuid",schema_name) select "name","number","currency","branch","refer_bank_id","opening_balance","note","created_at","updated_at","refer_currency_id","uuid", ''%I'' from %I.bank_accounts',schema_,schema_);

execute sql_;

--132
sql_=format('INSERT into shulesoft.feecat_class ("classesID","feetype_categoryID","uuid",schema_name) select (select "classesID" from shulesoft.classes where uuid=(select uuid from %I.classes where "classesID"=a."classesID")),"feetype_categoryID","uuid", ''%I'' from %I.feecat_class a',schema_,schema_,schema_);

execute sql_;
--133
sql_=format('INSERT into shulesoft.fees_classes ("fee_id","class_id","created_at","updated_at","uuid",schema_name) select (select id from shulesoft.fees where uuid=(select uuid from %I.fees where id=a.fee_id)),(select "classesID" from shulesoft.classes where uuid=(select uuid from %I.classes where "classesID"=a."class_id")),"created_at","updated_at","uuid", ''%I'' from %I.fees_classes a',schema_,schema_,schema_,schema_);

execute sql_;
--134
sql_=format('INSERT into shulesoft.bank_accounts_fees_classes ("bank_account_id","fees_classes_id","updated_at","created_at","uuid",schema_name) select (select id from shulesoft.bank_accounts where uuid=(select uuid from %I.bank_accounts where id=a.bank_account_id)),(select id from shulesoft.fees_classes where uuid=(select uuid from %I.fees_classes where id=a.fees_classes_id)),"updated_at","created_at","uuid", ''%I'' from %I.bank_accounts_fees_classes a',schema_,schema_,schema_,schema_);

execute sql_;

--135
sql_=format('INSERT into shulesoft.exchange_rates ("from_currency","to_currency","rate","note","created_at","updated_at","created_by_id","created_by_table","status","uuid",schema_name) select "from_currency","to_currency","rate","note","created_at","updated_at","created_by_id","created_by_table","status","uuid", ''%I'' from %I.exchange_rates',schema_,schema_);

execute sql_;

--136. invoices
sql_=format('INSERT into shulesoft.invoices ("reference","student_id","created_at","sync","return_message","push_status","date","updated_at","academic_year_id","prefix","due_date","sid","token","order_id","qr","gateway_buyer_uuid","payment_gateway_url","user_table","source","amount","status","live_package_id","uuid",schema_name) select "reference",(select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),"created_at","sync","return_message","push_status","date","updated_at",(select id from shulesoft.academic_year where uuid=(select uuid from %I.academic_year where id=a.academic_year_id)),"prefix","due_date","sid","token","order_id","qr","gateway_buyer_uuid","payment_gateway_url","user_table","source","amount","status","live_package_id","uuid", ''%I'' from %I.invoices a',schema_,schema_,schema_,schema_);

execute sql_;
--137.
sql_=format('INSERT into shulesoft.track_invoices ("reference","student_id","invoice_id","created_at","sync","return_message","push_status","date","updated_at","academic_year_id","prefix","due_date","deleted_at","session_id","usertype","uuid",schema_name) select "reference",(select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),(select id from shulesoft.invoices where uuid=(select uuid from %I.invoices where id=a.invoice_id)),"created_at","sync","return_message","push_status","date","updated_at",(select id from shulesoft.academic_year where uuid=(select uuid from %I.academic_year where id=a.academic_year_id)),"prefix","due_date","deleted_at","session_id","usertype","uuid", ''%I'' from %I.track_invoices a',schema_,schema_,schema_,schema_,schema_);

execute sql_;

--138.
sql_=format('INSERT into shulesoft.track ("user_id","user_type","table_name","column_name","column_value_from","column_final_value","created_at","status","uuid",schema_name) select (select "userID" from shulesoft.user where uuid=(select uuid from %I.user where "userID"=a."user_id")),"user_type","table_name","column_name","column_value_from","column_final_value","created_at","status","uuid", ''%I'' from %I.track a',schema_,schema_,schema_);

execute sql_;
--139
sql_=format('INSERT into shulesoft.student_fee_subscription ("fee_id","academic_year_id","student_id","status","uuid",schema_name) select (select id from shulesoft.fees where uuid=(select uuid from %I.fees where id=a.fee_id)),(select id from shulesoft.academic_year where uuid=(select uuid from %I.academic_year where id=a.academic_year_id)),(select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),"status","uuid", ''%I'' from %I.student_fee_subscription a',schema_,schema_,schema_,schema_,schema_);

execute sql_;

--140
sql_=format('INSERT into shulesoft.installments ("academic_year_id","start_date","end_date","name","created_at","updated_at","uuid",schema_name) select (select id from shulesoft.academic_year where uuid=(select uuid from %I.academic_year where id=a.academic_year_id)),"start_date","end_date","name","created_at","updated_at","uuid", ''%I'' from %I.installments a',schema_,schema_,schema_);

execute sql_;
RETURN 0; 
 END; 

$BODY$;

CREATE OR REPLACE FUNCTION shulesoft.transfer_stage_seven(
	schema_ text)
    RETURNS numeric
    LANGUAGE 'plpgsql'
AS $BODY$

 DECLARE 
	sql_ text;
 BEGIN 
-- we set statement timeout =0. This will cost our cpu and memory but for the sake of effective transfer, this is  almost a mandatory statement
  SET statement_timeout = 0; 
 -- to prevent db reset during running a long query, we set this to infinity
  SET idle_in_transaction_session_timeout = 0;
--141
sql_=format('INSERT into shulesoft.student_due_date ("student_id","due_date","installment_id","uuid",schema_name) select (select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),"due_date",(select id from shulesoft.installments where uuid=(select uuid from %I.installments where id=a.installment_id)),"uuid", ''%I'' from %I.student_due_date a',schema_,schema_,schema_,schema_);

execute sql_;

--142
sql_=format('INSERT into shulesoft.payments ("student_id","amount","payment_type_id","date","transaction_id","created_at","cheque_number","bank_account_id","payer_name","mobile_transaction_id","transaction_time","account_number","token","reconciled","receipt_code","updated_at","channel","amount_entered","created_by","created_by_table","note","invoice_id","status","sid","priority","comment","uuid","verification_code","verification_url","code",schema_name) select (select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),"amount","payment_type_id","date","transaction_id","created_at","cheque_number",(select id from shulesoft.bank_accounts where uuid=(select uuid from %I.bank_accounts where id=a.bank_account_id)),"payer_name","mobile_transaction_id","transaction_time","account_number","token","reconciled","receipt_code","updated_at","channel","amount_entered",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."created_by_table" and  "id"=a."created_by")),"created_by_table","note",(select id from shulesoft.invoices where uuid=(select uuid from %I.invoices where id=a.invoice_id)),"status","sid","priority","comment","uuid","verification_code","verification_url","code", ''%I'' from %I.payments a',schema_,schema_,schema_,schema_,schema_,schema_);

execute sql_;
--143
sql_=format('INSERT into shulesoft.advance_payments ("student_id","fee_id","payment_id","amount","created_at","updated_at","uuid",schema_name) select (select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),(select id from shulesoft.fees where uuid=(select uuid from %I.fees where id=a.fee_id)),(select id from shulesoft.payments where uuid=(select uuid from %I.payments where id=a.payment_id)),"amount","created_at","updated_at","uuid", ''%I'' from %I.advance_payments a',schema_,schema_,schema_,schema_,schema_);

execute sql_;
--145
sql_=format('INSERT into shulesoft.track_payments ("payment_id","student_id","amount","payment_type_id","date","transaction_id","created_at","cheque_number","bank_account_id","payer_name","mobile_transaction_id","transaction_time","account_number","token","reconciled","receipt_code","updated_at","channel","amount_entered","created_by","created_by_table","session_id","deleted_at","usertype","uuid",schema_name) select (select id from shulesoft.payments where uuid=(select uuid from %I.payments where id=a.payment_id)),(select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),"amount","payment_type_id","date","transaction_id","created_at","cheque_number",(select id from shulesoft.bank_accounts where uuid=(select uuid from %I.bank_accounts where id=a.bank_account_id)),"payer_name","mobile_transaction_id","transaction_time","account_number","token","reconciled","receipt_code","updated_at","channel","amount_entered",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."created_by_table" and  "id"=a."created_by")),"created_by_table","session_id","deleted_at","usertype","uuid", ''%I'' from %I.track_payments a',schema_,schema_,schema_,schema_,schema_,schema_);

execute sql_;

--146
sql_=format('INSERT into shulesoft.reminder_template ("template","class_level_id","type","academic_year_id","uuid",schema_name) select "template",(select classlevel_id from shulesoft.classlevel where uuid=(select uuid from %I.classlevel where classlevel_id=a.class_level_id)),"type",(select id from shulesoft.academic_year where uuid=(select uuid from %I.academic_year where id=a.academic_year_id)),"uuid", ''%I'' from %I.reminder_template a',schema_,schema_,schema_,schema_);

execute sql_;
--147
sql_=format('INSERT into shulesoft.user_reminders ("user_id","end_date","created_at","template_id","status","uuid",schema_name) select (select "userID" from shulesoft.user where uuid=(select uuid from %I.user where "userID"=a."user_id")),"end_date","created_at",(select id from shulesoft.reminder_template where uuid=(select uuid from %I.reminder_template where id=a.template_id)),"status","uuid", ''%I'' from %I.user_reminders a',schema_,schema_,schema_,schema_);

execute sql_;
--148
sql_=format('INSERT into shulesoft.account_groups ("name","created_at","updated_at","note","category_id","financial_category_id","predefined","uuid",schema_name) select "name","created_at","updated_at","note","category_id","financial_category_id","predefined","uuid", ''%I'' from %I.account_groups',schema_,schema_);

execute sql_;
--149
sql_=format('INSERT into shulesoft.refer_expense ("name","create_date","financial_category_id","note","status","code","date","open_balance","account_group_id","updated_at","created_at","predefined","depreciation","chart_no","uuid",schema_name) select "name","create_date","financial_category_id","note","status","code","date","open_balance",(select id from shulesoft.account_groups where uuid=(select uuid from %I.account_groups where id=a.account_group_id)),"updated_at","created_at","predefined","depreciation","chart_no","uuid", ''%I'' from %I.refer_expense a',schema_,schema_,schema_);

execute sql_;

--150
sql_=format('INSERT into shulesoft.notice ("title","notice","year","date","create_date","created_at","class_id","to_roll_id","notice_for","status","uuid",schema_name) select "title","notice","year","date","create_date","created_at",(select "classesID" from shulesoft.classes where uuid=(select uuid from %I.classes where "classesID"=a."class_id"::bigint)),(select id from shulesoft.role where uuid=(select uuid from %I.role where id=a.to_roll_id::integer)),"notice_for","status","uuid", ''%I'' from %I.notice a',schema_,schema_,schema_,schema_);

execute sql_;
--151
sql_=format('INSERT into shulesoft.admissions ("student_id","status","user_id","created_at","updated_at","comment","time","uuid",schema_name) select (select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),"status",(select "userID" from shulesoft.user where uuid=(select uuid from %I.user where "userID"=a."user_id")),"created_at","updated_at","comment","time","uuid", ''%I'' from %I.admissions a',schema_,schema_,schema_,schema_);

execute sql_;
--152
sql_=format('INSERT into shulesoft.due_amounts ("amount","student_id","fee_id","created_at","updated_at","uuid",schema_name) select "amount",(select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),(select id from shulesoft.fees where uuid=(select uuid from %I.fees where id=a.fee_id)),"created_at","updated_at","uuid", ''%I'' from %I.due_amounts a',schema_,schema_,schema_,schema_);

execute sql_;
--153
sql_=format('INSERT into shulesoft.due_amounts_payments ("payment_id","due_amount_id","amount","created_at","updated_at","uuid",schema_name) select (select id from shulesoft.payments where uuid=(select uuid from %I.payments where id=a.payment_id)),(select id from shulesoft.due_amounts where uuid=(select uuid from %I.due_amounts where id=a.due_amount_id)),"amount","created_at","updated_at","uuid", ''%I'' from %I.due_amounts_payments a',schema_,schema_,schema_,schema_);

execute sql_;
--154
sql_=format('INSERT into shulesoft.deductions ("name","percent","amount","created_at","updated_at","description","is_percentage","category","employer_amount","employer_percent","gross_pay","uuid",schema_name) select "name","percent","amount","created_at","updated_at","description","is_percentage","category","employer_amount","employer_percent","gross_pay","uuid", ''%I'' from %I.deductions',schema_,schema_);

execute sql_;
--155
sql_=format('INSERT into shulesoft.news_board ("title","role_id","body","create_date","created_at","updated_at","status","attach_file_name","attach","class_id","attachment","uuid",schema_name) select "title",(select id from shulesoft.role where uuid=(select uuid from %I.role where id=a.role_id)),"body","create_date","created_at","updated_at","status","attach_file_name","attach",(select "classesID" from shulesoft.classes where uuid=(select uuid from %I.classes where "classesID"=a."class_id"::bigint)),"attachment","uuid", ''%I'' from %I.news_board a',schema_,schema_,schema_,schema_);

execute sql_;
--156
sql_=format('INSERT into shulesoft.user_phones ("user_id","table","phone_number","created_at","updated_at","uuid",schema_name) select (select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."table" and  "id"=a."user_id")),"table","phone_number","created_at","updated_at","uuid", ''%I'' from %I.user_phones a',schema_,schema_,schema_);

execute sql_;
--157
sql_=format('INSERT into shulesoft.loan_types ("name","source","minimum_amount","maximum_amount","maximum_tenor","minimum_tenor","interest_rate","credit_ratio","created_at","updated_at","created_by","created_by_table","description","uuid",schema_name) select "name","source","minimum_amount","maximum_amount","maximum_tenor","minimum_tenor","interest_rate","credit_ratio","created_at","updated_at",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."created_by_table" and  "id"=a."created_by")),"created_by_table","description","uuid", ''%I'' from %I.loan_types a',schema_,schema_,schema_);
--158
execute sql_;
sql_=format('INSERT into shulesoft.loan_applications ("user_id","table","created_by","created_by_table","approved_by","approved_by_table","approval_status","amount","payment_start_date","loan_type_id","created_at","updated_at","qualify","months","description","monthly_repayment_amount","loan_source_id","uuid",schema_name) select (select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."table" and  "id"=a."user_id")),"table",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."created_by_table" and  "id"=a."created_by")),"created_by_table",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."approved_by_table" and  "id"=a."approved_by")),"approved_by_table","approval_status","amount","payment_start_date",(select "id" from shulesoft.loan_types where uuid in (select uuid from %I.loan_types where "id"=a."loan_type_id")),"created_at","updated_at","qualify","months","description","monthly_repayment_amount","loan_source_id","uuid", ''%I'' from %I.loan_applications a',schema_,schema_,schema_,schema_,schema_,schema_);

execute sql_;
--159
sql_=format('INSERT into shulesoft.loan_payments ("loan_application_id","amount","payment_type_id","date","transaction_id","created_at","cheque_number","bank_account_id","payer_name","mobile_transaction_id","transaction_time","account_number","token","reconciled","receipt_code","updated_at","channel","created_by","created_by_table","status","uuid",schema_name) select (select "id" from shulesoft.loan_applications where uuid =(select uuid from %I.loan_applications where "id"=a."loan_application_id")),"amount","payment_type_id","date","transaction_id","created_at","cheque_number",(select id from shulesoft.bank_accounts where uuid=(select uuid from %I.bank_accounts where id=a.bank_account_id)),"payer_name","mobile_transaction_id","transaction_time","account_number","token","reconciled","receipt_code","updated_at","channel",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."created_by_table" and  "id"=a."created_by")),"created_by_table","status","uuid", ''%I'' from %I.loan_payments a',schema_,schema_,schema_,schema_,schema_);

execute sql_;

--160
sql_=format('INSERT into shulesoft.user_deductions ("user_id","table","deduction_id","created_at","updated_at","created_by","deadline","type","amount","percent","employer_amount","employer_percent","loan_application_id","uuid",schema_name) select (select "id" from shulesoft.user where uuid in (select uuid from %I.users where "table"=a."table" and  "id"=a."user_id"::bigint)),"table",(select "id" from shulesoft.deductions where uuid =(select uuid from %I.deductions where "id"=a."deduction_id")),"created_at","updated_at",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."table" and  "id"=a."created_by"::bigint)),"deadline","type","amount","percent","employer_amount","employer_percent",(select id from shulesoft.loan_applications where uuid=(select uuid from %I.loan_applications where id=a.loan_application_id)),"uuid", ''%I'' from %I.user_deductions a',schema_,schema_,schema_,schema_,schema_,schema_);

execute sql_;
--161
sql_=format('INSERT into shulesoft.section_subject_teacher ("sectionID","academic_year_id","teacherID","created_at","refer_subject_id","subject_id","classesID","updated_at","uuid",schema_name) select (select "sectionID" from shulesoft.section where uuid=(select uuid from %I.section where "sectionID"=a."sectionID")),(select id from shulesoft.academic_year where uuid=(select uuid from %I.academic_year where id=a.academic_year_id)),(select "teacherID" from shulesoft.teacher where uuid=(select uuid from %I.teacher where "teacherID"=a."teacherID")),"created_at",(select "sectionID" from shulesoft.refer_subject where uuid=(select uuid from %I.refer_subject where "subject_id"=a."refer_subject_id")),(select "subjectID" from shulesoft.subject where uuid=(select uuid from %I.subject where "subjectID"=a."subject_id")),(select "classesID" from shulesoft.classes where uuid=(select uuid from %I.classes where "classesID"=a."classesID")),"updated_at","uuid", ''%I'' from %I.section_subject_teacher a',schema_,schema_,schema_,schema_,schema_,schema_,schema_,schema_);

execute sql_;
--162
sql_=format('INSERT into shulesoft.tattendance ("teacherID","usertype","monthyear","a1","a2","a3","a4","a5","a6","a7","a8","a9","a10","a11","a12","a13","a14","a15","a16","a17","a18","a19","a20","a21","a22","a23","a24","a25","a26","a27","a28","a29","a30","a31","created_at","uuid",schema_name) select (select "teacherID" from shulesoft.teacher where uuid=(select uuid from %I.teacher where "teacherID"=a."teacherID")),"usertype","monthyear","a1","a2","a3","a4","a5","a6","a7","a8","a9","a10","a11","a12","a13","a14","a15","a16","a17","a18","a19","a20","a21","a22","a23","a24","a25","a26","a27","a28","a29","a30","a31","created_at","uuid", ''%I'' from %I.tattendance a',schema_,schema_,schema_);

execute sql_;
--163
sql_=format('INSERT into shulesoft.livestudy_packages ("amount","days","note","created_at","updated_at","uuid",schema_name) select "amount","days","note","created_at","updated_at","uuid", ''%I'' from %I.livestudy_packages',schema_,schema_);

execute sql_;
--164
sql_=format('INSERT into shulesoft.routine ("classesID","sectionID","subjectID","day","room","created_at","start_time","end_time","uuid",schema_name) select (select "classesID" from shulesoft.classes where uuid=(select uuid from %I.classes where "classesID"=a."classesID")),(select "sectionID" from shulesoft.section where uuid=(select uuid from %I.section where "sectionID"=a."sectionID")),(select "subjectID" from shulesoft.subject where uuid=(select uuid from %I.subject where "subjectID"=a."subjectID")),"day","room","created_at","start_time","end_time","uuid", ''%I'' from %I.routine a',schema_,schema_,schema_,schema_,schema_);

execute sql_;
--165
sql_=format('INSERT into shulesoft.fees_installments ("fee_id","installment_id","created_at","updated_at","uuid",schema_name) select (select id from shulesoft.fees where uuid=(select uuid from %I.fees where id=a.fee_id)),(select id from shulesoft.installments where uuid=(select uuid from %I.installments where id=a.installment_id)),"created_at","updated_at","uuid", ''%I'' from %I.fees_installments a',schema_,schema_,schema_,schema_);

execute sql_;
RETURN 0; 
 END; 

$BODY$;

CREATE OR REPLACE FUNCTION shulesoft.transfer_stage_eight(
	schema_ text)
    RETURNS numeric
    LANGUAGE 'plpgsql'
AS $BODY$

 DECLARE 
	sql_ text;
 BEGIN 
-- we set statement timeout =0. This will cost our cpu and memory but for the sake of effective transfer, this is  almost a mandatory statement
  SET statement_timeout = 0; 
 -- to prevent db reset during running a long query, we set this to infinity
  SET idle_in_transaction_session_timeout = 0;
--166
sql_=format('INSERT into shulesoft.invoices_fees_installments ("invoice_id","fees_installment_id","created_at","updated_at","uuid",schema_name) select (select id from shulesoft.invoices where uuid=(select uuid from %I.invoices where id=a.invoice_id)),(select id from shulesoft.fees_installments where uuid=(select uuid from %I.fees_installments where id=a.fees_installment_id)),"created_at","updated_at","uuid", ''%I'' from %I.invoices_fees_installments a',schema_,schema_,schema_,schema_);

execute sql_;

--167
sql_=format('INSERT into shulesoft.advance_payments_invoices_fees_installments ("invoices_fees_installments_id","advance_payment_id","amount","created_at","updated_at","uuid",schema_name) select (select id from shulesoft.invoices_fees_installments where uuid=(select uuid from %I.invoices_fees_installments where id=a.invoices_fees_installments_id)),(select id from shulesoft.advance_payments where uuid=(select uuid from %I.advance_payments where id=a.advance_payment_id)),"amount","created_at","updated_at","uuid", ''%I'' from %I.advance_payments_invoices_fees_installments a',schema_,schema_,schema_,schema_);

execute sql_;


--168
sql_=format('INSERT into shulesoft.discount_fees_installments ("fees_installment_id","amount","student_id","note","created_at","updated_at","uuid",schema_name) select (select id from shulesoft.fees_installments where uuid=(select uuid from %I.fees_installments where id=a.fees_installment_id)),"amount",(select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),"note","created_at","updated_at","uuid", ''%I'' from %I.discount_fees_installments a',schema_,schema_,schema_,schema_);

execute sql_;

--169
sql_=format('INSERT into shulesoft.fees_installments_classes ("fees_installment_id","class_id","amount","created_at","updated_at","uuid",schema_name) select (select id from shulesoft.fees_installments where uuid=(select uuid from %I.fees_installments where id=a.fees_installment_id)),(select "classesID" from shulesoft.classes where uuid=(select uuid from %I.classes where "classesID"=a."class_id")),"amount","created_at","updated_at","uuid", ''%I'' from %I.fees_installments_classes a',schema_,schema_,schema_,schema_);

execute sql_;
--170
sql_=format('INSERT into shulesoft.vendors ("email","name","phone_number","telephone_number","country","city","location","bank_name","bank_branch","account_number","contact_person_name","contact_person_phone","contact_person_email","contact_person_jobtitle","service_product","created_at","updated_at","uuid",schema_name) select "email","name","phone_number","telephone_number","country","city","location","bank_name","bank_branch","account_number","contact_person_name","contact_person_phone","contact_person_email","contact_person_jobtitle","service_product","created_at","updated_at","uuid", ''%I'' from %I.vendors',schema_,schema_);

execute sql_;
--171
sql_=format('INSERT into shulesoft.lmember ("lID","user_id","lbalance","ljoindate","created_at","status","user_table","updated_at","uuid",schema_name) select "lID",(select "userID" from shulesoft.user where uuid=(select uuid from %I.user where "userID"=a."user_id")),"lbalance","ljoindate","created_at","status","user_table","updated_at","uuid", ''%I'' from %I.lmember a',schema_,schema_,schema_);

execute sql_;

--172
sql_=format('INSERT into shulesoft.issue ("lmember_id","issue_date","due_date","return_date","fine","note","created_at","is_returned","book_quantityID","created_by","type","book_quantity_id","book_id","created_by_table","updated_at","lID","uuid",schema_name) select (select id from shulesoft.lmember where uuid=(select uuid from %I.lmember where id=a.lmember_id)),"issue_date","due_date","return_date","fine","note","created_at","is_returned","book_quantityID",(select "id" from shulesoft.users where uuid in (select uuid from %I.user where  "userID"=a."created_by")),"type",(select id from shulesoft.book_quantity where uuid=(select uuid from %I.book_quantity where id=a.book_quantity_id)),(select id from shulesoft.book where uuid=(select uuid from %I.book where id=a.book_id)),"created_by_table","updated_at","lID","uuid", ''%I'' from %I.issue a',schema_,schema_,schema_,schema_,schema_,schema_);

execute sql_;
--173 hostels
sql_=format('INSERT into shulesoft.hostels ("name","htype","address","note","created_at","updated_at","user_id","usertype","beds_no","uuid",schema_name) select "name","htype","address","note","created_at","updated_at",(select "userID" from shulesoft.user where uuid=(select uuid from %I.user where "userID"=a."user_id")),"usertype","beds_no","uuid", ''%I'' from %I.hostels a',schema_,schema_,schema_);

execute sql_;
--174
sql_=format('INSERT into shulesoft.hostel_category ("hostel_id","class_type","hbalance","note","created_at","updated_at","uuid",schema_name) select (select id from shulesoft.hostels where uuid=(select uuid from %I.hostels where id=a.hostel_id)),"class_type","hbalance","note","created_at","updated_at","uuid", ''%I'' from %I.hostel_category a',schema_,schema_,schema_);

execute sql_;
--175
sql_=format('INSERT into shulesoft.hostel_beds ("name","hostel_id","created_at","updated_at","uuid",schema_name) select "name",(select id from shulesoft.hostels where uuid=(select uuid from %I.hostels where id=a.hostel_id)),"created_at","updated_at","uuid", ''%I'' from %I.hostel_beds a',schema_,schema_,schema_);

execute sql_;
--176
sql_=format('INSERT into shulesoft.hmembers ("student_id","hostel_category_id","jod","created_at","updated_at","hostel_id","installment_id","bed_id","uuid",schema_name) select (select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),(select id from shulesoft.hostel_category where uuid=(select uuid from %I.hostel_category where id=a.hostel_category_id)),"jod","created_at","updated_at",(select id from shulesoft.hostels where uuid=(select uuid from %I.hostels where id=a.hostel_id)),(select id from shulesoft.installments where uuid=(select uuid from %I.installments where id=a.installment_id)),(select id from shulesoft.hostel_beds where uuid=(select uuid from %I.hostel_beds where id=a.bed_id)),"uuid", ''%I'' from %I.hmembers a',schema_,schema_,schema_,schema_,schema_,schema_,schema_);

execute sql_;

--178
sql_=format('INSERT into shulesoft.general_character_assessment ("student_id","semester_id","class_teacher_id","class_teacher_comment","head_teacher_id","head_teacher_comment","class_teacher_created_at","head_teacher_created_at","class_teacher_updated_at","head_teacher_updated_at","exam_id","created_at","uuid",schema_name) select (select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),(select id from shulesoft.semester where uuid=(select uuid from %I.semester where id=a.semester_id)),(select "teacherID" from shulesoft.teacher where uuid=(select uuid from %I.teacher where "teacherID"=a."class_teacher_id")),"class_teacher_comment",(select "teacherID" from shulesoft.teacher where uuid=(select uuid from %I.teacher where "teacherID"=a."head_teacher_id")),"head_teacher_comment","class_teacher_created_at","head_teacher_created_at","class_teacher_updated_at","head_teacher_updated_at",(select "examID" from shulesoft.exam where uuid=(select uuid from %I.exam where "examID"=a."exam_id")),"created_at","uuid", ''%I'' from %I.general_character_assessment a',schema_,schema_,schema_,schema_,schema_,schema_,schema_);

execute sql_;

--179
sql_=format('INSERT into shulesoft.hostel_fees_installments ("hostel_id","fees_installment_id","amount","created_at","updated_at","uuid",schema_name) select (select id from shulesoft.hostels where uuid=(select uuid from %I.hostels where id=a.hostel_id)),(select id from shulesoft.fees_installments where uuid=(select uuid from %I.fees_installments where id=a.fees_installment_id)),"amount","created_at","updated_at","uuid", ''%I'' from %I.hostel_fees_installments a',schema_,schema_,schema_,schema_);

execute sql_;
--180
sql_=format('INSERT into shulesoft.items ("name","batch_number","quantity","vendor_id","contact_person_name","contact_person_number","status","price","created_at","comments","depreciation","current_price","date_purchased","uuid",schema_name) select "name","batch_number","quantity",(select id from shulesoft.vendors where uuid=(select uuid from %I.vendors where id=a.vendor_id)),"contact_person_name","contact_person_number","status","price","created_at","comments","depreciation","current_price","date_purchased","uuid", ''%I'' from %I.items a',schema_,schema_,schema_);

execute sql_;
--181
sql_=format('INSERT into shulesoft.livestudy_payments ("sid","payment_id","end_date","created_at","updated_at","livestudy_package_id","start_date","uuid",schema_name) select "sid",(select id from shulesoft.payments where uuid=(select uuid from %I.payments where id=a.payment_id)),"end_date","created_at","updated_at",(select id from shulesoft.livestudy_packages where uuid=(select uuid from %I.livestudy_packages where id=a.livestudy_package_id))"livestudy_package_id","start_date","uuid", ''%I'' from %I.livestudy_payments a',schema_,schema_,schema_,schema_);

execute sql_;
--182
sql_=format('INSERT into shulesoft.parent_documents ("type","parent_id","attach","attach_file_name","created_at","updated_at","uuid",schema_name) select "type",(select "parentID" from shulesoft.parent where uuid=(select uuid from %I.parent where "parentID"=a.parent_id)),"attach","attach_file_name","created_at","updated_at","uuid", ''%I'' from %I.parent_documents a',schema_,schema_,schema_);

execute sql_;
--183
sql_=format('INSERT into shulesoft.parent_phones ("parent_id","phone","updated_at","uuid",schema_name) select (select "parentID" from shulesoft.parent where uuid=(select uuid from %I.parent where "parentID"=a.parent_id)),"phone","updated_at","uuid", ''%I'' from %I.parent_phones a',schema_,schema_,schema_);

execute sql_;
--184
sql_=format('INSERT into shulesoft.payments_invoices_fees_installments ("invoices_fees_installment_id","payment_id","amount","created_at","updated_at","uuid",schema_name) select (select id from shulesoft.invoices_fees_installments where uuid=(select uuid from %I.invoices_fees_installments where id=a.invoices_fees_installment_id)),(select id from shulesoft.payments where uuid=(select uuid from %I.payments where id=a.payment_id)),"amount","created_at","updated_at","uuid", ''%I'' from %I.payments_invoices_fees_installments a',schema_,schema_,schema_,schema_);

execute sql_;
--185
sql_=format('INSERT into shulesoft.product_registers ("product_name","alert_quantity","product_code","refer_expense_id","unit_id","created_at","vendor_id","comment","contact_person_name","contact_person_number","account_group_id","updated_at","uuid",schema_name) select "product_name","alert_quantity","product_code",(select id from shulesoft.refer_expense where uuid=(select uuid from %I.refer_expense where id=a.refer_expense_id)),"unit_id","created_at",(select id from shulesoft.vendors where uuid=(select uuid from %I.vendors where id=a.vendor_id)),"comment","contact_person_name","contact_person_number",(select id from shulesoft.account_groups where uuid=(select uuid from %I.account_groups where id=a.account_group_id)),"updated_at","uuid", ''%I'' from %I.product_registers a',schema_,schema_,schema_,schema_,schema_);

execute sql_;
--186
sql_=format('INSERT into shulesoft.product_alert_quantity ("product_register_id","alert_quantity","updated_at","created_at","name","note","metric_id","refer_expense_id","open_blance","uuid",schema_name) select (select id from shulesoft.product_registers where uuid=(select uuid from %I.product_registers where id=a.product_register_id)),"alert_quantity","updated_at","created_at","name","note","metric_id",(select id from shulesoft.refer_expense where uuid=(select uuid from %I.refer_expense where id=a.refer_expense_id)),"open_blance","uuid", ''%I'' from %I.product_alert_quantity a',schema_,schema_,schema_,schema_);

execute sql_;

--187
sql_=format('INSERT into shulesoft.expense ("create_date","date","expense","amount","userID","uname","usertype","expenseyear","note","created_at","categoryID","is_depreciation","depreciation","refer_expense_id","ref_no","payment_method","created_by","bank_account_id","transaction_id","created_by_table","reconciled","voucher_no","payer_name","recipient","updated_at","payment_type_id","uuid",schema_name) select "create_date","date","expense","amount",(select "userID" from shulesoft.user where uuid=(select uuid from %I.user where "userID"=a."userID")),"uname","usertype","expenseyear","note","created_at","categoryID","is_depreciation","depreciation",(select id from shulesoft.refer_expense where uuid=(select uuid from %I.refer_expense where id=a.refer_expense_id)),"ref_no","payment_method",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."created_by_table" and  "id"=a."created_by"::bigint)),(select id from shulesoft.bank_accounts where uuid=(select uuid from %I.bank_accounts where id=a.bank_account_id)),"transaction_id","created_by_table","reconciled","voucher_no","payer_name","recipient","updated_at","payment_type_id","uuid", ''%I'' from %I.expense a',schema_,schema_,schema_,schema_,schema_,schema_);

execute sql_;
--188
sql_=format('INSERT into shulesoft.revenues ("payer_name","payer_phone","payer_email","refer_expense_id","amount","created_by_id","created_by_table","created_at","updated_at","payment_method","transaction_id","bank_account_id","invoice_number","note","date","user_in_shulesoft","user_id","user_table","reconciled","number","payment_type_id","loan_application_id","uuid",schema_name) select "payer_name","payer_phone","payer_email",(select id from shulesoft.refer_expense where uuid=(select uuid from %I.refer_expense where id=a.refer_expense_id)),"amount",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."created_by_table" and  "id"=a."created_by_id")),"created_by_table","created_at","updated_at","payment_method","transaction_id",(select id from shulesoft.bank_accounts where uuid=(select uuid from %I.bank_accounts where id=a.bank_account_id)),"invoice_number","note","date","user_in_shulesoft",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."user_table" and  "id"=a."user_id")),"user_table","reconciled","number","payment_type_id",(select "id" from shulesoft.loan_applications where uuid =(select uuid from %I.loan_applications where "id"=a."loan_application_id")),"uuid", ''%I'' from %I.revenues a',schema_,schema_,schema_,schema_,schema_,schema_,schema_);

execute sql_;
RETURN 0; 
 END; 

$BODY$;

CREATE OR REPLACE FUNCTION shulesoft.transfer_stage_nine(
	schema_ text)
    RETURNS numeric
    LANGUAGE 'plpgsql'
AS $BODY$

 DECLARE 
	sql_ text;
 BEGIN 
-- we set statement timeout =0. This will cost our cpu and memory but for the sake of effective transfer, this is  almost a mandatory statement
  SET statement_timeout = 0; 
 -- to prevent db reset during running a long query, we set this to infinity
  SET idle_in_transaction_session_timeout = 0;
--189
sql_=format('INSERT into shulesoft.product_cart ("name","product_alert_id","revenue_id","created_at","updated_at","quantity","amount","uuid",schema_name) select "name",(select id from shulesoft.product_alert_quantity where uuid=(select uuid from %I.product_alert_quantity where id=a.product_alert_id)),(select id from shulesoft.revenues where uuid=(select uuid from %I.revenues where id=a.revenue_id)),"created_at","updated_at","quantity","amount","uuid", ''%I'' from %I.product_cart a',schema_,schema_,schema_,schema_);

execute sql_;
--190
sql_=format('INSERT into shulesoft.product_purchases ("created_by","product_alert_id","quantity","amount","vendor_id","created_at","note","created_by_table","updated_at","expense_id","date","unit_price","status","uuid",schema_name) select (select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."created_by_table" and  "id"=a."created_by")),(select id from shulesoft.product_alert_quantity where uuid=(select uuid from %I.product_alert_quantity where id=a.product_alert_id)),"quantity","amount",(select id from shulesoft.vendors where uuid=(select uuid from %I.vendors where id=a.vendor_id)),"created_at","note","created_by_table","updated_at",(select id from shulesoft.expense where uuid=(select uuid from %I.expense where "expenseID"=a.expense_id)),"date","unit_price","status","uuid", ''%I'' from %I.product_purchases a',schema_,schema_,schema_,schema_,schema_,schema_);

execute sql_;

--191
sql_=format('INSERT into shulesoft.product_sales ("product_alert_id","quantity","selling_price","revenue_id","created_by","created_by_table","date","created_at","updated_at","note","uuid",schema_name) select (select id from shulesoft.product_alert_quantity where uuid=(select uuid from %I.product_alert_quantity where id=a.product_alert_id)),"quantity","selling_price",(select id from shulesoft.revenues where uuid=(select uuid from %I.revenues where id=a.revenue_id)),(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."created_by_table" and  "id"=a."created_by")),"created_by_table","date","created_at","updated_at","note","uuid", ''%I'' from %I.product_sales a',schema_,schema_,schema_,schema_,schema_);

execute sql_;
--192
sql_=format('INSERT into shulesoft.promotionsubject ("classesID","subjectID","subjectCode","subjectMark","created_at","uuid",schema_name) select (select "classesID" from shulesoft.classes where uuid=(select uuid from %I.classes where "classesID"=a."classesID")),(select "subjectID" from shulesoft.subject where uuid=(select uuid from %I.subject where "subjectID"=a."subjectID")),"subjectCode","subjectMark","created_at","uuid", ''%I'' from %I.promotionsubject a',schema_,schema_,schema_,schema_);

execute sql_;
--193
sql_=format('INSERT into shulesoft.expense_cart ("name","note","date","expense_id","refer_expense_id","created_at","updated_at","created_by","amount","uuid",schema_name) select "name","note","date",(select id from shulesoft.expense where uuid=(select uuid from %I.expense where "expenseID"=a.expense_id)),(select id from shulesoft.refer_expense where uuid=(select uuid from %I.refer_expense where id=a.refer_expense_id)),"created_at","updated_at",(select "id" from shulesoft.users where uuid in (select uuid from %I.user where  "userID"=a."created_by"::bigint)),"amount","uuid", ''%I'' from %I.expense_cart a',schema_,schema_,schema_,schema_,schema_);

execute sql_;
--194
sql_=format('INSERT into shulesoft.revenue_cart ("name","note","created_by_table","date","revenue_id","refer_expense_id","created_at","updated_at","amount","created_by_id","uuid",schema_name) select "name","note","created_by_table","date",(select id from shulesoft.revenues where uuid=(select uuid from %I.revenues where id=a.revenue_id)),(select id from shulesoft.refer_expense where uuid=(select uuid from %I.refer_expense where id=a.refer_expense_id)),"created_at","updated_at","amount",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."created_by_table" and  "id"=a."created_by_id")),"uuid", ''%I'' from %I.revenue_cart a',schema_,schema_,schema_,schema_,schema_);

execute sql_;
--195
sql_=format('INSERT into shulesoft.salaries ("user_id","table","basic_pay","allowance","gross_pay","pension_fund","deduction","tax","paye","net_pay","payment_date","created_at","reference","allowance_distribution","deduction_distribution","pension_distribution","uuid",schema_name) select (select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."table" and  "id"=a."user_id")),"table","basic_pay","allowance","gross_pay","pension_fund","deduction","tax","paye","net_pay","payment_date","created_at","reference","allowance_distribution","deduction_distribution","pension_distribution","uuid", ''%I'' from %I.salaries a',schema_,schema_,schema_);

execute sql_;
--196
sql_=format('INSERT into shulesoft.pensions ("name","employer_percentage","employee_percentage","created_at","address","updated_at","refer_pension_id","status","uuid",schema_name) select "name","employer_percentage","employee_percentage","created_at","address","updated_at","refer_pension_id","status","uuid", ''%I'' from %I.pensions',schema_,schema_);

execute sql_;
--197
sql_=format('INSERT into shulesoft.salary_pensions ("salary_id","pension_id","amount","created_at","created_by","employer_amount","uuid",schema_name) select (select id from shulesoft.salaries where uuid=(select uuid from %I.salaries where id=a.salary_id)),(select id from shulesoft.pensions where uuid=(select uuid from %I.pensions where id=a.pension_id)),"amount","created_at",(select "id" from shulesoft.users where uuid in (select uuid from %I.user  where  "userID"=a."created_by"::bigint)),"employer_amount","uuid", ''%I'' from %I.salary_pensions a',schema_,schema_,schema_,schema_,schema_);

execute sql_;
--198
sql_=format('INSERT into shulesoft.allowances ("name","amount","percent","created_at","updated_at","description","is_percentage","type","pension_included","category","uuid",schema_name) select "name","amount","percent","created_at","updated_at","description","is_percentage","type","pension_included","category","uuid", ''%I'' from %I.allowances',schema_,schema_);

execute sql_;
--199
sql_=format('INSERT into shulesoft.salary_allowances ("salary_id","allowance_id","amount","created_at","created_by","uuid",schema_name) select (select id from shulesoft.salaries where uuid=(select uuid from %I.salaries where id=a.salary_id)),(select id from shulesoft.allowances where uuid=(select uuid from %I.allowances where id=a.allowance_id)),"amount","created_at",(select "id" from shulesoft.users where uuid in (select uuid from %I.user where  "userID"=a."created_by"::bigint)),"uuid", ''%I'' from %I.salary_allowances a',schema_,schema_,schema_,schema_,schema_);

execute sql_;
--200
sql_=format('INSERT into shulesoft.salary_deductions ("salary_id","deduction_id","amount","created_at","created_by","employer_amount","uuid",schema_name) select (select id from shulesoft.salaries where uuid=(select uuid from %I.salaries where id=a.salary_id)),(select id from shulesoft.deductions where uuid=(select uuid from %I.deductions where id=a.deduction_id)),"amount","created_at",(select "id" from shulesoft.users where uuid in (select uuid from %I.user where "userID"=a."created_by"::bigint)),"employer_amount","uuid", ''%I'' from %I.salary_deductions a',schema_,schema_,schema_,schema_,schema_);

execute sql_;

--201
sql_=format('INSERT into shulesoft.sattendances ("student_id","created_by","created_by_table","date","present","absent_reason","absent_reason_id","created_at","updated_at","uuid",schema_name) select (select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."created_by_table" and  "id"=a."created_by")),"created_by_table","date","present","absent_reason","absent_reason_id","created_at","updated_at","uuid", ''%I'' from %I.sattendances a',schema_,schema_,schema_,schema_);

execute sql_;

--202
sql_=format('INSERT into shulesoft.transport_routes ("name","note","created_at","updated_at","uuid",schema_name) select "name","note","created_at","updated_at","uuid", ''%I'' from %I.transport_routes',schema_,schema_);

execute sql_;
--203
sql_=format('INSERT into shulesoft.transport_routes_fees_installments ("transport_route_id","fees_installment_id","amount","created_at","updated_at","uuid",schema_name) select (select id from shulesoft.transport_routes where uuid=(select uuid from %I.transport_routes where id=a.transport_route_id)),(select id from shulesoft.fees_installments where uuid=(select uuid from %I.fees_installments where id=a.fees_installment_id)),"amount","created_at","updated_at","uuid", ''%I'' from %I.transport_routes_fees_installments a',schema_,schema_,schema_,schema_);

execute sql_;
--220
sql_=format('INSERT into shulesoft.vehicles ("plate_number","seats","description","created_at","created_by","updated_at","name","driver_id","conductor_id","uuid",schema_name) select "plate_number","seats","description","created_at",(select "id" from shulesoft.users where uuid in (select uuid from %I.user where  "userID"=a."created_by"::bigint)),"updated_at","name",(select "id" from shulesoft.users where uuid in (select uuid from %I.user where "userID"=a."driver_id"::bigint)),(select "id" from shulesoft.users where uuid in (select uuid from %I.user where "userID"=a."conductor_id"::bigint)),"uuid", ''%I'' from %I.vehicles a',schema_,schema_,schema_,schema_,schema_);

execute sql_;
--204
sql_=format('INSERT into shulesoft.tmembers ("student_id","transport_route_id","tjoindate","vehicle_id","is_oneway","created_at","updated_at","installment_id","uuid",schema_name) select (select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),(select id from shulesoft.transport_routes where uuid=(select uuid from %I.transport_routes where id=a.transport_route_id)),"tjoindate",(select id from shulesoft.vehicles where uuid=(select uuid from %I.vehicles where id=a.vehicle_id)),"is_oneway","created_at","updated_at",(select id from shulesoft.installments where uuid=(select uuid from %I.installments where id=a.installment_id)),"uuid", ''%I'' from %I.tmembers a',schema_,schema_,schema_,schema_,schema_,schema_);

execute sql_;
--205
sql_=format('INSERT into shulesoft.transport ("route","vehicle","fare","note","created_at","academic_year_id","uuid",schema_name) select "route","vehicle","fare","note","created_at",(select id from shulesoft.academic_year where uuid=(select uuid from %I.academic_year where id=a.academic_year_id)),"uuid", ''%I'' from %I.transport a',schema_,schema_,schema_);

execute sql_;
--206 (this is mostly likely not used anywhere)
sql_=format('INSERT into shulesoft.transport_installment ("transport_id","amount","fee_installment_id","total_amount","status","installment_id","uuid",schema_name) select (select id from shulesoft.transport where uuid=(select uuid from %I.transport where id=a.transport_id)),"amount",(select id from shulesoft.fees_installments where uuid=(select uuid from %I.fees_installments where id=a.fee_installment_id)),"total_amount","status",(select id from shulesoft.installments where uuid=(select uuid from %I.installments where id=a.installment_id)),"uuid", ''%I'' from %I.transport_installment a',schema_,schema_,schema_,schema_,schema_);

execute sql_;
--207
sql_=format('INSERT into shulesoft.student_fees_installments_unsubscriptions ("fees_installment_id","student_id","created_at","updated_at","uuid",schema_name) select (select id from shulesoft.fees_installments where uuid=(select uuid from %I.fees_installments where id=a.fees_installment_id)),(select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),"created_at","updated_at","uuid", ''%I'' from %I.student_fees_installments_unsubscriptions a',schema_,schema_,schema_,schema_);

execute sql_;

--208
sql_=format('INSERT into shulesoft.sms_content ("message","created_by","created_by_table","channels","created_at","updated_at","uuid",schema_name) select "message",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."created_by_table" and  "id"=a."created_by")),"created_by_table","channels","created_at","updated_at","uuid", ''%I'' from %I.sms_content a',schema_,schema_,schema_);

execute sql_;
--209
sql_=format('INSERT into shulesoft.sms_files ("sms_content_id","url","created_at","updated_at","uuid",schema_name) select (select id from shulesoft.sms_content where uuid=(select uuid from %I.sms_content where id=a.sms_content_id)),"url","created_at","updated_at","uuid", ''%I'' from %I.sms_files a',schema_,schema_,schema_);

execute sql_;
--210
sql_=format('INSERT into shulesoft.student_assessment ("valid_answer_id","student_id","question_id","created_at","updated_at","student_answer","score","attach_file_name","attach","uuid",schema_name) select (select "id" from shulesoft.valid_answers where uuid=(select uuid from %I.valid_answers where "id"=a."valid_answer_id")),(select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),(select "id" from shulesoft.forum_questions where uuid=(select uuid from %I.forum_questions where "id"=a."question_id")),"created_at","updated_at","student_answer","score","attach_file_name","attach","uuid", ''%I'' from %I.student_assessment a',schema_,schema_,schema_,schema_,schema_);

execute sql_;
--211
sql_=format('INSERT into shulesoft.bank_accounts_integrations ("bank_account_id","api_username","api_password","invoice_prefix","created_at","updated_at","sandbox_api_username","sandbox_api_password","uuid",schema_name) select (select id from shulesoft.bank_accounts where uuid=(select uuid from %I.bank_accounts where id=a.bank_account_id)),"api_username","api_password","invoice_prefix","created_at","updated_at","sandbox_api_username","sandbox_api_password","uuid", ''%I'' from %I.bank_accounts_integrations a',schema_,schema_,schema_);

execute sql_;

--212 prepayment table - needs to be deleted, unused
--sql_=format('INSERT into shulesoft.prepayments ("invoiceID","student_id","paymentamount","paymenttype","paymentdate","paymentmonth","paymentyear","created_at","transaction_id","userID","slipfile","approved","approved_date","approved_user_id","cheque_number","bank_name","payer_name","fee_id","transaction_time","account_number","token","bank_account_id","reconciled","updated_at","reject_reason","uuid",schema_name) select "invoiceID",(select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),"paymentamount","paymenttype","paymentdate","paymentmonth","paymentyear","created_at","transaction_id",(select "userID" from shulesoft.user where uuid=(select uuid from %I.user where "userID"=a."userID")),"slipfile","approved","approved_date","approved_user_id","cheque_number","bank_name","payer_name",(select id from shulesoft.fees where uuid=(select uuid from %I.fees where id=a.fee_id)),"transaction_time","account_number","token",(select id from shulesoft.bank_accounts where uuid=(select uuid from %I.bank_accounts where id=a.bank_account_id)),"reconciled","updated_at","reject_reason","uuid", ''%I'' from %I.prepayments',schema_,schema_);

--execute sql_;
--213. most likely not useful
sql_=format('INSERT into shulesoft.route_vehicle ("transport_id","vehicle_id","created_at","uuid",schema_name) select (select id from shulesoft.transport where uuid=(select uuid from %I.transport where id=a.transport_id)),(select id from shulesoft.vehicles where uuid=(select uuid from %I.vehicles where id=a.vehicle_id)),"created_at","uuid", ''%I'' from %I.route_vehicle a',schema_,schema_,schema_,schema_);

execute sql_;

--214
--sql_=format('INSERT into shulesoft.track_invoices_fees_installments ("deleted_at","fees_installments_id","invoice_id","uuid",schema_name) select "deleted_at",(select id from shulesoft.fees_installments where uuid=(select uuid from %I.fees_installments where id=a.fees_installment_id)),(select id from shulesoft.invoices where uuid=(select uuid from %I.invoices where id=a.invoice_id)),"uuid", ''%I'' from %I.track_invoices_fees_installments a',schema_,schema_,schema_,schema_);

--execute sql_;
--215
--sql_=format('INSERT into shulesoft.trainings ("training_checklist_id","user_id","table","created_at","updated_at","uuid",schema_name) select "training_checklist_id",(select "id" from shulesoft.users where uuid in (select uuid from %I.user where  "userID"=a."user_id")),"table","created_at","updated_at","uuid", ''%I'' from %I.trainings a',schema_,schema_,schema_);

--execute sql_;

--216
sql_=format('INSERT into shulesoft.uattendances ("user_id","created_by","created_by_table","user_table","date","timein","timeout","present","absent_reason","absent_reason_id","created_at","updated_at","uuid",schema_name) select (select "userID" from shulesoft.user where uuid=(select uuid from %I.user where "userID"=a."user_id")),(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."created_by_table" and  "id"=a."created_by"::bigint)),"created_by_table","user_table","date","timein","timeout","present","absent_reason","absent_reason_id","created_at","updated_at","uuid", ''%I'' from %I.uattendances a',schema_,schema_,schema_,schema_);

execute sql_;
--217
sql_=format('INSERT into shulesoft.user_allowances ("user_id","table","allowance_id","created_at","updated_at","created_by","deadline","type","amount","percent","uuid",schema_name) select (select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."table" and  "id"=a."user_id")),"table",(select id from shulesoft.allowances where uuid=(select uuid from %I.allowances where id=a.allowance_id)),"created_at","updated_at",(select "id" from shulesoft.users where uuid in (select uuid from %I.user where  "userID"=a."created_by"::bigint)),"deadline","type","amount","percent","uuid", ''%I'' from %I.user_allowances a',schema_,schema_,schema_,schema_,schema_);

execute sql_;
--218
sql_=format('INSERT into shulesoft.user_contract ("user_id","table","start_date","end_date","notify_date","employment_type_id","created_at","uuid",schema_name) select (select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."table" and  "id"=a."user_id")),"table","start_date","end_date","notify_date","employment_type_id","created_at","uuid", ''%I'' from %I.user_contract a',schema_,schema_,schema_);

execute sql_;
--219
sql_=format('INSERT into shulesoft.user_pensions ("user_id","table","pension_id","created_at","updated_at","created_by","checknumber","uuid",schema_name) select (select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."table" and  "id"=a."user_id")),"table","pension_id","created_at","updated_at",(select "id" from shulesoft.users where uuid in (select uuid from %I.user where  "userID"=a."created_by"::bigint)),"checknumber","uuid", ''%I'' from %I.user_pensions a',schema_,schema_,schema_,schema_);

execute sql_;
--220
sql_=format('INSERT into shulesoft.wallets ("student_id","amount","date","created_at","updated_at","uuid",schema_name) select (select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),"amount","date","created_at","updated_at","uuid", ''%I'' from %I.wallets a',schema_,schema_,schema_);

execute sql_;
--221
sql_=format('INSERT into shulesoft.wallet ("student_id","value","date","status","fee_id","uuid",schema_name) select (select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),"value","date","status",(select id from shulesoft.fees where uuid=(select uuid from %I.fees where id=a.fee_id)),"uuid", ''%I'' from %I.wallet a',schema_,schema_,schema_,schema_);

execute sql_;
--222
sql_=format('INSERT into shulesoft.topic_mark ("achievement_mark","effort_mark","grade_mark","created_at","updated_at","subjectID","examID","academic_year_id","student_id","classesID","subject_topic_id","subject_mark_id","exam","subject","status","uuid",schema_name) select "achievement_mark","effort_mark","grade_mark","created_at","updated_at",(select "subjectID" from shulesoft.subject where uuid=(select uuid from %I.subject where "subjectID"=a."subjectID")),(select "examID" from shulesoft.exam where uuid=(select uuid from %I.exam where "examID"=a."examID")),(select id from shulesoft.academic_year where uuid=(select uuid from %I.academic_year where id=a.academic_year_id)),(select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),(select "classesID" from shulesoft.classes where uuid=(select uuid from %I.classes where "classesID"=a."classesID")),(select id from shulesoft.subject_topic where uuid=(select uuid from %I.subject_topic where id=a.subject_topic_id)),(select id from shulesoft.subject_mark where uuid=(select uuid from %I.subject_mark where id=a.subject_mark_id)),"exam","subject","status","uuid", ''%I'' from %I.topic_mark a',schema_,schema_,schema_,schema_,schema_,schema_,schema_,schema_,schema_);

execute sql_;
--223
--sql_=format('INSERT into shulesoft.current_assets2 ("amount","date","from_refer_expense_id","to_refer_expense_id","payer_name","usertype","uname","created_by","userID","note","recipient","transaction_id","voucher_no","uuid",schema_name) select "amount","date",(select "id" from shulesoft.refer_expense where uuid=(select uuid from %I.refer_expense where "id"=a."from_refer_expense_id")),(select "id" from shulesoft.refer_expense where uuid=(select uuid from %I.refer_expense where "id"=a."to_refer_expense_id")),"payer_name","usertype","uname",(select "id" from shulesoft.users where uuid in (select uuid from %I.user where "userID"=a."created_by"::bigint)),(select "userID" from shulesoft.user where uuid=(select uuid from %I.user where "userID"=a."userID"::bigint)),"note","recipient","transaction_id","voucher_no","uuid", ''%I'' from %I.current_assets a',schema_,schema_,schema_,schema_,schema_,schema_);

--execute sql_;

 RETURN 0; 
 END; 

$BODY$;