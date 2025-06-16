<?php

namespace App\Controllers;

use App\Models\User;
use App\Helpers\Session;
use App\Models\Classes;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Schedule;
use \Core\View;
use \Core\Controller;

class ScheduleController extends Controller
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
        $schedules = Schedule::with(['class','subject','teacher'])->orderBy('id', 'desc')->get();
        $session = Session::getInstance();
        $message = $session->message();

        
        $teacherId = $_SESSION['teacher_id'] ?? null;
        if (!$teacherId) {
            header('Location: /eSchool/public/login');
            exit;
        }

        $schedules = Schedule::with(['class', 'subject', 'teacher'])->where('teacher_id', $teacherId)->orderBy('id', 'desc')->get();

        $session = Session::getInstance();
        $message = $session->message();

        View::renderTemplate('Schedules/index.html', [
            'schedules' => $schedules,
            'message' => $message,
            'user' => $this->user
        ]);
    }

    public function create()
    {

        $classes = Classes::orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();
        $teachers = Teacher::with('user')->orderBy('id')->get();

        View::renderTemplate('Schedules/create.html',[
            'classes' => $classes,
            'subjects' => $subjects,
            'teachers' => $teachers,
            'user' => $this->user
        ]);
    }

    public function store()
    {
        Schedule::create($_POST);

        Session::getInstance()->message("Schedule added Successfully");
        header('Location: /eSchool/public/schedules');
    }

    public function edit()
    {
       $teacherId = $_SESSION['teacher_id'] ?? null;
        $id = $_GET['id'];
        $schedule = Schedule::findOrFail($id);

        if ($schedule->teacher_id != $teacherId) {
            // Nuk lejohet të editojë një orar që nuk i përket
            header('Location: /eSchool/public/schedules');
            exit;
        }

        $classes = Classes::orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();
        $teachers = Teacher::with('user')->orderBy('id')->get();

        View::renderTemplate('Schedules/edit.html', [
            'schedule' => $schedule,
            'classes' => $classes,
            'subjects' => $subjects,
            'teachers' => $teachers,
            'user' => $this->user
        ]);
    }

    public function update()
    {
        $teacherId = $_SESSION['teacher_id'] ?? null;
        $id = $_POST['id'];
        $schedule = Schedule::findOrFail($id);

        if ($schedule->teacher_id != $teacherId) {
            // Nuk lejohet të modifikojë orarin që nuk i përket
            header('Location: /eSchool/public/schedules');
            exit;
        }

        $schedule->class_id = $_POST['class_id'];
        $schedule->subject_id = $_POST['subject_id'];
        $schedule->teacher_id = $_POST['teacher_id'];
        $schedule->day_of_week = $_POST['day_of_week'];
        $schedule->start_time = $_POST['start_time'];
        $schedule->end_time = $_POST['end_time'];

        $schedule->update();

        Session::getInstance()->message("Schedule modified Successfully");
        header('Location: /eSchool/public/schedules');
    }

    public function destroy()
    {
        $teacherId = $_SESSION['teacher_id'] ?? null;
        $id = $_POST['id'];
        $schedule = Schedule::findOrFail($id);

        if ($schedule->teacher_id != $teacherId) {
            // Nuk lejohet të fshijë orarin që nuk i përket
            header('Location: /eSchool/public/schedules');
            exit;
        }

        $schedule->delete();

        Session::getInstance()->message("Schedule deleted Successfully");
        header('Location: /eSchool/public/schedules');
    }
    public function show()
    {
        $id = $_GET['id'];
        $schedule = Schedule::with(['class','subject','teacher.user'])->findOrFail($id);

        View::renderTemplate('Schedules/show.html', [
            'schedule' => $schedule,
            'user' => $this->user
        ]);
    }
}

?>