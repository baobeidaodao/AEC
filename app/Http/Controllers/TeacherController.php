<?php
/**
 * Created by PhpStorm.
 * User: DaoDao
 * Date: 2018-11-22
 * Time: 05:57
 */

namespace App\Http\Controllers;


use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    private $active = 'teacher';

    public function index()
    {
        $teacherList = Teacher::all()->toArray();
        $data = [];
        $data['active'] = $this->active;
        $data['teacherList'] = $teacherList;
        return view('teacher.index', $data);
    }

    public function create()
    {
        $data = [];
        $data['active'] = $this->active;
        return view('teacher.create', $data);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'membership_id' => 'required|max:255',
            'given_name' => 'required|max:255',
            'family_name' => 'required|max:255',
        ])->validate();
        $teacher = (new Teacher)->create([
            'membership_id' => $request->membership_id,
            'given_name' => $request->given_name,
            'family_name' => $request->family_name,
        ]);
        return redirect('admin/teacher');
    }

    public function show($id)
    {
        $teacher = Teacher::find($id);
        if ($teacher) {
            $teacher = $teacher->toArray();
        } else {
            $teacher = [];
        }
        $data = [];
        $data['active'] = $this->active;
        $data['teacher'] = $teacher;
        return view('teacher.show', $data);
    }

    public function edit($id)
    {
        $teacher = Teacher::find($id);
        if ($teacher) {
            $teacher = $teacher->toArray();
        } else {
            $teacher = [];
        }
        $data = [];
        $data['active'] = $this->active;
        $data['teacher'] = $teacher;
        return view('teacher.edit', $data);
    }

    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'membership_id' => 'required|max:255',
            'given_name' => 'required|max:255',
            'family_name' => 'required|max:255',
        ])->validate();
        $teacher = (new Teacher)->findOrFail($id);
        $teacher->fill([
            'membership_id' => $request->membership_id,
            'given_name' => $request->given_name,
            'family_name' => $request->family_name,
        ])->save();
        return redirect('admin/teacher');
    }

    public function destroy($id)
    {
        $teacher = (new Teacher())->findOrFail($id);
        try {
            $teacher->delete();
        } catch (\Exception $e) {
            return redirect()->back();
        }
        return redirect('admin/teacher');
    }
}