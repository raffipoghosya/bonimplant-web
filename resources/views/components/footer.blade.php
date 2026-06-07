{{--
    Footer Component
    - Main logo (logo.png) on left above contact info
    - Decorative implant image (footerleftlogo.png) on right
    - No center nav column (matches Figma)
--}}
<footer class="site-footer">
    <div class="container-site" style="padding-top:3.5rem; padding-bottom:3.5rem;">

        {{-- 2-column footer grid: Logo+Contact (left) | Decorative image (right) --}}
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:2rem; align-items:center; position:relative;">

            {{-- LEFT: Logo + Contact info --}}
            <div>
                <a href="{{ route('home') }}" style="display:inline-block; margin-bottom:2rem;">
                    <img src="{{ asset('images/logo.png') }}"
                         alt="BonImplant"
                         style="height:56px; width:auto; display:block;">
                </a>

                <div style="display:flex; flex-direction:column; gap:0.875rem; margin-bottom:1.5rem;">
                    <a href="https://maps.google.com/?q=Yerevan+Sharav-Azbuyu+55a"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="footer-contact-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                        </svg>
                        {{ __('messages.footer_address') }}
                    </a>
                    <a href="tel:+37433625050" class="footer-contact-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 6.75Z"/>
                        </svg>
                        {{ __('messages.footer_phone') }}
                    </a>
                    <a href="mailto:info@justartmed.com" class="footer-contact-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/>
                        </svg>
                        {{ __('messages.footer_email') }}
                    </a>
                </div>
            </div>

            {{-- RIGHT: Decorative implant image (moved from left) --}}
            <div style="display:flex; align-items:center; justify-content:flex-end;">
                <img src="{{ asset('images/footerleftlogo.png') }}"
                     alt="Bone Implant"
                     style="max-width:420px; width:100%; opacity:0.85;"
                     onerror="this.style.display='none'">
            </div>
        </div>

        {{-- Bottom bar: copyright + design credit --}}
        <!-- <div style="display:flex; justify-content:space-between; align-items:center; padding-top:2rem; margin-top:1.5rem; border-top:1px solid rgba(255,255,255,0.35);"> -->
            <span style="font-size:0.8rem; color:rgba(255,255,255,0.35);">
                {{ __('messages.footer_copyright') }}
            </span>
            <span style="font-size:0.8rem; color:rgba(255,255,255,0.35);">
                {{ __('messages.footer_design') }}
            </span>
        </div>

    </div>
</footer>
