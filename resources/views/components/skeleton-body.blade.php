@props([
    'skeletonParts' => [],   {{-- associative array keyed by svg_element_id --}}
])

{{--
  ╔═══════════════════════════════════════════════════════════════╗
  ║  INTERACTIVE SKELETON COMPONENT                               ║
  ║                                                               ║
  ║  • allbody.svg rendered as <img> (background)                 ║
  ║  • Transparent SVG polygon overlay for hit-testing            ║
  ║  • Tooltip-ONLY hover reaction (no fill/stroke changes)       ║
  ║  • Bone names driven by DB via $skeletonParts JSON            ║
  ╚═══════════════════════════════════════════════════════════════╝
--}}

{{-- ── Scoped ID so multiple instances on a page don't conflict ── --}}
@php $uid = 'sk-' . uniqid(); @endphp

<div id="{{ $uid }}" class="sk-root" style="position:relative; width:100%; user-select:none;">

<style>
/* ── Canvas maintains allbody.svg aspect ratio ── */
#{{ $uid }} .sk-canvas {
    position: relative;
    width: 100%;
    aspect-ratio: 282 / 751;
}

/* ── Background skeleton image ── */
#{{ $uid }} .sk-img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: fill;
    display: block;
    pointer-events: none;
}

/* ── Transparent SVG overlay ── */
#{{ $uid }} .sk-overlay {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    background: transparent;
    overflow: visible;
}

/* ── Zone polygons — ALWAYS fully transparent.
       Cursor changes to pointer for discoverability. ── */
#{{ $uid }} .sk-zone {
    fill:            transparent;
    stroke:          transparent;
    cursor:          pointer;
    /* NO hover fill/stroke — tooltip only */
}

/* ── Glassmorphism tooltip ── */
#{{ $uid }}-tooltip {
    position:         fixed;   /* fixed so it escapes any overflow:hidden parent */
    pointer-events:   none;
    z-index:          9999;
    display:          none;    /* shown via JS */
    padding:          6px 14px;
    border-radius:    10px;
    background:       rgba(3, 12, 22, 0.80);
    backdrop-filter:  blur(20px) saturate(1.9);
    -webkit-backdrop-filter: blur(20px) saturate(1.9);
    border:           1px solid rgba(99, 243, 236, 0.28);
    box-shadow:
        0 8px 32px rgba(0, 0, 0, 0.60),
        0 0 0 0.5px rgba(255,255,255,0.04) inset;
    /* Typography */
    font-family:      'Montserrat_am3', 'Inter', sans-serif;
    font-size:        11px;
    font-weight:      700;
    letter-spacing:   0.07em;
    text-transform:   uppercase;
    color:            #b2fdf9;
    white-space:      nowrap;
    /* Smooth fade */
    opacity:          0;
    transition:       opacity 0.14s ease;
}

#{{ $uid }}-tooltip.visible {
    opacity: 1;
}
</style>

{{-- ── Tooltip element (outside canvas to avoid clipping) ── --}}
<div id="{{ $uid }}-tooltip" role="tooltip" aria-live="polite"></div>

