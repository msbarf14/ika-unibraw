<div {{ $attributes->merge(['class' => 'px-4 sm:px-6']) }}>
    <div>
        <h3 class="max-w-2xl mx-auto text-2xl font-bold text-center md:text-5xl">Unit Usaha</h3>
    </div>

    @foreach ($units as $index => $unit)
        @php
            $inverse = ($index+1)%2 != 0;
        @endphp

        <x-shared.unit-usaha.item 
            :$unit 
            :$inverse
            class="mt-12 md:mt-24" 
        />
    @endforeach
</div>