<?php
namespace App\Controllers;

use App\Helpers\Session;
use App\Models\User;
use App\Models\Classes;
use App\Models\Student;
use \Core\View;
use \Core\Controller;

class ClassesController extends Controller
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
        $classes = Classes::with('students.user')->orderBy('id', 'desc')->get();

        $session = Session::getInstance();
        $message = $session->message();

        View::renderTemplate('Classes/index.html', [
            'classes' => $classes,
            'message' => $message,
            'user' => $this->user
        ]);
    }

    public function create()
    {
        View::renderTemplate('Classes/create.html',[
            'user' => $this->user,
        ]);
    }

    public function store()
    {
        Classes::create([
            'name' => $_POST['name']
        ]);

        Session::getInstance()->message("Class added Successfully");
        header('Location: /eSchool/public/classes');
        exit;
    }

    public function edit()
    {
        $id = $_GET['id'];
        $class = Classes::findOrFail($id);
        $students = Student::with('user')->get(); // të gjithë studentët me info user

        $attachedStudents = $class->students()->pluck('students.id')->toArray();

        View::renderTemplate('Classes/edit.html', [
            'class' => $class,
            'students' => $students,
            'attachedStudents' => $attachedStudents,
            'user' => $this->user
        ]);
    }

    public function update()
    {
        $id = $_POST['id'];
        $class = Classes::findOrFail($id);
        $class->name = $_POST['name'];
        $class->save();

        $studentIds = $_POST['students'] ?? [];
        $class->students()->sync($studentIds); 

        Session::getInstance()->message("Class modified Successfully");
        header('Location: /eSchool/public/classes');
        exit;
    }

    // Fshi klasën dhe lidhjet e saj me studentët
    public function destroy()
    {
        $id = $_POST['id'];
        $class = Classes::findOrFail($id);

        $class->students()->detach();

        $class->delete();

        Session::getInstance()->message("Class deleted Successfully");
        header('Location: /eSchool/public/classes');
        exit;
    }
}
?>