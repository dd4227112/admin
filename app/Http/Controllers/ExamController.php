<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ExamController extends Controller {

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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
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
                $this->data['exams'] = \App\Model\GlobalExam::all();
                return view('exam.definition', $this->data);
                break;
            case 'grade':
                $this->data['levels'] = \App\Model\SchoolLevel::all();
                $this->data['grades'] = (int) request('id') > 0 ?
                        \App\Model\GlobalGrade::where('classlevel_id', request('id'))->get() : [];
                return view('exam.grade.index', $this->data);
                break;
            default:
                break;
        }
    }

    public function globalExam($a, $b = null, $action = null, $state = null) {
        if (strtolower($action) == 'add') {
            $this->data['levels'] = \App\Model\SchoolLevel::all();
            $this->data['associations'] = \App\Model\Association::all();
            $this->data['classes']=DB::table('constant.refer_classes')->get();
            if ($_POST) {
                $association=\App\Model\Association::find(request());
                $grade = \App\Model\GlobalExam::create(['name'=>$association->name]);
                $this->createLocalGrade($grade);
                return redirect('exam/grade?id=' . request('classlevel_id'))->with('success', 'Grade created successfully');
            }
            return view('exam.global.add', $this->data);
        } else if (strtolower($action) == 'edit') {
            $this->data['levels'] = \App\Model\SchoolLevel::all();
            $this->data['grade'] = \App\Model\GlobalGrade::find($state);
            $this->data['associations'] = \App\Model\Association::all();
            if ($_POST) {
                \App\Model\GlobalGrade::find($state)->update(request()->all());
                return redirect('exam/grade?id=' . $this->data['grade']->classlevel_id)->with('success', 'Grade updated successfully');
            }
            return view('exam.global.edit', $this->data);
        } else if (strtolower($action) == 'delete') {
            \App\Model\GlobalGrade::find($state)->delete();
            return redirect()->back()->with('success', 'Grade deleted successfully');
        }
    }

    public function createLocalGrade($grades) {
        //check if there is any special grade name with such name in all defined schema
        $school_associations = \App\Model\SchoolAssociation::where('association_id', $association_id)->get();
        foreach ($school_associations as $school) {
            $special_grade_name = DB::table($school->schema_name . '.special_grade_names')->where('association_id', $association_id)->first();
            if (count($special_grade_name) == 0) {
                $special_grade_name_id = DB::table($school->schema_name . '.special_grade_names')->insertGetId(['name' => $association->name, 'note' => 'Grades for ' . $association->name, 'association_id' => $association_id]);

                foreach ($grades as $grade) {
                    $special_grade = DB::table()->where('association_id', $association_id)->where('grade', $grade->grade)->first();
                    if (count($special_grade) == 0) {
                        DB::table()->insert([
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

    public function grade($id, $pg = null, $action = null, $state = null) {
        if (strtolower($action) == 'add') {
            $this->data['levels'] = \App\Model\SchoolLevel::all();
            $this->data['associations'] = \App\Model\Association::all();
            if ($_POST) {
                $grade = \App\Model\GlobalGrade::create(request()->all());
                $this->createLocalGrade($grade);
                return redirect('exam/grade?id=' . request('classlevel_id'))->with('success', 'Grade created successfully');
            }
            return view('exam.grade.add', $this->data);
        } else if (strtolower($action) == 'edit') {
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

    public function report($id, $pg, $x) {
        $this->data['classes'] = \App\Model\ReferClasses::all();
        $this->data['exams'] = \App\Model\GlobalExam::all();
        $this->data['academic_years'] = DB::select('select distinct academic_year from admin.all_mark_info ');
        $this->data['subjects'] = DB::select('select distinct subject_name from admin.all_mark_info ');
        $this->data['reports'] = [];
        if ($_POST) {
            $exam_id = request('exam_id');
            $subject_id = request('subject_id');
            $class_id = request('class_id');
            if (request('type_id') == 'school') {
                //get school reports
                $this->data['reports'] = $this->createSchoolReport($exam_id, $subject_id, $class_id);
            } else if (request('type_id') == 'subject') {
                $this->data['reports'] = $this->showAllSubjectReport($exam_id, $class_id);
            } else {
                //get student reports
                $this->data['reports'] = $this->createStudentReport($exam_id, $subject_id, $class_id);
            }
        }
        return view('exam.single_report', $this->data);
    }

    private function createSchoolReport($exam_id, $subject_id, $class_id) {
        $subject_list = $subject_id == 'all' ? ' ' : " and lower(subject_name)='" . strtolower($subject_id) . "'";
        return DB::select('select round(avg(mark)) as average, "schema_name", rank() over (order by round(avg(mark)) desc) as rank, \'A\' as grade from admin.all_mark_info where "classesID"=' . $class_id . ' AND global_exam_id=' . $exam_id . ' ' . $subject_list . ' group by "schema_name"');
    }

    private function createStudentReport($exam_id, $subject_id, $class_id) {
        $subject_list = $subject_id == 'all' ? ' ' : " and lower(subject_name)='" . strtolower($subject_id) . "'";
        return DB::select('select name,round(avg(mark)) as average, "schema_name", rank() over (order by round(avg(mark)) desc) as rank, \'A\' as grade from admin.all_mark_info where "classesID"=' . $class_id . ' AND global_exam_id=' . $exam_id . ' ' . $subject_list . ' group by "schema_name",name');
    }

    public function showAllSubjectReport($exam_id, $class_id) {
        $subject_status = 'SELECT distinct subject_name FROM admin.all_mark_info where "classesID"=' . $class_id . ' AND global_exam_id=' . $exam_id . ' order by 1';
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
        $this->data['grades'] = DB::select('select * from geniuskings.grade where classlevel_id=3');
        $this->data['subject_evaluations'] = DB::select('select round(AVG(mark),1) as average, subject_name, sum(mark), rank() OVER (ORDER BY (avg(mark)) DESC) AS ranking from admin.all_mark_info where global_exam_id=' . $exam_id . '  and "classesID"=' . $class_id . '  group by subject_name');
        return DB::select('with tempa as ( select b.name,b.roll,b."schema_name",a.*, c.subject_count, c.sum as total, c.average FROM (SELECT * FROM public.crosstab( \'select "student_id"::integer, subject_name, mark from admin.all_mark_info where "classesID"=' . $class_id . ' AND global_exam_id=' . $exam_id . ' order by 1,2 \',\' SELECT distinct subject_name FROM admin.all_mark_info where "classesID"=' . $class_id . ' AND global_exam_id=' . $exam_id . ' order by 1\') AS final_result("student_id" integer, ' . $subject_list . ') ) as a JOIN admin.all_student b ON (a."student_id"=b."student_id") JOIN admin.all_sum_exam_average_done c ON (c."student_id"=b."student_id"  AND c."schema_name"=b."schema_name") where c."classesID"=' . $class_id . ' and c.global_exam_id=' . $exam_id . '), tempb as (select * from tempa ) select *, rank() over (order by average desc) as rank from tempb');
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
        $academic_year_id = request('academic_year_id');
        $subjects = DB::select("select distinct subject_name from admin.all_mark_info where academic_year='$academic_year_id' AND \"classesID\"=" . $class_id);
        if (!empty($subjects)) {
            echo "<option value='0'>Select Subject</option>";
            echo "<option value='all'>All Subjects</option>";
            foreach ($subjects as $subject) {
                echo '<option value=' . $subject->subject_name . '>' . $subject->subject_name . '</option>';
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
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
