--
-- PostgreSQL database dump
--

-- Dumped from database version 13.7
-- Dumped by pg_dump version 14.2

-- Started on 2023-03-29 11:03:31

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 315159 (class 0 OID 2842097)
-- Dependencies: 597
-- Data for Name: permissions; Type: TABLE DATA; Schema: admin; Owner: postgres
--

INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (92, 'update_designation', 'Update user designation', 'Update user designation', '2021-06-10 12:12:12', '2021-06-10 12:12:12', 9);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (18, 'manage_software', 'Manage Software', 'Manage Software', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 7);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (94, 'view_sms_status', 'View sms status', 'View sms status', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 7);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (95, 'add_revenue', 'Add revenues', 'Add revenues', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (96, 'onboard_school', 'View onboarded schools ', 'View onboarded schools and other', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (97, 'general_report', 'Genaral schools data', 'All schools data', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (35, 'view_marketing_dashboard', 'View marketing Dashboard', 'View marketing dashboard', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 3);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (36, 'view_sales_dashboard', 'View sales dashboard', 'View sales dashboard', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 3);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (37, 'view_accounts_dashboard', 'View accounts dashboard', 'View accounts dashboard', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 3);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (38, 'view_customer_dashboard', 'View customer dashboard', 'View customer dashboard', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 3);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (39, 'view_software_dashboard', 'View software dashboard', 'View Software Dashboard', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 3);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (40, 'create_guide', 'Add guide', 'Add new guide', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 2);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (41, 'view_guide', 'View guide', 'view user guide', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 2);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (42, 'delete_guide', 'Delete guide', 'Delete user guide', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 2);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (43, 'edit_guide', 'Edit guide ', 'Edit user  guide ', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 2);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (44, 'add_faq', 'Add faq', 'Add frequent added questions', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 2);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (45, 'delete_faq', 'Delete faq', 'Delete  frequent asked questione', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 2);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (46, 'view_sales_material', 'View sales material', 'View sales material', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 1);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (47, 'add_school', 'Add new onboard school ', 'Add  onboard school ', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 1);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (48, 'view_school', 'View school profile', 'View school profile', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 1);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (49, 'edit_school', 'Edit school', 'Edit school', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 1);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (50, 'add_key_person', 'Add key personal', 'Add key personal', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 1);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (52, 'add_sales_lead', 'Add sales lead', 'Add sales lead', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 1);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (53, 'view_sales_status', 'View Sales status', 'View sales status', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 1);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (54, 'new_task', 'Add new task', 'Add new task', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 4);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (93, 'add_deduction', 'Add deductions', 'Financial add deductions', '2021-06-10 12:12:12', '2021-06-10 12:12:12', 6);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (55, 'view_task', 'View task', 'View task', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 4);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (56, 'manage_tasks', 'Manage tasks', 'manage tasks', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 4);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (57, 'new_post', 'Creating new post', 'Creating new post', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 5);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (58, 'view_post', 'view post', 'View published post', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 5);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (59, 'delete_post', 'Delete post', 'Delete post', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 5);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (60, 'add_event', 'Add new event', 'Add new event', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 5);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (62, 'send_message', 'Send message', 'Send message', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 5);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (63, 'creating_invoice', 'Creating invoice', 'Creating invoice', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 6);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (64, 'view_invoice', 'View single invoice', 'View single invoice', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 6);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (65, 'print_invoice', 'Print invoice', 'Print invoice', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 6);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (66, 'edit_invoice', 'Edit invoice', 'Edit invoice', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 6);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (68, 'add_payment', 'Add payment', 'Add payment', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 6);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (69, 'send_invoice', 'Send invoice', 'Send invoice', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 6);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (70, 'view_receipt
', 'View receipts', 'View receipts', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 6);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (71, 'add_call', 'Add calls summary', 'Add calls summary', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 2);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (72, 'reply_feeback', 'Reply to feeback', 'Reply shuleSoft Feedbacks', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 2);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (73, 'create_updates', 'Create shulesoft updates', 'Create shulesoft updates', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 2);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (74, 'add_requirements', 'Add user requirements', 'Add user requirements', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 2);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (21, 'manage_marketing', 'Manage Marketing', 'Manage Marketing', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 3);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (26, 'manage_expenses', 'Manage Expenses', 'Manage Expenses', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 3);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (85, 'hr_report', 'View human resource reports', 'View human resource reports', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 9);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (51, 'add_task', 'Add new task', 'Add new task', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 1);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (76, 'add_role', 'Add new role', 'Add new role', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 8);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (86, 'training', 'View training', 'View training', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (16, 'manage_users', 'Manage Users', 'Manage all users in the system', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 9);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (34, 'view_home_dashboard', ' Home Dashboard', 'View Home Dashboard', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 3);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (20, 'manage_sales', 'Manage Sales', 'Manage Sales', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 3);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (17, 'manage_customers', 'Manage Customers', 'Manage Customers', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 3);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (78, 'digital_marketing', 'Digital marketing', 'View digital marketing', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 5);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (79, 'event_seminars', 'Event and seminars', 'View events and seminars', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 5);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (81, 'usage_analysis', 'Usage and Analysis', 'view usage and analysis', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 5);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (19, 'manage_finance', 'Manage Finance', 'Manage Finance', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 3);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (83, 'manage_operations', 'Manage  operations', 'Manage manage operations', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (15, 'manage_schools', 'Manage Schools', 'Manage Schools', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (27, 'manage_sa', 'Manage Service Agent', 'Manage Service Agent', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (84, 'my_schools', 'Manage my schools', 'Manage my schools', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (87, 'reset_school_password', 'Reset school password', 'Reset school password', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 8);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (88, 'customer_module', 'Manage Customer Modules', 'Manage Customer Modules', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (89, 'upload_users', 'Upload users', 'Upload users', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (90, 'manage_payroll', 'Manage user payrolls', 'Manage user payrolls', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 6);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (91, 'add_expense', 'Add expenses', 'Add expenses', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 6);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (77, 'meeting_minutes', 'Add meeting minutes', 'Add meeting minutes', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (98, 'update_school_data', 'Update school details', 'Update school details', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (67, 'delete_invoice', 'Delete invoice', 'Delete invoice', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (80, 'communication', 'Communications', 'view communications', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (75, 'add_si', 'Add standing order ', 'Add standing order ', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 8);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (99, 'update_integration', 'Update bank integration', 'Update bank integration', '2021-06-01 12:12:12', '2021-06-01 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (100, 'create_user_group', 'Create schools group', 'Create schools group', '2021-08-01 12:12:12', '2021-08-01 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (101, 'remove_user', 'Remove user from system', 'Remove user from system', '2021-08-01 12:12:12', '2021-08-01 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (102, 'manage_database', 'manage database and contraints', 'manage database and contraints', '2021-08-01 12:12:12', '2021-08-01 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (103, 'edit_user_info', 'edit user information', 'edit user information', '2021-08-01 12:12:12', '2021-08-01 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (104, 'edit_leave_dates', 'Edit leave dates', 'Edit user leave dates', '2021-08-01 12:12:12', '2021-08-01 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (105, 'view_dashboard', 'view dashboard', 'View dashboard', '2021-10-26 12:12:12', '2021-10-26 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (106, 'cro_dashboard', 'View cro dashboard', 'View cro dashboard', '2021-10-26 12:12:12', '2021-10-26 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (107, 'operations_dashboard', 'Operations dashboard', 'Operations dashboard', '2021-10-26 12:12:12', '2021-10-26 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (108, 'engineering_dashboard', 'Engineering dashboard', 'Engineering dashboard', '2021-10-26 12:12:12', '2021-10-26 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (109, 'manage_revenue', 'Manage revenue', 'manage revenue', '2021-10-26 12:12:12', '2021-10-26 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (110, 'sales_plan', 'Sales plan', 'Sales plan', '2021-10-26 12:12:12', '2021-10-26 12:12:12', 1);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (111, 'event_seminar', 'Event seminar', 'Event seminar', '2021-10-26 12:12:12', '2021-10-26 12:12:12', 5);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (112, 'manage_sequence', 'Manage sequence', 'manage sequence', '2021-10-26 12:12:12', '2021-10-26 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (113, 'customer_success', 'Customer success', 'Customer success', '2021-10-26 12:12:12', '2021-10-26 12:12:12', 5);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (114, 'comm_logs', 'communications logs', 'communications logs', '2021-10-26 12:12:12', '2021-10-26 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (115, 'create_update', 'create update', 'create update', '2021-10-26 12:12:12', '2021-10-26 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (116, 'manage_partnership', 'manage partnership', 'manage partnership', '2021-10-26 12:12:12', '2021-10-26 12:12:12', 8);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (117, 'integration_requests', 'integration requests', 'integration requests', '2021-10-26 12:12:12', '2021-10-26 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (118, 'view_epayments', 'view epayments', 'view epayments', '2021-10-26 12:12:12', '2021-10-26 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (119, 'nmb_integration', 'nmb integration', 'nmb integration', '2021-10-26 12:12:12', '2021-10-26 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (120, 'manage_products', 'manage products', 'manage products', '2021-10-26 12:12:12', '2021-10-26 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (121, 'task_allocation', 'Task allocation', 'Task allocation', '2021-10-26 12:12:12', '2021-10-26 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (122, 'manage_Karibusms', 'Manage karibusms', 'manage karibusms', '2021-10-26 12:12:12', '2021-10-26 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (123, 'whatsapp_integrations', 'whatsapp integrations', 'whatsapp integrations', '2021-10-26 12:12:12', '2021-10-26 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (124, 'manage_joina', 'shulesoft portal', 'shulesoft portal', '2021-10-26 12:12:12', '2021-10-26 12:12:12', 8);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (125, 'reconciliation', 'Invoice reconciliation', 'Invoice reconciliation', '2021-10-26 12:12:12', '2021-10-26 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (126, 'manage_talents', 'Manage talents', 'Manage talents', '2021-10-26 12:12:12', '2021-10-26 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (127, 'hr_request', 'HR request', 'HR request', '2021-10-26 12:12:12', '2021-10-26 12:12:12', 8);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (128, 'engineering', 'manage engineering', 'manage engineering', '2021-10-26 12:12:12', '2021-10-26 12:12:12', 7);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (129, 'manage_errors', 'Manage errors', 'Manage errors', '2021-10-26 12:12:12', '2021-10-26 12:12:12', 7);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (130, 'manage_invoice', 'Manage invoice', 'Manage invoice', '2021-10-26 12:12:12', '2021-10-26 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (131, 'manage_transactions', 'Manage transactions', 'Manage transactions', '2021-10-26 12:12:12', '2021-10-26 12:12:12', 6);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (132, 'manage_loans', 'Manage loans', 'Manage loans', '2021-10-26 12:12:12', '2021-10-26 12:12:12', 6);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (133, 'settings', 'Manage settings', 'Manage settings', '2021-10-26 12:12:12', '2021-10-26 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (134, 'manage_salaries', 'Manage salaries', 'Manage salaries', '2021-10-26 12:12:12', '2021-10-26 12:12:12', 6);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (135, 'course_participants', 'view course participants', 'view course participants', '2021-10-26 12:12:12', '2021-10-26 12:12:12', 8);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (136, 'attendance_hr_report', 'Attendance report', 'Attendance report', '2021-10-26 12:12:12', '2021-10-26 12:12:12', 9);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (137, 'approve_implementaion', 'approve implementaion', 'Approve implementaion', '2021-10-26 12:12:12', '2021-10-26 12:12:12', 1);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (138, 'delete_tasks', 'Delete tasks', 'Delete tasks', '2021-10-26 12:12:12', '2021-10-26 12:12:12', 10);
INSERT INTO admin.permissions (id, name, display_name, description, created_at, updated_at, permission_group_id) VALUES (139, 'approve_onboard', 'Approve onboard', 'Approve onboard', '2021-10-26 12:12:12', '2021-10-26 12:12:12', 10);


--
-- TOC entry 315165 (class 0 OID 0)
-- Dependencies: 596
-- Name: permissions_id_seq; Type: SEQUENCE SET; Schema: admin; Owner: postgres
--

SELECT pg_catalog.setval('admin.permissions_id_seq', 140, false);


-- Completed on 2023-03-29 11:38:01

--
-- PostgreSQL database dump complete
--

