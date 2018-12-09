<?php
/**
 * Created by PhpStorm.
 * User: DaoDao
 * Date: 2018-11-22
 * Time: 14:39
 */

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Exam;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ExamController extends Controller
{
    private $active = 'application';
    private $nav = 'exam';

    public function index(Request $request)
    {
        $applicationId = Input::get('application_id');
        $examList = Exam::with([
            'application',
            'sectionList' => function ($query) {
                $query->with([
                    'groupList' => function ($query) {
                        $query->with(['level', 'examType', 'itemList' => function ($query) {
                            $query->with(Item::WITH);
                        },]);
                    },
                ]);
            },
        ])
            ->where(function ($query) use ($applicationId) {
                if (isset($applicationId) && !empty($applicationId))
                    $query->where('application_id', '=', $applicationId);
            })
            ->get()
            ->toArray();
        $application = [];
        if (isset($applicationId) && !empty($applicationId)) {
            $application = Application::with(Application::WITH)->find($applicationId);
            if (isset($application) && !empty($application)) {
                $application = $application->toArray();
            }
        }
        $data = [];
        $data['active'] = $this->active;
        $data['nav'] = $this->nav;
        $data['application'] = $application;
        $data['examList'] = $examList;
        return view('exam.index', $data);
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
        return view('exam.create', $data);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'application_id' => 'required',
        ])->validate();
        $exam = (new Exam)->create([
            'application_id' => $request->application_id,
        ]);
        Exam::check($exam->id);
        return redirect('admin/exam/' . $exam->id);
    }

    public function show($id)
    {
        $exam = Exam::with([
            'application' => function ($query) {
                $query->with([
                    'partC' => function ($query) {
                        $query->with(['partCTeacherList']);
                    },
                ]);
            },
            'sectionList' => function ($query) {
                $query->with([
                    'groupList' => function ($query) {
                        $query->with(['level', 'examType', 'itemList' => function ($query) {
                            $query->with(array_merge(Item::WITH, ['itemPartCTeacherList' => function ($query) {
                                $query->with(['partCTeacher']);
                            }]));
                        },]);
                    },
                ]);
            },
        ])
            ->find($id);
        if ($exam) {
            $exam = $exam->toArray();
        } else {
            $exam = [];
        }
        // dd($exam);
        $applicationId = $exam['application_id'];
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
        $data['exam'] = $exam;
        return view('exam.show', $data);
    }

    public function edit($id)
    {
        $exam = Exam::with(['application',])->find($id);
        if ($exam) {
            $exam = $exam->toArray();
        } else {
            $exam = [];
        }
        $applicationId = $exam['application_id'];
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
        $data['exam'] = $exam;
        return view('exam.edit', $data);
    }

    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'application_id' => 'required',
        ])->validate();
        $exam = (new Exam)->findOrFail($id);
        $exam->fill([
            'application_id' => $request->application_id,
        ])->save();
        Exam::check($exam->id);
        return redirect('admin/exam/' . $id);
    }

    public function destroy($id)
    {
        $exam = (new Exam)->findOrFail($id);
        try {
            $exam->delete();
        } catch (\Exception $e) {
            return redirect()->back();
        }
        return redirect('admin/application');
    }

}