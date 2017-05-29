<div class="form-group">
    <label>TYPE</label>
    <select name="type" class="form-control">
        @foreach($types as $type)
            <option value="{{ $type }}">{{$type}}</option>
        @endforeach
    </select>
</div>