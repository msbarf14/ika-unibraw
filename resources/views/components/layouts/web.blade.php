<x-layouts.app :title="$title">
    <div  
        x-data="{
            announcement: true
        }"
        class="min-h-screen text-black bg-white"
    >
        {{ $slot }}
    </div>
</x-layouts.app>