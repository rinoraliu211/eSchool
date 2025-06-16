<?php
namespace App\Controllers;

use App\Helpers\Session;
use App\Models\User;
use App\Models\Teacher;
use \Core\View;
use \Core\Controller;


class TeacherController extends Controller
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
        $teachers = Teacher::with('user')->orderBy('id', 'desc')->get();
        $session = Session::getInstance();
        $message = $session->message();

        View::renderTemplate('Teachers/index.html', [
            'teachers' => $teachers,
            'message' => $message,
            'user' => $this->user
        ]);
    }

    public function create()
    {
        $users = User::where('role', 'teacher')->get();
        $genders = ['male' => 'Male', 'female' => 'Female', 'other' => 'Other'];

        View::renderTemplate('Teachers/create.html', [
            'users' => $users,
            'genders' => $genders,
            'user' => $this->user
        ]);
    }

    public function store()
    {
        Teacher::create($_POST);

        Session::getInstance()->message("Teacher added successfully");
        header('Location: /eSchool/public/teachers');
    }

    public function edit()
    {
        $id = $_GET['id'];
        $teacher = Teacher::findorFail($id);
        $users = User::where('role', 'teacher')->get();
        $genders = ['male' => 'Male', 'female' => 'Female', 'other' => 'Other'];

        View::renderTemplate('Teachers/edit.html' ,[
            'teacher' => $teacher,
            'users' => $users,
            'genders' => $genders,
            'user' => $this->user
        ]);
    }

    public function update()
    {
        $id = $_POST['id'];
        $teacher = Teacher::findorFail($id);

        $teacher->user_id = $_POST['user_id'];
        $teacher->subject_specialty = $_POST['subject_specialty'];
        $teacher->date_of_birth = $_POST['date_of_birth'];
        $teacher->gender = $_POST['gender'];
        $teacher->update();

        Session::getInstance()->message("Teacher modified successfully");
        header('Location: /eSchool/public/teachers');
    }

    public function destroy()
    {
        $id = $_POST['id'];
        $teacher = Teacher::findorFail($id);

        $teacher->delete();

        Session::getInstance()->message("Teacher deleted successfully");
        header('Location: /eSchool/public/teachers');
    }

    
    public function details()
    {
        $id = $_GET['id'];
        $teacher = Teacher::with(['user', 'subjects', 'schedules'])->findOrFail($id);

        View::renderTemplate('Teachers/details.html', [
            'teacher' => $teacher,
            'user' => $this->user
        ]);
    }


}

?>