<div>
    <img
    src="{{ \Illuminate\Support\Facades\Storage::disk(config('filesystems.default'))->url($record['attachment']) }}"
    alt="{{ $record['name'] }}"
    class="object-cover w-full"
/>
</div>
