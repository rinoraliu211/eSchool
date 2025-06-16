<?php

namespace App\Controllers;

use App\Models\User;
use App\Helpers\Session;
use App\Models\Subject;
use App\Models\Teacher;
use \Core\View;
use \Core\Controller;

class SubjectController extends Controller
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
         $teacherId = $_SESSION['teacher_id'] ?? null;

        if (!$teacherId) {
            header('Location: /eSchool/public/login');
            exit;
        }
        
        $subjects = Subject::with('teacher')
            ->where('teacher_id', $teacherId)
            ->orderBy('id', 'desc')
            ->get();

        $session = Session::getInstance();
        $message = $session->message();

        View::renderTemplate('Subjects/index.html', [
            'subjects' => $subjects,
            'message' => $message,
            'user' => $this->user
        ]);
    }

    public function create()
    {

        $teachers = Teacher::with('user')->orderBy('id')->get();

        View::renderTemplate('Subjects/create.html', [
            'teachers' => $teachers,
            'user' => $this->user
        ]);
    }

    public function store()
    {
      Subject::create($_POST);

      Session::getInstance()->message("Subject added Successfully");
      header('Location: /eSchool/public/subjects');
    }

    public function edit()
    {

        $id = $_GET['id'];
        $subject = Subject::findorFail($id);

        $teacherId = $_SESSION['teacher_id'] ?? null;
            if (!$teacherId) {
                header('Location: /eSchool/public/login');
                exit;
            }

         if ($subject->teacher_id != $teacherId) {
        header('Location: /eSchool/public/subjects');
        exit;
    }

        $teachers = Teacher::with('user')->orderBy('id')->get();

        View::renderTemplate('Subjects/edit.html', [
            'subject' => $subject,
            'teachers' => $teachers,
            'user' => $this->user
        ]);
    }

    public function update()
    {
        $id = $_POST['id'];
        $subject = Subject::findorFail($id);

        $teacherId = $_SESSION['teacher_id'] ?? null;
            if (!$teacherId) {
                header('Location: /eSchool/public/login');
                exit;
            }

        if ($subject->teacher_id != $teacherId) {
        header('Location: /eSchool/public/subjects');
        exit;
    }

        $subject->name = $_POST['name'];
        $subject->code = $_POST['code'];
        $subject->teacher_id = $_POST['teacher_id'];

        $subject->update();

        Session::getInstance()->message("Subject modified Successfully");
        header('Location: /eSchool/public/subjects');
    }

    public function destroy()
    {
        $teacherId = $_SESSION['teacher_id'] ?? null;
            if (!$teacherId) {
                header('Location: /eSchool/public/login');
                exit;
            }

        $id = $_POST['id'];
        $subject = Subject::findorFail($id);

        if ($subject->teacher_id != $teacherId) {
            header('Location: /eSchool/public/subjects');
            exit;
        }
        $subject->delete();

        Session::getInstance()->message("Subject deleted Successfully");
        header('Location: /eSchool/public/subjects');
    }
   public function show()
    {
        $teacherId = $_SESSION['teacher_id'] ?? null;
        if (!$teacherId) {
            header('Location: /eSchool/public/login');
            exit;
        }

        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /eSchool/public/subjects');
            exit;
        }

        $subject = Subject::with([
            'teacher.user',
            'schedules',
            'grades.student.user',
            'attendance.student.user'
        ])->find($id);

        if (!$subject || $subject->teacher_id != $teacherId) {
            header('Location: /eSchool/public/subjects');
            exit;
        }

        View::renderTemplate('Subjects/show.html', [
            'subject' => $subject
        ]);
    }

}
?>