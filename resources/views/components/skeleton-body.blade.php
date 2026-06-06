@props(['activeZone' => null])
{{--
    Interactive Human Skeleton SVG Component
    Zones: head, torso, upper_limbs, lower_limbs
    Clicking a zone filters products by that body part zone.
--}}
<div class="skeleton-wrapper" x-data="{ hoveredZone: null }" style="padding: 1rem 0;">
    <svg viewBox="0 0 120 320" xmlns="http://www.w3.org/2000/svg"
         style="width:100%; max-width:150px; margin:0 auto; display:block; overflow:visible;">

        {{-- ===== HEAD ===== --}}
        @php $headActive = $activeZone === 'head'; @endphp
        <g class="skeleton-zone-group"
           @click="$dispatch('zone-clicked', 'head')"
           style="cursor:pointer;">
            {{-- Skull --}}
            <ellipse cx="60" cy="22" rx="16" ry="19"
                class="skeleton-zone {{ $headActive ? 'active' : '' }}"
                @mouseenter="hoveredZone='head'" @mouseleave="hoveredZone=null"/>
            {{-- Jaw --}}
            <path d="M48 34 Q60 44 72 34" fill="none" stroke="rgba(74,194,188,0.5)" stroke-width="1.2"/>
            {{-- Spine top --}}
            <line x1="60" y1="41" x2="60" y2="50" stroke="rgba(74,194,188,0.4)" stroke-width="1.2"/>
        </g>

        {{-- ===== TORSO ===== --}}
        @php $torsoActive = $activeZone === 'torso'; @endphp
        <g class="skeleton-zone-group"
           @click="$dispatch('zone-clicked', 'torso')"
           style="cursor:pointer;">
            {{-- Ribcage --}}
            <rect x="42" y="50" width="36" height="60" rx="6"
                class="skeleton-zone {{ $torsoActive ? 'active' : '' }}"
                @mouseenter="hoveredZone='torso'" @mouseleave="hoveredZone=null"/>
            {{-- Spine vertebrae --}}
            @for($i = 0; $i < 6; $i++)
            <rect x="57" y="{{ 54 + $i * 8 }}" width="6" height="5" rx="1"
                  fill="rgba(74,194,188,0.3)" stroke="rgba(74,194,188,0.5)" stroke-width="0.5"/>
            @endfor
            {{-- Ribs left --}}
            <path d="M57 60 Q48 64 44 70" fill="none" stroke="rgba(74,194,188,0.5)" stroke-width="1"/>
            <path d="M57 68 Q47 72 43 79" fill="none" stroke="rgba(74,194,188,0.5)" stroke-width="1"/>
            <path d="M57 76 Q47 80 44 87" fill="none" stroke="rgba(74,194,188,0.5)" stroke-width="1"/>
            {{-- Ribs right --}}
            <path d="M63 60 Q72 64 76 70" fill="none" stroke="rgba(74,194,188,0.5)" stroke-width="1"/>
            <path d="M63 68 Q73 72 77 79" fill="none" stroke="rgba(74,194,188,0.5)" stroke-width="1"/>
            <path d="M63 76 Q73 80 76 87" fill="none" stroke="rgba(74,194,188,0.5)" stroke-width="1"/>
            {{-- Pelvis --}}
            <path d="M42 110 Q30 118 34 132 Q60 140 86 132 Q90 118 78 110 Z"
                class="skeleton-zone {{ $torsoActive ? 'active' : '' }}"
                @mouseenter="hoveredZone='torso'" @mouseleave="hoveredZone=null"/>
        </g>

        {{-- ===== UPPER LIMBS ===== --}}
        @php $armsActive = $activeZone === 'upper_limbs'; @endphp
        <g class="skeleton-zone-group"
           @click="$dispatch('zone-clicked', 'upper_limbs')"
           style="cursor:pointer;">
            {{-- Left arm --}}
            <path d="M42 55 L28 90 L24 120 L26 155"
                  stroke="{{ $armsActive ? '#4AC2BC' : 'rgba(74,194,188,0.5)' }}"
                  stroke-width="{{ $armsActive ? '5' : '4' }}"
                  stroke-linecap="round" fill="none"
                  class="{{ $armsActive ? 'active' : '' }}"
                  @mouseenter="hoveredZone='upper_limbs'" @mouseleave="hoveredZone=null"/>
            {{-- Left hand --}}
            <ellipse cx="27" cy="160" rx="5" ry="8"
                  stroke="{{ $armsActive ? '#4AC2BC' : 'rgba(74,194,188,0.5)' }}"
                  stroke-width="1.2" fill="{{ $armsActive ? 'rgba(74,194,188,0.4)' : 'rgba(74,194,188,0.15)' }}"
                  @mouseenter="hoveredZone='upper_limbs'" @mouseleave="hoveredZone=null"/>
            {{-- Right arm --}}
            <path d="M78 55 L92 90 L96 120 L94 155"
                  stroke="{{ $armsActive ? '#4AC2BC' : 'rgba(74,194,188,0.5)' }}"
                  stroke-width="{{ $armsActive ? '5' : '4' }}"
                  stroke-linecap="round" fill="none"
                  @mouseenter="hoveredZone='upper_limbs'" @mouseleave="hoveredZone=null"/>
            {{-- Right hand --}}
            <ellipse cx="93" cy="160" rx="5" ry="8"
                  stroke="{{ $armsActive ? '#4AC2BC' : 'rgba(74,194,188,0.5)' }}"
                  stroke-width="1.2" fill="{{ $armsActive ? 'rgba(74,194,188,0.4)' : 'rgba(74,194,188,0.15)' }}"
                  @mouseenter="hoveredZone='upper_limbs'" @mouseleave="hoveredZone=null"/>
        </g>

        {{-- ===== LOWER LIMBS ===== --}}
        @php $legsActive = $activeZone === 'lower_limbs'; @endphp
        <g class="skeleton-zone-group"
           @click="$dispatch('zone-clicked', 'lower_limbs')"
           style="cursor:pointer;">
            {{-- Left thigh --}}
            <path d="M50 135 L44 190 L42 230"
                  stroke="{{ $legsActive ? '#4AC2BC' : 'rgba(74,194,188,0.5)' }}"
                  stroke-width="{{ $legsActive ? '7' : '6' }}"
                  stroke-linecap="round" fill="none"
                  @mouseenter="hoveredZone='lower_limbs'" @mouseleave="hoveredZone=null"/>
            {{-- Left shin --}}
            <path d="M42 232 L40 280 L38 310"
                  stroke="{{ $legsActive ? '#4AC2BC' : 'rgba(74,194,188,0.5)' }}"
                  stroke-width="{{ $legsActive ? '5' : '4' }}"
                  stroke-linecap="round" fill="none"
                  @mouseenter="hoveredZone='lower_limbs'" @mouseleave="hoveredZone=null"/>
            {{-- Left foot --}}
            <ellipse cx="36" cy="314" rx="10" ry="5"
                  stroke="{{ $legsActive ? '#4AC2BC' : 'rgba(74,194,188,0.5)' }}"
                  stroke-width="1.2" fill="{{ $legsActive ? 'rgba(74,194,188,0.4)' : 'rgba(74,194,188,0.15)' }}"
                  @mouseenter="hoveredZone='lower_limbs'" @mouseleave="hoveredZone=null"/>
            {{-- Right thigh --}}
            <path d="M70 135 L76 190 L78 230"
                  stroke="{{ $legsActive ? '#4AC2BC' : 'rgba(74,194,188,0.5)' }}"
                  stroke-width="{{ $legsActive ? '7' : '6' }}"
                  stroke-linecap="round" fill="none"
                  @mouseenter="hoveredZone='lower_limbs'" @mouseleave="hoveredZone=null"/>
            {{-- Right shin --}}
            <path d="M78 232 L80 280 L82 310"
                  stroke="{{ $legsActive ? '#4AC2BC' : 'rgba(74,194,188,0.5)' }}"
                  stroke-width="{{ $legsActive ? '5' : '4' }}"
                  stroke-linecap="round" fill="none"
                  @mouseenter="hoveredZone='lower_limbs'" @mouseleave="hoveredZone=null"/>
            {{-- Right foot --}}
            <ellipse cx="84" cy="314" rx="10" ry="5"
                  stroke="{{ $legsActive ? '#4AC2BC' : 'rgba(74,194,188,0.5)' }}"
                  stroke-width="1.2" fill="{{ $legsActive ? 'rgba(74,194,188,0.4)' : 'rgba(74,194,188,0.15)' }}"
                  @mouseenter="hoveredZone='lower_limbs'" @mouseleave="hoveredZone=null"/>

            {{-- Knee joints --}}
            <circle cx="43" cy="232" r="6" fill="{{ $legsActive ? 'rgba(74,194,188,0.35)' : 'rgba(74,194,188,0.15)' }}"
                    stroke="{{ $legsActive ? '#4AC2BC' : 'rgba(74,194,188,0.4)' }}" stroke-width="1.2"
                    @mouseenter="hoveredZone='lower_limbs'" @mouseleave="hoveredZone=null"/>
            <circle cx="77" cy="232" r="6" fill="{{ $legsActive ? 'rgba(74,194,188,0.35)' : 'rgba(74,194,188,0.15)' }}"
                    stroke="{{ $legsActive ? '#4AC2BC' : 'rgba(74,194,188,0.4)' }}" stroke-width="1.2"
                    @mouseenter="hoveredZone='lower_limbs'" @mouseleave="hoveredZone=null"/>
        </g>

        {{-- Shoulder joints --}}
        <circle cx="40" cy="54" r="5" fill="rgba(74,194,188,0.2)" stroke="rgba(74,194,188,0.5)" stroke-width="1"/>
        <circle cx="80" cy="54" r="5" fill="rgba(74,194,188,0.2)" stroke="rgba(74,194,188,0.5)" stroke-width="1"/>

    </svg>

    {{-- Zone label tooltip --}}
    <div x-show="hoveredZone"
         x-text="hoveredZone === 'head' ? '{{ __('Head / Neck') }}' : (hoveredZone === 'torso' ? '{{ __('Torso / Spine') }}' : (hoveredZone === 'upper_limbs' ? '{{ __('Arms') }}' : '{{ __('Legs') }}'))"
         style="text-align:center; font-size:0.65rem; font-weight:700; color:var(--color-primary); padding:0.25rem 0; letter-spacing:0.1em; text-transform:uppercase; min-height:1.25rem;">
    </div>
</div>
