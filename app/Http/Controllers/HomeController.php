<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Job;

class HomeController extends Controller
{
   /*  public function index()
    {
        return view('front.home');
    } */

   public function index() {

    $categories = Category::where('status',1)->orderBy('name','ASC')->take(8)->get();

    $featredJobs = Job::where('status',1)
                  ->orderBy('created_at', 'DESC')
                  ->with('jobType')
                  ->where('isFeatured',1)
                  ->take(6)->get();

                //  dd($featredJobs);

    $latestJobs = Job::where('status',1)
                  ->orderBy('created_at', 'DESC')
                   ->with('jobType')
                  ->take(6)->get();

     return view('front.home',[
        'categories' => $categories,
        'featredJobs' => $featredJobs,
        'latestJobs' => $latestJobs
     ]);
   }
}
