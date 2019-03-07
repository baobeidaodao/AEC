<?php

namespace Tests\Unit;

use App\Models\Group;
use App\Models\PartE;
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
        foreach ($partEList as $partE){
            $applicationId = $partE['application_id'];
            PartE::calculate($applicationId);
        }
        dd(1);
    }
}
