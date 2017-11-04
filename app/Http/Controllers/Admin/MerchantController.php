<?php
namespace App\Http\Controllers\Admin;

use App\Models\Admin\XunlianUser;
use App\Models\Admin\Merchant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MerchantController extends Controller
{
    protected $fields = [
        'mchntid'  => '',
        'miyao' => '',
        'inscd' => '93081888',
		'xuid' => 0
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$cid = 0)
    {
        if ($request->ajax()) {
            $data = array();
            $data['draw'] = $request->get('draw');
            $start = $request->get('start');
            $length = $request->get('length');
            $order = $request->get('order');
            $columns = $request->get('columns');
            $search = $request->get('search');
            $data['recordsTotal'] = Merchant::count();
            if (strlen($search['value']) > 0) {
                $data['recordsFiltered'] = Merchant::join('xunlian_users', 'xunlian_users.id', '=', 'xuid')
					->where(function ($query) use ($search) {
						$query->where('xunlian_users.name', 'LIKE', '%' . $search['value'] . '%')
							->orWhere('mchntid', 'like', '%' . $search['value'] . '%')
							->orWhere('inscd', 'like', '%' . $search['value'] . '%')
							->orWhere('miyao', 'like', '%' . $search['value'] . '%');
					})->count();
                $data['data'] = Merchant::select("xunlian_users.name","xunlian_merchants.*")->join('xunlian_users', 'xunlian_users.id', '=', 'xuid')
					->where(function ($query) use ($search) {
						$query->where('xunlian_users.name', 'LIKE', '%' . $search['value'] . '%')
							->orWhere('mchntid', 'like', '%' . $search['value'] . '%')
							->orWhere('inscd', 'like', '%' . $search['value'] . '%')
							->orWhere('miyao', 'like', '%' . $search['value'] . '%');
					})
                    ->skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get();
            } else {
                $data['recordsFiltered'] = $data['recordsTotal'];
                $data['data'] = Merchant::select("xunlian_users.name","xunlian_merchants.*")->leftJoin('xunlian_users', 'xunlian_users.id', '=', 'xuid')
					->skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get();
            }

            return response()->json($data);
        }

        return view('admin.merchant.index',['cid'=>$cid]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($xuid=0)
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }
		$data['xuids'] = XunlianUser::select('id','name')->get();
		$data['xuid'] = $xuid;
        return view('admin.merchant.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tag = new XunlianUser();
        foreach (array_keys($this->fields) as $field) {
            $tag->$field = $request->get($field);
        }
        $tag->save();
        event(new \App\Events\userActionEvent('\App\Models\Admin\XunlianUser', $tag->id, 1, '添加了商户' . $tag->name));
        return redirect('/admin/xunlian')->withSuccess('添加成功！');
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
