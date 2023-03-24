
@if($readonly)
<div class="col-lg-6">
    <div class="form-group">
        <label for="user_name" class="moto-widget-contact_form-label">User</label>
        <input type="text" name="user_name" class="form-control" value="{{ old('user_name',$item->user_name??"") }}" {{ $readonly??'' }} required autocomplete="nope">
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
        <label for="active" class="moto-widget-contact_form-label">Status <span class="red">*</span></label>
        @if(!$readonly)
        <select name="active" required class="form-control w-100" >
            @foreach(App\Models\Comment::STATUS_LIST as $key => $status)
            <option value="{{ $key }}" {{ old('active',$item->active??"") == $key ? 'selected' : '' }}>{{ $status }}</option>
            @endforeach
        </select>
        @else
        <input type="text" name="active" required="" class="form-control" value="{{ $item->status_name }}" {{ $readonly??'' }}>
        @endif
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
        <label for="total_likes" class="moto-widget-contact_form-label">Total Likes <i class="fa fa-heart pl-2 text-danger" aria-hidden="true"></i></label>
        <input type="number" min="1" step="1" name="total_likes" class="form-control" value="{{ old('total_likes',$item->total_likes??"") }}" {{ $readonly??'' }} required autocomplete="nope">
    </div>
</div> 
<div class="col-lg-6">
    <div class="form-group">
        <label for="total_reports" class="moto-widget-contact_form-label">Total Reports <i class="fa fa-exclamation-triangle pl-2 text-danger" aria-hidden="true"></i></label>
        <input type="number" min="1" step="1" name="total_reports" class="form-control" value="{{ old('total_reports',$item->total_reports??"") }}" {{ $readonly??'' }} required autocomplete="nope">
    </div>
</div> 
<div class="col-lg-12">
    <div class="form-group">
        <label for="message" class="moto-widget-contact_form-label">Message <i class="fa fa-comment pl-2 text-secondary" aria-hidden="true"></i></label>
        <textarea name="message" class="form-control" {{ $readonly??'' }} required>{{ old('message',$item->message??"") }}</textarea>
    </div>
</div>
@endif
@if($readonly)
<div class="col-lg-6">
    <div class="form-group">
        <label for="created_at" class="moto-widget-contact_form-label">Created At </label>
        <input type="text" name="created_at" value="{{ $item->created_at }}" class="form-control" readonly>
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
        <label for="updated_at" class="moto-widget-contact_form-label">Updated At </label>
        <input type="text" name="updated_at" value="{{ $item->updated_at }}" class="form-control" readonly>
    </div>
</div>
@endif
