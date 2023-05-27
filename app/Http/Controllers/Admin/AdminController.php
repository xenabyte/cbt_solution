<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use Illuminate\Support\Facades\Validator;
use League\Csv\Reader;
use Illuminate\Database\QueryException;


use App\Models\Admin;
use App\Models\Examination;
use App\Models\CandidateQuestion;
use App\Models\Candidate;
use App\Models\Option;
use App\Models\Question;
use App\Models\Student;

class AdminController extends Controller
{
    //
    protected $adminnId;

    //
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware(['auth:admin']);
    }

    public function index(){

        return view('admin.home');
    }

    public function examinations(){
        
        $examinations = Examination::with('admin', 'questions', 'candidates')->orderBy('id', 'DESC')->get();

        return view('admin.examination', [
            'examinations' => $examinations
        ]);
    }
    

    public function addExamination(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:1',
            'description' => 'required',
            'duration' => 'required',
            'mark' => 'required',
            'code' => 'required',
            'question_number' => 'required',
        ]);

        if($validator->fails()) {
            alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
            return redirect()->back();
        }

        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->title)));

        $newExamination = ([
            'admin_id' => Auth::guard('admin')->user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'duration' => $request->duration,
            'mark' => $request->mark,
            'code' => $request->code,
            'question_number' => $request->question_number,
            'slug' => $slug,
            'status' => 0
        ]);

        if(Examination::create($newExamination)){
            alert()->success('Examination Created successfully', '')->persistent('Close');
            return redirect()->back();
        }

        alert()->error('Oops!', 'Something went wrong')->persistent('Close');
        return redirect()->back();
        
    }

    public function deleteExamination(Request $request){

        $validator = Validator::make($request->all(), [
            'examination_id' => 'required|min:1',
        ]);

        if($validator->fails()) {
            alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
            return redirect()->back();
        }


        if(!$examination = Examination::find($request->examination_id)){
            alert()->error('Oops', 'Invalid Examination')->persistent('Close');
            return redirect()->back();
        }

        if($examination->delete()){
            alert()->success('Record Deleted', '')->persistent('Close');
            return redirect()->back();
        }

        alert()->error('Oops!', 'Something went wrong')->persistent('Close');
        return redirect()->back();
    }

    public function updateExamination(Request $request){
        $validator = Validator::make($request->all(), [
            'examination_id' => 'required|min:1',
        ]);

        if($validator->fails()) {
            alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
            return redirect()->back();
        }

        if(!$examination = Examination::find($request->examination_id)){
            alert()->error('Oops', 'Invalid Examination')->persistent('Close');
            return redirect()->back();
        }

        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->title)));


        if(!empty($request->title) &&  $request->title != $examination->title){
            $examination->title = $request->title;
            $examination->slug = $slug;
        }

        if(!empty($request->description) &&  $request->description != $examination->description){
            $examination->description = $request->description;
        }

        if(!empty($request->mark) &&  $request->mark != $examination->mark){
            $examination->mark = $request->mark;
        }

        if(!empty($request->duration) &&  $request->duration != $examination->duration){
            $examination->duration = $request->duration;
        }

        if(!empty($request->question_number) &&  $request->question_number != $examination->question_number){
            $examination->question_number = $request->question_number;
        }

        if(!empty($request->code) &&  $request->code != $examination->code){
            $examination->code = $request->code;
        }

        if(!empty($request->status) &&  $request->status != $examination->status){
            $examination->status = $request->status;
        }

        if($examination->save()){
            alert()->success('Changes Saved', 'Examination changes saved successfully')->persistent('Close');
            return redirect()->back();
        }

        alert()->error('Oops!', 'Something went wrong')->persistent('Close');
        return redirect()->back();
    }

    public function getExamination($slug){
        
        $examination = Examination::with('admin', 'questions', 'candidates', 'candidates.student')->where('slug', $slug)->first();

        return view('admin.singleExamination', [
            'examination' => $examination
        ]);
    }


    public function students(){
        
        $students = Student::with('candidates', 'candidates.z')->get();

        return view('admin.students', [
            'students' => $students
        ]);
    }

    public function addSingleStudent(Request $request){
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|min:1',
            'lastname' => 'required',
            'matric_number' => 'required',
            'reg_number' => 'required',
        ]);

        if($validator->fails()) {
            alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
            return redirect()->back();
        }

        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->title)));

        $newStudent = ([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'matric_number' => $request->matric_number,
            'reg_number' => $request->reg_number,
        ]);

        if(Student::create($newStudent)){
            alert()->success('Student Added successfully', '')->persistent('Close');
            return redirect()->back();
        }

        alert()->error('Oops!', 'Something went wrong')->persistent('Close');
        return redirect()->back();
        
    }

    public function updateStudent(Request $request){
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|min:1',
        ]);

        if($validator->fails()) {
            alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
            return redirect()->back();
        }

        if(!$student = Student::find($request->student_id)){
            alert()->error('Oops', 'Invalid Student')->persistent('Close');
            return redirect()->back();
        }


        if(!empty($request->firstname) &&  $request->firstname != $student->firstname){
            $student->firstname = $request->firstname;
        }

        if(!empty($request->lastname) &&  $request->lastname != $student->lastname){
            $student->lastname = $request->lastname;
        }

        if(!empty($request->matric_number) &&  $request->matric_number != $student->matric_number){
            $student->matric_number = $request->matric_number;
        }

        if(!empty($request->reg_number) &&  $request->reg_number != $student->reg_number){
            $student->reg_number = $request->reg_number;
        }

        if($student->save()){
            alert()->success('Changes Saved', 'Student changes saved successfully')->persistent('Close');
            return redirect()->back();
        }

        alert()->error('Oops!', 'Something went wrong')->persistent('Close');
        return redirect()->back();
    }

    public function deleteStudent(Request $request){

        $validator = Validator::make($request->all(), [
            'student_id' => 'required|min:1',
        ]);

        if($validator->fails()) {
            alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
            return redirect()->back();
        }

        if(!$student = Student::find($request->student_id)){
            alert()->error('Oops', 'Invalid Student')->persistent('Close');
            return redirect()->back();
        }

        if($student->delete()){
            alert()->success('Record Deleted', '')->persistent('Close');
            return redirect()->back();
        }

        alert()->error('Oops!', 'Something went wrong')->persistent('Close');
        return redirect()->back();
    }

    public function addBulkStudent(Request $request){


        try {

            $validator = Validator::make($request->all(), [
                'file' => 'required',
            ]);
    
            if($validator->fails()) {
                alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
                return redirect()->back();
            }
    
            if ($request->hasFile('file')) {
                $file = $request->file('file');
    
                // Create a CSV reader instance
                $csv = Reader::createFromPath($file->getPathname());
    
                // Set the header offset (skip the first row)
                $csv->setHeaderOffset(0);
    
                // Get all records from the CSV file
                $records = $csv->getRecords();
    
                foreach ($records as $row) {
                    //check for existing student record
                    if($student = Student::where('matric_number',$row['matric_number'])->orWhere('reg_number', $row['reg_number'])->first()){
                        alert()->error('Oops', $row['firstname'].' '.$row['lastname'].' in the file is having same record with '. $student->firstname.' '.$student->lastname .' in the database, kindly check')->persistent('Close');
                        return redirect()->back();
                    }

                    Student::create([
                        'firstname' => $row['firstname'],
                        'lastname' => $row['lastname'],
                        'email' => $row['email'],
                        'matric_number' => $row['matric_number'],
                        'reg_number' => $row['reg_number'],
                    ]);
                }
    
                alert()->success('Changes Saved', 'Students added successfully')->persistent('Close');
                return redirect()->back();
            }
        } catch (QueryException $e) {
            if ($e->errorInfo[1] === 1054 || $e->errorInfo[1] === 1061) {
                $errorMessage = 'Some students have the same matric number or registration numbeer, kindly check';
            } else {
                $errorMessage = 'Something went wrong';
            }

            // do something with the error message, such as returning a response
            alert()->error('Oops!', $errorMessage)->persistent('Close');
            return redirect()->back();
        }

    }
}
