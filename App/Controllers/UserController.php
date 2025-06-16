<?php
namespace App\Controllers;

use App\Helpers\Session;
use App\Models\User;
use \Core\View;
use \Core\Controller;

class UserController extends Controller
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
        $users = User::orderBy('id', 'desc')->get();
        $session = Session::getInstance();
        $message = $session->message();

        View::renderTemplate('Users/index.html' , [
            'users' => $users,
            'message' => $message,
            'user' => $this->user
        ]);

    }
    
    public function create()
    {
        $roles = ['admin', 'teacher', 'student'];
        View::renderTemplate('Users/create.html', [
            'roles' => $roles,
            'user' => $this->user
    ]);
    }

    public function store()
    {
        User::create($_POST);

        Session::getInstance()->message("User added successfully");
        header('Location: /eSchool/public/users');
    }

    public function edit()
    {
        $id = $_GET['id'];
        $user = User::findorFail($id);

        $roles = ['admin', 'teacher', 'student'];

        View::renderTemplate('Users/edit.html', [
            'user' => $user,
            'roles' => $roles,
            'user' => $this->user 
        ]);
    }

    public function update()
    {
        $id = $_POST['id'];
        $user = User::findorFail($id);
        $user->first_name = $_POST['first_name'];
        $user->last_name = $_POST['last_name'];
        $user->email = $_POST['email'];
        $user->password = $_POST['password'];
        $user->role = $_POST['role'];
        $user->update();

        Session::getInstance()->message("User modified successfully");
        header('Location: /eSchool/public/users');
    }

    public function destroy()
    {
        $id = $_POST['id'];
        $user = User::findorFail($id);
        $user->delete();

        Session::getInstance()->message("User deleted succesfully");
        header('Location: /eSchool/public/users');
    }
}
?>