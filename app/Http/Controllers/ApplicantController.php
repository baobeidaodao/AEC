<?php
/**
 * Created by PhpStorm.
 * User: DaoDao
 * Date: 2018-11-21
 * Time: 16:00
 */

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Identity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApplicantController extends Controller
{
    private $active = 'applicant';

    public function index()
    {
        $applicantList = Applicant::with(['identity'])->get()->toArray();
        $data = [];
        $data['active'] = $this->active;
        $data['applicantList'] = $applicantList;
        return view('applicant.index', $data);
    }

    public function create()
    {
        $identityList = Identity::all()->toArray();
        $data = [];
        $data['active'] = $this->active;
        $data['identityList'] = $identityList;
        return view('applicant.create', $data);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required|max:255',
        ])->validate();
        $applicant = (new Applicant)->create([
            'name' => $request->name,
            'membership_id' => $request->membership_id,
            'identity_id' => $request->identity_id,
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'address_3' => $request->address_3,
            'post_code' => $request->post_code,
            'tel' => $request->tel,
            'fax' => $request->fax,
            'email' => $request->email,
            'delivery_date' => $request->delivery_date,
            'neighbour' => $request->neighbour,
        ]);
        return redirect('admin/applicant');
    }

    public function show($id)
    {
        $applicant = Applicant::with(['identity'])->find($id);
        if ($applicant) {
            $applicant = $applicant->toArray();
        } else {
            $applicant = [];
        }
        $data = [];
        $data['active'] = $this->active;
        $data['applicant'] = $applicant;
        return view('applicant.show', $data);
    }

    public function edit($id)
    {
        $applicant = Applicant::with(['identity'])->find($id);
        if ($applicant) {
            $applicant = $applicant->toArray();
        } else {
            $applicant = [];
        }
        $data = [];
        $identityList = Identity::all()->toArray();
        $data['active'] = $this->active;
        $data['applicant'] = $applicant;
        $data['identityList'] = $identityList;
        return view('applicant.edit', $data);
    }

    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'name' => 'required|max:255',
        ])->validate();
        $applicant = (new Applicant)->findOrFail($id);
        $applicant->fill([
            'name' => $request->name,
            'membership_id' => $request->membership_id,
            'identity_id' => $request->identity_id,
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'address_3' => $request->address_3,
            'post_code' => $request->post_code,
            'tel' => $request->tel,
            'fax' => $request->fax,
            'email' => $request->email,
            'delivery_date' => $request->delivery_date,
            'neighbour' => $request->neighbour,
        ])->save();
        return redirect('admin/applicant');
    }

    public function destroy($id)
    {
        $applicant = (new Applicant)->findOrFail($id);
        try {
            $applicant->delete();
        } catch (\Exception $e) {
            return redirect()->back();
        }
        return redirect('admin/applicant');
    }

}