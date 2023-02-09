
<div class="col-lg-6">
    <div class="form-group">
        <label for="name" class="moto-widget-contact_form-label">Categories </label>
        <select name="categories[]" required class="form-control multiple-select2 w-100" multiple="multiple" {{ ($readonly? 'disabled' : '') }}>
            @foreach($categories as $key => $category)
            <option value="{{ $category->id }}" {{ old('categories')? \Helper::instance()->selectionSelected($category->id, old('categories')) : (isset($item)&&$item->categories? \Helper::instance()->selectionSelected($category->id, $item->categories->pluck('id')->toArray()) : '') }}>
                {{ $category->name }}
            </option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
        <label for="name" class="moto-widget-contact_form-label">Moods </label>
        <select name="moods[]" required class="form-control multiple-select2 w-100" multiple="multiple" {{ ($readonly? 'disabled' : '') }}>
            @foreach($moods as $key => $mood)
            <option value="{{ $mood->id }}" {{ old('moods')? \Helper::instance()->selectionSelected($mood->id, old('moods')) : (isset($item)&&$item->moods? \Helper::instance()->selectionSelected($mood->id, $item->moods->pluck('id')->toArray()) : '') }}>
                {{ $mood->name }}
            </option>
            @endforeach
        </select>
    </div>
</div>