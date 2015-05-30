
ALTER SESSION SET NLS_DATE_FORMAT='YYYY-MM-DD';
ALTER SESSION SET NLS_TIMESTAMP_FORMAT='YYYY-MM-DD HH24:MI:SS';

-----------------------------------------------------------------------
-- student_tb
-----------------------------------------------------------------------

DROP TABLE student_tb CASCADE CONSTRAINTS;

DROP SEQUENCE student_tb_SEQ;

CREATE TABLE student_tb
(
    id NUMBER NOT NULL,
    name NVARCHAR2(255),
    email NVARCHAR2(255),
    Request NUMBER,
    TeacherMessage NVARCHAR2(255),
    password NVARCHAR2(255) NOT NULL,
    CONSTRAINT IX_UQ_student_tb_email UNIQUE (email)
);

ALTER TABLE student_tb ADD CONSTRAINT student_tb_pk PRIMARY KEY (id);

CREATE SEQUENCE student_tb_SEQ
    INCREMENT BY 1 START WITH 1 NOMAXVALUE NOCYCLE NOCACHE ORDER;

-----------------------------------------------------------------------
-- Users
-----------------------------------------------------------------------

DROP TABLE Users CASCADE CONSTRAINTS;

DROP SEQUENCE Users_SEQ;

CREATE TABLE Users
(
    id NUMBER NOT NULL,
    name NVARCHAR2(255),
    email NVARCHAR2(255),
    type NVARCHAR2(255),
    password NVARCHAR2(255) NOT NULL
);

ALTER TABLE Users ADD CONSTRAINT Users_pk PRIMARY KEY (id);

CREATE SEQUENCE Users_SEQ
    INCREMENT BY 1 START WITH 1 NOMAXVALUE NOCYCLE NOCACHE ORDER;

-----------------------------------------------------------------------
-- subscription_tb
-----------------------------------------------------------------------

DROP TABLE subscription_tb CASCADE CONSTRAINTS;

DROP SEQUENCE subscription_tb_SEQ;

CREATE TABLE subscription_tb
(
    id NUMBER NOT NULL,
    student_id NUMBER,
    course_id NUMBER
);

ALTER TABLE subscription_tb ADD CONSTRAINT subscription_tb_pk PRIMARY KEY (id);

CREATE SEQUENCE subscription_tb_SEQ
    INCREMENT BY 1 START WITH 1 NOMAXVALUE NOCYCLE NOCACHE ORDER;

-----------------------------------------------------------------------
-- homework_tb
-----------------------------------------------------------------------

DROP TABLE homework_tb CASCADE CONSTRAINTS;

DROP SEQUENCE homework_tb_SEQ;

CREATE TABLE homework_tb
(
    id NUMBER NOT NULL,
    course_id NUMBER,
    Materie NVARCHAR2(255),
    DueTime TIMESTAMP,
    Description NVARCHAR2(2000),
    PostTime TIMESTAMP,
    Nota NUMBER
);

ALTER TABLE homework_tb ADD CONSTRAINT homework_tb_pk PRIMARY KEY (id);

CREATE SEQUENCE homework_tb_SEQ
    INCREMENT BY 1 START WITH 1 NOMAXVALUE NOCYCLE NOCACHE ORDER;

-----------------------------------------------------------------------
-- test_tb
-----------------------------------------------------------------------

DROP TABLE test_tb CASCADE CONSTRAINTS;

DROP SEQUENCE test_tb_SEQ;

CREATE TABLE test_tb
(
    id NUMBER NOT NULL,
    course_id NUMBER,
    Materie NVARCHAR2(255),
    DueTime TIMESTAMP,
    PostTime TIMESTAMP,
    Nota NUMBER
);

ALTER TABLE test_tb ADD CONSTRAINT test_tb_pk PRIMARY KEY (id);

CREATE SEQUENCE test_tb_SEQ
    INCREMENT BY 1 START WITH 1 NOMAXVALUE NOCYCLE NOCACHE ORDER;

-----------------------------------------------------------------------
-- project_tb
-----------------------------------------------------------------------

DROP TABLE project_tb CASCADE CONSTRAINTS;

DROP SEQUENCE project_tb_SEQ;

CREATE TABLE project_tb
(
    id NUMBER NOT NULL,
    course_id NUMBER,
    Titlu NVARCHAR2(255),
    Materie NVARCHAR2(255),
    Dificultate NVARCHAR2(255),
    Description NVARCHAR2(2000),
    Nota NUMBER,
    Numar_Participanti NUMBER,
    DueTime TIMESTAMP,
    PostTime TIMESTAMP
);

