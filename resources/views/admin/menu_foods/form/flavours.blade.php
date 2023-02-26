<div class="flavour_percentage d-none">
    <div class="row">
        <div class="col-lg-5">
            <div class="form-group">
                <input type="text" class="form-control flavour_title_input_temp" value="" {{ $readonly??'' }}  autocomplete="nope">
            </div>
        </div>
        <div class="col-lg-5">
            <div class="form-group">
                <input type="number" min="0" max="100" step="1" class="form-control flavour_percentage_input_temp" value="" {{ $readonly??'' }}  autocomplete="nope">
            </div>
        </div>
        <div class="col-lg-2 vertical-align-bottom">
            <div class="form-group">
                <button type="button" class="btn bg-danger inputRemove" data-target="div.input-field">Remove</button>
            </div>
        </div>
    </div>
</div>
<div class="flavour_container">
    <div class="row">
        @if(old('flavour_titles'))
            @foreach(old('flavour_titles') as $key => $flavour_title)
                <div class="col-lg-5">
                    <div class="form-group">
                        <input type="text" name="flavour_titles[]" class="form-control" value="{{ $flavour_title }}" {{ $readonly??'' }}  autocomplete="nope">
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="form-group">
                        <input type="number" name="flavour_percentages[]" min="0" max="100" step="1" class="form-control" value="{{ old('flavour_percentages') && isset(old('flavour_percentages')[$key])? old('flavour_percentages')[$key] : ''  }}" {{ $readonly??'' }}  autocomplete="nope">
                    </div>
                </div>
                <div class="col-lg-2 vertical-align-bottom">
                    <div class="form-group">
                        <button type="button" class="btn bg-danger inputRemove" data-target="div.input-field">Remove</button>
                    </div>
                </div>
            @endforeach
        @elseif(isset($item) && $item->flavours)
            @foreach($item->flavours as $flavour)            
                <div class="col-lg-5">
                    <div class="form-group">
                        <input type="text" name="flavour_titles[]" class="form-control" value="{{ $flavour->flavour_title }}" {{ $readonly??'' }}  autocomplete="nope">
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="form-group">
                        <input type="number" name="flavour_percentages[]" min="0" max="100" step="1" class="form-control" value="{{ $flavour->flavour_percentage }}" {{ $readonly??'' }}  autocomplete="nope">
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
            <div class="col-lg-5">
                <div class="form-group">
                    <input type="text" name="flavour_titles[]" class="form-control" value="" {{ $readonly??'' }}  autocomplete="nope">
                </div>
            </div>
            <div class="col-lg-5">
                <div class="form-group">
                    <input type="number" name="flavour_percentages[]" min="0" max="100" step="1" class="form-control" value="" {{ $readonly??'' }}  autocomplete="nope">
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