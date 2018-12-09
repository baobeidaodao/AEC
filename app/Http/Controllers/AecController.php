<?php
/**
 * Created by PhpStorm.
 * User: DaoDao
 * Date: 2018-11-21
 * Time: 14:45
 */

namespace App\Http\Controllers;


class AecController extends Controller
{
    private $active = 'index';

    public function index()
    {
        $data = [];
        $data['active'] = $this->active;
        return view('index', $data);
    }

}