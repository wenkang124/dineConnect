<div class="col-lg-12">
    <div class="form-group">
        <label for="name" class="moto-widget-contact_form-label">Merchants </label>
        <select name="merchants[]" class="form-control multiple-select2-without-tags w-100" multiple="multiple" {{ ($readonly? 'disabled' : '') }}>
            @foreach($merchants as $key => $merchant)
            <option value="{{ $merchant->id }}" {{ old('merchants')? \Helper::instance()->selectionSelected($merchant->id, old('merchants')) : (isset($item)&&$item->merchants? \Helper::instance()->selectionSelected($merchant->id, $item->merchants->pluck('id')->toArray()) : '') }}>
                {{ $merchant->name }}
            </option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
        <label for="name" class="moto-widget-contact_form-label">Title</label>
        <input type="text" name="name" class="form-control" value="{{ old('name',$item->name??"") }}" {{ $readonly??'' }} required autocomplete="nope">
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
        <label for="sequence" class="moto-widget-contact_form-label">Sequence</label>
        <input type="number" min="1" step="1" name="sequence" class="form-control" value="{{ old('sequence',$item->sequence??"") }}" {{ $readonly??'' }} required autocomplete="nope">
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
        <label for="active" class="moto-widget-contact_form-label">Status <span class="red">*</span></label>
        @if(!$readonly)
        <select name="active" required class="form-control w-100" >
            @foreach(App\Models\Category::STATUS_LIST as $key => $status)
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
