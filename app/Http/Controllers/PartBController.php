<?php
/**
 * Created by PhpStorm.
 * User: DaoDao
 * Date: 2018-11-22
 * Time: 14:39
 */

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Country;
use App\Models\PartB;
use App\Models\School;
use App\Models\Studio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class PartBController extends Controller
{
    private $active = 'application';
    private $nav = 'part_b';

    public function index()
    {
        $applicationId = Input::get('application_id');
        $partBList = PartB::with(['application', 'country', 'studio',])
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
        $data['partBList'] = $partBList;
        return view('part_b.index', $data);
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
        $schoolId = $application['part_a']['school_id'];
        $school = School::find($schoolId)->toArray();
        $countryList = Country::all()->toArray();
        $data = [];
        $data['active'] = $this->active;
        $data['nav'] = $this->nav;
        $data['application'] = $application;
        $data['school'] = $school;
        $data['countryList'] = $countryList;
        return view('part_b.create', $data);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'application_id' => 'required',
            'school_id' => 'required',
            'studio_name' => 'required',
            'country_id' => 'required',
            'address_1' => 'required',
            'post_code' => 'required',
            'tel' => 'required',
            'examination_day_contact_tel' => 'required',
        ], [
            'school_id.required' => 'please finish part A first!',
        ])->validate();
        $applicationId = Input::get('application_id');
        $application = Application::with(Application::WITH)->find($applicationId);
        if ($application) {
            $application = $application->toArray();
        } else {
            $application = [];
        }
        $schoolId = $application['part_a']['school_id'];
        $school = School::find($schoolId)->toArray();
        $studioName = $request->studio_name;
        $studio = (new Studio)->updateOrCreate([
            'school_id' => $schoolId,
            'name' => $studioName,
        ], [
            'country_id' => $request->country_id,
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'address_3' => $request->address_3,
            'post_code' => $request->post_code,
            'tel' => $request->tel,
            'examination_day_contact_tel' => $request->examination_day_contact_tel,
        ]);
        $partB = (new PartB)->create([
            'application_id' => $request->application_id,
            'country_id' => $request->country_id,
            'studio_id' => $studio->id,
            'studio_name' => $request->studio_name,
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'address_3' => $request->address_3,
            'post_code' => $request->post_code,
            'tel' => $request->tel,
            'examination_day_contact_tel' => $request->examination_day_contact_tel,
        ]);
        PartB::check($partB->id);
        return redirect('admin/part_b/' . $partB->id);
    }

    public function show($id)
    {
        $data = [];
        $data['active'] = $this->active;
        $data['nav'] = $this->nav;
        $partB = PartB::with(['application', 'country', 'studio',])->find($id);
        if ($partB) {
            $partB = $partB->toArray();
        } else {
            $partB = [];
        }
        $data['partB'] = $partB;
        $application = [];
        if (isset($partB) && isset($partB['application_id'])) {
            $application = Application::with(Application::WITH)->find($partB['application_id']);
            if ($application) {
                $application = $application->toArray();
            }
        }
        $data['application'] = $application;
        return view('part_b.show', $data);
    }

    public function edit($id)
    {
        $data = [];
        $data['active'] = $this->active;
        $data['nav'] = $this->nav;
        $partB = PartB::with(['application', 'country', 'studio',])->find($id);
        if ($partB) {
            $partB = $partB->toArray();
        } else {
            $partB = [];
        }
        $data['partB'] = $partB;
        $application = [];
        if (isset($partB) && isset($partB['application_id'])) {
            $application = Application::with(Application::WITH)->find($partB['application_id']);
            if ($application) {
                $application = $application->toArray();
            }
        }
        $data['application'] = $application;
        $countryList = Country::all()->toArray();
        $data['countryList'] = $countryList;
        $schoolId = $application['part_a']['school_id'];
        $school = School::find($schoolId)->toArray();
        $data['school'] = $school;
        return view('part_b.edit', $data);
    }

    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'application_id' => 'required',
            'school_id' => 'required',
            'studio_name' => 'required',
            'country_id' => 'required',
            'address_1' => 'required',
            'post_code' => 'required',
            'tel' => 'required',
            'examination_day_contact_tel' => 'required',
        ])->validate();
        $applicationId = Input::get('application_id');
        $application = Application::with(Application::WITH)->find($applicationId);
        if ($application) {
            $application = $application->toArray();
        } else {
            $application = [];
        }
        $schoolId = $application['part_a']['school_id'];
        $school = School::find($schoolId)->toArray();
        $studioName = $request->studio_name;
        $studio = (new Studio)->updateOrCreate([
            'school_id' => $schoolId,
            'name' => $studioName,
        ], [
            'country_id' => $request->country_id,
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'address_3' => $request->address_3,
            'post_code' => $request->post_code,
            'tel' => $request->tel,
            'examination_day_contact_tel' => $request->examination_day_contact_tel,
        ]);
        $partB = (new PartB)->findOrFail($id);
        $partB->fill([
            'application_id' => $request->application_id,
            'country_id' => $request->country_id,
            'studio_id' => $studio->id,
            'studio_name' => $request->studio_name,
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'address_3' => $request->address_3,
            'post_code' => $request->post_code,
            'tel' => $request->tel,
            'examination_day_contact_tel' => $request->examination_day_contact_tel,
        ])->save();
        PartB::check($partB->id);
        return redirect('admin/part_b/' . $partB->id);
    }

    public function destroy($id)
    {
        $partB = (new PartB)->findOrFail($id);
        $applicationId = '';
        if (isset($partB) && isset($partB->application_id)) {
            $applicationId = $partB->application_id;
        }
        try {
            $partB->delete();
        } catch (\Exception $e) {
            return redirect()->back();
        }
        return redirect('admin/application/' . $applicationId);
    }

}