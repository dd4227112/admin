/**
 * Author:  Ephraim
 * Global Exams settings
 */
ALTER TABLE geniuskings.refer_exam
    ADD CONSTRAINT refer_exam_global_exam_id_foreign FOREIGN KEY (global_exam_id)
    REFERENCES constant.global_exams (id) MATCH SIMPLE
    ON UPDATE CASCADE
    ON DELETE CASCADE;
CREATE INDEX fki_refer_exam_global_exam_id_foreign
    ON geniuskings.refer_exam(global_exam_id);

ALTER TABLE geniuskings.refer_exam
    ADD COLUMN global_exam_id integer default null;

ALTER TABLE geniuskings.classlevel
    ADD COLUMN school_level_id integer;
ALTER TABLE geniuskings.classlevel
    ADD CONSTRAINT classlevel_school_level_id_foreign FOREIGN KEY (school_level_id)
    REFERENCES constant.school_levels (id) MATCH SIMPLE
    ON UPDATE CASCADE
    ON DELETE RESTRICT;
CREATE INDEX fki_classlevel_school_level_id_foreign
    ON geniuskings.classlevel(school_level_id);