<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    protected $fields = [
        'name'  => '',
        'email' => '',
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
            $data['recordsTotal'] = User::count();
            if (strlen($search['value']) > 0) {
                $data['recordsFiltered'] = User::where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search['value'] . '%')
                        ->orWhere('email', 'like', '%' . $search['value'] . '%');
                })->count();
                $data['data'] = User::where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search['value'] . '%')
                        ->orWhere('email', 'like', '%' . $search['value'] . '%');
                })
                    ->skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get();
            } else {
                $data['recordsFiltered'] = $data['recordsTotal'];
                $data['data'] = User::
                skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get();
            }
            return response()->json($data);
        }
        return view('admin.member.index');
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

        return view('admin.member.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
        foreach (array_keys($this->fields) as $field) {
            $user->$field = $request->get($field);
        }
        $user->password = bcrypt($request->get('password'));
        $user->save();
       
        event(new \App\Events\userActionEvent('\App\Models\Admin\User', $user->id, 1, '添加了用户' . $user->name));

        return redirect('/admin/member')->withSuccess('添加成功！');
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
        $user = User::find((int)$id);
        if (!$user) return redirect('/admin/member')->withErrors("找不到该用户!");
        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $user->$field);
        }
        $data['id'] = (int)$id;
        
        return view('admin.member.edit', $data);
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
        $user = User::find((int)$id);
        foreach (array_keys($this->fields) as $field) {
            $user->$field = $request->get($field);
        }
        unset($user->roles);
        if ($request->get('password') != '') {
            $user->password = bcrypt($request->get('password'));

        }

        $user->save();
        $user->giveRoleTo($request->get('roles', []));
		event(new \App\Events\userActionEvent('\App\Models\Admin\User', $user->id, 3, '编辑了用户' . $user->name));

        return redirect('/admin/member')->withSuccess('添加成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = User::find((int)$id);
        foreach ($tag->roles as $v) {
            $tag->roles()->detach($v);
        }
        if ($tag && $tag->id != 1) {
            $tag->delete();
        } else {
            return redirect()->back()
                ->withErrors("删除失败");
        }
		event(new \App\Events\userActionEvent('\App\Models\Admin\User', $tag->id, 2, '删除了用户' . $tag->name));
        return redirect()->back()
            ->withSuccess("删除成功");
    }
}
