@props([
    'active' => false,
    'disabled' => false
])

@php
    $type = ($active || $disabled)? 'div' : 'button';
@endphp

<{{ $type }} 
    @class([
        "mb-1 mx-1 btn-paginate inline-flex items-center px-3 py-2 text-xs",
        'active' => $active,
        'disabled' => $disabled
    ])
    {{ $attributes }}
>
    <span>{{ $slot }}</span>
</{{ $type }}>