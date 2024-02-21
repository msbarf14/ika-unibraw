@php
use Illuminate\Support\Str;
$id = (string) Str::ulid();
@endphp

@props([
    'name' => null,
    'inline' => false,
    'label' => null,
    'disabled' => false,
    'inputClass' => '',
    'type' => null,
    'placeholder' => null,
    'readonly' => false,
    'help' => null,
    'textarea' => false
])

<div 
    class="{{ $inline? 'field-wrapper-inline' : 'field-wrapper' }}" 
>
    @if ($label)
        <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    @endif

    <div class="form-wrapper">
        <div class="relative">
            <{{ $textarea? 'textarea' : 'input' }}
                id="{{ $id }}"
                class="
                    block w-full border px-3 py-2 rounded-md bg-brand-secondary/[0.03] dark:bg-brand-secondary/20
                    focus:outline-none focus:ring-1
                    disabled:select-none

                    @error($name)
                        text-red-800 placeholder-red-400 border-red-500 focus:ring-red-500 focus:border-red-500 disabled:text-red-800/20
                    @else
                        border-brand-secondary/20 placeholder-brand-secondary focus:ring-brand-secondary focus:border-brand-secondary text-brand-dark disabled:text-brand-dark/20 dark:text-white/80 dark:disabled:text-white/40
                    @enderror

                    sm:text-sm
                    {{ $disabled? 'cursor-not-allowed' : '' }}
                    {{ $inputClass }},
                ]"
                type="{{ $type ?? 'text' }}"
                placeholder="{{ $placeholder ?? $label }}"
                {{ $readonly? 'readonly' : '' }}
                {{ $disabled? 'disabled' : '' }}
                ref="input"
                {{ $attributes }}
            ></textarea>

            @error($name)
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg
                        class="w-5 h-5 text-red-500"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </div>
            @enderror
        </div>

        @error($name)
            <div class="mt-1 form-error">{{ $message }}</div>
        @enderror

        @if ($help)
            <div class="mt-1 text-xs text-brand-secondary">
                {{ $help }}
            </div>
        @endif
    </div>
</div>