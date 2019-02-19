<?php
/**
 * Created by PhpStorm.
 * User: DaoDao
 * Date: 2018-11-22
 * Time: 05:57
 */

namespace App\Http\Controllers;


use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    private $active = 'student';

    public function index()
    {
        $studentList = Student::all()->toArray();
        $data = [];
        $data['active'] = $this->active;
        $data['studentList'] = $studentList;
        return view('student.index', $data);
    }

    public function create()
    {
        $data = [];
        $data['active'] = $this->active;
        return view('student.create', $data);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'number' => 'required|max:255',
            'given_name' => 'required|max:255',
            'family_name' => 'required|max:255',
            'birth_date' => 'required',
            'sex' => 'required',
        ])->validate();
        $student = (new Student)->create([
            'number' => $request->number,
            'given_name' => $request->given_name,
            'family_name' => $request->family_name,
            'birth_date' => date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $request->birth_date))),
            'sex' => $request->sex,
        ]);
        return redirect('admin/student');
    }

    public function show($id)
    {
        $student = Student::find($id);
        if ($student) {
            $student = $student->toArray();
        } else {
            $student = [];
        }
        $data = [];
        $data['active'] = $this->active;
        $data['student'] = $student;
        return view('student.show', $data);
    }

    public function edit($id)
    {
        $student = Student::find($id);
        if ($student) {
            $student = $student->toArray();
        } else {
            $student = [];
        }
        $data = [];
        $data['active'] = $this->active;
        $data['student'] = $student;
        return view('student.edit', $data);
    }

    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'number' => 'required|max:255',
            'given_name' => 'required|max:255',
            'family_name' => 'required|max:255',
            'birth_date' => 'required',
            'sex' => 'required',
        ])->validate();
        $student = (new Student)->findOrFail($id);
        $student->fill([
            'number' => $request->number,
            'given_name' => $request->given_name,
            'family_name' => $request->family_name,
            'birth_date' => date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $request->birth_date))),
            'sex' => $request->sex,
        ])->save();
        return redirect('admin/student');
    }

    public function destroy($id)
    {
        $student = (new Student())->findOrFail($id);
        try {
            $student->delete();
        } catch (\Exception $e) {
            return redirect()->back();
        }
        return redirect('admin/student');
    }
}