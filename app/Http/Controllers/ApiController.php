<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin\Cfzxauth;
class ApiController extends Controller
{
	protected $cfzxauth = [
        'ip'=>'',
		'domain'=>'',
		'remarks'=>'',
		'show'=>0,
		'show_txt'=>'您好！您的系统未授权，请联系QQ214884460进行授权使用。3天内不联系则后果自负',
		'state'=>1,
		'type'=>1
    ];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home.index.index');
    }
	//插入授权
	public function i(Request $request){
		$tag = new Cfzxauth();
        foreach ($this->cfzxauth as $field=>$fieldv) {
            $tag->$field = isset($request->get($field))?$request->get($field):$fieldv;
        }
        $tag->save();
	}
}
