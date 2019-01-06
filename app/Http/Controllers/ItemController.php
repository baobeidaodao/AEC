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
use App\Models\Item;
use App\Models\ItemPartCTeacher;
use App\Models\Level;
use App\Models\PartCTeacher;
use App\Models\PartE;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    private $active = 'application';
    private $nav = 'item';

    public function index(Request $request)
    {
        $groupId = Input::get('group_id');
        $itemList = Item::with(['group', 'student',])
            ->where(function ($query) use ($groupId) {
                if (isset($groupId) && !empty($groupId))
                    $query->where('group_id', '=', $groupId);
            })
            ->get()
            ->toArray();
        $group = [];
        if (isset($groupId) && !empty($groupId)) {
            $group = Group::find($groupId);
            if (isset($group) && !empty($group)) {
                $group = $group->toArray();
            }
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
        $data['itemList'] = $itemList;
        return view('item.index', $data);
    }

    public function create(Request $request)
    {
        Validator::make($request->all(), [
            'group_id' => 'required',
        ])->validate();
        $groupId = Input::get('group_id');
        $group = Group::with(['itemList',])->find($groupId);
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
        $studentList = Student::all()->toArray();
        $examTypeList = ExamType::all()->toArray();
        $data = [];
        $partCTeacherList = PartCTeacher::where('part_c_id', '=', $application['part_c']['id'])->get()->toArray();
        $data['active'] = $this->active;
        $data['nav'] = $this->nav;
        $data['group'] = $group;
        $data['section'] = $section;
        $data['exam'] = $exam;
        $data['application'] = $application;
        $data['levelList'] = $levelList;
        $data['examTypeList'] = $examTypeList;
        $data['studentList'] = $studentList;
        $data['partCTeacherList'] = $partCTeacherList;
        $birthDate = Group::birthDate($groupId);
        $data['birthDate'] = $birthDate;
        return view('item.create', $data);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'group_id' => 'required',
            'number' => 'required|max:255',
            'student_number' => 'required|max:255',
            'given_name' => 'required|regex:/^[A-Z]{1}[a-z]+[A-Za-z\s]*$/|max:255',
            'family_name' => 'required|regex:/^[A-Z]{1}[a-z]+$/|max:255',
            'member' => 'required|max:255',
            'birth_date' => 'required|max:255',
            'sex' => 'required|max:255',
            'part_c_teacher_id' => 'required|max:255',
        ])->validate();
        if (isset($request->student_number) && !empty($request->student_number)) {
            $student = Student::where('number', '=', $request->student_number)->first();
        }
        if (isset($student) && !empty($student)) {
            $student->fill([
                'number' => $request->student_number,
                'given_name' => $request->given_name,
                'family_name' => $request->family_name,
                'member' => $request->member,
                'birth_date' => date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $request->birth_date))),
                'sex' => $request->sex,
            ])->save();
        } else {
            $student = (new Student)->create([
                'number' => $request->student_number,
                'given_name' => $request->given_name,
                'family_name' => $request->family_name,
                'member' => $request->member,
                'birth_date' => date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $request->birth_date))),
                'sex' => $request->sex,
            ]);
        }
        $studentId = $student->id;
        $item = (new Item)->create([
            'group_id' => $request->group_id,
            'number' => $request->number,
            'student_id' => $studentId,
            'student_number' => $request->student_number,
            'given_name' => $request->given_name,
            'family_name' => $request->family_name,
            'member' => $request->member,
            'birth_date' => date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $request->birth_date))),
            'sex' => $request->sex,
        ]);
        $itemId = $item->id;
        $partCTeacherIdArray = Input::get('part_c_teacher_id', []);
        ItemPartCTeacher::where('item_id', '=', $itemId)->update([
            'status' => 0
        ]);
        foreach ($partCTeacherIdArray as $partCTeacherId) {
            ItemPartCTeacher::updateOrCreate([
                'item_id' => $itemId,
                'part_c_teacher_id' => $partCTeacherId,
            ], [
                'status' => 1,
            ]);
        }
        Item::check($item->id);
        $group = (new Group)->findOrFail($request->group_id);
        $sectionId = $group->section_id;
        Section::calculate($sectionId);
        $section = (new Section)->findOrFail($sectionId);
        $application = Section::findApplicationBySectionId($section->id);
        PartE::calculate($application->id);
        $examId = $section->exam_id;
        return redirect('admin/exam/' . $examId);
    }

    public function show($id)
    {
        $item = Item::with(['group', 'student',])->find($id);
        if ($item) {
            $item = $item->toArray();
        } else {
            $item = [];
        }
        $group = [];
        if (isset($item) && isset($item['group_id'])) {
            $group = Group::find($item['group_id']);
            if (isset($group) && !empty($group)) {
                $group = $group->toArray();
            }
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
        $data['application'] = $application;
        $data['exam'] = $exam;
        $data['section'] = $section;
        $data['group'] = $group;
        $data['item'] = $item;
        return view('item.show', $data);
    }

    public function edit($id)
    {
        $item = Item::with(array_merge(Item::WITH, ['itemPartCTeacherList' => function ($query) {
            $query->with(['partCTeacher']);
        }]))->find($id);
        if ($item) {
            $item = $item->toArray();
        } else {
            $item = [];
        }
        $group = [];
        if (isset($item) && isset($item['group_id'])) {
            $group = Group::find($item['group_id']);
            if (isset($group) && !empty($group)) {
                $group = $group->toArray();
            }
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
        $partCTeacherList = PartCTeacher::where('part_c_id', '=', $application['part_c']['id'])->get()->toArray();
        $partCTeacherIdList = ItemPartCTeacher::where('item_id', '=', $item['id'])
            ->where('status', '=', 1)
            ->pluck('part_c_teacher_id')
            ->toArray();
        $levelList = Level::all()->toArray();
        $studentList = Student::all()->toArray();
        $examTypeList = ExamType::all()->toArray();
        $data = [];
        $data['active'] = $this->active;
        $data['nav'] = $this->nav;
        $data['application'] = $application;
        $data['exam'] = $exam;
        $data['section'] = $section;
        $data['group'] = $group;
        $data['item'] = $item;
        $data['levelList'] = $levelList;
        $data['studentList'] = $studentList;
        $data['examTypeList'] = $examTypeList;
        $data['partCTeacherList'] = $partCTeacherList;
        $data['partCTeacherIdList'] = $partCTeacherIdList;
        $birthDate = Group::birthDate($group['id']);
        $data['birthDate'] = $birthDate;
        return view('item.edit', $data);
    }

    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'group_id' => 'required',
            'number' => 'required|max:255',
            'student_number' => 'required|max:255',
            'given_name' => 'required|regex:/^[A-Z]{1}[a-z]+[A-Za-z\s]*$/|max:255',
            'family_name' => 'required|regex:/^[A-Z]{1}[a-z]+$/|max:255',
            'member' => 'required|max:255',
            'birth_date' => 'required|max:255',
            'sex' => 'required|max:255',
            'part_c_teacher_id' => 'required|max:255',
        ])->validate();
        if (isset($request->student_number) && !empty($request->student_number)) {
            $student = Student::where('number', '=', $request->student_number)->first();
        }
        if (isset($student) && !empty($student)) {
            $student->fill([
                'number' => $request->student_number,
                'given_name' => $request->given_name,
                'family_name' => $request->family_name,
                'member' => $request->member,
                'birth_date' => date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $request->birth_date))),
                'sex' => $request->sex,
            ])->save();
        } else {
            $student = (new Student)->create([
                'number' => $request->student_number,
                'given_name' => $request->given_name,
                'family_name' => $request->family_name,
                'member' => $request->member,
                'birth_date' => date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $request->birth_date))),
                'sex' => $request->sex,
            ]);
        }
        $studentId = $student->id;
        $item = (new Item)->findOrFail($id);
        $item->fill([
            'group_id' => $request->group_id,
            'number' => $request->number,
            'student_id' => $studentId,
            'student_number' => $request->student_number,
            'given_name' => $request->given_name,
            'family_name' => $request->family_name,
            'member' => $request->member,
            'birth_date' => date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $request->birth_date))),
            'sex' => $request->sex,
        ])->save();
        $itemId = $item->id;
        $partCTeacherIdArray = Input::get('part_c_teacher_id', []);
        ItemPartCTeacher::where('item_id', '=', $itemId)->update([
            'status' => 0
        ]);
        foreach ($partCTeacherIdArray as $partCTeacherId) {
            ItemPartCTeacher::updateOrCreate([
                'item_id' => $itemId,
                'part_c_teacher_id' => $partCTeacherId,
            ], [
                'status' => 1,
            ]);
        }
        Item::check($item->id);
        $group = (new Group)->findOrFail($request->group_id);
        $sectionId = $group->section_id;
        $section = (new Section)->findOrFail($sectionId);
        Section::calculate($sectionId);
        $examId = $section->exam_id;
        $application = Section::findApplicationBySectionId($section->id);
        PartE::calculate($application->id);
        return redirect('admin/exam/' . $examId);
    }

    public function destroy($id)
    {
        $item = (new Item)->findOrFail($id);
        $group = (new Group)->findOrFail($item->group_id);
        try {
            $item->delete();
        } catch (\Exception $e) {
            return redirect()->back();
        }
        $sectionId = $group->section_id;
        $section = (new Section)->findOrFail($sectionId);
        $examId = $section->exam_id;
        return redirect('admin/exam/' . $examId);
    }

}