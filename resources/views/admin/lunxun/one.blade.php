@extends('admin.layouts.base')

@section('title','控制面板')

@section('pageHeader','控制面板')

@section('pageDesc','DashBoard')

@section('content')
<form class="form-horizontal" role="form" method="POST" action="/admin/lunxun/one" >
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="form-group">
    <label for="tag" class="col-md-3 control-label">商户号</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="mchntid" id="tag" value="" autofocus>
    </div>
</div>
<br/>
<div class="form-group">
    <label for="tag" class="col-md-3 control-label">秘钥</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="miyao" id="tag" value="" >
    </div>
</div>
<br/>
<div class="form-group">
    <label for="tag" class="col-md-3 control-label">机构号</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="inscd" id="tag" value="93081888" >
    </div>
</div><br/>
<div class="form-group">
    <label for="tag" class="col-md-3 control-label">订单号</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="orderNum" id="tag" value="" >
    </div>
</div>
<button style ="margin-left:500px;margin-top:50px;" type="submit" class="btn btn-primary btn-md">
                                            <i class="fa fa-plus-circle"></i>
                                            添加
                                        </button>
</form>


@stop
