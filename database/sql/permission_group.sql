--
-- PostgreSQL database dump
--

-- Dumped from database version 13.7
-- Dumped by pg_dump version 14.2

-- Started on 2023-03-29 11:04:45

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
-- TOC entry 315165 (class 1262 OID 2799751)
-- Name: shulesoft2022; Type: DATABASE; Schema: -; Owner: postgres
--

CREATE DATABASE shulesoft2022 WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE = 'en_US.UTF-8';


ALTER DATABASE shulesoft2022 OWNER TO postgres;

\connect shulesoft2022

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
-- TOC entry 315159 (class 0 OID 2842081)
-- Dependencies: 593
-- Data for Name: permission_groups; Type: TABLE DATA; Schema: admin; Owner: postgres
--

INSERT INTO admin.permission_groups (id, name, description, created_at, updated_at) VALUES (1, 'Sales', 'to manage sales activities', '2021-05-11 12:12:12', '2021-05-11 12:12:12');
INSERT INTO admin.permission_groups (id, name, description, created_at, updated_at) VALUES (3, 'Dashboard', 'Manage Dashboard', '2021-05-11 12:12:12', '2021-05-11 12:12:12');
INSERT INTO admin.permission_groups (id, name, description, created_at, updated_at) VALUES (2, 'Customer services', 'Managing customer services', '2021-05-11 12:12:12', '2021-05-11 12:12:12');
INSERT INTO admin.permission_groups (id, name, description, created_at, updated_at) VALUES (4, 'Task', 'Task management', '2021-05-11 12:12:12', '2021-05-11 12:12:12');
INSERT INTO admin.permission_groups (id, name, description, created_at, updated_at) VALUES (5, 'Marketing', 'Managing marketing', '2021-05-11 12:12:12', '2021-05-11 12:12:12');
INSERT INTO admin.permission_groups (id, name, description, created_at, updated_at) VALUES (7, 'Software', 'Manage software', '2021-05-11 12:12:12', '2021-05-11 12:12:12');
INSERT INTO admin.permission_groups (id, name, description, created_at, updated_at) VALUES (6, 'Accounts and finance', 'Managing accounts and finance', '2021-05-11 12:12:12', '2021-05-11 12:12:12');
INSERT INTO admin.permission_groups (id, name, description, created_at, updated_at) VALUES (8, 'Adminstatration', 'Admin roles', '2021-05-11 12:12:12', '2021-05-11 12:12:12');
INSERT INTO admin.permission_groups (id, name, description, created_at, updated_at) VALUES (9, 'Human resource', 'Manage Human resources', '2021-05-11 12:12:12', '2021-05-11 12:12:12');
INSERT INTO admin.permission_groups (id, name, description, created_at, updated_at) VALUES (10, 'Operations', 'Manage operations', '2021-05-11 12:12:12', '2021-05-11 12:12:12');


--
-- TOC entry 315166 (class 0 OID 0)
-- Dependencies: 592
-- Name: permission_groups_id_seq; Type: SEQUENCE SET; Schema: admin; Owner: postgres
--

SELECT pg_catalog.setval('admin.permission_groups_id_seq', 11, false);


-- Completed on 2023-03-29 11:40:14

--
-- PostgreSQL database dump complete
--

