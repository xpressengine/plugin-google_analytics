<div class="form-group">
    <label>TYPE</label>
    <select name="type" class="form-control">
        @foreach($types as $type)
            <option value="{{ $type }}" {{ $selected === $type ? 'selected' : '' }}>{{xe_trans('ga::widget.'.str_singular($type))}}</option>
        @endforeach
    </select>
</div>