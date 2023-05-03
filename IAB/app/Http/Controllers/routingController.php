<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class routingController extends Controller
{
    public function index() {
        return view('index');
    }

    public function forgotPassword() {
        return view('forgotPassword');
    }

    public function signup() {
        return view('signup');
    }

    public function adminDashboard() {
        return view('admin/home');
    }
    
    public function currentStudentDashboard() {
        return view('student/home');
    }
    
    public function alumniDashboard() {
        return view('alumni/home');
    }
    public function alumnniBookmarks() {
        return view('alumni/bookmarks');
    }
    public function alumniEvents() {
        return view('alumni/events');
    }
    public function alumniJobs() {
        return view('alumni/jobs');
    }
    public function alumniProfile() {
        return view('alumni/profile');
    }
    public function alumniAwards() {
        return view('alumni/awards');
    }

    public function store(Request $request)
    {

        // Validate the form data
        $validatedData = $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'inputEmail' => 'required|email',
            'inputPassword' => 'required',
            'inputConfirmPassword' => 'required|same:inputPassword',
            'iubId' => 'required|digits_between:5,7',
        ]);
        
        $users = user::all();
        foreach ($users as $user) {
            if ($user->userEmail == $validatedData['inputEmail'] ) {
                return redirect()->route('signup')->with('msg', "Account with this 'email' already exists");
            }
        }

        // Create a new alumni record using Eloquent
        $user = new user();
        $user->userEmail = $validatedData['inputEmail'];
        $user->password = $validatedData['inputPassword'];
        $user->save();
        $student = new student();
        $student->userEmail = $validatedData['inputEmail'];
        $student->firstName = $validatedData['firstName'];
        $student->lastName = $validatedData['lastName'];
        $student->iubID = $validatedData['iubId'];
        $student->save();
        $alumni = new alumni();
        $alumni->userEmail = $validatedData['inputEmail'];
        $alumni->save();

        // Redirect or return a response
        return redirect()->route('index')->with('msg','Account Created Successfully');
    }
    
}


