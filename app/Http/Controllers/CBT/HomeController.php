<?php

namespace App\Http\Controllers\CBT;

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
use App\Models\CandidateExamSubject;

class HomeController extends Controller
{
    protected $authUser;
    //
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware(['auth:student']);
    }

    public function index(){

        $candidates = Candidate::with('student', 'examination')->where('student_id', Auth::guard('student')->user()->id)->where('status', null)->get();
        return view('exams', [
            'candidates' => $candidates
        ]);
    }

    public function takeExam($slug){
        $userId = Auth::guard('student')->user()->id;
    
        $examination = Examination::with('admin', 'candidates', 'candidates.student')->where('slug', $slug)->first();
    
        $candidate = Candidate::where('student_id', $userId)->where('examination_id', $examination->id)->where('status', null)->first();
    
        $candidateExamSubjects = CandidateExamSubject::with('subject')
            ->where('candidate_id', $candidate->id)
            ->where('examination_id', $examination->id)
            ->get();
    
        $candidateQuestions = CandidateQuestion::with('candidate', 'candidate.student', 'question', 'question.options')
            ->where('candidate_id', $candidate->id)
            ->get()
            ->each(function ($candidateQuestion) {
                $candidateQuestion->question->options = $candidateQuestion->question->options->shuffle();
            });
    
        $groupedCandidateQuestions = $candidateExamSubjects->flatMap(function ($candidateExamSubject) use ($candidateQuestions) {
            $subjectQuestions = $candidateQuestions->filter(function ($candidateQuestion) use ($candidateExamSubject) {
                return $candidateQuestion->question->subject_id === $candidateExamSubject->subject_id;
            });
    
            return [
                $candidateExamSubject->subject->subject => $subjectQuestions,
            ];
        });

    
        return view('takeExam', [
            'examination' => $examination,
            'candidate' => $candidate,
            'groupedCandidateQuestions' => $groupedCandidateQuestions,
            'candidateExamSubjects' => $candidateExamSubjects,
            'candidateQuestions' => $candidateQuestions
        ]);
    }
    

    public function startExam(Request $request){
        $validator = Validator::make($request->all(), [
            'examination_id' => 'required|min:1',
            'candidate_id' => 'required|min:1',
        ]);

        if($validator->fails()) {
            alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
            return redirect()->back();
        }

        if(!$examination = Examination::find($request->examination_id)){
            alert()->error('Oops', 'Invalid Examination')->persistent('Close');
            return redirect()->back();
        }

        if(!$candidate = Candidate::find($request->candidate_id)){
            alert()->error('Oops', 'Invalid Candidate')->persistent('Close');
            return redirect()->back();
        }

        if($examination->status != 'Start'){
            alert()->error('Oops', 'You cant start the assessment yet.')->persistent('Close');
            return redirect()->back();
        }
        
        $candidateQuestions = CandidateQuestion::with('candidate', 'candidate.student', 'question', 'question.options')
        ->where('candidate_id', $candidate->id)
        ->get()
        ->each(function ($candidateQuestion) {
            $candidateQuestion->question->options = $candidateQuestion->question->options->shuffle();
        });


        if($candidateQuestions->count() >= $examination->question_number && $candidate->exam_start_at != null) {
            return redirect()->back();
        }


        $candidateQuestions = CandidateQuestion::with('candidate', 'candidate.student', 'question', 'question.options')
        ->where('candidate_id', $candidate->id)
        ->get()
        ->each(function ($candidateQuestion) {
            $candidateQuestion->question->options = $candidateQuestion->question->options->shuffle();
        });

        $start = Carbon::parse();
        $end = Carbon::parse()->addMinutes($examination->duration);
        $candidate->exam_start_at = $start;
        $candidate->exam_end_at = $end;
        $candidate->save();

        return redirect()->back();
    }

    public function saveOption(Request $request){
        $validator = Validator::make($request->all(), [
            'optionId' => 'required|min:1',
            'questionId' => 'required|min:1',
        ]);

        if($validator->fails()) {
            alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
            return redirect()->back();
        }

        $candidateQuestion = CandidateQuestion::find($request->questionId);
        $candidateQuestion->candidate_option = $request->optionId;

        $option = Option::find($request->optionId);
        if($option->is_correct) {
            $candidateQuestion->candidate_is_correct = true;
        }else{
            $candidateQuestion->candidate_is_correct = false;
        }
        $candidateQuestion->save();

        $answeredQuestion = CandidateQuestion::where('candidate_id', $candidateQuestion->candidate_id)->where('candidate_option', '!=', null)->count();
        
        return response()->json($answeredQuestion);
    }

    public function forceSubmit(Request $request){

        $userId = Auth::guard('student')->user()->id;
        $examination = Examination::findOrFail($request->examinationId);
        $candidate = Candidate::where('student_id', $userId)
            ->where('examination_id', $request->examinationId)
            ->firstOrFail();

        $candidateCorrectQuestions = CandidateQuestion::where('candidate_id', $candidate->id)
            ->where('candidate_is_correct', 1)
            ->with('question')
            ->get();

        $groupedCandidateQuestions = $candidateCorrectQuestions->groupBy('question.subject_id');

        $totalScore = 0;

        foreach ($groupedCandidateQuestions as $subjectId => $questions) {
            $correctOptionsCount = $questions->count();
            $candidateExamSubject = CandidateExamSubject::where('candidate_id', $candidate->id)
                ->where('subject_id', $subjectId)
                ->where('examination_id', $request->examinationId)
                ->firstOrFail();

            $subjectScore = ($correctOptionsCount / $candidateExamSubject->question_quantity) * $candidateExamSubject->question_mark;

            $candidateExamSubject->student_score = $subjectScore;
            $candidateExamSubject->save();

            $totalScore += $subjectScore;
        }

        $candidate->result = round($totalScore);
        $candidate->status = 'Submitted';
        $candidate->save();

        Auth::guard('student')->logout();

        return view('welcome');

    }

    public function submitExam(Request $request){
        $validator = Validator::make($request->all(), [
            'candidateId' => 'required|min:1',
            'examinationId' => 'required|min:1',
        ]);
    
        if($validator->fails()) {
            alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
            return redirect()->back();
        }
    
        $userId = Auth::guard('student')->user()->id;
        $examination = Examination::findOrFail($request->examinationId);
        $candidate = Candidate::where('student_id', $userId)
            ->where('examination_id', $request->examinationId)
            ->firstOrFail();

        $candidateCorrectQuestions = CandidateQuestion::where('candidate_id', $candidate->id)
            ->where('candidate_is_correct', 1)
            ->with('question')
            ->get();

        $groupedCandidateQuestions = $candidateCorrectQuestions->groupBy('question.subject_id');

        $totalScore = 0;

        foreach ($groupedCandidateQuestions as $subjectId => $questions) {
            $correctOptionsCount = $questions->count();
            $candidateExamSubject = CandidateExamSubject::where('candidate_id', $candidate->id)
                ->where('subject_id', $subjectId)
                ->where('examination_id', $request->examinationId)
                ->firstOrFail();

            $subjectScore = ($correctOptionsCount / $candidateExamSubject->question_quantity) * $candidateExamSubject->question_mark;

            $candidateExamSubject->student_score = $subjectScore;
            $candidateExamSubject->save();

            $totalScore += $subjectScore;
        }

        $candidate->result = round($totalScore);
        $candidate->status = 'Submitted';
        $candidate->save();

        Auth::guard('student')->logout();

        return view('welcome');
    }
    
}
