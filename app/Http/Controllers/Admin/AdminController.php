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
use App\Models\Media;
use App\Models\Subject;
use App\Models\ExaminationType;
use App\Models\CandidateExamSubject;


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
        $admin = Auth::guard('admin')->user();
        $examinations = Examination::with('admin', 'candidates', 'candidates.student' )->where('admin_id', $admin->id)->orderBy('id', 'DESC')->get();
        
        if(empty($admin->role)){
            $examinations = Examination::with('admin', 'candidates', 'candidates.student')->orderBy('id', 'DESC')->get();
        }
        $students = Student::all();
        $examinationTypes = ExaminationType::all();

        return view('admin.home', [
            'examinations' => $examinations,
            'students' => $students,
            'examinationTypes' => $examinationTypes
        ]);
    }

    public function examinations(){
        $admin = Auth::guard('admin')->user();
        $examinations = Examination::with('admin', 'candidates')->where('admin_id', $admin->id)->orderBy('id', 'DESC')->get();

        if(empty($admin->role)){
            $examinations = Examination::with('admin', 'candidates')->orderBy('id', 'DESC')->get();
        }

        $examinationTypes = ExaminationType::all();

        return view('admin.examination', [
            'examinations' => $examinations,
            'examinationTypes' => $examinationTypes
        ]);
    }
    

    public function addExamination(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:1',
            'description' => 'required',
            'duration' => 'required',
            'examination_type_id' => 'required',
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
            'examination_type_id' => $request->examination_type_id,
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

        if(!empty($request->duration) &&  $request->duration != $examination->duration){
            $examination->duration = $request->duration;
        }

        if(!empty($request->examination_type_id) &&  $request->examination_type_id != $examination->examination_type_id){
            $examination->examination_type_id = $request->examination_type_id;
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
        $examination = Examination::with('admin', 'candidates', 'candidates.student')->where('slug', $slug)->first();

        $examinationTypes = ExaminationType::all();

        return view('admin.singleExamination', [
            'examination' => $examination,
            'examinationTypes' => $examinationTypes
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
                        continue;
                        // alert()->error('Oops', $row['firstname'].' '.$row['lastname'].' in the file is having same record with '. $student->firstname.' '.$student->lastname .' in the database, kindly check')->persistent('Close');
                        // return redirect()->back();
                    }

                    $password = !empty($row['matric_number']) ?  $row['matric_number'] : $row['reg_number'];

                    Student::create([
                        'firstname' => $row['firstname'],
                        'lastname' => $row['lastname'],
                        'email' => $row['email'],
                        'matric_number' => !empty($row['matric_number']) ?  $row['matric_number'] : null,
                        'reg_number' => !empty($row['reg_number']) ?  $row['reg_number'] : null,
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
    

            if(!$examination = Examination::find($request->examination_id)){
                alert()->error('Oops', 'Invalid Examination')->persistent('Close');
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
                    $regNumber = $row['reg_number'];
                    

                    //check for existing student record
                    if(!$student = Student::where('matric_number',$row['reg_number'])->first()){
                        $message = "Student with registration number " . $row['reg_number'] . " does not exist";
                        alert()->error('oops!!', $message)->persistent('Close');
                        return redirect()->back();
                    }

                    $student = Student::where('matric_number', $row['reg_number'])->first();

                    if(!$candidate = Candidate::where('examination_id', $request->examination_id)->where('student_id', $student->id)->first()){
                        $candidate = Candidate::create([
                            'examination_id' => $request->examination_id,
                            'student_id' => $student->id,
                            'result' => 0
                        ]);
                    }

                    foreach ($row as $key => $value) {
                        if (strpos($key, 'subject_') === 0 && !empty($value)) {

                            $parts = explode(':', $value);
                            $subjectName = trim($parts[0]);
                            $questionQuantity = trim($parts[1]);
                            $mark = trim($parts[2]);

                            $subject = Subject::where('subject', trim($subjectName))->where('examination_type_id', $examination->examination_type_id)->first();
                            Log::info($subject);
                            if (!$subject) {
                                $message = $subjectName . " does not exist";
                                alert()->error('Oops', $message)->persistent('Close');
                                return redirect()->back();
                            }

                            $subjectData = [
                                'examination_id' =>$request->examination_id,
                                'subject_id' => $subject->id,
                                'question_quantity' => $questionQuantity,
                                'question_mark' => $mark,
                                'candidate_id' => $candidate->id,
                            ];

                            CandidateExamSubject::create($subjectData);
    
                        }
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
                'subject_id' => 'required',
            ]);
    
            if($validator->fails()) {
                alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
                return redirect()->back();
            }

            if(!$subject = Subject::find($request->subject_id)){
                alert()->error('Oops', 'Invalid Subject')->persistent('Close');
                return redirect()->back();
            }

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension(); // Get the file extension
                
                if ($extension === 'csv') {
                    $this->processCsvFile($file, $request);
                } elseif ($extension === 'txt') {
                    $this->processTxtFile($file, $request);
                } else {
                    alert()->error('Oops', 'Unsupported file type.')->persistent('Close');
                    return redirect()->back();
                }
            }

            alert()->success('Good Job', 'Question Upload Successful')->persistent('Close');
            return redirect()->back();

        } catch (QueryException $e) {
            $errorMessage = 'Something went wrong';
            alert()->error('Oops!', $errorMessage)->persistent('Close');
            return redirect()->back();
        }
    }

    public function processCsvFile($file, $request){

        $file = $request->file('file');
        $csv = Reader::createFromPath($file->getPathname());

        $csv->setHeaderOffset(0);

        $records = $csv->getRecords();

        foreach ($records as $row) {

            if(!empty($row['question_text'])){
                $questionData = [
                    'text' => trim($row['question_text']),
                    'subject_id' => $request->subject_id,
                ];

                $optionsData = [];
                $isCorrectOptionSet = false;

                foreach ($row as $key => $value) {
                    if (strpos($key, 'option_') === 0 && !empty($value)) {
                        $optionData = [
                            'option_text' => trim($value),
                            'is_correct' => (trim($value) == trim($row['answer'])) ? 1 : 0,
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
    }

    
    public function processTxtFile($file, $request) {
        $content = file_get_contents($file->getPathname());
        $lines = explode("\n", $content);
        $subjectId = $request->subject_id;
    
        $questions = [];
        $currentQuestion = null;
        $optionsData = [];
    
        foreach ($lines as $line) {
            if (empty(trim($line))) {
                // Skip empty lines
                continue;
            }
    
            $parts = explode(':', $line, 2);
            $key = trim($parts[0]);
            $value = isset($parts[1]) ? trim($parts[1]) : '';
    
            if ($key === 'question') {
                // Start a new question
                if ($currentQuestion !== null && count($optionsData) > 0) {
                    // Save the previous question and options
                    $this->saveQuestionWithOptions($currentQuestion, $optionsData, $subjectId);
                    $optionsData = [];
                }
                // Append to the current question text
                $currentQuestion = [
                    'text' => $value,
                    'subject_id' => $subjectId,
                ];
            } elseif ($key === 'option') {
                // Add option to the current question
                $optionsData[] = [
                    'option_text' => $value,
                    'is_correct' => false,
                ];
            } elseif ($key === 'answer') {
                // Mark correct options
                $optionsData[] = [
                    'option_text' => $value,
                    'is_correct' => true,
                ];
            } else {
                // Append to the current question text
                if ($currentQuestion !== null) {
                    $currentQuestion['text'] .= "\n" . $line;
                }
            }
        }
    
        // Save the last question and options
        if ($currentQuestion !== null) {
            $this->saveQuestionWithOptions($currentQuestion, $optionsData, $subjectId);
        }
    }
    
    private function saveQuestionWithOptions($question, $optionsData, $subjectId) {
        // Save question
        $currentQuestion = Question::create(['text' => $question['text'], 'subject_id' => $subjectId]);
    
        // Save options
        foreach ($optionsData as $optionData) {
            Option::create([
                'question_id' => $currentQuestion->id,
                'option_text' => $optionData['option_text'],
                'is_correct' => $optionData['is_correct'],
            ]);
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
        $isCorrect = $request->is_correct == 'on' ? true : false;
        if($isCorrect != $option->is_correct){
            $option->is_correct = $isCorrect;

            Option::where('question_id', $option->question_id)->update(['is_correct' => 0]);
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

        $isCorrect = $request->is_correct == 'on' ? true : false;

        $addOption = ([
            'question_id' => $request->question_id,
            'is_correct' => $isCorrect,
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
                unlink($media->image);
            }
            alert()->success('Record Deleted', '')->persistent('Close');
            return redirect()->back();
        }


        alert()->error('Oops!', 'Something went wrong')->persistent('Close');
        return redirect()->back();
    }

    public function admins(){
        
        $admins = Admin::get();

        return view('admin.admins', [
            'admins' => $admins
        ]);
    }

    public function addAdmin(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1',
            'email' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()) {
            alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
            return redirect()->back();
        }
        
        $password = $request->password;

        $newAdmin = ([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($password),
            'role' => $request->role
        ]);

        if(Admin::create($newAdmin)){
            alert()->success('Admin Added successfully', '')->persistent('Close');
            return redirect()->back();
        }

        alert()->error('Oops!', 'Something went wrong')->persistent('Close');
        return redirect()->back();
        
    }

    public function updateAdmin(Request $request){
        $validator = Validator::make($request->all(), [
            'admin_id' => 'required|min:1',
        ]);

        if($validator->fails()) {
            alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
            return redirect()->back();
        }

        if(!$admin = Admin::find($request->admin_id)){
            alert()->error('Oops', 'Invalid Admin')->persistent('Close');
            return redirect()->back();
        }


        if(!empty($request->name) &&  $request->name != $admin->name){
            $admin->name = $request->name;
        }

        if(!empty($request->email) &&  $request->email != $admin->email){
            $admin->email = $request->email;
        }

        if(!empty($request->role) &&  $request->role != $admin->role){
            $admin->role = $request->role;
        }

        if(!empty($request->password) &&  $request->password != $admin->password){
            $admin->password = bcrypt($request->password);
        }

        if($admin->save()){
            alert()->success('Changes Saved', 'Admin changes saved successfully')->persistent('Close');
            return redirect()->back();
        }

        alert()->error('Oops!', 'Something went wrong')->persistent('Close');
        return redirect()->back();
    }

    public function deleteAdmin(Request $request){

        $validator = Validator::make($request->all(), [
            'admin_id' => 'required|min:1',
        ]);

        if($validator->fails()) {
            alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
            return redirect()->back();
        }

        if(!$admin = Admin::find($request->admin_id)){
            alert()->error('Oops', 'Invalid Admin')->persistent('Close');
            return redirect()->back();
        }

        if($admin->delete()){
            alert()->success('Record Deleted', '')->persistent('Close');
            return redirect()->back();
        }

        alert()->error('Oops!', 'Something went wrong')->persistent('Close');
        return redirect()->back();
    }

    public function clearCandidates(Request $request){
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

        $candidates = Candidate::where('examination_id', $examination->id)->get();

        foreach ($candidates as $candidate) {
            $candidateQuestions = CandidateQuestion::where('examination_id', $examination->id)->where('candidate_id', $candidate->id)->forceDelete();
        }
        
        foreach ($candidates as $candidate) {
            $candidate->forceDelete();
        }
        
        alert()->success('Records Deleted', '')->persistent('Close');
        return redirect()->back();
    }

    public function subjects(){
        $admin = Auth::guard('admin')->user();
        $subjects = Subject::with('admin', 'questions', 'type')->where('admin_id', $admin->id)->orderBy('id', 'DESC')->get();

        if(empty($admin->role)){
            $subjects = Subject::with('admin', 'questions', 'type')->orderBy('id', 'DESC')->get();
        }

        $examinationTypes = ExaminationType::all();

        return view('admin.subjects', [
            'subjects' => $subjects,
            'examinationTypes' => $examinationTypes
        ]);
    }
    

    public function addSubject(Request $request){
        $validator = Validator::make($request->all(), [
            'subject' => 'required|min:1',
            'description' => 'required',
            'examination_type_id' => 'required',
            'code' => 'nullable',
        ]);

        if($validator->fails()) {
            alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
            return redirect()->back();
        }

        if($subject = Subject::where('subject', $request->subject)->where('examination_type_id', $request->examination_type_id)->where('code', $request->code)->first()){
            alert()->error('Oops', 'Subject/Course already exist')->persistent('Close');
            return redirect()->back();
        }


        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->subject.$request->examination_type_id.$request->code)));

        $newSubject = ([
            'admin_id' => Auth::guard('admin')->user()->id,
            'subject' => $request->subject,
            'description' => $request->description,
            'code' => $request->code,
            'examination_type_id' => $request->examination_type_id,
            'slug' => $slug,
        ]);

        if(Subject::create($newSubject)){
            alert()->success('Subject Created successfully', '')->persistent('Close');
            return redirect()->back();
        }

        alert()->error('Oops!', 'Something went wrong')->persistent('Close');
        return redirect()->back();
        
    }

    public function deleteSubject(Request $request){

        $validator = Validator::make($request->all(), [
            'subject_id' => 'required|min:1',
        ]);

        if($validator->fails()) {
            alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
            return redirect()->back();
        }

        if(!$subject = Subject::find($request->subject_id)){
            alert()->error('Oops', 'Invalid Subject')->persistent('Close');
            return redirect()->back();
        }

        if($subject->delete()){
            alert()->success('Record Deleted', '')->persistent('Close');
            return redirect()->back();
        }

        alert()->error('Oops!', 'Something went wrong')->persistent('Close');
        return redirect()->back();
    }

    public function updateSubject(Request $request){
        $validator = Validator::make($request->all(), [
            'subject_id' => 'required|min:1',
        ]);

        if($validator->fails()) {
            alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
            return redirect()->back();
        }

        if(!$subject = Subject::find($request->subject_id)){
            alert()->error('Oops', 'Invalid Subject')->persistent('Close');
            return redirect()->back();
        }

        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->suject)));


        if(!empty($request->suject) &&  $request->suject != $subject->suject){
            $subject->suject = $request->suject;
            $subject->slug = $slug;
        }

        if(!empty($request->description) &&  $request->description != $subject->description){
            $subject->description = $request->description;
        }

        if(!empty($request->examination_type_id) &&  $request->examination_type_id != $subject->examination_type_id){
            $subject->examination_type_id = $request->examination_type_id;
        }

        if(!empty($request->code) &&  $request->code != $subject->code){
            $subject->code = $request->code;
        }

        if($subject->save()){
            alert()->success('Changes Saved', 'Subject changes saved successfully')->persistent('Close');
            return redirect()->back();
        }

        alert()->error('Oops!', 'Something went wrong')->persistent('Close');
        return redirect()->back();
    }

    public function getSubject($slug){
        $subject = Subject::with('admin', 'questions')->where('slug', $slug)->first();
        $examinationTypes = ExaminationType::all();

        return view('admin.subject', [
            'subject' => $subject,
            'examinationTypes' => $examinationTypes
        ]);
    }

    public function generateCandidateQuestions(Request $request){
        $validator = Validator::make($request->all(), [
            'examination_id' => 'required|min:1',
        ]);

        if($validator->fails()) {
            alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
            return redirect()->back();
        }

        if(!$examination = Examination::with('candidates')->where('id', $request->examination_id)->first()){
            alert()->error('Oops', 'Invalid Examination')->persistent('Close');
            return redirect()->back();
        }

        $candidates = $examination->candidates;

        if($candidates->count() < 1){
            alert()->error('Oops', 'No candidate have been enrolled for this examination')->persistent('Close');
            return redirect()->back();
        }

        foreach($candidates as $candidate){
            $candidateSubjects = CandidateExamSubject::where('examination_id', $request->examination_id)->where('candidate_id', $candidate->id)->get();
            
            foreach($candidateSubjects as $candidateSubject){
                $questionQuantity = $candidateSubject->question_quantity;
                
                // set candidate question
                $questions = Question::where('subject_id', $candidateSubject->subject_id)->inRandomOrder()->limit($questionQuantity)->get();
                
                foreach($questions as $question){
                    CandidateQuestion::create([
                        'examination_id' => $request->examination_id,
                        'candidate_id' => $candidate->id,
                        'question_id' => $question->id,
                        'candidate_exam_subject_id' => $candidateSubject->id
                    ]);
                }
            }
        }

        alert()->success('Good Job!!', 'Questions generated successfully')->persistent('Close');
        return redirect()->back();
    }
}
