<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admin\Cfzxauth;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CfzxauthController extends Controller
{
    protected $fields = [
        'ip'=>'',
		'domain'=>'',
		'remarks'=>'',
		'show'=>'',
		'show_txt'=>'',
		'state'=>'',
		'type'=>1
    ];
	protected $types = [1=>'财富之星'];

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
            $data['recordsTotal'] = Cfzxauth::count();
            if (strlen($search['value']) > 0) {
                $data['recordsFiltered'] = Cfzxauth::where(function ($query) use ($search) {
                    $query->where('ip', 'LIKE', '%' . $search['value'] . '%')
						->orWhere('remarks', 'like', '%' . $search['value'] . '%')
						->orWhere('show_txt', 'like', '%' . $search['value'] . '%')
                        ->orWhere('domain', 'like', '%' . $search['value'] . '%');
                })->count();
                $data['data'] = Cfzxauth::where(function ($query) use ($search) {
                    $query->where('ip', 'LIKE', '%' . $search['value'] . '%')
						->orWhere('remarks', 'like', '%' . $search['value'] . '%')
						->orWhere('show_txt', 'like', '%' . $search['value'] . '%')
                        ->orWhere('domain', 'like', '%' . $search['value'] . '%');
                })
                    ->skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get();
            } else {
                $data['recordsFiltered'] = $data['recordsTotal'];
                $data['data'] = Cfzxauth::
                skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get();
            }
			$data['types']=$this->types;
            return response()->json($data);
        }
        return view('admin.cfzxauth.index');
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
		$data['types'] = $this->types;
        return view('admin.cfzxauth.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tag = new Cfzxauth();
        foreach (array_keys($this->fields) as $field) {
            $tag->$field = $request->get($field);
        }
        $tag->save();
       
        event(new \App\Events\userActionEvent('\App\Models\Admin\Cfzxauth', $tag->id, 1, '添加了授权' . $tag->ip));

        return redirect('/admin/cfzxauth')->withSuccess('添加成功！');
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
        $tag = Cfzxauth::find((int)$id);
        if (!$tag) return redirect('/admin/cfzxauth')->withErrors("找不到该数据!");
        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $tag->$field);
        }
        $data['id'] = (int)$id;
        $data['types'] = $this->types;
        return view('admin.cfzxauth.edit', $data);
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
        $tag = Cfzxauth::find((int)$id);
        foreach (array_keys($this->fields) as $field) {
            $tag->$field = $request->get($field);
        }
        $tag->save();
		event(new \App\Events\userActionEvent('\App\Models\Admin\Cfzxauth', $tag->id, 3, '编辑了授权' . $tag->ip));

        return redirect('/admin/cfzxauth')->withSuccess('更新成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Cfzxauth::find((int)$id);
        if ($tag) {
            $tag->delete();
        } else {
            return redirect()->back()
                ->withErrors("删除失败");
        }
		event(new \App\Events\userActionEvent('\App\Models\Admin\Cfzxauth', $tag->id, 2, '删除了授权' . $tag->ip));
        return redirect()->back()
            ->withSuccess("删除成功");
    }
}
