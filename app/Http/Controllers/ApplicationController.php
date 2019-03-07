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
                if (!Permission::userHasPermission($userId, 'admin') && !Permission::userHasPermission($userId, 'secondary_admin') ) {
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

}