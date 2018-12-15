<?php
/**
 * Created by PhpStorm.
 * User: DaoDao
 * Date: 2018-11-22
 * Time: 14:39
 */

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ExamType;
use App\Models\Level;
use App\Models\PartE;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class PartEController extends Controller
{
    private $active = 'application';
    private $nav = 'part_e';

    public function index()
    {
        $applicationId = Input::get('application_id');
        $partEList = PartE::with(['application',])
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
        $data['partEList'] = $partEList;
        return view('part_e.index', $data);
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
        // return view('part_e.create', $data);
        return $this->store($request);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'application_id' => 'required',
        ])->validate();
        $partE = (new PartE)->create([
            'application_id' => $request->application_id,
        ]);
        $partE = PartE::check($partE->id);
        if ($partE->check == 1) {
            return redirect('/admin/part_f/create?application_id=' . $request->application_id);
        } else {
            return redirect('admin/part_e/' . $partE->id);
        }
    }

    public function show($id)
    {
        $data = [];
        $data['active'] = $this->active;
        $data['nav'] = $this->nav;
        $partE = PartE::with(['application',])->find($id);
        if ($partE) {
            $partE = $partE->toArray();
        } else {
            $partE = [];
        }
        $data['partE'] = $partE;
        $application = [];
        if (isset($partE) && isset($partE['application_id'])) {
            $application = Application::with(Application::WITH)->find($partE['application_id']);
            if ($application) {
                $application = $application->toArray();
            }
        }
        $data['application'] = $application;
        $levelList = Level::all()->toArray();
        $data['levelList'] = $levelList;
        $examTypeList = ExamType::all()->toArray();
        $data['examTypeList'] = $examTypeList;
        return view('part_e.show', $data);
    }

    public function edit($id)
    {
        $data = [];
        $data['active'] = $this->active;
        $data['nav'] = $this->nav;
        $partE = PartE::with(['application',])->find($id);
        if ($partE) {
            $partE = $partE->toArray();
        } else {
            $partE = [];
        }
        $data['partE'] = $partE;
        $application = [];
        if (isset($partE) && isset($partE['application_id'])) {
            $application = Application::with(Application::WITH)->find($partE['application_id']);
            if ($application) {
                $application = $application->toArray();
            }
        }
        $data['application'] = $application;
        $levelList = Level::all()->toArray();
        $data['levelList'] = $levelList;
        $examTypeList = ExamType::all()->toArray();
        $data['examTypeList'] = $examTypeList;
        return view('part_e.edit', $data);
    }

    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'application_id' => 'required',
        ])->validate();
        $partE = (new PartE)->findOrFail($id);
        $partE->fill([
            'application_id' => $request->application_id,
        ])->save();
        PartE::check($partE->id);
        // return redirect('admin/part_e/' . $partE->id);
        return redirect('admin/application/');
    }

    public function destroy($id)
    {
        $partE = (new PartE)->findOrFail($id);
        $applicationId = '';
        if (isset($partE) && isset($partE->application_id)) {
            $applicationId = $partE->application_id;
        }
        try {
            $partE->delete();
        } catch (\Exception $e) {
            return redirect()->back();
        }
        return redirect('admin/application/' . $applicationId);
    }

}