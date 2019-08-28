<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class Exam extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    public function listing() {
        $this->data['exams'] = \App\Model\GlobalExamDefinition::all();
        return view('exam.listing', $this->data);
    }

    public function schedule() {
        $this->data['exams'] = \App\Model\GlobalExam::all();
        return view('exam.schedule.index', $this->data);
    }

    public function grade() {
        $this->data['levels'] = \App\Model\SchoolLevel::all();
        $this->data['grades'] = (int) request('id') > 0 ?
                \App\Model\GlobalGrade::where('classlevel_id', request('id'))->get() : [];
        return view('exam.grade.index', $this->data);
    }

    public function editGrade() {
        $state = request()->segment(3);
        $this->data['levels'] = \App\Model\SchoolLevel::all();
        $this->data['grade'] = \App\Model\GlobalGrade::find($state);
        $this->data['associations'] = \App\Model\Association::all();
        if ($_POST) {
            \App\Model\GlobalGrade::find($state)->update(request()->all());
            return redirect('exam/grade/null?id=' . $this->data['grade']->classlevel_id)->with('success', 'Grade updated successfully');
        }
        return view('exam.grade.edit', $this->data);
    }

    public function deleteGrade() {
        $state = request()->segment(3);
        \App\Model\GlobalGrade::find($state)->delete();
        return redirect()->back()->with('success', 'Grade deleted successfully');
    }

    public function addGrade() {
        $this->data['levels'] = \App\Model\SchoolLevel::all();
        $this->data['associations'] = \App\Model\Association::all();
        if ($_POST) {
            $grade = \App\Model\GlobalGrade::create(request()->all());
            $this->createLocalGrade($grade);
            return redirect('exam/grade/null?id=' . request('classlevel_id'))->with('success', 'Grade created successfully');
        }
        return view('exam.grade.add', $this->data);
    }

    public function allocate() {
        $this->data['exams'] = \App\Model\GlobalExam::all();
        return view('exam.allocate.index', $this->data);
    }

    public function addAllocation() {
        $this->data['levels'] = \App\Model\SchoolLevel::all();
        $this->data['exams'] = \App\Model\GlobalExamDefinition::all();
        $this->data['classes'] = DB::table('constant.refer_classes')->get();
        if ($_POST) {
            $exam = \App\Model\GlobalExamDefinition::find(request('global_exam_definition_id'));
            $global_exam = \App\Model\GlobalExam::create(['name' => $exam->name, 'global_exam_definition_id' => $exam->id, 'school_level_id' => $exam->school_level_id, 'date' => date('Y-m-d', strtotime(request('date'))), 'note' => request('note')]);
            $this->createLocalExam($global_exam);
            return redirect('exam/allocate')->with('success', 'Grade created successfully');
        }
        return view('exam.allocate.add', $this->data);
    }

    public function editAllocation() {
        $this->data['levels'] = \App\Model\SchoolLevel::all();
        $this->data['associations'] = \App\Model\Association::all();
        if ($_POST) {
            $grade = \App\Model\GlobalGrade::create(request()->all());
            $this->createLocalGrade($grade);
            return redirect('exam/grade/null?id=' . request('classlevel_id'))->with('success', 'Grade created successfully');
        }
        return view('exam.grade.add', $this->data);
    }

    public function deleteAllocation() {
        $id = request()->segment(3);
        \App\Model\GlobalExam::find($id)->delete();
        return redirect()->back()->with('success', 'Exam deleted successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        switch ($id) {
            case 'definition':
                $this->data['exams'] = \App\Model\GlobalExamDefinition::all();
                return view('exam.definition', $this->data);
                break;
            case 'grade':
                $this->data['levels'] = \App\Model\SchoolLevel::all();
                $this->data['grades'] = (int) request('id') > 0 ?
                        \App\Model\GlobalGrade::where('classlevel_id', request('id'))->get() : [];
                return view('exam.grade.index', $this->data);
                break;
            case 'schedule':
                $this->data['exams'] = \App\Model\GlobalExam::all();
                return view('exam.schedule.index', $this->data);
                break;
            default:
                break;
        }
    }

    private function createLocalExam($global_exam) {
        //check refere exam if we have an exam with this name first
        //then create a map record on all schema

        $school_associations = \App\Model\SchoolAssociation::where('association_id', $global_exam->globalExamDefinition->association->id)->get();

        foreach ($school_associations as $school) {

            $check_refer_exam = DB::table($school->schema_name . '.refer_exam')->where(DB::raw('lower(name)'), strtolower($global_exam->globalExamDefinition->name))->first();

            $classlevel = DB::table($school->schema_name . '.classlevel')->where('school_level_id', $global_exam->school_level_id)->first();
            $classlevel_id = count($classlevel) == 1 ? $classlevel->classlevel_id : $this->mapClassLevel($school->schema_name, $global_exam);
            if (count($check_refer_exam) == 0) {

                $refer_exam_id = DB::table($school->schema_name . '.refer_exam')->insertGetId(['name' => $global_exam->globalExamDefinition->name, 'classlevel_id' => $classlevel_id, 'note' => request('note')]);
            } else {
                $refer_exam_id = $check_refer_exam->id;
            }
            $special_grade = DB::table($school->schema_name . '.special_grade_names')->where('association_id', $global_exam->globalExamDefinition->association->id)->first();
            if (count($special_grade) == 1) {
                $grade_id = $special_grade->id;
            } else {
                $grade_id = DB::table($school->schema_name . '.special_grade_names')->insertGetId(['name' => $global_exam->globalExamDefinition->association->name, 'association_id' => $global_exam->globalExamDefinition->association->id, 'note' => strtoupper($global_exam->globalExamDefinition->association->name)]);
            }
            $check_exam = DB::table($school->schema_name . '.exam')->where('global_exam_id', $global_exam->id)->first();

            if (count($check_exam) == 0) {

                $semester = DB::table($school->schema_name . '.semester')->where('class_level_id', $classlevel_id)->where('start_date', '<', date('Y-m-d', strtotime($global_exam->date)))->where('end_date', '>', date('Y-m-d', strtotime($global_exam->date)))->first();


                $exam_id = DB::table($school->schema_name . '.exam')->insertGetId([
                    'exam' => $global_exam->globalExamDefinition->name,
                    'date' => date('Y-m-d', strtotime($global_exam->date)),
                    'global_exam_id' => $global_exam->id,
                    'special_grade_name_id' => $grade_id,
                    'refer_exam_id' => $refer_exam_id,
                    'semester_id' => count($semester) == 1 ? $semester->id : DB::table($school->schema_name . '.semester')->first()->id], 'examID');
                $refer_class_id = request('class_id');
                $class = DB::table($school->schema_name . '.classes')->where('refer_class_id', $refer_class_id)->first();
                $class_id = count($class) == 1 ? $class->classesID : $this->mapClass($school->schema_name, $refer_class_id, $classlevel_id);
                DB::table($school->schema_name . '.class_exam')->insert([
                    'class_id' => $class_id,
                    'exam_id' => $exam_id,
                    'academic_year_id' => count($semester) == 1 ? $semester->academic_year_id : DB::table($school->schema_name . '.semester')->first()->academic_year_id
                ]);
            }
        }
    }

    public function mapClass($schema, $refer_class_id, $classlevel_id) {
        $refer_class = \App\Model\ReferClasses::find($refer_class_id);

        $r = \collect(DB::select("select * from " . $schema . ".classes where lower(classes) like '%" . strtolower($refer_class->name) . "%'  OR (classes_numeric=" . $refer_class->class_numeric . " AND classlevel_id=" . $classlevel_id . "  )"))->first();
        if (count($r) == 1) {
            DB::table($schema . '.classes')->where('classesID', $r->classesID)->update(['refer_class_id' => $refer_class_id]);
            return $r->classesID;
        } else {

            $return = DB::table($schema . '.classes')->where('classes_numeric', $refer_class->class_numeric)->where('classlevel_id', $classlevel_id);
            $id = $return->first()->classesID;
            $return->update(['refer_class_id' => $refer_class_id]);
            return $id;
        }
    }

    public function mapClassLevel($schema, $level) {
        $r = \collect(DB::select("select * from " . $schema . ".classlevel where lower(name) like '%" . strtolower($level->schoolLevel->name) . "%' "))->first();
        if (count($r) == 1) {
            DB::table($schema . '.classlevel')->where('classlevel_id', $r->classlevel_id)->update(['school_level_id' => $level->school_level_id]);
            return $r->classlevel_id;
        } else {
            return DB::table($schema . '.classlevel')->where('span_number', $level->schoolLevel->span_number)->first()->classlevel_id;
        }
    }

    public function createGlobalExam($id) {
        $school_associations = \App\Model\SchoolAssociation::where('association_id', request('association_id'))->get();
        foreach ($school_associations as $school) {
            $refer_exam = DB::table($school->schema_name . '.refer_exam')->where('name', request('name'))->first();
            if (count($refer_exam) == 0) {
                $classlevel = DB::table($school->schema_name . '.classlevel')->where('school_level_id', request('class_level_id'))->first();
                DB::statement('ALTER TABLE ' . $school->schema_name . '.refer_exam ADD COLUMN if not exists global_exam_definition_id integer');
                DB::table($school->schema_name . '.refer_exam')->insert(['name' => request('name'), 'classlevel_id' => $classlevel->classlevel_id, 'note' => request('note'), 'global_exam_definition_id' => $id]);
            }
        }
    }

    public function globalExam($a, $b = null, $action = null, $state = null) {
        if (strtolower($action) == 'add') {
            $this->data['levels'] = \App\Model\SchoolLevel::all();
            $this->data['associations'] = \App\Model\Association::all();
            $this->data['classes'] = DB::table('constant.refer_classes')->get();
            if ($_POST) {
                $this->validate(request(), [
                    'name' => 'required|max:255',
                    'association_id' => 'required|min:1',
                    "school_level_id" => "required|min:1",
                ]);
                $check = DB::table('constant.global_exam_definitions')->where('name', request('name'))->count();
                if ($check > 0) {
                    return redirect()->back()->with('error', 'Exam with this name exists');
                }
                $id = DB::table('constant.global_exam_definitions')->insertGetId([
                    'name' => request('name'),
                    'association_id' => request('association_id'),
                    'school_level_id' => request('class_level_id'),
                    'note' => request('note')
                ]);
                $this->createGlobalExam($id);
                return redirect('exam/listing')->with('success', 'Exam created successfully');
            }
            return view('exam.global.add', $this->data);
        } else if (strtolower($action) == 'edit') {
            $this->data['levels'] = \App\Model\SchoolLevel::all();
            $this->data['associations'] = \App\Model\Association::all();
            $this->data['exam'] = \App\Model\GlobalExamDefinition::find($state);
            if ($_POST) {
                $this->data['exam']->update(request()->all());
                $this->updateGlobalExam($state);
                return redirect('exam/listing')->with('success', 'Grade updated successfully');
            }
            return view('exam.global.edit', $this->data);
        } else if (strtolower($action) == 'delete') {

            $exam = \App\Model\GlobalExamDefinition::find($state);
            $this->deleteGlobalExam($exam);
            $exam->delete();

            return redirect()->back()->with('success', 'Grade deleted successfully');
        } else if (strtolower($action) == 'show') {
            $this->data['schools'] = \App\Model\SchoolAssociation::all();
            $this->data['associations'] = \App\Model\Association::all();
            return view('exam.global.show', $this->data);
        }
    }

    public function deleteGlobalExam($exam) {
        $school_associations = \App\Model\SchoolAssociation::where('association_id', $exam->association_id)->get();
        foreach ($school_associations as $school) {
            DB::table($school->schema_name . '.refer_exam')->where('global_exam_definition_id', $exam->id)->delete();
        }
    }

    public function updateGlobalExam($id) {
        $school_associations = \App\Model\SchoolAssociation::where('association_id', request('association_id'))->get();
        foreach ($school_associations as $school) {
            $classlevel = DB::table($school->schema_name . '.classlevel')->where('school_level_id', request('school_level_id'))->first();
            DB::table($school->schema_name . '.refer_exam')->where('global_exam_definition_id', $id)->update(['name' => request('name'), 'classlevel_id' => $classlevel->classlevel_id, 'note' => request('note')]);
        }
    }

    public function createLocalGrade($grades) {
        //check if there is any special grade name with such name in all defined schema
        $association = \App\Model\Association::find(request('association_id'));
        $school_associations = \App\Model\SchoolAssociation::where('association_id', $association->id)->get();
        foreach ($school_associations as $school) {
            $special_grade_name = DB::table($school->schema_name . '.special_grade_names')->where('association_id', $association->id)->first();
            if (count($special_grade_name) == 0) {
                $special_grade_name_id = DB::table($school->schema_name . '.special_grade_names')->insertGetId(['name' => $association->name, 'note' => 'Grades for ' . $association->name, 'association_id' => $association->id]);

                foreach ($grades as $grade) {
                    $special_grade = DB::table()->where('association_id', $association->id)->where('grade', $grade->grade)->first();
                    if (count($special_grade) == 0) {
                        DB::table('grade')->insert([
                            'grade' => $grade->grade, 'point' => $grade->point,
                            'gradefrom' => $grade->gradefrom, 'gradeupto' => $grade->gradeupto,
                            'note' => $grade->note, 'classlevel_id' => $grade->point,
                            'special_grade_name_id' => $special_grade_name_id
                        ]);
                    }
                }
            }
        }
    }

    public function grades($id, $pg = null, $action = null, $state = null) {
        if (strtolower($action) == 'edit') {
            $this->data['levels'] = \App\Model\SchoolLevel::all();
            $this->data['grade'] = \App\Model\GlobalGrade::find($state);
            $this->data['associations'] = \App\Model\Association::all();
            if ($_POST) {
                \App\Model\GlobalGrade::find($state)->update(request()->all());
                return redirect('exam/grade?id=' . $this->data['grade']->classlevel_id)->with('success', 'Grade updated successfully');
            }
            return view('exam.grade.edit', $this->data);
        } else if (strtolower($action) == 'delete') {
            \App\Model\GlobalGrade::find($state)->delete();
            return redirect()->back()->with('success', 'Grade deleted successfully');
        }
    }

    public function report() {
        $this->data['classes'] = \App\Model\ReferClasses::all();
        $this->data['exams'] = \App\Model\GlobalExamDefinition::all();

        $this->data['academic_years'] = ['academic_year' => date('Y')];
        // $this->data['subjects'] = DB::select('select distinct lower(subject_name) as subject_name from admin.all_mark_info ');
        $type = request()->segment(3);
        if ($type == 'single') {
            return $this->singleReport();
        } else {
            return $this->combinedReport();
        }
    }

    public function singleReport() {
        $this->data['reports'] = [];
        if ($_POST) {
            $exam_id = request('exam_id');
            $subject_id = request('subject_id');
            $class_id = request('class_id');
            $class = DB::table('constant.refer_classes')->where('id', $class_id)->first();
            $this->data['grades'] = \App\Model\GlobalGrade::where('classlevel_id', $class->school_level_id)->orderBy('grade')->get();
            $sql='select distinct lower(subject_name) as subject_name from admin.all_mark_info where refer_class_id=' . $class_id . ' AND global_exam_id=' . $exam_id . ' and mark is not null order by 1';
            $this->data['subjects'] = DB::select($sql);
            if (request('type_id') == 'school') {
                //get school reports
                $this->data['reports'] = $this->createSchoolReport($exam_id, $subject_id, $class_id);
            } else if (request('type_id') == 'subject') {

                $this->data['reports'] = $this->showAllSubjectReport($exam_id, $class_id);
            } else {
                $this->data['reports'] = $this->createStudentReport($exam_id, $subject_id, $class_id);
            }
        }
        return view('exam.single.single_report', $this->data);
    }

    public function combinedReport() {
        $this->data['exams'] = [];
        return view('exam.combined.summary', $this->data);
    }

    private function createSchoolReport($exam_id, $subject_id, $class_id) {
        $class = DB::table('constant.refer_classes')->where('id', $class_id)->first();

        $subject_list = $subject_id == 'all' || $subject_id == '0' ? ' ' : " and lower(subject_name)='" . strtolower($subject_id) . "'";
        $sql = 'select round(avg(mark)) as average,"schema_name", rank() over (order by round(avg(mark)) desc) as rank, rank() over (partition by "schema_name" order by round(avg(mark)) desc ) as school_rank,  (select grade from constant.global_grades where classlevel_id=' . $class->school_level_id . ' and round(avg(mark)) between gradefrom and gradeupto ) from admin.all_mark_info where refer_class_id=' . $class_id . ' AND global_exam_id=' . $exam_id . ' ' . $subject_list . ' group by "schema_name"';
        return DB::select($sql);
    }

    private function createStudentReport($exam_id, $subject_id, $class_id) {
        $class = DB::table('constant.refer_classes')->where('id', $class_id)->first();
       $subject_list = ($subject_id == 'all' || $subject_id == '0') ? ' ' : " and lower(subject_name)='" . strtolower($subject_id) . "'";
        $sql = 'select name,round(avg(mark)) as average, "schema_name", rank() over (order by round(avg(mark)) desc) as rank, rank() over (partition by "schema_name" order by round(avg(mark)) desc ) as school_rank, (select grade from constant.global_grades where classlevel_id=' . $class->school_level_id . ' and round(avg(mark)) between gradefrom and gradeupto ) from admin.all_mark_info where refer_class_id=' . $class_id . ' AND global_exam_id=' . $exam_id . ' ' . $subject_list . ' group by "schema_name",name'; 
        return DB::select($sql);
    }

    public function showAllSubjectReport($exam_id, $class_id) {
        $subject_status = 'SELECT distinct lower(subject_name)  as subject_name FROM admin.all_mark_info where refer_class_id=' . $class_id . ' AND global_exam_id=' . $exam_id . ' order by 1';
        $school = DB::table('constant.refer_classes')->where('id', $class_id)->first();
        $result = DB::select($subject_status);
        if (!empty($result)) {
            $list = '';
            foreach ($result as $subject) {
                $list .= ' "' . strtolower($subject->subject_name) . '" NUMERIC, ';
            }
            $subject_list = rtrim($list, ', ') == '' ? 'null' : rtrim($list, ', ');
        } else {
            $subject_list = ' "subject" NUMERIC';
        }
        $this->data['subjects'] = $result;
        $this->data['grades'] = DB::select('select * from constant.global_grades where classlevel_id=' . $school->school_level_id);
        $this->data['subject_evaluations'] = DB::select('select round(AVG(mark),1) as average, lower(subject_name) as subject_name, sum(mark), rank() OVER (ORDER BY (avg(mark)) DESC) AS ranking from admin.all_mark_info where global_exam_id=' . $exam_id . '  and refer_class_id=' . $class_id . '  group by lower(subject_name)');
        $sql='with tempa as ( select b.name,b.roll,b.sex,b."schema_name",a.*, c.subject_count, c.sum as total, c.average FROM (SELECT * FROM public.crosstab( \'select "student_id"::integer, lower(subject_name), mark from admin.all_mark_info where refer_class_id=' . $class_id . ' AND global_exam_id=' . $exam_id . ' order by 1,2 \',\' SELECT distinct lower(subject_name)  as subject_name FROM admin.all_mark_info where refer_class_id=' . $class_id . ' AND global_exam_id=' . $exam_id . ' order by 1\') AS final_result("student_id" integer, ' . $subject_list . ') ) as a JOIN admin.all_student b ON (a."student_id"=b."student_id") JOIN admin.all_sum_exam_average_done c ON (c."student_id"=b."student_id"  AND c."schema_name"=b."schema_name") where c.refer_class_id=' . $class_id . ' and c.global_exam_id=' . $exam_id . '), tempb as (select * from tempa ) select *, rank() over (order by average desc) as rank, rank() over ( partition by "schema_name" order by average desc) as school_rank from tempb';
        return DB::select($sql);
    }

    public function getYears() {
        $class_id = request('class_id');
        $academic_year_id = request('academic_year_id');
        $classes = (int) $class_level_id == 0 ? \App\Model\Classes::all() : \App\Model\Classes::where('classlevel_id', $class_level_id)->get();
        if (!empty($classes)) {
            echo "<option value='0'>Select class</option>";
            //  echo "<option value='all'>All</option>";
            foreach ($classes as $class) {
                echo '<option value=' . $class->classesID . '>' . $class->classes . '</option>';
            }
        } else {
            echo "0";
        }
    }

    public function getSubjects() {
        $class_id = request('class_id');
        $exam_id = request('exam_id');
         $sql='select distinct lower(subject_name) as subject_name from admin.all_mark_info where refer_class_id=' . $class_id . ' AND global_exam_id=' . $exam_id . ' and mark is not null order by 1';
            $this->data['subjects'] = DB::select($sql);
            
        $subjects = DB::select($sql);
        if (!empty($subjects)) {
            echo "<option value='0'>Select Subject</option>";
            echo "<option value='all'>All Subjects</option>";
            foreach ($subjects as $subject) {
                echo '<option value=' . $subject->subject_name . '>' . ucwords($subject->subject_name) . '</option>';
            }
        } else {
            echo "0";
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function dashboard() {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function marking() {
        //
    }

}
