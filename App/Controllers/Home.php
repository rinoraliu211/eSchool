<?php

namespace App\Controllers;
use App\Helpers\Session;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\Event;
use \Core\View;
use \Core\Controller;

/**
 * Home controller
 */
class Home extends Controller
{

   protected $user;

    public function __construct()
    {
        $session = Session::getInstance();
        if (!$session->isSignedIn()) {
            header('Location: /eSchool/public/login');
        }

        $this->user = User::find($_SESSION['userId']);
         
    }
    public function index()
    {
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $totalClasses = Classes::count();
        $totalSubjects = Subject::count();
        $lastThreeEvents = Event::orderBy('event_date', 'desc')->limit(3)->get();
                                

        
        View::renderTemplate('Dashboard/index.html',[
            'totalStudents' => $totalStudents,
            'totalTeachers' => $totalTeachers,
            'totalClasses' => $totalClasses,
            'totalSubjects' => $totalSubjects,
            'events' => $lastThreeEvents,
            'user' => $this->user
        ]);
    }
}
