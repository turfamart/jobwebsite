<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class HomeController extends Controller
{
   /*  public function index()
    {
        return view('front.home');
    } */

   public function index() {

    $categories = Category::where('status',1)->orderBy('name','ASC')->take(8)->get();
     return view('front.home',[
        'categories' => $categories
     ]);
   }
}
