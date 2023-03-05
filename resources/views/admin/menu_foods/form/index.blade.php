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
        <label for="name" class="moto-widget-contact_form-label">Category </label>
        <select name="categories[]" required class="form-control single-select2 w-100" multiple="multiple" {{ ($readonly? 'disabled' : '') }}>
            @foreach($categories as $key => $category)
            <option value="{{ $category->id }}" {{ old('categories')? \Helper::instance()->selectionSelected($category->id, old('categories')) : (isset($item)&&$item->menuCategories? \Helper::instance()->selectionSelected($category->id, $item->menuCategories->pluck('id')->toArray()) : '') }}>
                {{ $category->name }}
            </option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
        <label for="name" class="moto-widget-contact_form-label">Sub Categories </label>
        <select name="sub_categories[]" required class="form-control multiple-select2 w-100" multiple="multiple" {{ ($readonly? 'disabled' : '') }}>
            @foreach($sub_categories as $key => $sub_category)
            <option value="{{ $sub_category->id }}" {{ old('sub_categories')? \Helper::instance()->selectionSelected($sub_category->id, old('sub_categories')) : (isset($item)&&$item->menuSubCategories? \Helper::instance()->selectionSelected($sub_category->id, $item->menuSubCategories->pluck('id')->toArray()) : '') }}>
                {{ $sub_category->name }}
            </option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
        <label for="name" class="moto-widget-contact_form-label">Name <span class="red">*</span></label>
        <input type="text" name="name" required class="form-control" value="{{ old('name',$item->name??"") }}" {{ $readonly??'' }}  autocomplete="nope">
    </div>
</div>
<div class="col-lg-12">
    <div class="form-group">
        <label for="short_description" class="moto-widget-contact_form-label">Short Description <span class="red">*</span></label>
        <input name="short_description" required class="form-control" value="{{ old('short_description',$item->short_description??"") }}" {{ $readonly??'' }} autocomplete="nope">
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
        <label for="price" class="moto-widget-contact_form-label">Price</label>
        <input type="number" name="price" class="form-control" value="{{ old('price',$item->price??"") }}" {{ $readonly??'' }} min="0" step="0.01" autocomplete="nope">
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
        <label for="active" class="moto-widget-contact_form-label">Status <span class="red">*</span></label>
        @if(!$readonly)
        <select name="active" required class="form-control w-100" >
            @foreach(App\Models\MenuFood::STATUS_LIST as $key => $status)
            <option value="{{ $key }}" {{ old('active',$item->active??"") == $key ? 'selected' : '' }}>{{ $status }}</option>
            @endforeach
        </select>
        @else
        <input type="text" name="active" required="" class="form-control" value="{{ $item->status_name }}" {{ $readonly??'' }}>
        @endif
    </div>
</div>
<div class="col-lg-12">
    <div class="form-group">
        <label for="description" class="moto-widget-contact_form-label">Description <span class="red">*</span></label>
        <textarea id="{{ $readonly? 'summernote-disable' : 'summernote' }}" name="description">{{ old('description',$item->description??"") }}</textarea>
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