<?php
/**
 * Created by PhpStorm.
 * User: DaoDao
 * Date: 2018-11-22
 * Time: 14:39
 */

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Application;
use App\Models\Identity;
use App\Models\PartD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class PartDController extends Controller
{
    private $active = 'application';
    private $nav = 'part_d';

    public function index()
    {
        $applicationId = Input::get('application_id');
        $partDList = PartD::with(['application', 'applicant', 'identity',])
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
        $data['partDList'] = $partDList;
        return view('part_d.index', $data);
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
        $identityList = Identity::all()->toArray();
        $data = [];
        $data['active'] = $this->active;
        $data['nav'] = $this->nav;
        $data['application'] = $application;
        $data['identityList'] = $identityList;
        return view('part_d.create', $data);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'application_id' => 'required',
            'applicant_name' => 'required|regex:/^[A-Z]{1}[a-z]*([\s\-]{1}[A-Z]{1}[a-z]*)*$/|max:255',
            'identity_id' => 'required|max:255',
            'address_1' => 'required|max:255',
            'post_code' => 'required|max:255',
            'tel' => 'required|max:255',
            //'fax' => 'required|max:255',
            'email' => 'required|email|max:255',
            // 'delivery_date' => 'required|regex:/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/|max:10|min:10',
            'neighbour' => 'required|max:255',
        ], [
            'applicant_name.required' => 'Applicant Name is required. Applicant Name 为必填项',
            'applicant_name.regex' => 'Applicant Name is invalid. Applicant Name 格式错误',
            'identity_id.required' => 'Identity is required. Identity 为必填项',
            'address_1.required' => 'Address is required. Address 为必填项',
            'post_code.required' => 'Post Code is required. Post Code 为必填项',
            'tel.required' => 'Tel is required. Tel 为必填项',
            'email.required' => 'Email is required. Email 为必填项',
            'email.email' => 'Email is invalid. Email 格式错误',
            // 'delivery_date.regex' => 'delivery_date is invalid. delivery_date 格式错误',
            'neighbour.required' => 'Neighbour is required. Neighbour 为必填项',
        ])->validate();
        if (isset($request->delivery_date) && !empty($request->delivery_date)) {
            $pattern = '/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/';
            if (!preg_match($pattern, $request->delivery_date)) {
                return back()->withErrors('Delivery Date is invalid. Delivery Date 格式错误');
            }
        }
        $applicant = (new Applicant)->updateOrCreate([
            'name' => $request->applicant_name,
            'membership_id' => $request->membership_id,
        ], [
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
        $partD = (new PartD)->create([
            'application_id' => $request->application_id,
            'applicant_id' => $applicant->id,
            'applicant_name' => $request->applicant_name,
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
        $partD = PartD::check($partD->id);
        if ($partD->check == 1) {
            return redirect('/admin/part_e/create?application_id=' . $request->application_id);
        } else {
            return redirect('admin/part_d/' . $partD->id);
        }
    }

    public function show($id)
    {
        $data = [];
        $data['active'] = $this->active;
        $data['nav'] = $this->nav;
        $partD = PartD::with(['application',])->find($id);
        if ($partD) {
            $partD = $partD->toArray();
        } else {
            $partD = [];
        }
        $data['partD'] = $partD;
        $application = [];
        if (isset($partD) && isset($partD['application_id'])) {
            $application = Application::with(Application::WITH)->find($partD['application_id']);
            if ($application) {
                $application = $application->toArray();
            }
        }
        $data['application'] = $application;
        return view('part_d.show', $data);
    }

    public function edit($id)
    {
        $data = [];
        $data['active'] = $this->active;
        $data['nav'] = $this->nav;
        $partD = PartD::with(['application',])->find($id);
        if ($partD) {
            $partD = $partD->toArray();
        } else {
            $partD = [];
        }
        $data['partD'] = $partD;
        $application = [];
        if (isset($partD) && isset($partD['application_id'])) {
            $application = Application::with(Application::WITH)->find($partD['application_id']);
            if ($application) {
                $application = $application->toArray();
            }
        }
        $data['application'] = $application;
        $identityList = Identity::all()->toArray();
        $data['identityList'] = $identityList;
        return view('part_d.edit', $data);
    }

    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'application_id' => 'required',
            'applicant_name' => 'required|regex:/^[A-Z]{1}[a-z]*([\s\-]{1}[A-Z]{1}[a-z]*)*$/|max:255',
            'identity_id' => 'required|max:255',
            'address_1' => 'required|max:255',
            'post_code' => 'required|max:255',
            'tel' => 'required|max:255',
            //'fax' => 'required|max:255',
            'email' => 'required|email|max:255',
            // 'delivery_date' => 'required|regex:/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/|max:10|min:10',
            'neighbour' => 'required|max:255',
        ], [
            'applicant_name.required' => 'Applicant Name is required. Applicant Name 为必填项',
            'applicant_name.regex' => 'Applicant Name is invalid. Applicant Name 格式错误',
            'identity_id.required' => 'Identity is required. Identity 为必填项',
            'address_1.required' => 'Address is required. Address 为必填项',
            'post_code.required' => 'Post Code is required. Post Code 为必填项',
            'tel.required' => 'Tel is required. Tel 为必填项',
            'email.required' => 'Email is required. Email 为必填项',
            'email.email' => 'Email is invalid. Email 格式错误',
            // 'delivery_date.regex' => 'delivery_date is invalid. delivery_date 格式错误',
            'neighbour.required' => 'Neighbour is required. Neighbour 为必填项',
        ])->validate();
        if (isset($request->delivery_date) && !empty($request->delivery_date)) {
            $pattern = '/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/';
            if (!preg_match($pattern, $request->delivery_date)) {
                return back()->withErrors('Delivery Date is invalid. Delivery Date 格式错误');
            }
        }
        $applicant = (new Applicant)->updateOrCreate([
            'name' => $request->applicant_name,
            'membership_id' => $request->membership_id,
        ], [
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
        $partD = (new PartD)->findOrFail($id);
        $partD->fill([
            'application_id' => $request->application_id,
            'applicant_id' => $applicant->id,
            'applicant_name' => $request->applicant_name,
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
        PartD::check($partD->id);
        // return redirect('admin/part_d/' . $partD->id);
        return redirect('admin/application/');
    }

    public function destroy($id)
    {
        $partD = (new PartD)->findOrFail($id);
        $applicationId = '';
        if (isset($partD) && isset($partD->application_id)) {
            $applicationId = $partD->application_id;
        }
        try {
            $partD->delete();
        } catch (\Exception $e) {
            return redirect()->back();
        }
        return redirect('admin/application/' . $applicationId);
    }

}