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
use App\Models\PartE;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class SectionController extends Controller
{
    private $active = 'application';
    private $nav = 'section';

    public function index(Request $request)
    {
        $examId = Input::get('exam_id');
        $sectionList = Section::with(['exam',])
            ->where(function ($query) use ($examId) {
                if (isset($examId) && !empty($examId)) {
                    $query->where('exam_id', '=', $examId);
                }
            })
            ->get()->toArray();
        $exam = [];
        if (isset($examId) && !empty($examId)) {
            $exam = Exam::find($examId);
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
        $data['sectionList'] = $sectionList;
        return view('section.index', $data);
    }

    public function create(Request $request)
    {
        Validator::make($request->all(), [
            'exam_id' => 'required',
        ])->validate();
        $examId = Input::get('exam_id');
        $exam = Exam::with(['sectionList'])->find($examId);
        if ($exam) {
            $exam = $exam->toArray();
        } else {
            $exam = [];
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
        return view('section.create', $data);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'exam_id' => 'required',
            'number' => 'required|max:255',
            'exam_time' => 'required|max:255',
        ], [
            'exam_time.required' => 'Exam Time is required. Exam Time 为必填项',
        ])->validate();
        if (!preg_match('/^[0-2]{1}[0-9]{1}(:|：)[0-5]{1}[0-9]{1}$/', $request->exam_time)) {
            return back()->withErrors('Exam Time is invalid. Exam Time 格式错误');
        }
        $request->exam_time = str_replace('：', ':', $request->exam_time);
        $section = (new Section)->create([
            'exam_id' => $request->exam_id,
            'number' => $request->number,
            'exam_time' => date('Y-m-d ') . $request->exam_time . ':00',
            'finish_time' => date('Y-m-d ') . $request->exam_time . ':00',
        ]);
        Section::check($section->id);
        Section::calculate($section->id);
        $application = Section::findApplicationBySectionId($section->id);
        PartE::calculate($application->id);
        return redirect('admin/exam/' . $request->exam_id);
    }

    public function show($id)
    {
        $section = Section::with(['exam',])->find($id);
        if ($section) {
            $section = $section->toArray();
        } else {
            $section = [];
        }
        $exam = [];
        if (isset($section) && isset($section['exam_id'])) {
            $examId = $section['exam_id'];
            $exam = Exam::find($examId);
            if ($exam) {
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
        return view('section.show', $data);
    }

    public function edit($id)
    {
        $section = Section::with(['exam',])->find($id);
        if ($section) {
            $section = $section->toArray();
        } else {
            $section = [];
        }
        $exam = [];
        if (isset($section) && isset($section['exam_id'])) {
            $examId = $section['exam_id'];
            $exam = Exam::find($examId);
            if ($exam) {
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
        return view('section.edit', $data);
    }

    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'exam_id' => 'required',
            'number' => 'required|max:255',
            'exam_time' => 'required|max:255',
        ], [
            'exam_time.required' => 'Exam Time is required. Exam Time 为必填项',
        ])->validate();
        if (!preg_match('/^[0-2]{1}[0-9]{1}(:|：)[0-5]{1}[0-9]{1}$/', $request->exam_time)) {
            return back()->withErrors('Exam Time is invalid. Exam Time 格式错误');
        }
        $request->exam_time = str_replace('：', ':', $request->exam_time);
        $section = (new Section)->findOrFail($id);
        $section->fill([
            'exam_id' => $request->exam_id,
            'number' => $request->number,
            'exam_time' => date('Y-m-d ') . $request->exam_time . ':00',
        ])->save();
        Section::calculate($section->id);
        $application = Section::findApplicationBySectionId($section->id);
        PartE::calculate($application->id);
        Section::check($section->id);
        return redirect('admin/exam/' . $request->exam_id);
    }

    public function destroy($id)
    {
        $section = (new Section)->findOrFail($id);
        $application = Section::findApplicationBySectionId($section->id);
        $examId = $section->exam_id;
        try {
            $section->delete();
            $sectionList = (new Section)->where('exam_id', $examId)->orderBy('id', 'asc')->get();
            $i = 1;
            foreach ($sectionList as $item) {
                $item->number = $i;
                $item->save();
                $i++;
            }
            PartE::calculate($application->id);
        } catch (\Exception $e) {
            return redirect()->back();
        }
        return redirect('admin/exam/' . $examId);
    }

}