ALTER TABLE project_tb ADD CONSTRAINT project_tb_pk PRIMARY KEY (id);

CREATE SEQUENCE project_tb_SEQ
    INCREMENT BY 1 START WITH 1 NOMAXVALUE NOCYCLE NOCACHE ORDER;

-----------------------------------------------------------------------
-- profesor_tb
-----------------------------------------------------------------------

DROP TABLE profesor_tb CASCADE CONSTRAINTS;

DROP SEQUENCE profesor_tb_SEQ;

CREATE TABLE profesor_tb
(
    id NUMBER NOT NULL,
    name NVARCHAR2(255),
    email NVARCHAR2(255),
    password NVARCHAR2(255) NOT NULL
);

ALTER TABLE profesor_tb ADD CONSTRAINT profesor_tb_pk PRIMARY KEY (id);

CREATE SEQUENCE profesor_tb_SEQ
    INCREMENT BY 1 START WITH 1 NOMAXVALUE NOCYCLE NOCACHE ORDER;

-----------------------------------------------------------------------
-- course_tb
-----------------------------------------------------------------------

DROP TABLE course_tb CASCADE CONSTRAINTS;

DROP SEQUENCE course_tb_SEQ;

CREATE TABLE course_tb
(
    id NUMBER NOT NULL,
    profesor_id NUMBER,
    subject_id NUMBER,
    Subject_Name NVARCHAR2(255),
    Class_Capacity NUMBER,
    Initial_Class_Capacity NUMBER,
    Start_Date TIMESTAMP,
    Finish_Date TIMESTAMP
);

ALTER TABLE course_tb ADD CONSTRAINT course_tb_pk PRIMARY KEY (id);

CREATE SEQUENCE course_tb_SEQ
    INCREMENT BY 1 START WITH 1 NOMAXVALUE NOCYCLE NOCACHE ORDER;

-----------------------------------------------------------------------
-- subject_tb
-----------------------------------------------------------------------

DROP TABLE subject_tb CASCADE CONSTRAINTS;

DROP SEQUENCE subject_tb_SEQ;

CREATE TABLE subject_tb
(
    id NUMBER NOT NULL,
    student_id NUMBER,
    course_id NUMBER
);

ALTER TABLE subject_tb ADD CONSTRAINT subject_tb_pk PRIMARY KEY (id);

CREATE SEQUENCE subject_tb_SEQ
    INCREMENT BY 1 START WITH 1 NOMAXVALUE NOCYCLE NOCACHE ORDER;

-----------------------------------------------------------------------
-- homeworkeval_tb
-----------------------------------------------------------------------

DROP TABLE homeworkeval_tb CASCADE CONSTRAINTS;

DROP SEQUENCE homeworkeval_tb_SEQ;

CREATE TABLE homeworkeval_tb
(
    id NUMBER NOT NULL,
    homework_id NUMBER,
    subscription_id NUMBER
);

ALTER TABLE homeworkeval_tb ADD CONSTRAINT homeworkeval_tb_pk PRIMARY KEY (id);

CREATE SEQUENCE homeworkeval_tb_SEQ
    INCREMENT BY 1 START WITH 1 NOMAXVALUE NOCYCLE NOCACHE ORDER;

-----------------------------------------------------------------------
-- testeval_tb
-----------------------------------------------------------------------

DROP TABLE testeval_tb CASCADE CONSTRAINTS;

DROP SEQUENCE testeval_tb_SEQ;

CREATE TABLE testeval_tb
(
    id NUMBER NOT NULL,
    test_id NUMBER,
    subscription_id NUMBER
);

ALTER TABLE testeval_tb ADD CONSTRAINT testeval_tb_pk PRIMARY KEY (id);

CREATE SEQUENCE testeval_tb_SEQ
    INCREMENT BY 1 START WITH 1 NOMAXVALUE NOCYCLE NOCACHE ORDER;

-----------------------------------------------------------------------
-- projecteval_tb
-----------------------------------------------------------------------

DROP TABLE projecteval_tb CASCADE CONSTRAINTS;

DROP SEQUENCE projecteval_tb_SEQ;

CREATE TABLE projecteval_tb
(
    id NUMBER NOT NULL,
    project_id NUMBER,
    subscription_id NUMBER
);

ALTER TABLE projecteval_tb ADD CONSTRAINT projecteval_tb_pk PRIMARY KEY (id);

CREATE SEQUENCE projecteval_tb_SEQ
    INCREMENT BY 1 START WITH 1 NOMAXVALUE NOCYCLE NOCACHE ORDER;

