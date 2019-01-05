<?php
/**
 * Created by PhpStorm.
 * User: DaoDao
 * Date: 2018-11-22
 * Time: 14:39
 */

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\PartC;
use App\Models\PartCTeacher;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class PartCTeacherController extends Controller
{
    private $active = 'application';
    private $nav = 'part_c';

    public function index()
    {
        $applicationId = Input::get('application_id');
        $application = [];
        if (isset($applicationId) && !empty($applicationId)) {
            $application = Application::with(Application::WITH)->find($applicationId);
            if ($application) {
                $application = $application->toArray();
            }
        }
        $partCTeacherList = PartCTeacher::with(['partC',])->get()->toArray();
        $data = [];
        $data['active'] = $this->active;
        $data['nav'] = $this->nav;
        $data['application'] = $application;
        $data['partCTeacherList'] = $partCTeacherList;
        return view('part_c_teacher.index', $data);
    }

    public function create(Request $request)
    {
        Validator::make($request->all(), [
            'application_id' => 'required',
        ])->validate();
        $applicationId = Input::get('application_id');
        $application = Application::with(Application::WITH)->find($applicationId);
        if ($application) {
            $application = $application->toArray();
        } else {
            $application = [];
        }
        $partCId = $application['part_c']['id'];
        $partC = PartC::with(['partCTeacherList'])
            ->where('id', '=', $partCId)
            ->first()
            ->toArray();
        $data = [];
        $data['active'] = $this->active;
        $data['nav'] = $this->nav;
        $data['application'] = $application;
        $data['partC'] = $partC;
        return view('part_c_teacher.create', $data);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'part_c_id' => 'required',
            //'membership_id' => 'required|max:255',
            'given_name' => 'required|regex:/^[A-Z]{1}[a-z]+[A-Za-z\s]*$/|max:255',
            'family_name' => 'required|regex:/^[A-Z]{1}[a-z]+$/|max:255',
        ],[
            'part_c_id.required' => 'please create part C first!'
        ])->validate();
        $teacher = (new Teacher)->updateOrCreate([
            'membership_id' => $request->membership_id,
        ], [
            'given_name' => $request->given_name,
            'family_name' => $request->family_name,
        ]);
        $teacherId = $teacher->id;
        $partCTeacher = (new PartCTeacher)->create([
            'part_c_id' => $request->part_c_id,
            'teacher_id' => $teacherId,
            'number' => $request->number,
            'membership_id' => $request->membership_id,
            'given_name' => $request->given_name,
            'family_name' => $request->family_name,
        ]);
        PartCTeacher::check($partCTeacher->id);
        PartC::check($request->part_c_id);
        return redirect('admin/part_c/' . $request->part_c_id);
    }

    public function show($id)
    {
        $partCTeacher = PartCTeacher::with(['partC', 'teacher',])->find($id);
        if ($partCTeacher) {
            $partCTeacher = $partCTeacher->toArray();
        } else {
            $partCTeacher = [];
        }
        $data = [];
        $data['active'] = $this->active;
        $data['nav'] = $this->nav;
        $data['partCTeacher'] = $partCTeacher;
        $partC = $partCTeacher['part_c'];
        $application = [];
        if (isset($partC) && isset($partC['application_id'])) {
            $application = Application::with(Application::WITH)->find($partC['application_id']);
            if ($application) {
                $application = $application->toArray();
            }
        }
        $data['application'] = $application;
        return view('part_c_teacher.show', $data);
    }

    public function edit($id)
    {
        $partCTeacher = PartCTeacher::with(['partC', 'teacher',])->find($id);
        if ($partCTeacher) {
            $partCTeacher = $partCTeacher->toArray();
        } else {
            $partCTeacher = [];
        }
        $data = [];
        $data['active'] = $this->active;
        $data['nav'] = $this->nav;
        $data['partCTeacher'] = $partCTeacher;
        $partC = $partCTeacher['part_c'];
        $application = [];
        if (isset($partC) && isset($partC['application_id'])) {
            $application = Application::with(Application::WITH)->find($partC['application_id']);
            if ($application) {
                $application = $application->toArray();
            }
        }
        $data['application'] = $application;
        return view('part_c_teacher.edit', $data);
    }

    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'part_c_id' => 'required',
            //'membership_id' => 'required|max:255',
            'given_name' => 'required|regex:/^[A-Z]{1}[a-z]+[A-Za-z\s]*$/|max:255',
            'family_name' => 'required|regex:/^[A-Z]{1}[a-z]+$/|max:255',
        ],[
            'part_c_id.required' => 'please create part C first!'
        ])->validate();
        $teacher = (new Teacher)->updateOrCreate([
            'membership_id' => $request->membership_id,
        ], [
            'given_name' => $request->given_name,
            'family_name' => $request->family_name,
        ]);
        $teacherId = $teacher->id;
        $partCTeacher = (new PartCTeacher)->findOrFail($id);
        $partCTeacher->fill([
            'part_c_id' => $request->part_c_id,
            'teacher_id' => $teacherId,
            'number' => $request->number,
            'membership_id' => $request->membership_id,
            'given_name' => $request->given_name,
            'family_name' => $request->family_name,
        ])->save();
        PartCTeacher::check($partCTeacher->id);
        PartC::check($request->part_c_id);
        return redirect('admin/part_c/' . $request->part_c_id);
    }

    public function destroy($id)
    {
        $partCTeacher = (new PartCTeacher)->findOrFail($id);
        $applicationId = '';
        if (isset($partCTeacher) && isset($partCTeacher->application_id)) {
            $applicationId = $partCTeacher->application_id;
        }
        try {
            $partCTeacher->delete();
        } catch (\Exception $e) {
            return redirect()->back();
        }
        return redirect('admin/application/' . $applicationId);
    }

}