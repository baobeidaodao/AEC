<?php
/**
 * Created by PhpStorm.
 * User: DaoDao
 * Date: 2018-11-21
 * Time: 16:00
 */

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\School;
use App\Models\Studio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudioController extends Controller
{
    private $active = 'studio';

    public function index()
    {
        $studioList = Studio::with(['school', 'country'])->get()->toArray();
        $data = [];
        $data['active'] = $this->active;
        $data['studioList'] = $studioList;
        return view('studio.index', $data);
    }

    public function create()
    {
        $schoolList = School::all()->toArray();
        $countryList = Country::all()->toArray();
        $data = [];
        $data['active'] = $this->active;
        $data['schoolList'] = $schoolList;
        $data['countryList'] = $countryList;
        return view('studio.create', $data);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'school_id' => 'required',
            'name' => 'required|max:255',
        ])->validate();
        $studio = (new Studio)->create([
            'school_id' => $request->school_id,
            'name' => $request->name,
            'country_id' => $request->country_id,
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'address_3' => $request->address_3,
            'post_code' => $request->post_code,
            'tel' => $request->tel,
            'examination_day_contact_tel' => $request->examination_day_contact_tel,
        ]);
        return redirect('admin/studio');
    }

    public function show($id)
    {
        $studio = Studio::with(['country'])->find($id);
        if ($studio) {
            $studio = $studio->toArray();
        } else {
            $studio = [];
        }
        $data = [];
        $data['active'] = $this->active;
        $data['studio'] = $studio;
        return view('studio.show', $data);
    }

    public function edit($id)
    {
        $studio = Studio::with(['country'])->find($id);
        if ($studio) {
            $studio = $studio->toArray();
        } else {
            $studio = [];
        }
        $schoolList = School::all()->toArray();
        $countryList = Country::all()->toArray();
        $data = [];
        $data['active'] = $this->active;
        $data['studio'] = $studio;
        $data['schoolList'] = $schoolList;
        $data['countryList'] = $countryList;
        return view('studio.edit', $data);
    }

    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'school_id' => 'required',
            'name' => 'required|max:255',
        ])->validate();
        $studio = (new Studio)->findOrFail($id);
        $studio->fill([
            'school_id' => $request->school_id,
            'name' => $request->name,
            'country_id' => $request->country_id,
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'address_3' => $request->address_3,
            'post_code' => $request->post_code,
            'tel' => $request->tel,
            'examination_day_contact_tel' => $request->examination_day_contact_tel,
        ])->save();
        return redirect('admin/studio');
    }

    public function destroy($id)
    {
        $studio = (new Studio())->findOrFail($id);
        try {
            $studio->delete();
        } catch (\Exception $e) {
            return redirect()->back();
        }
        return redirect('admin/studio');
    }

}