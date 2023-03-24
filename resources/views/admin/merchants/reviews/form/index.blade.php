
@if(!$readonly)
<div class="col-lg-4 col-md-6 col-12">
    <div class="box">
        <div class="js--image-preview" style="background-image: url('{{ $item->image_path ?? '/images/img-800x500.jpg' }}')"></div>
        <div class="upload-options">
          <label>
            <input type="file" name="image" class="image-upload" accept="image/*" />
          </label>
        </div>
    </div>
</div>
@else
<div class="col-lg-12 col-md-12 col-12 mb-5">
    <label for="image" class="moto-widget-contact_form-label">Uploaded Images</label>
    <div class="row">
        @foreach($item->images as $image)
        <div class="col-lg-auto col-md-auto col-12">
            <img src="{{ asset($image->tn_path) }}" class="w-auto" height="200" />
        </div>
        @endforeach
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
        <label for="user_name" class="moto-widget-contact_form-label">User</label>
        <input type="text" name="user_name" class="form-control" value="{{ old('user_name',$item->user_name??"") }}" {{ $readonly??'' }} required autocomplete="nope">
    </div>
</div>
<div class="col-lg-6">
</div>
<div class="col-lg-6">
    <div class="form-group">
        <label for="rating" class="moto-widget-contact_form-label">Rating</label>
        <input type="number" min="1" step="1" name="rating" class="form-control" value="{{ old('rating',$item->rating??"") }}" {{ $readonly??'' }} required autocomplete="nope">
    </div>
</div> 
<div class="col-lg-6">
    <div class="form-group">
        <label for="total_likes" class="moto-widget-contact_form-label">Total Likes</label>
        <input type="number" min="1" step="1" name="total_likes" class="form-control" value="{{ old('total_likes',$item->total_likes??"") }}" {{ $readonly??'' }} required autocomplete="nope">
    </div>
</div> 
<div class="col-lg-12">
    <div class="form-group">
        <label for="message" class="moto-widget-contact_form-label">Review</label>
        <textarea name="message" class="form-control" {{ $readonly??'' }} required>{{ old('message',$item->message??"") }}</textarea>
    </div>
</div>
@endif
<div class="col-lg-6">
    <div class="form-group">
        <label for="active" class="moto-widget-contact_form-label">Status <span class="red">*</span></label>
        @if(!$readonly)
        <select name="active" required class="form-control w-100" >
            @foreach(App\Models\Banner::STATUS_LIST as $key => $status)
            <option value="{{ $key }}" {{ old('active',$item->active??"") == $key ? 'selected' : '' }}>{{ $status }}</option>
            @endforeach
        </select>
        @else
        <input type="text" name="active" required="" class="form-control" value="{{ $item->status_name }}" {{ $readonly??'' }}>
        @endif
    </div>
</div>
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
