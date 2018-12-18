<?php
/**
 * Created by PhpStorm.
 * User: DaoDao
 * Date: 2018-11-21
 * Time: 16:00
 */

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Studio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SchoolController extends Controller
{
    private $active = 'school';

    public function index()
    {
        $schoolList = School::all()->toArray();
        $data = [];
        $data['active'] = $this->active;
        $data['schoolList'] = $schoolList;
        return view('school.index', $data);
    }

    public function create()
    {
        $data = [];
        $data['active'] = $this->active;
        return view('school.create', $data);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required|unique:school|max:255',
            'email' => 'required|email|unique:school|max:255',
        ])->validate();
        $school = (new School)->create([
            'name' => $request->name,
            'code' => $request->code,
            'email' => $request->email,
            'tel' => $request->tel,
        ]);
        return redirect('admin/school');
    }

    public function show($id)
    {
        $school = School::find($id);
        if ($school) {
            $school = $school->toArray();
        } else {
            $school = [];
        }
        $data = [];
        $data['active'] = $this->active;
        $data['school'] = $school;
        $studioList = Studio::with(['school', 'country'])
            ->where('school_id', '=', $school['id'])
            ->get()
            ->toArray();
        $data['studioList'] = $studioList;
        return view('school.show', $data);
    }

    public function edit($id)
    {
        $school = School::find($id);
        if ($school) {
            $school = $school->toArray();
        } else {
            $school = [];
        }
        $data = [];
        $data['active'] = $this->active;
        $data['school'] = $school;
        $studioList = Studio::with(['school', 'country'])
            ->where('school_id', '=', $school['id'])
            ->get()
            ->toArray();
        $data['studioList'] = $studioList;
        return view('school.edit', $data);
    }

    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
        ])->validate();
        $school = (new School)->findOrFail($id);
        $school->fill([
            'name' => $request->name,
            'code' => $request->code,
            'email' => $request->email,
            'tel' => $request->tel,
        ])->save();
        return redirect('admin/school');
    }

    public function destroy($id)
    {
        $school = (new School)->findOrFail($id);
        try {
            $school->delete();
        } catch (\Exception $e) {
            return redirect()->back();
        }
        return redirect('admin/school');
    }

}