<?php
/**
 * Created by PhpStorm.
 * User: DaoDao
 * Date: 2018-11-21
 * Time: 16:00
 */

namespace App\Http\Controllers;

use App\Models\Aec;
use App\Models\Application;
use App\Models\Exam;
use App\Models\PartA;
use App\Models\PartB;
use App\Models\PartC;
use App\Models\PartCTeacher;
use App\Models\PartD;
use App\Models\PartE;
use App\Models\PartF;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{
    private $active = 'application';
    private $nav = 'application';

    public function index($page = null)
    {
        if (!isset($page)) {
            $page = 1;
        }
        $size = 20;
        $db = Application::with(['aec', 'user', 'partA', 'partB', 'partC', 'partD', 'partE', 'partF', 'exam',])
            ->where(function ($query) {
                $userId = Auth::id();
                if (!Permission::userHasPermission($userId, 'admin') && !Permission::userHasPermission($userId, 'secondary_admin')) {
                    $query->where('created_user_id', '=', $userId);
                }
            });
        $total = $db->count();
        $pagination = [];
        $pagination['page'] = $page;
        $pagination['count'] = ceil($total / $size);

        $applicationList = $db->forPage($page, 20)
            ->get()
            ->toArray();
        $data = [];
        $data['active'] = $this->active;
        $data['nav'] = $this->nav;
        $data['pagination'] = $pagination;
        $data['applicationList'] = $applicationList;
        return view('application.index', $data);
    }

    public function create()
    {
        $aecList = Aec::all()->toArray();
        $data = [];
        $data['active'] = $this->active;
        $data['nav'] = $this->nav;
        $data['aecList'] = $aecList;
        return view('application.create', $data);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'aec_id' => 'required|max:255',
        ])->validate();
        $application = (new Application)->create([
            'aec_id' => $request->aec_id,
            'created_user_id' => Auth::user()->id,
            'updated_user_id' => Auth::user()->id,
        ]);
        Application::check($application->id);
        return redirect('admin/application');
    }

    public function show($id)
    {
        $application = Application::with([
            'aec', 'user', 'partA', 'partB',
            'partC' => function ($query) {
                $query->with(['partCTeacherList']);
            },
            'partD', 'partE', 'partF', 'exam',
        ])->find($id);
        if ($application) {
            $application = $application->toArray();
        } else {
            $application = [];
        }
        $data = [];
        $data['active'] = $this->active;
        $data['nav'] = $this->nav;
        $data['application'] = $application;
        return view('application.show', $data);
    }

    public function edit($id)
    {
        $application = Application::with(['aec', 'user'])->find($id);
        if ($application) {
            $application = $application->toArray();
        } else {
            $application = [];
        }
        $data = [];
        $aecList = Aec::all()->toArray();
        $data['active'] = $this->active;
        $data['nav'] = $this->nav;
        $data['application'] = $application;
        $data['aecList'] = $aecList;
        return view('application.edit', $data);
    }

    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'aec_id' => 'required|max:255',
        ])->validate();
        $application = (new Application)->findOrFail($id);
        $application->fill([
            'aec_id' => $request->aec_id,
            'updated_user_id' => Auth::user()->id,
        ])->save();
        Application::check($application->id);
        return redirect('admin/application');
    }

    public function destroy($id)
    {
        $application = (new Application)->findOrFail($id);
        try {
            $application->deleted_user_id = Auth::user()->id;
            $application->save();
            $application->delete();
        } catch (\Exception $e) {
            return redirect()->back();
        }
        return redirect('admin/application');
    }

    public function copy($thatApplicationId)
    {
        // dd($thatApplicationId);
        $thatApplication = (new Application)->findOrFail($thatApplicationId);
        $thatPartA = (new PartA)->where('application_id', $thatApplicationId)->whereNull('deleted_at')->first();
        $thatPartB = (new PartB)->where('application_id', $thatApplicationId)->whereNull('deleted_at')->first();
        $thatPartC = (new PartC)->where('application_id', $thatApplicationId)->whereNull('deleted_at')->first();
        $thatPartCTeacherList = (new PartCTeacher)->where('part_c_id', $thatPartC->id)->whereNull('deleted_at')->orderBy('id', 'asc')->get();
        $thatPartD = (new PartD)->where('application_id', $thatApplicationId)->whereNull('deleted_at')->first();
        $thatPartE = (new PartE)->where('application_id', $thatApplicationId)->whereNull('deleted_at')->first();
        $thatPartF = (new PartF)->where('application_id', $thatApplicationId)->whereNull('deleted_at')->first();
        $thatExam = (new Exam)->where('application_id', $thatApplicationId)->whereNull('deleted_at')->first();

        $application = (new Application)->create([
            'aec_id' => $thatApplication->aec_id,
            'created_user_id' => $thatApplication->created_user_id,
            'updated_user_id' => $thatApplication->updated_user_id,
        ]);
        // Application::check($application->id);

        $partA = (new PartA)->create([
            'application_id' => $application->id,
            'school_id' => $thatPartA->school_id,
            'school_name' => $thatPartA->school_name,
            'school_code' => $thatPartA->school_code,
            'email' => $thatPartA->email,
            'tel' => $thatPartA->tel,
        ]);
        PartA::check($partA->id);
        // Application::check($application->id);

        $partB = (new PartB)->create([
            'application_id' => $application->id,
            'country_id' => $thatPartB->country_id,
            'studio_id' => $thatPartB->studio_id,
            'studio_name' => $thatPartB->studio_name,
            'address_1' => $thatPartB->address_1,
            'address_2' => $thatPartB->address_2,
            'address_3' => $thatPartB->address_3,
            'post_code' => $thatPartB->post_code,
            'tel' => $thatPartB->tel,
            'examination_day_contact_tel' => $thatPartB->examination_day_contact_tel,
        ]);
        PartB::check($partB->id);
        // Application::check($application->id);

        $partC = (new PartC)->create([
            'application_id' => $application->id,
        ]);
        // PartC::check($partC->id);
        // Application::check($application->id);

        foreach ($thatPartCTeacherList as $thatPartCTeacher) {
            $partCTeacher = (new PartCTeacher)->create([
                'part_c_id' => $partC->id,
                'teacher_id' => $thatPartCTeacher->teacher_id,
                'number' => $thatPartCTeacher->number,
                'membership_id' => $thatPartCTeacher->membership_id,
                'given_name' => $thatPartCTeacher->given_name,
                'family_name' => $thatPartCTeacher->family_name,
            ]);
            PartCTeacher::check($partCTeacher->id);
            // PartC::check($partC->id);
        }
        PartC::check($partC->id);

        $partD = (new PartD)->create([
            'application_id' => $application->id,
            'applicant_id' => $thatPartD->applicant_id,
            'applicant_name' => $thatPartD->applicant_name,
            'membership_id' => $thatPartD->membership_id,
            'identity_id' => $thatPartD->identity_id,
            'address_1' => $thatPartD->address_1,
            'address_2' => $thatPartD->address_2,
            'address_3' => $thatPartD->address_3,
            'post_code' => $thatPartD->post_code,
            'tel' => $thatPartD->tel,
            'fax' => $thatPartD->fax,
            'email' => $thatPartD->email,
            'delivery_date' => $thatPartD->delivery_date,
            'neighbour' => $thatPartD->neighbour,
        ]);
        PartD::check($partD->id);
        // Application::check($application->id);

        $partE = (new PartE)->create([
            'application_id' => $application->id,
        ]);
        PartE::check($partE->id);
        // Application::check($application->id);

        $partF = (new PartF)->create([
            'application_id' => $application->id,
            'applicant_id' => $thatPartF->applicant_id,
            'applicant_name' => $thatPartF->applicant_name,
        ]);
        PartF::check($partF->id);
        // Application::check($application->id);

        $exam = (new Exam)->create([
            'application_id' => $application->id,
        ]);
        Exam::check($exam->id);

        Application::check($application->id);

        return redirect('/admin/exam/' . $exam->id);

    }

}