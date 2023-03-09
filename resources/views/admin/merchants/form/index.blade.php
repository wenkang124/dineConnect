<div class="col-lg-4 col-md-6 col-12 mb-5">
    @if(!$readonly)
    <div class="box">
        <div class="js--image-preview" style="background-image: url('{{ $item->image_path ?? '/images/img-800x500.jpg' }}')"></div>
        <div class="upload-options">
          <label>
            <input type="file" name="thumbnail" class="image-upload" accept="image/*" />
          </label>
        </div>
    </div>
    @else
    <img src="{{ asset($item->thumbnail) }}" class="w-100" />
    @endif
</div>
<div class="col-lg-6 col-md-6 col-6 mb-5">
</div>
<div class="col-lg-6">
    <div class="form-group">
        <label for="name" class="moto-widget-contact_form-label">Name <span class="red">*</span></label>
        <input type="text" name="name" required class="form-control" value="{{ old('name',$item->name??"") }}" {{ $readonly??'' }}  autocomplete="nope">
    </div>
</div>
<div class="col-lg-12">
    <div class="form-group">
        <label for="description" class="moto-widget-contact_form-label">Description <span class="red">*</span></label>
        <textarea name="description" required class="form-control" value="" {{ $readonly??'' }}  autocomplete="nope">{{ old('description',$item->description??"") }}</textarea>
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
        <label for="address" class="moto-widget-contact_form-label">Address <span class="red">*</span></label>
        <input type="text" name="address" required class="form-control" value="{{ old('address',$item->address??"") }}" {{ $readonly??'' }}  autocomplete="nope">
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
        <label for="postal_code" class="moto-widget-contact_form-label">Postal Code <span class="red">*</span></label>
        <input type="text" name="postal_code" required class="form-control" value="{{ old('postal_code',$item->postal_code??"") }}" {{ $readonly??'' }}  autocomplete="nope">
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
        <label for="city" class="moto-widget-contact_form-label">City <span class="red">*</span></label>
        <input type="text" name="city" required class="form-control" value="{{ old('city',$item->city??"") }}" {{ $readonly??'' }}  autocomplete="nope">
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
        <label for="state" class="moto-widget-contact_form-label">State <span class="red">*</span></label>
        <input type="text" name="state" required class="form-control" value="{{ old('state',$item->state??"") }}" {{ $readonly??'' }}  autocomplete="nope">
    </div>
</div>
<div class="col-lg-12">
    <div class="form-group">
        <label for="name" class="moto-widget-contact_form-label">Country </label>
        <select name="country_id" required class="form-control single-select2-without-tags w-100" multiple="multiple" required {{ ($readonly? 'disabled' : '') }}>
            @foreach($countries as $key => $country)
            <option value="{{ $country->id }}" {{ old('country_id') && old('country_id') == $country->id? 'selected' : (isset($item)&&$item->country_id == $country->id? 'selected' : '') }}>
                {{ $country->nicename }}
            </option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
        <label for="longitude" class="moto-widget-contact_form-label">Longitude</label>
        <input type="number" name="lng" class="form-control" value="{{ old('lng',$item->lng??"") }}" {{ $readonly??'' }} step="0.00000001" autocomplete="nope">
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
        <label for="latitude" class="moto-widget-contact_form-label">Latitude</label>
        <input type="number" name="lat" class="form-control" value="{{ old('lat',$item->lat??"") }}" {{ $readonly??'' }} step="0.00000001" autocomplete="nope">
    </div>
</div>
{{-- <div class="col-lg-6">
    <div class="form-group">
        <label for="phone" class="moto-widget-contact_form-label">Contact Number <span class="red">*</span></label>
        <div class="dropdown-country-code">
            <input id="telephone" type="tel" class="form-control" name="phone" required value="{{old('mobile_prefix',$item->prefixNumber->phonecode ?? "")}}{{ $item->phone ??""}}" {{ $readonly??'' }} />
        </div>
        <input type="hidden" class="country_code" name="country_code" value="{{ old('country_code',$item->prefixNumber->iso ?? '') }}" />
        <input type="hidden" class="dial_code" name="mobile_prefix_id" value="{{ old('mobile_prefix_id',$item->prefixNumber->phonecode ?? '') }}"/>
    </div>
</div> --}}
<div class="col-lg-6">
    <div class="form-group">
        <label for="active" class="moto-widget-contact_form-label">Status <span class="red">*</span></label>
        @if(!$readonly)
        <select name="active" required class="form-control w-100" >
            @foreach(App\Models\Merchant::STATUS_LIST as $key => $status)
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