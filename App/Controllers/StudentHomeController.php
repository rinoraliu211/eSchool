<?php
namespace App\Controllers;

use App\Helpers\Session;
use App\Models\Grade;
use App\Models\Attendance;
use App\Models\Student;
use Core\View;
use Core\Controller;

class StudentHomeController extends Controller
{
    protected $session;
    protected $student;

    public function __construct()
    {
        $this->session = Session::getInstance();

        if (!$this->session->isSignedIn()) {
            header('Location: /eSchool/public/login');
            exit();
        }

        $userId = $this->session->userId;

        $this->student = Student::where('user_id', $userId)->first();

        
    }

    public function index()
    {
        $session = Session::getInstance();

        if (!$session->isSignedIn()) {
            header('Location: /eSchool/public/login');
            exit;
        }

        $student = Student::where('user_id', $session->userId)->first();

        if (!$student) {
            die('Student not found');
        }

        $classes = $student->classes()->with('schedules')->get();


        $grades = Grade::where('student_id', $student->id)->get();

        $attendances = Attendance::where('student_id', $student->id)->get();

        

        View::renderTemplate('student_homepage.html', [
            'student' => $student,
            'classes' => $classes,
            'grades' => $grades,
            'attendances' => $attendances,
        ]);
    }
     public function view()
    {
        $classes = $this->student->classes()->get();


        View::renderTemplate('student_profile.html', [
            'student' => $this->student,
            'classes' => $classes,
        ]);
    }
}

