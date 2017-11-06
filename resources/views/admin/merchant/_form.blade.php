<div class="form-group">
    <label for="tag" class="col-md-3 control-label">商户号</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="mchntid" id="tag" value="{{ $mchntid }}" autofocus>
    </div>
</div>
<div class="form-group">
    <label for="tag" class="col-md-3 control-label">密钥</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="miyao" id="tag" value="{{ $miyao }}" >
    </div>
</div>

<div class="form-group">
    <label for="tag" class="col-md-3 control-label">机构号</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="inscd" id="tag" value="{{ $inscd }}" >
    </div>
</div>
<div class="form-group">
    <label for="tag" class="col-md-3 control-label">所属客户</label>
    <div class="col-md-5">
        <select class="form-control" name="xuid" >
		@foreach ($xuids as $xu)
			 @if($xuid!=0) 
					@if($xuid==$xu->id) <option value='{{$xu->id}}' @if($xuid==$xu->id) selected @endif>{{$xu->name}}</option> @endif
			 @else
				<option value='{{$xu->id}}' @if($xuid==$xu->id) selected @endif>{{$xu->name}}</option>
			 @endif
			
		@endforeach
		</select>
    </div>
</div>