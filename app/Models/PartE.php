<?php
/**
 * Created by PhpStorm.
 * User: DaoDao
 * Date: 2018-11-20
 * Time: 15:34
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

class PartE extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table = 'part_e';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $guarded = [];

    const CHECK_VALID = 1;
    const CHECK_INVALID = 0;

    const FEE = [
        'ex_pid' => 410,
        'ex_g1' => 445,
        'ex_g2' => 490,
        'ex_g3' => 525,
        'ex_g4' => 560,
        'ex_g5' => 595,
        'ex_g6' => 615,
        'ex_g7' => 640,
        'ex_g8' => 675,
        'ex_intf' => 810,
        'ex_int' => 915,
        'ex_advf' => 1520,
        'ex_advf_m' => 940,
        'ex_adv1' => 1550,
        'ex_adv1_m' => 970,
        'ex_adv2' => 1570,
        'ex_adv2_m' => 1000,
        'ex_ss' => 0,
        'ex_r2c' => 300,
        'ex_r2v1' => 300,
        'ex_r2v2' => 300,
        'ex_r3c' => 360,
        'ex_r3v1' => 360,
        'ex_r3v2' => 360,
        'ex_r4c' => 420,
        'ex_r4v1' => 420,
        'ex_r4v2' => 420,
        'dc_dc1' => 115,
        'dc_dc2' => 115,
        'ca_ppid' => 250,
        'ca_pid' => 280,
        'ca_g1' => 310,
        'ca_g2' => 350,
        'ca_g3' => 375,
        'ca_g4' => 410,
        'ca_g5' => 445,
        'ca_r2c' => 200,
        'ca_r2v1' => 200,
        'ca_r2v2' => 200,
        'ca_r3c' => 240,
        'ca_r3v1' => 240,
        'ca_r3v2' => 240,
        'ca_r4c' => 280,
        'ca_r4v1' => 280,
        'ca_r4v2' => 280,
        'pc_g6' => 470,
        'pc_g7' => 485,
        'pc_g8' => 500,
        'spa_g1' => 275,
        'spa_g2' => 310,
        'spa_g3' => 350,
        'spa_g4' => 365,
        'spa_g5' => 400,
    ];

    const MEMBER_LEVEL = [
        'advf',
        'adv1',
        'adv2',
    ];

    public function application()
    {
        return $this->hasOne(Application::class, 'id', 'application_id');
    }

    public static function check($id)
    {
        $partE = self::find($id);
        if (!isset($partE) || empty($partE)) {
            return;
        }
        if (
            isset($partE->application_id) && !empty($partE->application_id)
        ) {
            $partE->check = self::CHECK_VALID;
        } else {
            $partE->check = self::CHECK_INVALID;
        }
        $partE->save();
        return $partE;
    }

    public static function calculate($applicationId)
    {
        $partE = PartE::where('application_id', '=', $applicationId)->first();
        $columnArray = Schema::getColumnListing('part_e');
        $groupList = Group::with(['level', 'examType', 'itemList'])
            ->join('section', 'section.id', '=', 'group.section_id')
            ->join('exam', 'exam.id', '=', 'section.exam_id')
            ->where('exam.application_id', '=', $applicationId)
            ->get();
        foreach ($groupList as $group) {
            $attribute = strtolower($group->examType->code) . '_' . strtolower($group->level->code);
            $attributeM = '';
            if (in_array(strtolower($group->level->code), self::MEMBER_LEVEL)) {
                $attributeM = $attribute . '_m';
            }
            if (!in_array($attribute, $columnArray) || (isset($attributeM) && !in_array($attributeM, $columnArray))) {
                continue;
            }
            if (!in_array(strtolower($group->level->code), self::MEMBER_LEVEL)) {
                $count = count($group->itemList);
                $attributeCount = $attribute . 'Count';
                if (!isset($$attributeCount)) {
                    $$attributeCount = 0;
                }
                $$attributeCount = $$attributeCount + $count;
                $partE->$attribute = $$attributeCount;
            } else {
                $itemList = $group->itemList;
                $attributeCount = $attribute . 'Count';
                if (!isset($$attributeCount)) {
                    $$attributeCount = 0;
                }
                $attributeMCount = $attributeM . 'Count';
                if (!isset($$attributeMCount)) {
                    $$attributeMCount = 0;
                }
                foreach ($itemList as $item) {
                    if (isset($item->member) && $item->member == 1) {
                        $$attributeMCount = $$attributeMCount + 1;
                    }else{
                        $$attributeCount = $$attributeCount + 1;
                    }
                }
                $partE->$attributeM = $$attributeMCount;
                $partE->$attribute = $$attributeCount;
            }
        }
        $partE->save();
    }

    public static function export($id)
    {
        $data = [];
        $head = [
            0 => '',
            1 => 'Examinations',
            2 => 'Demonstration / Presentation Classes / Class Awards',
            3 => 'Solo Performance Awards',
        ];
        $data['part_e'][] = $head;
        $partE = PartE::find($id);
        if (!$partE) {
            return $data;
        } else {
            $partE = $partE->toArray();
        }
        $data['part_e'][] = [
            0 => 'Demonstration Class L1/2',
            1 => '',
            2 => $partE['dc_dc1'] + $partE['dc_dc2'],
            3 => '',
        ];
        $data['part_e'][] = [
            0 => 'Pre-Primary in Dance',
            1 => '',
            2 => $partE['ca_ppid'],
            3 => '',
        ];
        $data['part_e'][] = [
            0 => 'Primary in Dance',
            1 => $partE['ex_pid'],
            2 => $partE['ca_pid'],
            3 => '',
        ];
        $data['part_e'][] = [
            0 => 'Grade 1',
            1 => $partE['ex_g1'],
            2 => $partE['ca_g1'],
            3 => $partE['spa_g1'],
        ];
        $data['part_e'][] = [
            0 => 'Grade 2',
            1 => $partE['ex_g2'],
            2 => $partE['ca_g2'],
            3 => $partE['spa_g2'],
        ];
        $data['part_e'][] = [
            0 => 'Grade 3',
            1 => $partE['ex_g3'],
            2 => $partE['ca_g3'],
            3 => $partE['spa_g3'],
        ];
        $data['part_e'][] = [
            0 => 'Grade 4',
            1 => $partE['ex_g4'],
            2 => $partE['ca_g4'],
            3 => $partE['spa_g4'],
        ];
        $data['part_e'][] = [
            0 => 'Grade 5',
            1 => $partE['ex_g5'],
            2 => $partE['ca_g5'],
            3 => $partE['spa_g5'],
        ];
        $data['part_e'][] = [
            0 => 'Grade 6',
            1 => $partE['ex_g6'],
            2 => $partE['pc_g6'],
            3 => '',
        ];
        $data['part_e'][] = [
            0 => 'Grade 7',
            1 => $partE['ex_g7'],
            2 => $partE['pc_g7'],
            3 => '',
        ];
        $data['part_e'][] = [
            0 => 'Grade 8',
            1 => $partE['ex_g8'],
            2 => $partE['pc_g8'],
            3 => '',
        ];
        $data['part_e'][] = [
            0 => 'Intermediate Foundation',
            1 => $partE['ex_intf'],
            2 => '',
            3 => '',
        ];
        $data['part_e'][] = [
            0 => 'Intermediate',
            1 => $partE['ex_int'],
            2 => '',
            3 => '',
        ];
        $data['part_e'][] = [
            0 => 'Advanced Foundation',
            1 => $partE['ex_advf'],
            2 => '',
            3 => '',
        ];
        $data['part_e'][] = [
            0 => 'Adv F (Member)',
            1 => $partE['ex_advf_m'],
            2 => '',
            3 => '',
        ];
        $data['part_e'][] = [
            0 => 'Advanced 1',
            1 => $partE['ex_adv1'],
            2 => '',
            3 => '',
        ];
        $data['part_e'][] = [
            0 => 'Adv 1 (Member)',
            1 => $partE['ex_adv1_m'],
            2 => '',
            3 => '',
        ];
        $data['part_e'][] = [
            0 => 'Advanced 2',
            1 => $partE['ex_adv2'],
            2 => '',
            3 => '',
        ];
        $data['part_e'][] = [
            0 => 'Adv 2 (Member)',
            1 => $partE['ex_adv2_m'],
            2 => '',
            3 => '',
        ];
        $data['part_e'][] = [
            0 => 'Solo Seal Award',
            1 => $partE['ex_ss'],
            2 => '',
            3 => '',
        ];
        $data['part_e'][] = [
            0 => 'Classical Ballet Repertoire Level 2',
            1 => '',
            2 => '',
            3 => '',
        ];
        $data['part_e'][] = [
            0 => 'Discovering Repertoire Level 2 Class',
            1 => $partE['ex_r2c'],
            2 => $partE['ca_r2c'],
            3 => '',
        ];
        $data['part_e'][] = [
            0 => 'Discovering Repertoire Level 2 Variation 1',
            1 => $partE['ex_r2v1'],
            2 => $partE['ca_r2v1'],
            3 => '',
        ];
        $data['part_e'][] = [
            0 => 'Discovering Repertoire Level 2 Variation 2',
            1 => $partE['ex_r2v2'],
            2 => $partE['ca_r2v2'],
            3 => '',
        ];
        $data['part_e'][] = [
            0 => 'Classical Ballet Repertoire Level 3',
            1 => '',
            2 => '',
            3 => '',
        ];
        $data['part_e'][] = [
            0 => 'Discovering Repertoire Level 3 Class',
            1 => $partE['ex_r3c'],
            2 => $partE['ca_r3c'],
            3 => '',
        ];
        $data['part_e'][] = [
            0 => 'Discovering Repertoire Level 3 Variation 1',
            1 => $partE['ex_r3v1'],
            2 => $partE['ca_r3v1'],
            3 => '',
        ];
        $data['part_e'][] = [
            0 => 'Discovering Repertoire Level 3 Variation 2',
            1 => $partE['ex_r3v2'],
            2 => $partE['ca_r3v2'],
            3 => '',
        ];
        $data['part_e'][] = [
            0 => 'Classical Ballet Repertoire Level 4',
            1 => '',
            2 => '',
            3 => '',
        ];
        $data['part_e'][] = [
            0 => 'Discovering Repertoire Level 4 Class',
            1 => $partE['ex_r4c'],
            2 => $partE['ca_r4c'],
            3 => '',
        ];
        $data['part_e'][] = [
            0 => 'Discovering Repertoire Level 4 Variation 1',
            1 => $partE['ex_r4v1'],
            2 => $partE['ca_r4v1'],
            3 => '',
        ];
        $data['part_e'][] = [
            0 => 'Discovering Repertoire Level 4 Variation 2',
            1 => $partE['ex_r4v2'],
            2 => $partE['ca_r4v2'],
            3 => '',
        ];
        return $data;
    }
}