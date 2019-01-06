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
use App\Models\ExamType;
use App\Models\Group;
use App\Models\Level;
use App\Models\PartE;
use App\Models\Rest;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{
    private $active = 'application';
    private $nav = 'group';

    public function index(Request $request)
    {
        $sectionId = Input::get('section_id');
        $groupList = Group::with(['section', 'level', 'examType', 'rest',])
            ->where(function ($query) use ($sectionId) {
                if (isset($sectionId) && !empty($sectionId)) {
                    $query->where('section_id', '=', $sectionId);
                }
            })
            ->get()
            ->toArray();
        $section = [];
        if (isset($sectionId) && !empty($sectionId)) {
            $section = Section::find($sectionId);
            if (isset($section) && !empty($section)) {
                $section = $section->toArray();
            }
        }
        $exam = [];
        if (isset($section) && !empty($section['exam_id'])) {
            $exam = Exam::find($section['exam_id']);
            if (isset($exam) && !empty($exam)) {
                $exam = $exam->toArray();
            }
        }
        $application = [];
        if (isset($exam) && isset($exam['application_id'])) {
            $applicationId = $exam['application_id'];
            $application = Application::with(Application::WITH)->find($applicationId);
            if ($application) {
                $application = $application->toArray();
            }
        }
        $data = [];
        $data['active'] = $this->active;
        $data['nav'] = $this->nav;
        $data['application'] = $application;
        $data['exam'] = $exam;
        $data['section'] = $section;
        $data['groupList'] = $groupList;
        return view('group.index', $data);
    }

    public function create(Request $request)
    {
        $data = [];
        Validator::make($request->all(), [
            'section_id' => 'required',
        ])->validate();
        $sectionId = Input::get('section_id');
        $section = [];
        if (isset($sectionId) && !empty($sectionId)) {
            $section = Section::with(['groupList'])->find($sectionId);
            if (isset($section) && !empty($section)) {
                $section = $section->toArray();
            }
        }
        $exam = [];
        if (isset($section) && !empty($section['exam_id'])) {
            $exam = Exam::find($section['exam_id']);
            if (isset($exam) && !empty($exam)) {
                $exam = $exam->toArray();
            }
        }
        $application = [];
        if (isset($exam) && isset($exam['application_id'])) {
            $applicationId = $exam['application_id'];
            $application = Application::with(Application::WITH)->find($applicationId);
            if ($application) {
                $application = $application->toArray();
            }
        }
        $levelList = Level::all()->toArray();
        $examTypeList = ExamType::all()->toArray();
        $restList = Rest::all()->toArray();
        $data['active'] = $this->active;
        $data['nav'] = $this->nav;
        $data['application'] = $application;
        $data['exam'] = $exam;
        $data['section'] = $section;
        $data['levelList'] = $levelList;
        $data['examTypeList'] = $examTypeList;
        $data['restList'] = $restList;
        return view('group.create', $data);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'section_id' => 'required',
            'number' => 'required|max:255',
            'level_id' => 'required|max:255',
            'exam_type_id' => 'required|max:255',
            'rest_id' => 'required|max:255',
        ])->validate();
        $group = (new Group)->create([
            'section_id' => $request->section_id,
            'number' => $request->number,
            'exam_time' => $request->exam_time,
            'level_id' => $request->level_id,
            'exam_type_id' => $request->exam_type_id,
            'rest_id' => $request->rest_id,
        ]);
        Section::calculate($request->section_id);
        $application = Section::findApplicationBySectionId($request->section_id);
        PartE::calculate($application->id);
        Group::check($group->id);
        $section = (new Section)->findOrFail($request->section_id);
        $examId = $section->exam_id;
        return redirect('admin/exam/' . $examId);
    }

    public function show($id)
    {
        $group = Group::with(['section', 'level', 'examType', 'rest',])->find($id);
        if ($group) {
            $group = $group->toArray();
        } else {
            $group = [];
        }
        $section = [];
        if (isset($group) && isset($group['section_id'])) {
            $section = Section::find($group['section_id']);
            if (isset($section) && !empty($section)) {
                $section = $section->toArray();
            }
        }
        $exam = [];
        if (isset($section) && !empty($section['exam_id'])) {
            $exam = Exam::find($section['exam_id']);
            if (isset($exam) && !empty($exam)) {
                $exam = $exam->toArray();
            }
        }
        $application = [];
        if (isset($exam) && isset($exam['application_id'])) {
            $applicationId = $exam['application_id'];
            $application = Application::with(Application::WITH)->find($applicationId);
            if ($application) {
                $application = $application->toArray();
            }
        }
        $data = [];
        $data['active'] = $this->active;
        $data['nav'] = $this->nav;
        $data['group'] = $group;
        $data['section'] = $section;
        $data['exam'] = $exam;
        $data['application'] = $application;
        return view('group.show', $data);
    }

    public function edit($id)
    {
        $data = [];
        $group = Group::with(['section', 'level', 'examType', 'rest',])->find($id);
        if ($group) {
            $group = $group->toArray();
        } else {
            $group = [];
        }
        $section = [];
        if (isset($group) && isset($group['section_id'])) {
            $section = Section::find($group['section_id']);
            if (isset($section) && !empty($section)) {
                $section = $section->toArray();
            }
        }
        $exam = [];
        if (isset($section) && !empty($section['exam_id'])) {
            $exam = Exam::find($section['exam_id']);
            if (isset($exam) && !empty($exam)) {
                $exam = $exam->toArray();
            }
        }
        $application = [];
        if (isset($exam) && isset($exam['application_id'])) {
            $applicationId = $exam['application_id'];
            $application = Application::with(Application::WITH)->find($applicationId);
            if ($application) {
                $application = $application->toArray();
            }
        }
        $levelList = Level::all()->toArray();
        $examTypeList = ExamType::all()->toArray();
        $restList = Rest::all()->toArray();
        $data['active'] = $this->active;
        $data['nav'] = $this->nav;
        $data['application'] = $application;
        $data['exam'] = $exam;
        $data['section'] = $section;
        $data['group'] = $group;
        $data['levelList'] = $levelList;
        $data['examTypeList'] = $examTypeList;
        $data['restList'] = $restList;
        return view('group.edit', $data);
    }

    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'section_id' => 'required',
            'number' => 'required|max:255',
            'level_id' => 'required|max:255',
            'exam_type_id' => 'required|max:255',
        ])->validate();
        $group = (new Group)->findOrFail($id);
        $group->fill([
            'section_id' => $request->section_id,
            'number' => $request->number,
            'exam_time' => $request->exam_time,
            'level_id' => $request->level_id,
            'exam_type_id' => $request->exam_type_id,
            'rest_id' => $request->rest_id,
        ])->save();
        Section::calculate($request->section_id);
        $application = Section::findApplicationBySectionId($request->section_id);
        PartE::calculate($application->id);
        Group::check($group->id);
        $section = (new Section)->findOrFail($request->section_id);
        $examId = $section->exam_id;
        return redirect('admin/exam/' . $examId);
    }

    public function destroy($id)
    {
        $group = (new Group)->findOrFail($id);
        $sectionId = $group->section_id;
        $section = (new Section)->findOrFail($sectionId);
        $examId = $section->exam_id;
        try {
            $group->delete();
            $groupList = (new Group)->where('section_id', $sectionId)->orderBy('id', 'asc')->get();
            $i = 1;
            foreach ($groupList as $item) {
                $item->number = $i;
                $item->save();
                $i++;
            }
        } catch (\Exception $e) {
            return redirect()->back();
        }
        return redirect('admin/exam/' . $examId);
    }

}