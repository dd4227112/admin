 CREATE OR REPLACE FUNCTION shulesoft.transfer_settings_into_shulesoft(
	schema_ text)
    RETURNS numeric
    LANGUAGE 'plpgsql'
AS $BODY$

 DECLARE 

	sql_ text;
 
 BEGIN 
 
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
sql_=format('INSERT into shulesoft.teacher ("teacherID","name","designation","dob","sex","email","phone","address","jod","photo","username","password","usertype","created_at","employment_type","signature","signature_path","id_number","library","health_insurance_id","health_status_id","education_id","designation_id","education_level_id","updated_at","physical_condition_id","religion_id","nationality","salary","default_password","status","status_id","bank_account_number","bank_name","remember_token","email_valid","number","location","region","sid","city_id","national_id","country_id","qualification","payroll_status","fcm_token","role_id","uuid",schema_name) select "teacherID","name","designation","dob","sex","email","phone","address","jod","photo","username","password","usertype","created_at","employment_type","signature","signature_path","id_number","library","health_insurance_id","health_status_id","education_id","designation_id","education_level_id","updated_at","physical_condition_id","religion_id","nationality","salary","default_password","status","status_id","bank_account_number","bank_name","remember_token","email_valid","number","location","region","sid","city_id","national_id","country_id","qualification","payroll_status","fcm_token","role_id","uuid", ''%I'' from %I.teacher',schema_,schema_);

execute sql_;

--START ACADEMIC DATA TRANSFER
--9. insert into classlevel 
sql_=format('INSERT into shulesoft.classlevel ("classlevel_id","name","start_date","end_date","span_number","created_at","updated_at","note","result_format","terms","level_numeric","school_level_id","stamp","head_teacher_title","school_id","leaving_certificate","pass_mark","reg_form","gender","category","religion","education_level_id","uuid","end_time",schema_name) select "classlevel_id","name","start_date","end_date","span_number","created_at","updated_at","note","result_format","terms","level_numeric","school_level_id","stamp","head_teacher_title","school_id","leaving_certificate","pass_mark","reg_form","gender","category","religion","education_level_id","uuid","end_time", ''%I'' from %I.classlevel',schema_,schema_);

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
--33. exam special case
sql_=format('INSERT into shulesoft.exam_special_cases ("student_id","exam_id","description","special_exam_reason_id","created_by","created_by_table","created_at","updated_at","subjects_excluded","subjects_ids_excluded","uuid",schema_name) select (select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),(select "examID" from shulesoft.exam where uuid=(select uuid from %I.exam where "examID"=a."exam_id")),"description","special_exam_reason_id",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."created_by_table" and  "id"=a."created_by")),"created_by_table","created_at","updated_at","subjects_excluded","subjects_ids_excluded","uuid", ''%I'' from %I.exam_special_cases a',schema_,schema_,schema_,schema_,schema_);

execute sql_;

--34. insert user
sql_=format('INSERT into shulesoft.user ("name","dob","sex","email","phone","address","jod","photo","username","password","usertype","created_at","signature","signature_path","role_id","salary","id_number","default_password","status","status_id","bank_account_number","bank_name","remember_token","number","sid","location","education_level_id","employment_type_id","physical_condition_id","health_status_id","health_insurance_id","religion_id","town","national_id","country_id","qualification","email_valid","payroll_status","fcm_token","updated_at","uuid",schema_name) select "name","dob","sex","email","phone","address","jod","photo","username","password","usertype","created_at","signature","signature_path",(select id from shulesoft.role where uuid=(select uuid from %I.role where id=a.role_id)),"salary","id_number","default_password","status","status_id","bank_account_number","bank_name","remember_token","number","sid","location","education_level_id","employment_type_id","physical_condition_id","health_status_id","health_insurance_id","religion_id","town","national_id","country_id","qualification","email_valid","payroll_status","fcm_token","updated_at","uuid", ''%I'' from %I.user a',schema_,schema_,schema_);

execute sql_;
--35. insert emails
sql_=format('INSERT into shulesoft.email ("email_id","body","subject","user_id","created_at","status","email","table","uuid",schema_name) select "email_id","body","subject","user_id","created_at","status","email","table","uuid", ''%I'' from %I.email',schema_,schema_);

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
sql_=format('INSERT into shulesoft.user_role ("user_id","role_id","created_at","updated_at","table","uuid",schema_name) select (select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."table" and "id"=a."user_id")),(select id from shulesoft.role where uuid=(select uuid from %I.role where id=a.role_id)),"created_at","updated_at","table","uuid", ''%I'' from %I.user_role a',schema_,schema_,schema_,schema_);

