<?php
namespace App\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Helpers\Session;
use App\Models\User;
use App\Models\Classes;
use App\Models\Student;
use \Core\View;
use \Core\Controller;

class StudentController extends Controller
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
        $students = Student::with(['user','classes'])->orderBy('id', 'desc')->get();
        $session = Session::getInstance();
        $message = $session->message();

        View::renderTemplate('Students/index.html',[
            'students' => $students,
            'message' => $message,
            'user' => $this->user
        ]);
    }

    public function create()
    {
        $users = User::where('role' , 'student')->get();
        $classes = Classes::all();
        $genders = ['male' => 'Male', 'female' => 'Female', 'other' => 'Other'];

        View::renderTemplate('Students/create.html', [
            'users' => $users,
            'classes' => $classes,
            'genders' => $genders,
            'user' => $this->user
        ]);
    }

    public function store()
    {
        $student = Student::create([
        'user_id' => $_POST['user_id'],
        'gender' => $_POST['gender'],
        'date_of_birth' => $_POST['date_of_birth'],
        ]);

        if (isset($_POST['class_id'])) {
            $student->classes()->sync($_POST['class_id']); 
        }

        Session::getInstance()->message("Student added Successfully");
        header('Location: /eSchool/public/students');
    }

    public function edit()
    {
        $student = Student::findorFail($_GET['id']);
        $users = User::where('role' , 'student')->get();
        $classes = Classes::all();
        $genders = ['male' => 'Male', 'female' => 'Female', 'other' => 'Other'];

        View::renderTemplate('Students/edit.html',[
            'student' => $student,
            'users' => $users,
            'classes' => $classes,
            'genders' => $genders,
            'user' => $this->user
        ]);
    }

    public function update()
    {
       $id = $_POST['id'];
        $student = Student::findOrFail($id);

        $student->user_id = $_POST['user_id'];
        $student->gender = $_POST['gender'];
        $student->date_of_birth = $_POST['date_of_birth'];
        $student->update();

       if (isset($_POST['class_id'])) {
            $student->classes()->sync($_POST['class_id']);
        } else {
            $student->classes()->sync([]); 
        }

        Session::getInstance()->message("Student added Successfully");
        header('Location: /eSchool/public/students');
    }

    public function destroy()
    {
        $id = $_POST['id'];
        $student = Student::findorFail($id);
        $student->classes()->detach();
        $student->delete();
        
        Session::getInstance()->message("Student added Successfully");
        header('Location: /eSchool/public/students');
    }

    public function details()
    {
        $student = Student::with(['user', 'classes', 'grades.subject', 'attendance', 'classes'])
            ->findOrFail($_GET['id']);

        View::renderTemplate('Students/details.html', [
            'student' => $student,
            'user' => $this->user
        ]);
    }

    public function print()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            Session::getInstance()->message("Invalid student ID");
            header("Location: /eSchool/public/students");
            exit;
        }

        $student = Student::with(['user',  'classes', 'grades.subject', 'attendance'])->findOrFail($id);

        $html = View::getTemplate('Students/pdf.html', [
            'student' => $student
        ]);


        $options = new Options();
        $options->set('defaultFont', 'Helvetica');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Shfaq PDF direkt në browser
        $dompdf->stream("student-details.pdf", ["Attachment" => false]);
        exit;
    }


}

?>