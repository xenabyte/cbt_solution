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

use Log;
use Carbon\Carbon;

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

        $examinations = Examination::with('admin', 'questions', 'candidates', 'candidates.student')->get();
        $students = Student::all();

        return view('admin.home', [
            'examinations' => $examinations,
            'students' => $students
        ]);
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
        
        $students = Student::with('candidates')->get();

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
        
        $password = !empty($request->matric_number) ?  $request->matric_number : $request->reg_number;

        $newStudent = ([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'matric_number' => $request->matric_number,
            'reg_number' => $request->reg_number,
            'password' => bcrypt($password),
            'view_password' => $password,
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

                    $password = !empty($row['matric_number']) ?  $row['matric_number'] : $row['reg_number'];

                    Student::create([
                        'firstname' => $row['firstname'],
                        'lastname' => $row['lastname'],
                        'email' => $row['email'],
                        'matric_number' => $row['matric_number'],
                        'reg_number' => $row['reg_number'],
                        'password' => bcrypt($password),
                        'view_password' => $password,
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

    public function addSingleCandidate(Request $request){

        $validator = Validator::make($request->all(), [
            'matric_number' => 'required_without:reg_number',
            'reg_number' => 'required_without:matric_number',
            'examination_id' => 'required',
        ]);

        if($validator->fails()) {
            alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
            return redirect()->back();
        }

        if(!$examination = Examination::find($request->examination_id)){
            alert()->error('Oops', 'Invalid Examination')->persistent('Close');
            return redirect()->back();
        }

        if(!$student = Student::where('matric_number',$request->matric_number)->orWhere('reg_number', $request->reg_number)->first()){
            alert()->error('Oops','Invalid Student')->persistent('Close');
            return redirect()->back();
        }

        if($candidate = Candidate::where('examination_id', $request->examination_id)->where('student_id', $student->id)->first()){
            alert()->error('Oops','Student enrolled already')->persistent('Close');
            return redirect()->back();
        }

        $newCandidate = ([
            'examination_id' => $request->examination_id,
            'student_id' => $student->id
        ]);

        if(Candidate::create($newCandidate)){
            alert()->success('Candidate created successfully', '')->persistent('Close');
            return redirect()->back();
        }

        alert()->error('Oops!', 'Something went wrong')->persistent('Close');
        return redirect()->back();
    }


    public function addBulkCandidate(Request $request){
        try {

            $validator = Validator::make($request->all(), [
                'file' => 'required',
                'examination_id' => 'required',
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
                    if(!$student = Student::where('matric_number',$row['matric_number'])->orWhere('reg_number', $row['reg_number'])->first()){
                        Student::create([
                            'firstname' => $row['firstname'],
                            'lastname' => $row['lastname'],
                            'email' => $row['email'],
                            'matric_number' => $row['matric_number'],
                            'reg_number' => $row['reg_number'],
                        ]);
                    }

                    $student = Student::where('matric_number',$row['matric_number'])->orWhere('reg_number', $row['reg_number'])->first();

                    if(!$candidate = Candidate::where('examination_id', $request->examination_id)->where('student_id', $student->id)->first()){
                        Candidate::create([
                            'examination_id' => $request->examination_id,
                            'student_id' => $student->id,
                            'result' => 0
                        ]);
                    }

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


    public function deleteCandidate(Request $request){

        $validator = Validator::make($request->all(), [
            'candidate_id' => 'required|min:1',
        ]);

        if($validator->fails()) {
            alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
            return redirect()->back();
        }

        if(!$candidate = Candidate::find($request->candidate_id)){
            alert()->error('Oops', 'Invalid Candidate')->persistent('Close');
            return redirect()->back();
        }

        if($candidate->delete()){
            alert()->success('Record Deleted', '')->persistent('Close');
            return redirect()->back();
        }

        alert()->error('Oops!', 'Something went wrong')->persistent('Close');
        return redirect()->back();
    }

    public function uploadBulkQuestion(Request $request){
        try {

            $validator = Validator::make($request->all(), [
                'file' => 'required',
                'examination_id' => 'required',
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

                    if(!empty($row['question_text'])){
                        $questionData = [
                            'text' => $row['question_text'],
                            'examination_id' => $request->examination_id,
                        ];
    
            
                        $optionsData = [];
                        $isCorrectOptionSet = false;
    
                        foreach ($row as $key => $value) {
                            if (strpos($key, 'option_') === 0 && !empty($value)) {
                                $optionData = [
                                    'option_text' => $value,
                                    'is_correct' => ($value === $row['answer']) ? 1 : 0,
                                ];

                                if ($optionData['is_correct']) {
                                    $isCorrectOptionSet = true;
                                }
            
                                $optionsData[] = $optionData;
                            }
                        }
            
                        if ($isCorrectOptionSet) {
                            $question = Question::create($questionData);
                            $question->options()->createMany($optionsData);
                        }
                    }
                }
    
                alert()->success('Changes Saved', 'Examination question uploaded successfully')->persistent('Close');
                return redirect()->back();
            }
        } catch (QueryException $e) {
            $errorMessage = 'Something went wrong';
            alert()->error('Oops!', $errorMessage)->persistent('Close');
            return redirect()->back();
        }
    }

    public function deleteQuestion(Request $request){

        $validator = Validator::make($request->all(), [
            'question_id' => 'required|min:1',
        ]);

        if($validator->fails()) {
            alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
            return redirect()->back();
        }

        if(!$question = Question::find($request->question_id)){
            alert()->error('Oops', 'Invalid Question')->persistent('Close');
            return redirect()->back();
        }

        if($question->delete()){
            alert()->success('Record Deleted', '')->persistent('Close');
            return redirect()->back();
        }

        alert()->error('Oops!', 'Something went wrong')->persistent('Close');
        return redirect()->back();
    }

    public function deleteOption(Request $request){

        $validator = Validator::make($request->all(), [
            'option_id' => 'required|min:1',
        ]);

        if($validator->fails()) {
            alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
            return redirect()->back();
        }

        if(!$option = Option::find($request->option_id)){
            alert()->error('Oops', 'Invalid Option')->persistent('Close');
            return redirect()->back();
        }

        if($option->is_correct){
            if(Option::where('question_id',$option->question_id)->count() < 1){
                alert()->error('Oops', 'You cannot delete answer to the question, kindly set another option as answer or add correct answer before deleting this option')->persistent('Close');
                return redirect()->back();
            }
        }

        if($option->delete()){
            alert()->success('Record Deleted', '')->persistent('Close');
            return redirect()->back();
        }

        alert()->error('Oops!', 'Something went wrong')->persistent('Close');
        return redirect()->back();
    }
    
    public function updateQuestion(Request $request){

        $validator = Validator::make($request->all(), [
            'question_id' => 'required|min:1',
        ]);

        if($validator->fails()) {
            alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
            return redirect()->back();
        }

        if(!$question = Question::find($request->question_id)){
            alert()->error('Oops', 'Invalid Question')->persistent('Close');
            return redirect()->back();
        }

        if(!empty($request->text) && $request->text != $question->text){
            $question->text = $request->text;
        }

        if($question->save()){
            alert()->success('Changes Saved', 'Question changes saved successfully')->persistent('Close');
            return redirect()->back();
        }
        
        alert()->error('Oops!', 'Something went wrong')->persistent('Close');
        return redirect()->back();
    }

    public function updateOption(Request $request){

        $validator = Validator::make($request->all(), [
            'option_id' => 'required|min:1',
        ]);

        if($validator->fails()) {
            alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
            return redirect()->back();
        }

        if(!$option = Option::find($request->option_id)){
            alert()->error('Oops', 'Invalid Option')->persistent('Close');
            return redirect()->back();
        }

        if(!empty($request->option_text) && $request->option_text != $option->option_text){
            $option->option_text = $request->option_text;
        }

        if($request->is_correct != $option->is_correct){
            $option->is_correct = $request->is_correct;
        }

        if($option->save()){
            alert()->success('Changes Saved', 'Option changes saved successfully')->persistent('Close');
            return redirect()->back();
        }
        
        alert()->error('Oops!', 'Something went wrong')->persistent('Close');
        return redirect()->back();
    }

    public function addOption(Request $request){

        $validator = Validator::make($request->all(), [
            'question_id' => 'required|min:1',
            'option_text' => 'required',
            'is_correct' => 'nullable'
        ]);

        if($validator->fails()) {
            alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
            return redirect()->back();
        }

        if(!$question = Question::find($request->question_id)){
            alert()->error('Oops', 'Invalid Question')->persistent('Close');
            return redirect()->back();
        }

        $addOption = ([
            'question_id' => $request->question_id,
            'is_correct' => $request->is_correct,
            'option_text' => $request->option_text
        ]);

        if(Option::create($addOption)){
            alert()->success('Option added successfully', '')->persistent('Close');
            return redirect()->back();
        }
        
        alert()->error('Oops!', 'Something went wrong')->persistent('Close');
        return redirect()->back();
    }
    

    public function examStatus(Request $request){
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

        if(!empty($request->status) &&  $request->status != $examination->status){
            if($request->status == 'Start'){
                $examination->start_exam_at = Carbon::now();
            }

            $examination->status = $request->status;
        }

        if($examination->save()){
            alert()->success('Changes Saved', 'Status Updated')->persistent('Close');
            return redirect()->back();
        }

        alert()->error('Oops!', 'Something went wrong')->persistent('Close');
        return redirect()->back();
    }

    public function media(){
        $media = Media::get();

        return view('admin.media', [
            'media' => $media
        ]);
    }

    public function addMedia(Request $request){
        $validator = Validator::make($request->all(), [
            'filename' => 'required',
            'file' => 'required',
            'type' => 'required',
        ]);

        if($validator->fails()) {
            alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
            return redirect()->back();
        }

        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->filename)));

        $fileUrl = 'uploads/media/'.$slug.'.'.$request->file('file')->getClientOriginalExtension();
        $file = $request->file('file')->move('uploads/media', $fileUrl);

        // Get the size of the file in bytes
        $fileSize = File::size($fileUrl);

        // Convert the size to KB or MB
        if ($fileSize < 1024) {
            $fileSize = $fileSize . ' B';
        } elseif ($fileSize < 1048576) {
            $fileSize = round($fileSize / 1024, 2) . ' KB';
        } else {
            $fileSize = round($fileSize / 1048576, 2) . ' MB';
        }

        $addFile = ([            
            'filename' => $request->filename,
            'filepath' => $fileUrl,
            'type' => $request->type,
            'size' => $fileSize,
        ]);

        if(Media::create($addFile)){
            alert()->success('File uploaded successfully', '')->persistent('Close');
            return redirect()->back();
        }

        alert()->error('Oops!', 'Something went wrong')->persistent('Close');
        return redirect()->back();
    }

    public function updateFile(Request $request){
        $validator = Validator::make($request->all(), [
            'media_id' => 'required|min:1',
        ]);


        if($validator->fails()) {
            alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
            return redirect()->back();
        }

        if(!$media = Media::find($request->media_id)){
            alert()->error('Oops', 'Invalid Media ')->persistent('Close');
            return redirect()->back();
        }

        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->filename)));

        if(!empty($request->filename) &&  $request->filename != $media->filename){
            $media->filename = $request->filename;
        }

        if(!empty($request->type) &&  $request->type != $media->type){
            $media->type = $request->type;
        }

        if(!empty($request->file)){
            if(!empty($media->filepath)){
                //unlink($media->image);
            }

            $fileUrl = 'uploads/media/'.$slug.'.'.$request->file('file')->getClientOriginalExtension();
            $file = $request->file('file')->move('uploads/media', $fileUrl);

            // Get the size of the file in bytes
            $fileSize = File::size($fileUrl);

            // Convert the size to KB or MB
            if ($fileSize < 1024) {
                $fileSize = $fileSize . ' B';
            } elseif ($fileSize < 1048576) {
                $fileSize = round($fileSize / 1024, 2) . ' KB';
            } else {
                $fileSize = round($fileSize / 1048576, 2) . ' MB';
            }

            $media->size = $fileSize;
            $media->filepath = $fileUrl;
        }

        if($media->save()){
            alert()->success('Changes Saved', 'File changes saved successfully')->persistent('Close');
            return redirect()->back();
        }
    }

    public function deleteMedia(Request $request){
        $validator = Validator::make($request->all(), [
            'media_id' => 'required|min:1',
        ]);


        if($validator->fails()) {
            alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
            return redirect()->back();
        }

        if(!$media = Media::find($request->media_id)){
            alert()->error('Oops', 'Invalid Media ')->persistent('Close');
            return redirect()->back();
        }

        if($media->delete()){ 
            if(!empty($media->file)){
                //unlink($slider->image);
            }
            alert()->success('Record Deleted', '')->persistent('Close');
            return redirect()->back();
        }


        alert()->error('Oops!', 'Something went wrong')->persistent('Close');
        return redirect()->back();
    }
}
