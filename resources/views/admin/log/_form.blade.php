<div class="form-group">
    <label for="tag" class="col-md-3 control-label">客户名称</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="name" id="tag" value="{{ $name }}" autofocus>
    </div>
</div>
<div class="form-group">
    <label for="tag" class="col-md-3 control-label">姓名</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="username" id="tag" value="{{ $username }}" >
    </div>
</div>

<div class="form-group">
    <label for="tag" class="col-md-3 control-label">手机</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="phone" id="tag" value="{{ $phone }}" >
    </div>
</div>
<div class="form-group">
    <label for="tag" class="col-md-3 control-label">域名</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="domain" id="tag" value="{{ $domain }}" >
    </div>
</div>
<div class="form-group">
    <label for="tag" class="col-md-3 control-label">总款项</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="count_price" id="tag" value="{{ $count_price }}" >
    </div>
</div>
<div class="form-group">
    <label for="tag" class="col-md-3 control-label">已收</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="paid_price" id="tag" value="{{ $paid_price }}" >
    </div>
</div>
<div class="form-group">
    <label for="tag" class="col-md-3 control-label">未收</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="bepaid_price" id="tag" value="{{ $bepaid_price }}" >
    </div>
</div>
<div class="form-group">
    <label for="tag" class="col-md-3 control-label">备注</label>
    <div class="col-md-5">
		<textarea class="form-control" name="remake">{{ $remake }}</textarea>
    </div>
</div>
<div class="form-group">
    <label for="tag" class="col-md-3 control-label">跟进人</label>
    <div class="col-md-5">
        <select class="form-control" name="aid">
		@foreach ($aids as $aid)
			<option value='{{$aid->id}}'>{{$aid->name}}</option>
		@endforeach
		</select>
    </div>
</div>