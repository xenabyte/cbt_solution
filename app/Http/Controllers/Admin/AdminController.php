<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Admin;
use App\Models\CandidateQuestion;
use App\Models\Candidate;
use App\Models\Option;
use App\Models\Question;
use App\Models\Students;

class AdminController extends Controller
{
    //

    public function index(){

        return view('admin.home');
    }

    public function examination(){
        
        $examinations = Examination::with()->get();

        return view('admin.examination', [
            'examinations' => $examinations
        ]);
    }
}
