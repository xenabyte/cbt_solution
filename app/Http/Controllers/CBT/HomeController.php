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

class HomeController extends Controller
{
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

        Log::info(Auth::guard('student')->user());
        return view('exams');
    }
}
