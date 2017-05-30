<div class="form-group">
    <label>TYPE</label>
    <select name="type" class="form-control">
        @foreach($types as $type)
            <option value="{{ $type }}" {{ $selected === $type ? 'selected' : '' }}>{{call_user_func($prettyType, $type)}}</option>
        @endforeach
    </select>
</div>