{{-- ── Canvas ── --}}
<div class="sk-canvas">

    <img class="sk-img"
         src="{{ asset('images/allbody.svg') }}"
         alt="{{ __('Human skeleton diagram') }}"
         draggable="false">

    {{--
      ════════════════════════════════════════════════════════════
      SVG OVERLAY  ·  viewBox 0 0 282 751
      Coordinates measured from the extracted 562×1496 PNG ÷ 2.
      All zones use fill="transparent" — tooltip-only interaction.
      ════════════════════════════════════════════════════════════
    --}}
    <svg class="sk-overlay"
         viewBox="0 0 282 751"
         xmlns="http://www.w3.org/2000/svg"
         preserveAspectRatio="none"
         aria-hidden="true"
         focusable="false">

        {{-- ═══ JAW (unpaired) ═══ --}}
        <polygon class="sk-zone" data-part="jaw"
            points="125,82 157,82 163,90 160,100 155,108 148,114 134,114 127,108 122,100 119,90"/>

        {{-- ═══ CERVICAL SPINE (unpaired) ═══ --}}
        <polygon class="sk-zone" data-part="cervical-spine"
            points="134,114 148,114 150,120 150,168 132,168 132,120"/>

        {{-- ═══ CLAVICLE — left ═══ --}}
        <polygon class="sk-zone" data-part="clavicle-l"
            points="88,120 132,118 134,128 92,132"/>
        {{-- ═══ CLAVICLE — right ═══ --}}
        <polygon class="sk-zone" data-part="clavicle-r"
            points="150,118 194,120 190,132 148,128"/>

        {{-- ═══ THORACIC SPINE (unpaired) ═══ --}}
        <polygon class="sk-zone" data-part="thoracic-spine"
            points="132,168 150,168 150,280 132,280"/>

        {{-- ═══ LUMBAR SPINE (unpaired) ═══ --}}
        <polygon class="sk-zone" data-part="lumbar-spine"
            points="130,280 152,280 154,362 128,362"/>

        {{-- ═══ SHOULDER JOINT — left ═══ --}}
        <polygon class="sk-zone" data-part="shoulder-l"
            points="74,126 92,132 84,142 82,160 68,150 66,136"/>
        {{-- ═══ SHOULDER JOINT — right ═══ --}}
        <polygon class="sk-zone" data-part="shoulder-r"
            points="190,132 208,126 216,136 214,150 200,160 198,142"/>

        {{-- ═══ HUMERUS — left ═══ --}}
        <polygon class="sk-zone" data-part="humerus-l"
            points="68,160 82,160 78,200 72,240 66,272 56,272 62,240 68,200"/>
        {{-- ═══ HUMERUS — right ═══ --}}
        <polygon class="sk-zone" data-part="humerus-r"
            points="200,160 214,160 214,200 220,240 226,272 216,272 210,240 204,200"/>

        {{-- ═══ ULNA — left ═══ --}}
        <polygon class="sk-zone" data-part="ulna-l"
            points="56,272 66,272 58,320 52,360 46,400 36,400 42,360 48,320"/>
        {{-- ═══ ULNA — right ═══ --}}
        <polygon class="sk-zone" data-part="ulna-r"
            points="216,272 226,272 234,320 240,360 246,400 236,400 230,360 224,320"/>

        {{-- ═══ RADIUS — left ═══ --}}
        <polygon class="sk-zone" data-part="radius-l"
            points="46,280 56,272 48,320 42,360 36,400 26,410 32,360 38,320"/>
        {{-- ═══ RADIUS — right ═══ --}}
        <polygon class="sk-zone" data-part="radius-r"
            points="226,272 236,280 244,320 250,360 256,410 246,400 240,360 234,320"/>

        {{-- ═══ HAND — left ═══ --}}
        <polygon class="sk-zone" data-part="hand-l"
            points="14,470 36,428 42,440 36,468 30,490 20,508 16,520
                    26,530 42,536 56,540 68,536 78,530 82,520
                    78,510 72,498 66,486 56,476 46,468 38,462 30,460"/>
        {{-- ═══ HAND — right ═══ --}}
        <polygon class="sk-zone" data-part="hand-r"
            points="246,428 268,470 252,460 244,462 236,468 226,476
                    216,486 210,498 204,510 200,520 204,530
                    214,536 226,540 240,536 256,530 266,520
                    262,508 252,490 246,468 240,440"/>

        {{-- ═══ PELVIS — left ═══ --}}
        <polygon class="sk-zone" data-part="pelvis-l"
            points="96,362 140,362 140,390 136,406 128,416 116,420 104,416 96,406 92,390"/>
        {{-- ═══ PELVIS — right ═══ --}}
        <polygon class="sk-zone" data-part="pelvis-r"
            points="142,362 186,362 190,390 186,406 178,416 166,420 154,416 146,406 142,390"/>

        {{-- ═══ HIP JOINT — left ═══ --}}
        <polygon class="sk-zone" data-part="hip-l"
            points="108,416 132,416 136,430 134,444 126,448 112,448 106,444 104,430"/>
        {{-- ═══ HIP JOINT — right ═══ --}}
        <polygon class="sk-zone" data-part="hip-r"
            points="150,416 174,416 178,430 176,444 170,448 156,448 150,444 148,430"/>

        {{-- ═══ FEMUR — left ═══ --}}
        <polygon class="sk-zone" data-part="femur-l"
            points="106,448 132,448 130,490 128,530 124,570 120,590 108,590 104,570 102,530 100,490"/>
        {{-- ═══ FEMUR — right ═══ --}}
        <polygon class="sk-zone" data-part="femur-r"
            points="150,448 176,448 182,490 180,530 178,570 174,590 162,590 158,570 154,530 152,490"/>

        {{-- ═══ KNEE JOINT — left ═══ --}}
        <polygon class="sk-zone" data-part="knee-l"
            points="104,590 124,590 126,600 124,614 102,614 100,600"/>
        {{-- ═══ KNEE JOINT — right ═══ --}}
        <polygon class="sk-zone" data-part="knee-r"
            points="158,590 178,590 180,600 178,614 160,614 156,600"/>

        {{-- ═══ TIBIA — left ═══ --}}
        <polygon class="sk-zone" data-part="tibia-l"
            points="102,614 120,614 118,650 116,690 112,714 100,714 96,690 98,650"/>
        {{-- ═══ TIBIA — right ═══ --}}
        <polygon class="sk-zone" data-part="tibia-r"
            points="162,614 180,614 184,650 186,690 182,714 170,714 166,690 164,650"/>

        {{-- ═══ FIBULA — left ═══ --}}
        <polygon class="sk-zone" data-part="fibula-l"
            points="88,618 98,614 96,650 94,690 90,712 82,710 84,690 86,650"/>
        {{-- ═══ FIBULA — right ═══ --}}
        <polygon class="sk-zone" data-part="fibula-r"
            points="184,614 194,618 196,650 198,690 200,710 192,712 188,690 186,650"/>

        {{-- ═══ FOOT — left ═══ --}}
        <polygon class="sk-zone" data-part="foot-l"
            points="82,714 112,714 108,724 104,734 96,742 86,748 74,748
                    66,744 62,738 60,728 62,718 68,714"/>
        {{-- ═══ FOOT — right ═══ --}}
        <polygon class="sk-zone" data-part="foot-r"
            points="170,714 200,714 214,718 220,728 222,738 218,744
                    210,748 196,748 186,742 178,734 174,724"/>

    </svg>
