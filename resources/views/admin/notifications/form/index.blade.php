<div class="col-lg-12">
    <div class="form-group">
        <label for="title" class="moto-widget-contact_form-label">Title <span class="red">*</span></label>
        <input type="text" name="title" class="form-control" value="{{ old('title',$item->title??"") }}" {{ $readonly??'' }} autocomplete="nope">
    </div>
</div>

<div class="col-lg-12">
    <div class="form-group">
        <label for="description" class="moto-widget-contact_form-label">Description <span class="red">*</span></label>
        <textarea name="description" class="form-control" value="" {{ $readonly??'' }} autocomplete="nope">{{ old('description',$item->description??"") }}</textarea>
    </div>
</div>

<div class="col-lg-12">
    <div class="form-group">
        <label for="all">All users</label>
        <input type="checkbox" id="all" name="all" value="true" >
    </div>
</div>

<div class="col-lg-12">
    <div class="form-group">
        <label for="users" class="moto-widget-contact_form-label">Users <span class="red">*</span></label>
        <select name="users[]" id="user-selection" required class="form-control w-100 multiple-select2" multiple="multiple">
            @foreach(App\Models\User::all() as $user)
            <option value="{{ $user->id }}">{{ $user->name }} | {{ $user->email }}</option>
            @endforeach
        </select>
    </div>
</div>