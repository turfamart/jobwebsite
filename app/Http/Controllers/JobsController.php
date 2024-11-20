<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Jobtype;
use App\Models\job;

class JobsController extends Controller
{

    public function index() {

        $category = Category::where('status', 1)->get();

        $jobType = Jobtype::where('status', 1)->get();

        $jobs= Job::where('status', 1)->with('jobType')->with('Category')->orderBy('created_at','ASC')->paginate(9);
      //  dd($jobs);
        return view('front.jobs', [
            'category' => $category,
            'jobType' => $category,
            'jobs' => $jobs
        ]);
    }
}
