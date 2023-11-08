<div class="col-lg-3 col-md-4 col-12 mb-5">
    <div class="profile">
        <div class="profile-pic">
            <img id="item-img-output" class="w-100" src="{{ asset($item->profile_image ?? 'images/default-profile.png') }}" />
            <input type="hidden" name="create_img" class="create_img">
        </div>
    </div>
</div>
<div class="col-lg-9 col-md-8 col-12 vertical-align-bottom mb-5">
    @if(!$readonly)
    <span class="upload">
        <a id="save-image" href="javascript:void(0)" class="btn btn-secondary btn-change ml-4" data-toggle="modal"
            data-target="#uploadImage">Upload Profile Picture</a>
    </span>
    @endif
</div>  
<div class="col-lg-6">
    <div class="form-group">
        <label for="name" class="moto-widget-contact_form-label">Name <span class="red">*</span></label>
        <input type="text" name="name" required class="form-control" value="{{ old('name',$item->name??"") }}" {{ $readonly??'' }}  autocomplete="nope">
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
        <label for="username" class="moto-widget-contact_form-label">Username <span class="red">*</span></label>
        <input type="text" name="username" required class="form-control" value="{{ old('username',$item->username??"") }}" {{ $readonly??'' }}  autocomplete="nope">
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
        <label for="email" class="moto-widget-contact_form-label">Email <span class="red">*</span></label>
        <input type="email" name="email" required class="form-control" value="{{ old('email',$item->email??"") }}" {{ $readonly??'' }}  autocomplete="nope">
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
        <label for="phone" class="moto-widget-contact_form-label">Contact Number <span class="red">*</span></label>
        <div class="dropdown-country-code">
            <input id="telephone" type="tel" class="form-control" name="phone" required value="{{old('mobile_prefix',$item->prefixNumber->phonecode ?? "")}}{{ $item->phone ??""}}" {{ $readonly??'' }} />
        </div>
        <input type="hidden" class="country_code" name="country_code" value="{{ old('country_code',$item->prefixNumber->iso ?? '') }}" />
        <input type="hidden" class="dial_code" name="mobile_prefix_id" value="{{ old('mobile_prefix_id',$item->prefixNumber->phonecode ?? '') }}"/>
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
        <label for="occupation" class="moto-widget-contact_form-label">Occupation</label>
        <input type="text" name="occupation" class="form-control" value="{{ old('occupation',$item->occupation??"") }}" {{ $readonly??'' }}  autocomplete="nope">
    </div>
</div>
@if(!$readonly)
<div class="col-lg-6">
    <div class="form-group">
        <label for="password" class="moto-widget-contact_form-label">Password </label>
        <input type="password" name="password" value="" class="form-control" {{ $readonly??'' }} autocomplete="new-password">
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
        <label for="confirmation_password" class="moto-widget-contact_form-label">Confirmation Password </label>
        <input type="password" name="confirmation_password" value="" class="form-control" autocomplete="new-password">
    </div>
</div>
@endif 
<div class="col-lg-6">
    <div class="form-group">
        <label for="active" class="moto-widget-contact_form-label">Status <span class="red">*</span></label>
        @if(!$readonly)
        <select name="active" required class="form-control w-100" >
            @foreach(App\Models\User::STATUS_LIST as $key => $status)
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

 <!-- Modal Profile Image -->
<div class="modal fade" id="uploadImage" tabindex="-1" role="dialog" aria-labelledby="uploadImageLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadImageLabel">Upload Profile Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="customFile">Profile Image</label>
                <div class="custom-file">
                    <input type="file" id="file-upload"
                        class="custom-file-input @error('profile_image') is-invalid @enderror" name="profile_image" >
                    <label id="filename" class="custom-file-label" for="customFile">Choose file (Max File Size:1
                        MB)</label>
                    <span id="no-image" class="invalid-feedback d-none">
                        No File Input!
                    </span>
                </div>
                @error('profile_image')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <div class="preview_container pt-3" style="display:none">
                    <div id="image-preview"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary bg-theme-color create_upload_image_link">Upload</button>
            </div>
        </div>
    </div>
</div>
