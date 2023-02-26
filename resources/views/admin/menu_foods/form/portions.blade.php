<div class="portion_list d-none">
    <div class="row">
        <div class="col-lg-2">
            <div class="form-group">
                <select name="" class="form-control portion_size_input_temp" {{ $readonly??'' }}>
                    @foreach(App\Models\MenuFoodPortion::SIZE_LIST as $size)
                    <option value="{{ $size }}">{{ $size }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <input type="text" name="" class="form-control portion_servings_input_temp" value="" {{ $readonly??'' }}  autocomplete="nope">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <input type="text" name="" class="form-control portion_descriptions_input_temp" value="" {{ $readonly??'' }}  autocomplete="nope">
            </div>
        </div>
        <div class="col-lg-2 vertical-align-bottom">
            <div class="form-group">
                <button type="button" class="btn bg-danger inputRemove" data-target="div.input-field">Remove</button>
            </div>
        </div>
    </div>
</div>
<div class="portion_container">
    <div class="row">
        @if(old('portion_sizes'))
            @foreach(old('portion_sizes') as $key => $portion_size)
                <div class="col-lg-2">
                    <div class="form-group">
                        <select name="portion_sizes[]" class="form-control" {{ $readonly??'' }}>
                            @foreach(App\Models\MenuFoodPortion::SIZE_LIST as $size)
                            <option value="{{ $size }}" {{ ($size == $portion_size)? 'selected' : '' }}>{{ $size }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <input type="text" name="portion_servings[]" class="form-control" value="{{ old('portion_servings') && isset(old('portion_servings')[$key])? old('portion_servings')[$key] : ''  }}" {{ $readonly??'' }}  autocomplete="nope">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <input type="text" name="portion_descriptions[]" class="form-control" value="{{ old('portion_descriptions') && isset(old('portion_descriptions')[$key])? old('portion_descriptions')[$key] : ''  }}" {{ $readonly??'' }}  autocomplete="nope">
                    </div>
                </div>
                <div class="col-lg-2 vertical-align-bottom">
                    <div class="form-group">
                        <button type="button" class="btn bg-danger inputRemove" data-target="div.input-field">Remove</button>
                    </div>
                </div>
            @endforeach
        @elseif(isset($item) && $item->portions)
            @foreach($item->portions as $portion)       
            <div class="col-lg-2">
                <div class="form-group">
                    <select name="portion_sizes[]" class="form-control" {{ $readonly??'' }}>
                        @foreach(App\Models\MenuFoodPortion::SIZE_LIST as $size)
                        <option value="{{ $size }}" {{ ($size == $portion->size)? 'selected' : '' }}>{{ $size }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <input type="text" name="portion_servings[]" class="form-control" value="{{ $portion->portion_serving ?? ''  }}" {{ $readonly??'' }}  autocomplete="nope">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <input type="text" name="portion_descriptions[]" class="form-control" value="{{ $portion->description ?? ''  }}" {{ $readonly??'' }}  autocomplete="nope">
                </div>
            </div>
            @if(!$readonly)
            <div class="col-lg-2 vertical-align-bottom">
                <div class="form-group">
                    <button type="button" class="btn bg-danger inputRemove" data-target="div.input-field">Remove</button>
                </div>
            </div>
            @endif
            @endforeach
        @else
            <div class="col-lg-2">
                <div class="form-group">
                    <select name="portion_sizes[]" class="form-control" {{ $readonly??'' }}>
                        @foreach(App\Models\MenuFoodPortion::SIZE_LIST as $size)
                        <option value="{{ $size }}">{{ $size }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <input type="text" name="portion_servings[]" class="form-control" value="" {{ $readonly??'' }}  autocomplete="nope">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <input type="text" name="portion_descriptions[]" class="form-control" value="" {{ $readonly??'' }}  autocomplete="nope">
                </div>
            </div>
            <div class="col-lg-2 vertical-align-bottom">
                <div class="form-group">
                    <button type="button" class="btn bg-danger inputRemove" data-target="div.input-field">Remove</button>
                </div>
            </div>
        @endif
    </div>
</div>