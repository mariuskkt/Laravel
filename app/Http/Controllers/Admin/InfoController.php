<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

class InfoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
    }

    public function index($id)
    {
        dump('neveikia dumpas' . $id);
        return view('home');
    }
}
