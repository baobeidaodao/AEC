<?php
/**
 * Created by PhpStorm.
 * User: DaoDao
 * Date: 2018-11-22
 * Time: 14:39
 */

namespace App\Http\Controllers;


use App\Models\Application;
use App\Models\PartA;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class PartAController extends Controller
{
    private $active = 'application';
    private $nav = 'part_a';

    public function index(Request $request)
    {
        $applicationId = Input::get('application_id');
        $partAList = PartA::with(['application'])
            ->where(function ($query) use ($applicationId) {
                if (isset($applicationId) && !empty($applicationId))
                    $query->where('application_id', '=', $applicationId);
            })
            ->get()->toArray();
        $application = [];
        if (isset($applicationId) && !empty($applicationId)) {
            $application = Application::with(Application::WITH)->find($applicationId);
            if ($application) {
                $application = $application->toArray();
            }
        }
        $data = [];
        $data['active'] = $this->active;
        $data['nav'] = $this->nav;
        $data['application'] = $application;
        $data['partAList'] = $partAList;
        return view('part_a.index', $data);
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
        $data = [];
        $data['active'] = $this->active;
        $data['nav'] = $this->nav;
        $data['application'] = $application;
        return view('part_a.create', $data);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'application_id' => 'required',
            'school_code' => 'required|max:255',
            'school_name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'tel' => 'required',
        ])->validate();
        if (isset($request->school_code) && !empty($request->school_code)) {
            $school = School::where('code', '=', $request->school_code)->first();
        }
        if (isset($school) && !empty($school)) {
            $school->fill([
                'name' => $request->school_name,
                'code' => $request->school_code,
                'email' => $request->email,
                'tel' => $request->tel,
            ])->save();
        } else {
            $school = (new School)->create([
                'name' => $request->school_name,
                'code' => $request->school_code,
                'email' => $request->email,
                'tel' => $request->tel,
            ]);
        }
        $schoolId = $school->id;
        $partA = (new PartA)->create([
            'application_id' => $request->application_id,
            'school_id' => $schoolId,
            'school_name' => $request->school_name,
            'school_code' => $request->school_code,
            'email' => $request->email,
            'tel' => $request->tel,
        ]);
        $partA = PartA::check($partA->id);
        if ($partA->check == 1) {
            return redirect('/admin/part_b/create?application_id=' . $request->application_id);
        } else {
            return redirect('admin/part_a/' . $partA->id);
        }
    }

    public function show($id)
    {
        $data = [];
        $data['active'] = $this->active;
        $data['nav'] = $this->nav;
        $partA = PartA::with(['application'])->find($id);
        if ($partA) {
            $partA = $partA->toArray();
        } else {
            $partA = [];
        }
        $data['partA'] = $partA;
        $application = [];
        if (isset($partA) && isset($partA['application_id'])) {
            $application = Application::with(Application::WITH)->find($partA['application_id']);
            if ($application) {
                $application = $application->toArray();
            }
        }
        $data['application'] = $application;
        return view('part_a.show', $data);
    }

    public function edit($id)
    {
        $data = [];
        $data['active'] = $this->active;
        $data['nav'] = $this->nav;
        $partA = PartA::with(['application'])->find($id);
        if ($partA) {
            $partA = $partA->toArray();
        } else {
            $partA = [];
        }
        $data['partA'] = $partA;
        $application = [];
        if (isset($partA) && isset($partA['application_id'])) {
            $application = Application::with(Application::WITH)->find($partA['application_id']);
            if ($application) {
                $application = $application->toArray();
            }
        }
        $data['application'] = $application;
        return view('part_a.edit', $data);
    }

    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'application_id' => 'required',
            'school_code' => 'required|max:255',
            'school_name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'tel' => 'required|max:255',
        ])->validate();
        if (isset($request->school_code) && !empty($request->school_code)) {
            $school = School::where('code', '=', $request->school_code)->first();
        }
        if (isset($school) && !empty($school)) {
            $school->fill([
                'name' => $request->school_name,
                'code' => $request->school_code,
                'email' => $request->email,
                'tel' => $request->tel,
            ])->save();
        } else {
            $school = (new School)->create([
                'name' => $request->school_name,
                'code' => $request->school_code,
                'email' => $request->email,
                'tel' => $request->tel,
            ]);
        }
        $schoolId = $school->id;
        $partA = (new PartA)->findOrFail($id);
        $partA->fill([
            'application_id' => $request->application_id,
            'school_id' => $schoolId,
            'school_name' => $request->school_name,
            'school_code' => $request->school_code,
            'email' => $request->email,
            'tel' => $request->tel,
        ])->save();
        PartA::check($partA->id);
        // return redirect('admin/part_a/' . $partA->id);
        return redirect('admin/application/');
    }

    public function destroy($id)
    {
        $partA = (new PartA)->findOrFail($id);
        $applicationId = '';
        if (isset($partA) && isset($partA->application_id)) {
            $applicationId = $partA->application_id;
        }
        try {
            $partA->delete();
        } catch (\Exception $e) {
            return redirect()->back();
        }
        return redirect('admin/application/');
    }

}