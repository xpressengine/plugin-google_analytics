<div class="form-group">
    <label>시작일</label>
    <select name="startdate" class="form-control">
        <option value="7daysAgo" {{ '7daysAgo' === $startdate ? 'selected' : '' }}>7daysAgo</option>
        <option value="15daysAgo" {{ '15daysAgo' === $startdate ? 'selected' : '' }}>15daysAgo</option>
        <option value="30daysAgo" {{ '30daysAgo' === $startdate ? 'selected' : '' }}>30daysAgo</option>
        <option value="60daysAgo" {{ '60daysAgo' === $startdate ? 'selected' : '' }}>60daysAgo</option>
    </select>
</div>