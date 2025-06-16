<?php
namespace App\Controllers;

use App\Helpers\Session;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Classes;
use \Core\View;
use \Core\Controller;

class AttendanceController extends Controller
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
        $attendances = Attendance::with(['student.user', 'subject', 'class'])->orderBy('date', 'desc')->get();
        $session = Session::getInstance();
        $message = $session->message();

        View::renderTemplate('Attendance/index.html', [
            'attendances' => $attendances,
            'message' => $message,
            'user' => $this->user
        ]);
    }

    public function create()
    {
         $students = Student::with('user')->get();
        $subjects = Subject::all();
        $classes = Classes::all();

        View::renderTemplate('Attendance/create.html', [
            'students' => $students,
            'subjects' => $subjects,
            'classes' => $classes,
             'old' => [],
            'errors' => [],
            'user' => $this->user
        ]);
    }

    public function store()
    {
         Attendance::create([
            'student_id' => $_POST['student_id'],
            'subject_id' => $_POST['subject_id'],
            'class_id'   => $_POST['class_id'],
            'date'       => $_POST['date'],
            'status'     => $_POST['status'],
            'old' => $_POST,
        ]);

        Session::getInstance()->message("Attendance added Successfully");
        header('Location: /eSchool/public/attendance');
    }

    public function edit()
    {
        $id = $_GET['id'];
        $attendance = Attendance::findOrFail($id);

        $students = Student::with('user')->get();
        $subjects = Subject::all();
        $classes = Classes::all();

        View::renderTemplate('Attendance/edit.html', [
            'attendance' => $attendance,
            'students'   => $students,
            'subjects'   => $subjects,
            'classes'    => $classes,
            'old' => [],
            'errors' => [],
            'user' => $this->user
            
        ]);
    }

    public function update()
    {
        $id = $_POST['id'];
        $attendance = Attendance::findOrFail($id);

        $attendance->update([
            'student_id' => $_POST['student_id'],
            'subject_id' => $_POST['subject_id'],
            'class_id'   => $_POST['class_id'],
            'date'       => $_POST['date'],
            'status'     => $_POST['status']
        ]);

        Session::getInstance()->message("Attendance modified Successfully");
        header('Location: /eSchool/public/attendance');
    }

    public function destroy()
    {
        $id = $_POST['id'];
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();

        Session::getInstance()->message("Attendance deleted Successfully");
        header('Location: /eSchool/public/attendance');
    }
}
?>