<?php
namespace App\Controllers;

use App\Helpers\Session;
use App\Models\User;
use App\Models\Event;
use \Core\View;
use \Core\Controller;

class EventController extends Controller
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
        $events = Event::orderBy('event_date', 'desc')->get();
        $session = Session::getInstance();
        $message = $session->message();

        View::renderTemplate('Events/index.html', [
            'events' => $events,
            'message' => $message,
            'user' => $this->user
        ]);
    }

    public function create()
    {
         View::renderTemplate('Events/create.html',[
            'user' => $this->user
         ]);
    }

    public function store()
    {
        Event::create($_POST);

        Session::getInstance()->message("Event added Successfully");
        header('Location: /eSchool/public/events');
    }

    public function edit()
    {
        $id = $_GET['id'];
        $event = Event::findOrFail($id);

        View::renderTemplate('Events/edit.html', [
            'event' => $event,
            'user' => $this->user
        ]);
    }

    public function update()
    {
        $id = $_POST['id'];
        $event = Event::findOrFail($id);

        $event->title = $_POST['title'];
        $event->description = $_POST['description'];
        $event->event_date = $_POST['event_date'];
        $event->update();

        Session::getInstance()->message("Event modified Successfully");
        header('Location: /eSchool/public/events');
    }

    public function destroy()
    {
        $id = $_POST['id'];
        $event = Event::findOrFail($id);
        $event->delete();

        Session::getInstance()->message("Event deleted Successfully");
        header('Location: /eSchool/public/events');
    }
}
?>