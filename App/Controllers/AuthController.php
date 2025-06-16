<?php

namespace App\Controllers;

use App\Helpers\Session;
use App\Models\Student;
use App\Models\User;
use App\Models\Teacher;
use \Core\View;
use \Core\Controller;

class AuthController extends Controller
{
    public function login()
    {
        View::renderTemplate('Login.html');
    }

    public function loginStore()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = User::where('email', $email)->where('password', $password)->latest()->first();
        $session = Session::getInstance();

        if ($user) {
            $session->login($user);

            if ($user->role === 'admin') {
                header('Location: /eSchool/public/users');
            } elseif ($user->role === 'teacher') {
                $teacher = Teacher::where('user_id', $user->id)->first();
                if($teacher)
                {
                    $_SESSION['teacher_id'] = $teacher->id;
                    header("Location: /eSchool/public/teachers");
                } else {
                    $session->message("No teacher");
                    header("Location: /eSchool/public/login");
                }
            } elseif ($user->role === 'student') {
                $student = Student::where('user_id', $user->id)->first();
                if ($student) {
                    header("Location: /eSchool/public/student/home");
                } else {
                    $session->message("No student ");
                    header('Location: /eSchool/public/login');
                }
            } else {
                $session->message("Unknown user role.");
                header('Location: /eSchool/public/login');
            }
            exit;
        } else {
            $session->message("Your email or password is incorrect.");
            header('Location: /eSchool/public/login');
            exit;
        }
    }

    public function logout()
    {
        $session = Session::getInstance();

        if (! $session->isSignedIn()) {
            header("Location: /eSchool/public/login");
            exit;
        }

        $session->logout();
        header("Location: /eSchool/public/login");
        exit;
    }
}

?>