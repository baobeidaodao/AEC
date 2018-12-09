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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class PartCController extends Controller
{
    private $active = 'application';
    private $nav = 'part_c';

    public function index()
    {
        $applicationId = Input::get('application_id');
        $partCList = PartC::with(['application', 'partCTeacherList',])
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
        $data['partCList'] = $partCList;
        return view('part_c.index', $data);
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
        return view('part_c.create', $data);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'application_id' => 'required',
        ])->validate();
        $partC = (new PartC)->create([
            'application_id' => $request->application_id,
        ]);
        PartC::check($partC->id);
        return redirect('admin/part_c/' . $partC->id . '/edit');
    }

    public function show($id)
    {
        $data = [];
        $data['active'] = $this->active;
        $data['nav'] = $this->nav;
        $partC = PartC::with(['application', 'partCTeacherList',])->find($id);
        if ($partC) {
            $partC = $partC->toArray();
        } else {
            $partC = [];
        }
        $data['partC'] = $partC;
        $application = [];
        if (isset($partC) && isset($partC['application_id'])) {
            $application = Application::with(Application::WITH)->find($partC['application_id']);
            if ($application) {
                $application = $application->toArray();
            }
        }
        $data['application'] = $application;
        return view('part_c.show', $data);
    }

    public function edit($id)
    {
        $data = [];
        $data['active'] = $this->active;
        $data['nav'] = $this->nav;
        $partC = PartC::with(['application', 'partCTeacherList',])->find($id);
        if ($partC) {
            $partC = $partC->toArray();
        } else {
            $partC = [];
        }
        $data['partC'] = $partC;
        $application = [];
        if (isset($partC) && isset($partC['application_id'])) {
            $application = Application::with(Application::WITH)->find($partC['application_id']);
            if ($application) {
                $application = $application->toArray();
            }
        }
        $data['application'] = $application;
        return view('part_c.edit', $data);
    }

    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'application_id' => 'required',
        ])->validate();
        $partC = (new PartC)->findOrFail($id);
        $partC->fill([
            'application_id' => $request->application_id,
        ])->save();
        PartC::check($partC->id);
        return redirect('admin/part_c/' . $partC->id);
    }

    public function destroy($id)
    {
        $partC = (new PartC)->findOrFail($id);
        $applicationId = '';
        if (isset($partC) && isset($partC->application_id)) {
            $applicationId = $partC->application_id;
        }
        try {
            $partC->delete();
        } catch (\Exception $e) {
            return redirect()->back();
        }
        return redirect('admin/application/' . $applicationId);
    }

}