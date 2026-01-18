<?php
require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../models/Student.php';

class StudentController extends BaseController {

    public function index() {
        $students = Student::all();
        $this->render('student/index', [
            'students' => $students
        ]);
    }
}
