@foreach ($files as $file)
    <img src="{{ Storage::url($file) }}" alt="Image" style="max-width: 100px; max-height: 100px;"/>
@endforeach
