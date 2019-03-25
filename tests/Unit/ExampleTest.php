<?php

namespace Tests\Unit;

use App\Models\Exam;
use App\Models\Group;
use App\Models\PartA;
use App\Models\PartC;
use App\Models\PartCTeacher;
use App\Models\PartE;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }

    public function test1()
    {
        $pattern = '/^[A-Z]{1}[a-z]*([\s\-]{1}[A-Z]{1}[a-z]*)*$/';
        $string = 'Cheong-Leen';
        $b = preg_match($pattern, $string);
        $string = 'Cheong Leen';
        $b = preg_match($pattern, $string);
        $string = 'Cheong L';
        $b = preg_match($pattern, $string);
    }

    public function test2()
    {
        $applicationId = 24;
        $groupList = Group::with([
            'level' => function ($query) {
                $query->where('level.code', 'PPID');
            },
            'examType', 'itemList',
        ])
            ->join('section', 'section.id', '=', 'group.section_id')
            ->join('exam', 'exam.id', '=', 'section.exam_id')
            ->where('exam.application_id', '=', $applicationId)
            ->select(['group.*'])
//            ->get();
            ->toSql();
//        dd($groupList);

        PartE::calculate($applicationId);
        $partEList = PartE::all()->toArray();
        foreach ($partEList as $partE) {
            $applicationId = $partE['application_id'];
            PartE::calculate($applicationId);
        }
        dd(1);
    }

    public function test3()
    {
        $applicationId = 49;
        PartE::calculate($applicationId);
    }

    public function test4()
    {
        $examList = Exam::all();
        $count = 0;
        $a = [];
        foreach ($examList as $exam) {
            $examId = $exam->id;
            $countLimit = Exam::countLimit($examId);
            if ($countLimit['line'] >= $countLimit['limit']) {
                $count += 1;
                $a[] = $countLimit;
            }
        }

        dd($a);
    }

    public function test5()
    {
        $applicationId = 1;
        $thatPartA = (new PartA)->where('application_id', $applicationId)->whereNull('deleted_at')->first();
        $thatPartC = (new PartC)->where('application_id', $applicationId)->whereNull('deleted_at')->first();
        $thatPartCTeacherList = (new PartCTeacher)->where('part_c_id', $thatPartC->id)->whereNull('deleted_at')->orderBy('id', 'asc')->get();

        dd($thatPartCTeacherList);
    }

    public function test6()
    {

    }

}
