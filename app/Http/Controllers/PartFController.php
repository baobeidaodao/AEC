<?php
/**
 * Created by PhpStorm.
 * User: DaoDao
 * Date: 2018-11-22
 * Time: 14:39
 */

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\PartD;
use App\Models\PartF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class PartFController extends Controller
{
    private $active = 'application';
    private $nav = 'part_f';

    public function index(Request $request)
    {
        $applicationId = Input::get('application_id');
        $partFList = PartF::with(['application',])
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
        $data['partFList'] = $partFList;
        return view('part_f.index', $data);
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
        return view('part_f.create', $data);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'application_id' => 'required',
            'applicant_name' => 'required|regex:/^[A-Z]{1}[a-z]+(\s[A-Z]{1}[a-z]+)*$/|max:255',
            'agree' => 'required',
        ], [
            'applicant_name.required' => 'Applicant Name is required. Applicant Name 为必填项',
            'applicant_name.regex' => 'Applicant Name is invalid. Applicant Name 格式错误',
            'agree.required' => 'Agree is required. Agree 为必填项',
        ])->validate();
        $partD = PartD::where('application_id', '=', $request->application_id)->first();
        if ($request->applicant_name != $partD->applicant_name) {
            return back()->withErrors('Applicant Name must be consistent with Part D. Applicant Name 必须与 Part D 中保持一致');
        }
        $agree = Input::get('agree', []);
        if (!isset($agree[0]) || $agree[0] != 1) {
            return back()->withErrors('Agree is required. Agree 为必填项');
        }
        $partF = (new PartF)->create([
            'application_id' => $request->application_id,
            'applicant_id' => $request->applicant_id,
            'applicant_name' => $request->applicant_name,
        ]);
        $partF = PartF::check($partF->id);
        Application::check($request->application_id);
        if ($partF->check == 1) {
            return redirect('/admin/exam/create?application_id=' . $request->application_id);
        } else {
            return redirect('admin/part_f/' . $partF->id);
        }
    }

    public function show($id)
    {
        $data = [];
        $data['active'] = $this->active;
        $data['nav'] = $this->nav;
        $partF = PartF::with(['application',])->find($id);
        if ($partF) {
            $partF = $partF->toArray();
        } else {
            $partF = [];
        }
        $data['partF'] = $partF;
        $application = [];
        if (isset($partF) && isset($partF['application_id'])) {
            $application = Application::with(Application::WITH)->find($partF['application_id']);
            if ($application) {
                $application = $application->toArray();
            }
        }
        $data['application'] = $application;
        return view('part_f.show', $data);
    }

    public function edit($id)
    {
        $data = [];
        $data['active'] = $this->active;
        $data['nav'] = $this->nav;
        $partF = PartF::with(['application',])->find($id);
        if ($partF) {
            $partF = $partF->toArray();
        } else {
            $partF = [];
        }
        $data['partF'] = $partF;
        $application = [];
        if (isset($partF) && isset($partF['application_id'])) {
            $application = Application::with(Application::WITH)->find($partF['application_id']);
            if ($application) {
                $application = $application->toArray();
            }
        }
        $data['application'] = $application;
        return view('part_f.edit', $data);
    }

    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'application_id' => 'required',
            'applicant_name' => 'required|regex:/^[A-Z]{1}[a-z]+(\s[A-Z]{1}[a-z]+)*$/|max:255',
            'agree' => 'required',
        ], [
            'applicant_name.required' => 'Applicant Name is required. Applicant Name 为必填项',
            'applicant_name.regex' => 'Applicant Name is invalid. Applicant Name 格式错误',
            'agree.required' => 'Agree is required. Agree 为必填项',
        ])->validate();
        $partD = PartD::where('application_id', '=', $request->application_id)->first();
        if ($request->applicant_name != $partD->applicant_name) {
            return back()->withErrors('Applicant Name must be consistent with Part D. Applicant Name 必须与 Part D 中保持一致');
        }
        $agree = Input::get('agree', []);
        if (!isset($agree[0]) || $agree[0] != 1) {
            return back()->withErrors('Agree is required. Agree 为必填项');
        }
        $partF = (new PartF)->findOrFail($id);
        $partF->fill([
            'application_id' => $request->application_id,
            'applicant_id' => $request->applicant_id,
            'applicant_name' => $request->applicant_name,
        ])->save();
        PartF::check($partF->id);
        Application::check($request->application_id);
        // return redirect('admin/part_f/' . $partF->id);
        return redirect('admin/application/');
    }

    public function destroy($id)
    {
        $partF = (new PartF)->findOrFail($id);
        $applicationId = '';
        if (isset($partF) && isset($partF->application_id)) {
            $applicationId = $partF->application_id;
        }
        try {
            $partF->delete();
        } catch (\Exception $e) {
            return redirect()->back();
        }
        return redirect('admin/application/' . $applicationId);
    }

}