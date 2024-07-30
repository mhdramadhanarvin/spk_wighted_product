<div class="mt-2">
    @foreach ($options as $key => $v)
    <div class="flex mb-2">
      <input type="radio" name="{{$name}}" class="shrink-0 mt-0.5 border-gray-400 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none " id="{{$key}}" value="{{$key}}" {{ ( old($name) == $key || (isset($value) && $value == $key) ) ? 'checked' : '' }} required="{{$required}}">
      <label for="{{$key}}" class="text-sm text-gray-500 ms-2 dark:text-neutral-400">{{ $v }}</label>
    </div>
    @endforeach
</div>
