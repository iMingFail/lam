
<div class="form-group">
    <label for="tag" class="col-md-3 control-label">系统</label>
    <div class="col-md-5">
        <select class="form-control" name="type">
			@foreach ($types as $k=>$typ)
				<option value='{{$k}}'>{{$typ}}</option>
			@endforeach
		</select>
    </div>
</div>
<div class="form-group">
    <label for="tag" class="col-md-3 control-label">IP</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="ip" id="tag" value="{{ $ip }}" autofocus>
    </div>
</div>
<div class="form-group">
    <label for="tag" class="col-md-3 control-label">域名</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="domain" id="tag" value="{{ $domain }}" autofocus>
    </div>
</div>
<div class="form-group">
    <label for="tag" class="col-md-3 control-label">授权</label>
    <div class="col-md-5">
        <select class="form-control" name="state">
			<option @if ($state==0) selected @endif value='0'>否</option>
			<option @if ($state==1) selected @endif value='1'>是</option>
		</select>
    </div>
</div>
<div class="form-group">
    <label for="tag" class="col-md-3 control-label">显示内容</label>
    <div class="col-md-5">
        <select class="form-control" name="show">
			<option @if ($show==0) selected @endif value='0'>否</option>
			<option @if ($show==1) selected @endif value='1'>是</option>
		</select>
    </div>
</div>
<div class="form-group">
    <label for="tag" class="col-md-3 control-label">显示内容</label>
    <div class="col-md-5">
		<textarea class="form-control" name="show_txt">{{ $show_txt }}</textarea>
    </div>
</div>
<div class="form-group">
    <label for="tag" class="col-md-3 control-label">备注</label>
    <div class="col-md-5">
		<textarea class="form-control" name="remarks">{{ $remarks }}</textarea>
    </div>
</div>