execute sql_;
--42. reminders
sql_=format('INSERT into shulesoft.reminders ("user_id","role_id","date","time","mailandsmstemplate_id","title","is_repeated","days","created_at","updated_at","message","type","category","student_id","last_schedule_date","uuid",schema_name) select user_id,role_id,"date","time","mailandsmstemplate_id","title","is_repeated","days","created_at","updated_at","message","type","category",(select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),"last_schedule_date","uuid", ''%I'' from %I.reminders a',schema_,schema_,schema_);

execute sql_;
--43. file folder
sql_=format('INSERT into shulesoft.file_folder ("user_id","table","name","created_at","uuid",schema_name) select (select "userID" from shulesoft.user where uuid=(select uuid from %I.user where "userID"=a."user_id")),"table","name","created_at","uuid", ''%I'' from %I.file_folder a',schema_,schema_,schema_);

execute sql_;
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
sql_=format('INSERT into shulesoft.book ("name","author","rack","created_at","edition","user_id","serial_no","subject_code","subject_id","classesID","whois","book_condition","quantity","book_for","due_quantity","updated_at","uuid",schema_name) select "name","author","rack","created_at","edition",(select "userID" from shulesoft.user where uuid=(select uuid from %I.user where "userID"=a."user_id")),"serial_no","subject_code",(select "subjectID" from shulesoft.subject where uuid=(select uuid from %I.subject where "subjectID"=a."subject_id")),(select "classesID" from shulesoft.classes where uuid=(select uuid from %I.classes where "classesID"=a."classesID")),"whois","book_condition","quantity","book_for","due_quantity","updated_at","uuid", ''%I'' from %I.book a',schema_,schema_,schema_,schema_,schema_);

execute sql_;

--51. diaries
sql_=format('INSERT into shulesoft.diaries ("student_id","teacher_id","work_title","created_at","updated_at","start_date","description","end_date","subject_id","book_id","book_chapter","uuid",schema_name) select (select student_id from shulesoft.student where uuid=(select uuid from %I.student where student_id=a.student_id)),(select "teacherID" from shulesoft.teacher where uuid=(select uuid from %I.teacher where "teacherID"=a."teacher_id")),"work_title","created_at","updated_at","start_date","description","end_date",(select "subjectID" from shulesoft.subject where uuid=(select uuid from %I.subject where "subjectID"=a."subject_id")),(select "id" from shulesoft.book where uuid=(select uuid from %I.book where "id"=a."book_id")),"book_chapter","uuid", ''%I'' from %I.diaries a',schema_,schema_,schema_,schema_,schema_,schema_);

execute sql_;
--52. diary comments
sql_=format('INSERT into shulesoft.diary_comments ("user_id","table","comment","diary_id","created_at","updated_at","opened","uuid",schema_name) select (select "userID" from shulesoft.user where uuid=(select uuid from %I.user where "userID"=a."user_id")),"table","comment",(select "id" from shulesoft.diaries where uuid=(select uuid from %I.diaries where "id"=a."diary_id")),"created_at","updated_at","opened","uuid", ''%I'' from %I.diary_comments a',schema_,schema_,schema_,schema_);

execute sql_;
--53. messages
sql_=format('INSERT into shulesoft.message ("email","receiverID","receiverType","subject","message","attach","attach_file_name","userID","usertype","useremail","year","date","create_date","read_status","from_status","to_status","fav_status","fav_status_sent","reply_status","created_at","receiverTable","uuid",schema_name) select "email","receiverID","receiverType","subject","message","attach","attach_file_name",(select "userID" from shulesoft.user where uuid=(select uuid from %I.user where "userID"=a."userID")),"usertype","useremail","year","date","create_date","read_status","from_status","to_status","fav_status","fav_status_sent","reply_status","created_at","receiverTable","uuid", ''%I'' from %I.message a',schema_,schema_,schema_);

execute sql_;
--54. login locations
sql_=format('INSERT into shulesoft.login_locations ("ip","city","region","country","latitude","longtude","timezone","user_id","table","continent","currency_code","currency_symbol","currency_convert","location_radius_accuracy","created_at","updated_at","action","uuid",schema_name) select "ip","city","region","country","latitude","longtude","timezone",(select "id" from shulesoft.users where uuid in (select uuid from %I.users where "table"=a."table" and  "id"=a."user_id")),"table","continent","currency_code","currency_symbol","currency_convert","location_radius_accuracy","created_at","updated_at","action","uuid", ''%I'' from %I.login_locations a',schema_,schema_,schema_);

execute sql_;

 RETURN 0; 
 END; 

$BODY$;