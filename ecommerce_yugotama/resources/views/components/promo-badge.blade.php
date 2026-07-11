@props([
    'text' => 'Promo',
])

<span {{ $attributes->merge(['class' => 'inline-flex items-center px-2.5 py-1 rounded-full bg-accent-100 text-accent-500 text-xs font-bold']) }}>
    {{ $text }}
</span>
