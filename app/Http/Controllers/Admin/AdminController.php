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

use App\Models\Admin;
use App\Models\Examination;
use App\Models\CandidateQuestion;
use App\Models\Candidate;
use App\Models\Option;
use App\Models\Question;
use App\Models\Students;

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
        
        $examinations = Examination::with('admin', 'questions', 'candidates')->get();

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
}
