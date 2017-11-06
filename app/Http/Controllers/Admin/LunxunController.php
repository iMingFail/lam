<?php
namespace App\Http\Controllers\Admin;

use App\Models\Admin\Merchant;
use App\Models\Admin\Lunxun;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Excel;
class LunxunController extends Controller
{
    protected $fields = [
        'errorDetail'  => '',
        'state' => 0,
        'orderNum' => 0,
		'channlNum' => 0
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = array();
            $data['draw'] = $request->get('draw');
            $start = $request->get('start');
            $length = $request->get('length');
            $order = $request->get('order');
            $columns = $request->get('columns');
            $search = $request->get('search');
            $data['recordsTotal'] = Lunxun::count();
            if (strlen($search['value']) > 0) {
                $data['recordsFiltered'] = Lunxun::leftJoin('xunlian_merchants', 'xunlian_merchants.id', '=', 'xunlian_lunxuns.mid')
					->where(function ($query) use ($search) {
						$query->where('errorDetail', 'like', '%' . $search['value'] . '%')
							->orWhere('state', 'like', '%' . $search['value'] . '%')
							->orWhere('orderNum', 'like', '%' . $search['value'] . '%')
							->orWhere('channlNum', 'like', '%' . $search['value'] . '%')
							->orWhere('mchntid', 'like', '%' . $search['value'] . '%');
					})->count();
                $data['data'] = Lunxun::select('xunlian_lunxuns.*','xunlian_merchants.mchntid')
					->leftJoin('xunlian_merchants', 'xunlian_merchants.id', '=', 'xunlian_lunxuns.mid')
					->where(function ($query) use ($search) {
						$query->where('errorDetail', 'like', '%' . $search['value'] . '%')
							->orWhere('state', 'like', '%' . $search['value'] . '%')
							->orWhere('orderNum', 'like', '%' . $search['value'] . '%')
							->orWhere('channlNum', 'like', '%' . $search['value'] . '%')
							->orWhere('mchntid', 'like', '%' . $search['value'] . '%');
					})
                    ->skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get();
            } else {
                $data['recordsFiltered'] = $data['recordsTotal'];
                $data['data'] = Lunxun::select('xunlian_lunxuns.*','xunlian_merchants.mchntid')
					->leftJoin('xunlian_merchants', 'xunlian_merchants.id', '=', 'xunlian_lunxuns.mid')
					->skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get();
            }

            return response()->json($data);
        }

        return view('admin.lunxun.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }
        return view('admin.lunxun.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		ini_set('max_execution_time', '0');
		ini_set('memory_limit','1024M');
		$file = $request->file('file');
		$fileName = date('YmdHis').'.'.$file->getClientOriginalExtension();
		$path = Storage::put($fileName, file_get_contents($file->getRealPath()));
		$load = Excel::load(storage_path('./app/local/').$fileName, function($reader) {
			$data = $reader->getSheet(0)->toArray();
			ob_start(); 
			foreach($data as $key=>$v){
				if($key>0){
					$merchant = Merchant::where('mchntid',$v[0])->first();
					if(!$merchant){
						continue;
					}
					$channlNum = time().rand(1000,9999);
					$state = $this->checkrecharge($errorDetail,$channlNum,$v[2],$merchant->miyao,$v[0]);
					$tag = new Lunxun();
					$tag->errorDetail = $errorDetail;
					$tag->state = $state;
					$tag->orderNum = $v[2];
					$tag->channlNum = $channlNum;
					$tag->mid = $merchant->id;
					$tag->save();
					//usleep(50000);
				}
				if($key%5==0){
					ob_flush();
					//ob_end_clean();
				}
			}
		});
        event(new \App\Events\userActionEvent('\App\Models\Admin\Lunxun', 0, 1, '批量执行轮询' ));
        return redirect('/admin/lunxun')->withSuccess('批量处理成功！');
    }

	public function checkrecharge(&$errorDetail,$channlNum,$orderNum,$miyao,$mchntid,$inscd = '93081888'){
		$data = array();
		$qxdata = array();
		$data['version'] = "2.2";
		$data['signType'] = 'SHA256';
		$data['charset'] = 'utf-8';
		$data['origOrderNum'] = $orderNum;
		$data['busicd'] = 'INQY';
		//$data['respcd'] = '00';
		$data['inscd'] = $inscd;
		$data['mchntid'] = $mchntid;
		$data['terminalid'] = $inscd;
		$data['txndir'] = 'Q';
		ksort($data);
		$str = '';
		foreach($data as $k=>$v){
			if($str!=''){
				$str .= '&';
			}
			$str .= $k.'='.$v;
		}
		$str.= $miyao;
		$sign=hash("sha256", $str);
		$data['sign'] = $sign;
		$data=json_encode($data);
		$pc = json_decode(xlcurl('https://showmoney.cn/scanpay/unified',$data),true);
		$errorDetail = $pc['errorDetail'];
		if($pc['errorDetail']=='待买家支付'){ 
			$qxdata['busicd'] = 'CANC';
			$qxdata['charset'] = 'utf-8';
			$qxdata['inscd'] = $inscd;
			$qxdata['mchntid'] = $mchntid;
			$qxdata['orderNum'] = $channlNum;
			$qxdata['origOrderNum'] = $orderNum;
			$qxdata['signType'] = 'SHA256';
			$qxdata['terminalid'] = $inscd;
			$qxdata['txndir'] = 'Q';
			$qxdata['version'] = '2.2';
			ksort($qxdata);
			$str = '';
			foreach($qxdata as $k=>$v){
				if($str!=''){
					$str .= '&';
				}
				$str .= $k.'='.$v;
			}
			$str.= $miyao;
			$qxdata['sign'] = hash("sha256", $str);
			$qpc = json_decode(xlcurl('https://showmoney.cn/scanpay/unified',json_encode($qxdata)),true);
			return $qpc['errorDetail'];
		}
		return $pc['errorDetail'];
	}
    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tag = XunlianUser::find((int)$id);
        if (!$tag) return redirect('/admin/xunlian')->withErrors("找不到该商户!");
       
        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $tag->$field);
        }
        $data['id'] = (int)$id;
		$data['aids'] = User::select('id','name')->get();
        return view('admin.xunlian.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tag = XunlianUser::find((int)$id);
        foreach (array_keys($this->fields) as $field) {
            $tag->$field = $request->get($field);
        }
        $tag->save();
		event(new \App\Events\userActionEvent('\App\Models\Admin\XunlianUser', $tag->id, 3, '编辑了商户' . $tag->name));
        return redirect('/admin/xunlian')->withSuccess('添加成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = XunlianUser::find((int)$id);
        if ($tag && $tag->id != 1) {
            $tag->delete();
        } else {
            return redirect()->back()
                ->withErrors("删除失败");
        }

        return redirect()->back()
            ->withSuccess("删除成功");
    }
}