-----------------------------------------------------------------------
-- group_tb
-----------------------------------------------------------------------

DROP TABLE group_tb CASCADE CONSTRAINTS;

DROP SEQUENCE group_tb_SEQ;

CREATE TABLE group_tb
(
    id NUMBER NOT NULL,
    project_id NUMBER,
    nr NUMBER DEFAULT 0
);

ALTER TABLE group_tb ADD CONSTRAINT group_tb_pk PRIMARY KEY (id);

CREATE SEQUENCE group_tb_SEQ
    INCREMENT BY 1 START WITH 1 NOMAXVALUE NOCYCLE NOCACHE ORDER;

-----------------------------------------------------------------------
-- pack_tb
-----------------------------------------------------------------------

DROP TABLE pack_tb CASCADE CONSTRAINTS;

DROP SEQUENCE pack_tb_SEQ;

CREATE TABLE pack_tb
(
    id NUMBER NOT NULL,
    group_id NUMBER,
    subscription_id NUMBER
);

ALTER TABLE pack_tb ADD CONSTRAINT pack_tb_pk PRIMARY KEY (id);

CREATE SEQUENCE pack_tb_SEQ
    INCREMENT BY 1 START WITH 1 NOMAXVALUE NOCYCLE NOCACHE ORDER;

-----------------------------------------------------------------------
-- Foreign Keys
-----------------------------------------------------------------------

ALTER TABLE subscription_tb ADD CONSTRAINT subscription_tb_fk_97f89d
    FOREIGN KEY (student_id) REFERENCES student_tb (id);

ALTER TABLE subscription_tb ADD CONSTRAINT subscription_tb_fk_cad7d4
    FOREIGN KEY (course_id) REFERENCES course_tb (id);

ALTER TABLE homework_tb ADD CONSTRAINT homework_tb_fk_cad7d4
    FOREIGN KEY (course_id) REFERENCES course_tb (id);

ALTER TABLE test_tb ADD CONSTRAINT test_tb_fk_cad7d4
    FOREIGN KEY (course_id) REFERENCES course_tb (id);

ALTER TABLE project_tb ADD CONSTRAINT project_tb_fk_cad7d4
    FOREIGN KEY (course_id) REFERENCES course_tb (id);

ALTER TABLE course_tb ADD CONSTRAINT course_tb_fk_cfe292
    FOREIGN KEY (profesor_id) REFERENCES profesor_tb (id);

ALTER TABLE course_tb ADD CONSTRAINT course_tb_fk_bc272d
    FOREIGN KEY (subject_id) REFERENCES subject_tb (id);

ALTER TABLE subject_tb ADD CONSTRAINT subject_tb_fk_97f89d
    FOREIGN KEY (student_id) REFERENCES student_tb (id);

ALTER TABLE subject_tb ADD CONSTRAINT subject_tb_fk_cad7d4
    FOREIGN KEY (course_id) REFERENCES course_tb (id);

ALTER TABLE homeworkeval_tb ADD CONSTRAINT homeworkeval_tb_fk_aadd2e
    FOREIGN KEY (homework_id) REFERENCES homework_tb (id);

ALTER TABLE homeworkeval_tb ADD CONSTRAINT homeworkeval_tb_fk_eb3ec5
    FOREIGN KEY (subscription_id) REFERENCES subscription_tb (id);

ALTER TABLE testeval_tb ADD CONSTRAINT testeval_tb_fk_3df1df
    FOREIGN KEY (test_id) REFERENCES test_tb (id);

ALTER TABLE testeval_tb ADD CONSTRAINT testeval_tb_fk_eb3ec5
    FOREIGN KEY (subscription_id) REFERENCES subscription_tb (id);

ALTER TABLE projecteval_tb ADD CONSTRAINT projecteval_tb_fk_f508d4
    FOREIGN KEY (project_id) REFERENCES project_tb (id);

ALTER TABLE projecteval_tb ADD CONSTRAINT projecteval_tb_fk_eb3ec5
    FOREIGN KEY (subscription_id) REFERENCES subscription_tb (id);

ALTER TABLE group_tb ADD CONSTRAINT group_tb_fk_f508d4
    FOREIGN KEY (project_id) REFERENCES project_tb (id);

ALTER TABLE pack_tb ADD CONSTRAINT pack_tb_fk_79b0a1
    FOREIGN KEY (group_id) REFERENCES group_tb (id);

ALTER TABLE pack_tb ADD CONSTRAINT pack_tb_fk_eb3ec5
    FOREIGN KEY (subscription_id) REFERENCES subscription_tb (id);
