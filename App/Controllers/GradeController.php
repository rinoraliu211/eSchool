<?php
namespace App\Controllers;

use App\Models\User;
use App\Helpers\Session;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use \Core\View;
use \Core\Controller;

class GradeController extends Controller
{

    protected $user;

    public function __construct()
    {
        $session = Session::getInstance();
        if (!$session->isSignedIn()) {
            header('Location: /eSchool/public/login');
            exit;
        }
        $this->user = User::find($_SESSION['userId']);
    }

    public function index()
    {
        // Mënyra për të marrë vetëm notat e mësuesit të kyçur
        $teacherId = $_SESSION['teacher_id'] ?? null;

        if (!$teacherId) {
            header('Location: /eSchool/public/login');
            exit;
        }

        // Merr notat vetëm për subjektet e mësuesit të kyçur
        $grades = Grade::with(['student.user', 'subject'])
            ->whereHas('subject', function($query) use ($teacherId) {
                $query->where('teacher_id', $teacherId);
            })
            ->orderBy('id', 'desc')
            ->get();

        $session = Session::getInstance();
        $message = $session->message();

        View::renderTemplate('Grades/index.html', [
            'grades' => $grades,
            'message' => $message,
            'user' => $this->user
        ]);
    }

    public function create()
    {
        $teacherId = $_SESSION['teacher_id'] ?? null;

        // Merr vetëm subjektet që i përkasin mësuesit të kyçur
        $subjects = Subject::where('teacher_id', $teacherId)->orderBy('name')->get();

        // Merr të gjithë studentët (ose mund ta filtrosh sipas klasave nëse do)
        $students = Student::with('user')->orderBy('id')->get();

        View::renderTemplate('Grades/create.html', [
            'students' => $students,
            'subjects' => $subjects,
            'user' => $this->user
        ]);
    }

    public function store()
    {
        $teacherId = $_SESSION['teacher_id'] ?? null;

        // Kontrollo që subjekti i dhënë i përket mësuesit të kyçur
        $subjectId = $_POST['subject_id'] ?? null;
        $subject = Subject::find($subjectId);

        if (!$subject || $subject->teacher_id != $teacherId) {
            header('Location: /eSchool/public/grades');
            exit;
        }

        $grade = new Grade();
        $grade->student_id = $_POST['student_id'];
        $grade->subject_id = $subjectId;
        $grade->grade = $_POST['grade'];
        $grade->exam_date = $_POST['exam_date'];
        $grade->save();

        Session::getInstance()->message("Grade added Successfully");
        header('Location: /eSchool/public/grades');
    }

    public function edit()
    {
        $teacherId = $_SESSION['teacher_id'] ?? null;
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /eSchool/public/grades');
            exit;
        }

        $grade = Grade::with('subject')->findOrFail($id);

        // Kontrollo që nota i përket mësuesit të kyçur
        if ($grade->subject->teacher_id != $teacherId) {
            header('Location: /eSchool/public/grades');
            exit;
        }

        $students = Student::with('user')->orderBy('id')->get();
        $subjects = Subject::where('teacher_id', $teacherId)->orderBy('name')->get();

        View::renderTemplate('Grades/edit.html', [
            'grade' => $grade,
            'students' => $students,
            'subjects' => $subjects,
            'user' => $this->user
        ]);
    }

    public function update()
    {
        $teacherId = $_SESSION['teacher_id'] ?? null;
        $id = $_POST['id'] ?? null;

        if (!$id) {
            header('Location: /eSchool/public/grades');
            exit;
        }

        $grade = Grade::with('subject')->findOrFail($id);

        if ($grade->subject->teacher_id != $teacherId) {
            header('Location: /eSchool/public/grades');
            exit;
        }

        // Kontrollo që subjekti i zgjedhur i përket mësuesit të kyçur
        $subjectId = $_POST['subject_id'] ?? null;
        $subject = Subject::find($subjectId);
        if (!$subject || $subject->teacher_id != $teacherId) {
            header('Location: /eSchool/public/grades');
            exit;
        }

        $grade->student_id = $_POST['student_id'];
        $grade->subject_id = $subjectId;
        $grade->grade = $_POST['grade'];
        $grade->exam_date = $_POST['exam_date'];
        $grade->update();

        Session::getInstance()->message("Grade modified Successfully");
        header('Location: /eSchool/public/grades');
    }

    public function destroy()
    {
        $teacherId = $_SESSION['teacher_id'] ?? null;
        $id = $_POST['id'] ?? null;

        if (!$id) {
            header('Location: /eSchool/public/grades');
            exit;
        }

        $grade = Grade::with('subject')->findOrFail($id);

        if ($grade->subject->teacher_id != $teacherId) {
            header('Location: /eSchool/public/grades');
            exit;
        }

        $grade->delete();

        Session::getInstance()->message("Grade deleted Successfully");
        header('Location: /eSchool/public/grades');
    }
}
?>
