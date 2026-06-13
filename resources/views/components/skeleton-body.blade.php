@props([
    'activeZone'    => null,
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

        {{-- HEAD & NECK --}}
        <polygon class="sk-zone" data-zone="head"
            points="128,4 154,4 168,10 176,22 178,38 176,54 173,68 168,78 163,85
                    156,92 152,100 150,112 148,120 134,120 132,112 130,100
                    125,92 119,85 114,78 108,68 105,54 103,38 105,22 114,10"/>

        {{-- TORSO (clavicles → ribcage → spine → pelvis) --}}
        <polygon class="sk-zone" data-zone="torso"
            points="134,120 148,120 158,122 170,124 185,126 200,128 210,132
                    218,140 220,155 218,175 214,200 210,225 208,250 208,275
                    210,300 212,320 212,340 208,360 202,378 196,392 188,405
                    180,412 170,415 155,418 141,418 127,415 118,412 110,405
                    104,392 98,378 94,360 90,340 90,320 92,300 94,275 94,250
                    92,225 88,200 84,175 82,155 84,140 92,132 100,128 115,126
                    130,124 142,122"/>

        {{-- LEFT ARM (viewer's left = image left) --}}
        <polygon class="sk-zone" data-zone="upper_limbs"
            points="84,132 92,132 82,155 82,175 75,205 68,240 62,275 56,305
                    52,330 48,355 44,380 40,405 36,428 30,448 24,465 18,478
                    14,490 12,505 14,515 18,522 28,530 40,535 50,538 62,540
                    72,538 80,534 84,528 82,518 78,508 74,498 72,488 74,475
                    78,460 84,445 90,428 94,412 98,395 98,378 94,360 90,340
                    90,320 92,300 94,275 92,250 88,225 84,200 84,175 82,155
                    84,140"/>

        {{-- RIGHT ARM (viewer's right = image right) --}}
        <polygon class="sk-zone" data-zone="upper_limbs"
            points="198,132 210,132 220,140 220,155 218,175 218,200 214,225
                    210,250 188,275 196,305 202,330 208,355 214,380 222,405
                    226,428 230,448 236,465 242,478 248,490 252,505 250,515
                    246,522 240,530 230,535 218,538 206,540 196,538 188,534
                    182,528 180,518 182,508 186,498 190,488 188,475 186,460
                    182,445 178,428 172,412 168,395 166,378 166,360 168,340
                    170,320 170,300 172,275 172,250 170,225 168,200 166,175
                    166,155 168,140 178,132 188,126 200,128 210,132"/>

        {{-- LEFT LEG (viewer's left = image left) --}}
        <polygon class="sk-zone" data-zone="lower_limbs"
            points="118,415 141,418 145,425 146,440 144,458 140,478 136,500
                    132,522 128,544 125,562 123,578 121,595 120,610 120,624
                    121,638 122,650 122,662 120,675 118,688 116,700 112,712
                    108,722 104,732 98,740 90,745 82,748 74,748 68,744 64,738
                    60,730 58,718 60,706 64,694 70,682 76,670 80,658 82,646
                    82,634 82,620 82,606 84,590 86,574 88,556 90,538 92,518
                    94,498 96,478 98,458 99,440 98,425 96,418"/>

        {{-- RIGHT LEG (viewer's right = image right) --}}
        <polygon class="sk-zone" data-zone="lower_limbs"
            points="141,418 164,415 183,418 184,425 183,440 182,458 180,478
                    178,498 176,518 174,538 172,556 170,574 168,590 166,606
                    166,620 166,634 168,646 170,658 172,670 176,682 182,694
                    186,706 186,718 184,730 180,738 174,744 166,748 158,748
                    150,745 142,740 136,730 132,720 128,710 124,700 122,688
                    120,675 120,662 120,650 120,638 121,624 122,610 123,595
                    124,578 126,562 128,544 130,522 132,500 134,478 136,458
                    136,440 136,425 136,418"/>

    </svg>
</div>{{-- /.sk-canvas --}}

{{-- ── Vanilla JS: tooltip driven entirely by DB data ── --}}
<script>
(function () {
    // ── Data from DB: { 'svg_element_id': { name_hy: '...' }, ... }
    // We also build a fallback map from data-zone → generic Armenian label
    const PARTS   = @json($skeletonParts);
    const ZONES   = {
        head:         'Գլուխ / Պարանոց',
        torso:        'Իրան / Ողնաշար',
        upper_limbs:  'Վերին վերջույթներ',
        lower_limbs:  'Ստորին վերջույթներ',
    };

    const root    = document.getElementById('{{ $uid }}');
    const tooltip = document.getElementById('{{ $uid }}-tooltip');

    if (!root || !tooltip) return;

    const zones   = root.querySelectorAll('.sk-zone');
    let   rafId   = null;
    let   targetX = 0;
    let   targetY = 0;

    // ── Position tooltip near cursor (offset so it doesn't cover the bone)
    function positionTooltip(e) {
        const x = e.clientX + 14;
        const y = e.clientY - 38;
        tooltip.style.left = x + 'px';
        tooltip.style.top  = y + 'px';
    }

    // ── Show tooltip with a bone label
    function showTooltip(label, e) {
        tooltip.textContent = label;
        tooltip.style.display = 'block';
        positionTooltip(e);
        // Trigger CSS fade-in on next frame
        requestAnimationFrame(() => tooltip.classList.add('visible'));
    }

    // ── Hide tooltip
    function hideTooltip() {
        tooltip.classList.remove('visible');
        // Wait for fade-out before hiding
        setTimeout(() => {
            if (!tooltip.classList.contains('visible')) {
                tooltip.style.display = 'none';
            }
        }, 160);
    }

    // ── Attach listeners to each polygon zone
    zones.forEach(zone => {
        const zoneKey = zone.dataset.zone; // e.g. 'head', 'torso', ...

        zone.addEventListener('mouseenter', function (e) {
            // 1. Try to match by svg_element_id if zone has a data-part attr
            const partId = zone.dataset.part;
            let label    = null;

            if (partId && PARTS[partId]) {
                label = PARTS[partId].name_hy;
            }

            // 2. Fallback to zone-level generic label
            if (!label && zoneKey && ZONES[zoneKey]) {
                label = ZONES[zoneKey];
            }

            if (label) showTooltip(label, e);
        });

        zone.addEventListener('mousemove', positionTooltip);

        zone.addEventListener('mouseleave', hideTooltip);

        // ── Click: dispatch zone-clicked for parent Alpine to handle filtering
        zone.addEventListener('click', function () {
            if (zoneKey) {
                zone.dispatchEvent(new CustomEvent('zone-clicked', {
                    detail: zoneKey,
                    bubbles: true,
                    composed: true,
                }));
            }
        });
    });

    // ── Also listen on individual named elements inside the SVG image
    // (for when allbody.svg is eventually replaced with a proper inline SVG)
    // This hooks on any element that has an id matching a PARTS key.
    root.querySelectorAll('[id]').forEach(el => {
        const id = el.id;
        if (PARTS[id]) {
            el.style.cursor = 'pointer';
            el.addEventListener('mouseenter', e => showTooltip(PARTS[id].name_hy, e));
            el.addEventListener('mousemove',  positionTooltip);
            el.addEventListener('mouseleave', hideTooltip);
        }
    });

})();
</script>

</div>{{-- /.sk-root --}}
