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

class WelcomeController extends Controller
{
    //
    public function welcome(){

        Auth::guard('student')->logout();
        return view('welcome');
    }
}