</div>{{-- /.sk-canvas --}}

{{-- ── Vanilla JS: tooltip & click filtering driven by DB data ── --}}
<script>
(function () {
    const PARTS = @json($skeletonParts);
    const root    = document.getElementById('{{ $uid }}');
    const tooltip = document.getElementById('{{ $uid }}-tooltip');

    if (!root || !tooltip) return;

    function positionTooltip(e) {
        tooltip.style.left = (e.clientX + 14) + 'px';
        tooltip.style.top  = (e.clientY - 38) + 'px';
    }

    function showTooltip(label, e) {
        tooltip.textContent = label;
        tooltip.style.display = 'block';
        positionTooltip(e);
        requestAnimationFrame(() => tooltip.classList.add('visible'));
    }

    function hideTooltip() {
        tooltip.classList.remove('visible');
        setTimeout(() => {
            if (!tooltip.classList.contains('visible')) {
                tooltip.style.display = 'none';
            }
        }, 160);
    }

    root.querySelectorAll('.sk-zone').forEach(zone => {
        const partId = zone.dataset.part;
        if (!partId || !PARTS[partId]) return;

        const data = PARTS[partId];

        zone.addEventListener('mouseenter', e => showTooltip(data.name, e));
        zone.addEventListener('mousemove', positionTooltip);
        zone.addEventListener('mouseleave', hideTooltip);
        zone.addEventListener('click', function () {
            if (data.body_part_id) {
                const url = new URL(window.location.href);
                url.pathname = '{{ route("products.index") }}'.replace(window.location.origin, '');
                url.searchParams.set('body_part', data.body_part_id);
                window.location.href = url.toString();
            }
        });
    });
})();
</script>

</div>{{-- /.sk-root --}}
