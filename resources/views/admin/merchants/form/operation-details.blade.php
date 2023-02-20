
<div class="col-lg-6">
    <div class="form-group">
        <label for="is_open" class="moto-widget-contact_form-label pr-2">Default Operation </label>
        <select name="is_open" class="form-control">
            <option value="1" {{ old('is_open') && old('is_open') == 1? 'selected' : (isset($item)&&$item->is_open == 1? 'selected'  : '') }}>Open</option>
            <option value="0" {{ old('is_open') && old('is_open') == 0? 'selected' : (isset($item)&&$item->is_open == 0? 'selected'  : '') }}>Close</option>
        </select>
    </div>
</div>
<div class="col-lg-6"></div>

@for($i = 0; $i  < 7; $i++)
<div class="col-lg-2">
    <div class="form-group">
        <div class="icheck-primary">
            <input name="operation_days[{{ $i }}]" type="checkbox" id="operation_day_{{ $i }}" value="{{ $i }}" {{ old('operation_days')? \Helper::instance()->checkboxChecked($i, old('operation_days')) : (isset($item)&&$item->operationDaySettings? \Helper::instance()->checkboxChecked($i, $item->operationDaySettings->pluck('day')->toArray()) : '') }} />
            <label for="operation_day_{{ $i }}" class="moto-widget-contact_form-label">{{ $days[$i] }} </label>
        </div>
    </div>
</div>
<div class="col-lg-5">
    <div class="form-group">
        <div class="input-group time">
            <label for="name" class="moto-widget-contact_form-label pr-2">Start Time: </label>
            <input name="start_times[{{ $i }}]" class="form-control timepicker start_time" value="{{ isset(old('start_times')[$i])? old('start_times')[$i] : (isset($item)&&$item->operationDaySettings? \Helper::instance()->operationTimeSetting($i, $item->operationDaySettings, 'start_time') : '08:00') }}" />
        </div>
    </div>
</div>
<div class="col-lg-5">
    <div class="form-group">
        <div class="input-group time">
            <label for="name" class="moto-widget-contact_form-label pr-2">End Time: </label>
            <input name="end_times[{{ $i }}]" class="form-control timepicker end_time" value="{{ isset(old('end_times')[$i])? old('end_times')[$i] : (isset($item)&&$item->operationDaySettings? \Helper::instance()->operationTimeSetting($i, $item->operationDaySettings, 'end_time') : '22:00') }}" />
        </div>
    </div>
</div>
@endfor