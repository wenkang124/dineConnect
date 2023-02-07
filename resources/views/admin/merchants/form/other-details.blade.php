
<div class="col-lg-6">
    <div class="form-group">
        <label for="name" class="moto-widget-contact_form-label">Categories </label>
        <select name="categories[]" required class="form-control multiple-select2 w-100" multiple="multiple">
            @foreach($categories as $key => $category)
            <option value="{{ $category->id }}" {{ old('categories')? \Helper::instance()->selectionSelected($category->id, old('categories')) : (isset($item)&&$item->categories? \Helper::instance()->selectionSelected($category->id, $item->categories) : '') }}>
                {{ $category->name }}
            </option>
            @endforeach
        </select>
    </div>
</div>