@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'disabled' => false,
    'class' => '',
    'icon' => null,
    'title' => null,
])

@php
    $baseClasses = 'btn';
    $variantClass = 'btn-' . $variant;
    $sizeClass = $size === 'sm' ? 'btn-sm' : ($size === 'lg' ? 'btn-lg' : '');
    $disabledClass = $disabled ? 'disabled' : '';
    $combinedClasses = trim("{$baseClasses} {$variantClass} {$sizeClass} {$disabledClass} {$class}");
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $combinedClasses]) }} @if($disabled) disabled @endif @if($title) title="{{ $title }}" @endif>
        @if($icon)
            <i class="fas fa-{{ $icon }} @if($slot->isNotEmpty()) me-1 @endif"></i>
        @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $combinedClasses]) }} @if($disabled) disabled @endif @if($title) title="{{ $title }}" @endif>
        @if($icon)
            <i class="fas fa-{{ $icon }} @if($slot->isNotEmpty()) me-1 @endif"></i>
        @endif
        {{ $slot }}
    </button>
@endif
