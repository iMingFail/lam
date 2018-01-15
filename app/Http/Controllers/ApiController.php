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
		'show'=>'0',
		'show_txt'=>'您好！您的系统未授权，请3天内联系QQ1054895115进行授权使用。',
		'state'=>'1',
		'type'=>'1'
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
			if($field=='ip'){
				$tag->$field = $this->getIP();
				continue;
			}
			if($field=='domain'){
				$tag->$field = $request->get($field);
				continue;
			}
            $tag->$field = $fieldv;
        }
        $tag->save();
	}
	public function getIP() { 
		if (getenv('HTTP_CLIENT_IP')) { 
			$ip = getenv('HTTP_CLIENT_IP'); 
		} 
		elseif (getenv('HTTP_X_FORWARDED_FOR')) { 
			$ip = getenv('HTTP_X_FORWARDED_FOR'); 
		} 
		elseif (getenv('HTTP_X_FORWARDED')) { 
			$ip = getenv('HTTP_X_FORWARDED'); 
		} 
		elseif (getenv('HTTP_FORWARDED_FOR')) { 
			$ip = getenv('HTTP_FORWARDED_FOR'); 

		} 
		elseif (getenv('HTTP_FORWARDED')) { 
			$ip = getenv('HTTP_FORWARDED'); 
		} 
		else { 
			$ip = $_SERVER['REMOTE_ADDR']; 
		} 
		return $ip; 
	}
	public function a(Request $request){
		$auth = Cfzxauth::where('ip',''.$this->getIP())->where('show',1)->first();
		if(!$auth){
			echo " ";
		}else{
			echo $auth['show_txt'];
		}
		
	}
}
