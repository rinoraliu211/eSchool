<?php

$router = new Core\Router();

$router->add('index', ['controller' => 'Home', 'action' => 'index']);

$router->add('student/home' , ['controller' => 'StudentHomeController' , 'action' => 'index']);
$router->add('student/profile', ['controller' => 'StudentHomeController', 'action' => 'view']);


$router->add('users', ['controller' => 'UserController', 'action' => 'index']);
$router->add('users/create', ['controller' => 'UserController', 'action' => 'create']);
$router->add('users/store', ['controller' => 'UserController', 'action' => 'store']);
$router->add('users/edit', ['controller' => 'UserController', 'action' => 'edit']);
$router->add('users/update', ['controller' => 'UserController', 'action' => 'update']);
$router->add('users/delete', ['controller' => 'UserController', 'action' => 'destroy']);

$router->add('teachers', ['controller' => 'TeacherController', 'action' => 'index']);
$router->add('teachers/create', ['controller' => 'TeacherController', 'action' => 'create']);
$router->add('teachers/store', ['controller' => 'TeacherController', 'action' => 'store']);
$router->add('teachers/edit', ['controller' => 'TeacherController', 'action' => 'edit']);
$router->add('teachers/update', ['controller' => 'TeacherController', 'action' => 'update']);
$router->add('teachers/delete', ['controller' => 'TeacherController', 'action' => 'destroy']);
$router->add('teachers/details', ['controller' => 'TeacherController', 'action' => 'details']);



$router->add('subjects', ['controller' => 'SubjectController', 'action' => 'index']);
$router->add('subjects/create', ['controller' => 'SubjectController', 'action' => 'create']);
$router->add('subjects/store', ['controller' => 'SubjectController', 'action' => 'store']);
$router->add('subjects/edit', ['controller' => 'SubjectController', 'action' => 'edit']);
$router->add('subjects/update', ['controller' => 'SubjectController', 'action' => 'update']);
$router->add('subjects/delete', ['controller' => 'SubjectController', 'action' => 'destroy']);
$router->add('subjects/show', ['controller' => 'SubjectController', 'action' => 'show']);




$router->add('students', ['controller' => 'StudentController', 'action' => 'index']);
$router->add('students/create', ['controller' => 'StudentController', 'action' => 'create']);
$router->add('students/store', ['controller' => 'StudentController', 'action' => 'store']);
$router->add('students/edit', ['controller' => 'StudentController', 'action' => 'edit']);
$router->add('students/update', ['controller' => 'StudentController', 'action' => 'update']);
$router->add('students/delete', ['controller' => 'StudentController', 'action' => 'destroy']);
$router->add('students/details', ['controller' => 'StudentController', 'action' => 'details']);
$router->add('students/print', ['controller' => 'StudentController', 'action' => 'print']);



$router->add('schedules', ['controller' => 'ScheduleController', 'action' => 'index']);
$router->add('schedules/create', ['controller' => 'ScheduleController', 'action' => 'create']);
$router->add('schedules/store', ['controller' => 'ScheduleController', 'action' => 'store']);
$router->add('schedules/edit', ['controller' => 'ScheduleController', 'action' => 'edit']);
$router->add('schedules/update', ['controller' => 'ScheduleController', 'action' => 'update']);
$router->add('schedules/delete', ['controller' => 'ScheduleController', 'action' => 'destroy']);
$router->add('schedules/show', ['controller' => 'ScheduleController', 'action' => 'show']);

$router->add('grades', ['controller' => 'GradeController', 'action' => 'index']);
$router->add('grades/create', ['controller' => 'GradeController', 'action' => 'create']);
$router->add('grades/store', ['controller' => 'GradeController', 'action' => 'store']);
$router->add('grades/edit', ['controller' => 'GradeController', 'action' => 'edit']);
$router->add('grades/update', ['controller' => 'GradeController', 'action' => 'update']);
$router->add('grades/delete', ['controller' => 'GradeController', 'action' => 'destroy']);

$router->add('events', ['controller' => 'EventController', 'action' => 'index']);
$router->add('events/create', ['controller' => 'EventController', 'action' => 'create']);
$router->add('events/store', ['controller' => 'EventController', 'action' => 'store']);
$router->add('events/edit', ['controller' => 'EventController', 'action' => 'edit']);
$router->add('events/update', ['controller' => 'EventController', 'action' => 'update']);
$router->add('events/delete', ['controller' => 'EventController', 'action' => 'destroy']);


$router->add('classes', ['controller' => 'ClassesController', 'action' => 'index']);
$router->add('classes/create', ['controller' => 'ClassesController', 'action' => 'create']);
$router->add('classes/store', ['controller' => 'ClassesController', 'action' => 'store']);
$router->add('classes/edit', ['controller' => 'ClassesController', 'action' => 'edit']);
$router->add('classes/update', ['controller' => 'ClassesController', 'action' => 'update']);
$router->add('classes/delete', ['controller' => 'ClassesController', 'action' => 'destroy']);


$router->add('attendance', ['controller' => 'AttendanceController', 'action' => 'index']);
$router->add('attendance/create', ['controller' => 'AttendanceController', 'action' => 'create']);
$router->add('attendance/store', ['controller' => 'AttendanceController', 'action' => 'store']);
$router->add('attendance/edit', ['controller' => 'AttendanceController', 'action' => 'edit']);
$router->add('attendance/update', ['controller' => 'AttendanceController', 'action' => 'update']);
$router->add('attendance/delete', ['controller' => 'AttendanceController', 'action' => 'destroy']);

$router->add('login' , ['controller' => 'Authcontroller' , 'action' => 'login']);
$router->add('login/store', ['controller' => 'AuthController', 'action' => 'loginStore']);
$router->add('logout',['controller' => 'AuthController' , 'action' => 'logout']);

$router->dispatch($_SERVER['QUERY_STRING']);

?>