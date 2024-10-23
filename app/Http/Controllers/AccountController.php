<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Jobtype;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\GD\Driver;

class AccountController extends Controller
{
    public function registration(){
        return view('front.account.register');
    }

    public function processRegistration(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|same:confirm_password',
            'confirm_password' => 'required',
        ]);

        if($validator->passes()){

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
          
            $user->save();

            Session()->flash('success','Your registration has been successful');

            return response()->json([
                'status' => true,
                'errors' =>[]
            ]);
        }
        else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function login(){
        return view('front.account.login');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required | email',
            'password' => 'required',
       
        ]);

        if($validator->passes()) {

            if(Auth::attempt(['email' => $request->email, 'password' =>$request->password])) {
                return redirect()->route('account.profile');
            } else {
                return redirect()->route('account.login')->with('error','Either Email/Password is incorrect');
            }
        } else {
            return redirect()->route('account.login')
                    ->withErrors($validator)
                    ->withInput($request->only('email'));
        }
    }

    public function profile(){

        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
       // dd($id);
       // User::where()
      return view('front.account.profile',['user' => $user]);
    }

    public function updateProfile(Request $request){

        $id = Auth::user()->id;

        $validator = Validator::make($request->all(),[
            'name' =>'required|min:5|max:20',
            'email' =>'required|email|unique:users,email,'.$id.',id'

        ]);

        if($validator->passes()){
           $user = User::find($id);
           $user->name = $request->name;
           $user->email = $request->email;
           $user->mobile = $request->mobile;
           $user->designation = $request->designation;
           $user->save();

           session()->flash('success','Profile Updated Successfully');

           return response()->json([
            'status' => 'true',
            'errors' => []
           ]);
        }
        else {

            session()->flash('error','Profile did not Updated Properly');

            return response()->json([
                'status' => 'false',
                'errors' => $validator->errors()
               ]);
        }
    }

    public function logout(){
        Auth::logout();

        return redirect()->route('account.login');
      }

      public function updateProfilePic(Request $request) {

        $id = Auth::user()->id;
        
       $validator = Validator::make($request->all(),[
        'image' => 'required|image'
       ]);

       if($validator->passes()) {
            
        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $imageName = $id.'-'.time().'.'.$ext;
        $image->move(public_path('/profile_pic/'), $imageName);

        $sourceImage = public_path('/profile_pic/'.$imageName);
        //Create a small thumbnail
        $manager = new ImageManager(Driver::class);
        $image = $manager->read($sourceImage); // 800 x 600

        $image->cover(150, 150);
        $image->toPng()->save(public_path('/profile_pic/thumb/'.$imageName));

        File::delete(public_path('/profile_pic/'.Auth::user()->image));
        File::delete(public_path('/profile_pic/thumb/'.Auth::user()->image));

        User::where('id', $id)->update(['image' => $imageName]);

        session()->flash('success','Profile picture updated Successfully');

       } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
       }
      }

      public function createJobs (){
        $categories = Category::orderBy('name','ASC')->where('status',1)->get();
        $jobtypes = Jobtype::orderBy('name','ASC')->where('status',1)->get();

        return view('front.account.job.create',[
            'categories' => $categories,
            'jobtypes' => $jobtypes
        ]);
      }

      public function saveJobs(Request $request) {

        $rules = [
            'title' => 'required|min:5|max:200',
            'category' => 'required',
            'job_type' => 'required',
            'location' => 'required|max:50',
            'description' => 'required',
            'company_name' => 'required|min:3|max:75'
              
        ]; 

        $validator = Validator::make($request->all(),$rules);

        if($validator->passes()) {

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
      }
}
