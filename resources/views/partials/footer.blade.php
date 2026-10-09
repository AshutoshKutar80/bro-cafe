<footer
    style="border-top: 3px solid var(--border); background: var(--black); color: var(--white); padding: 40px 0 20px; margin-top: 60px;">
    <div class="container">
        <div
            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 32px; margin-bottom: 32px;">
            <div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                    <span class="logo-badge"
                        style="background: var(--yellow); color: var(--black); padding: 4px 10px; border: 3px solid var(--yellow); font-family: 'Archivo Black'; font-size: 16px;">BRO</span>
                    <span style="font-family: 'Archivo Black'; font-size: 18px;">CAFE</span>
                </div>
                <p style="font-size: 13px; opacity: 0.7;">Good Coffee. Good Mood.<br>Freshly brewed. Always better.</p>
            </div>
            <div>
                <h4 style="font-size: 13px; margin-bottom: 12px; color: var(--yellow);">Quick Links</h4>
                <a href="{{ route('home') }}"
                    style="display: block; font-size: 13px; padding: 4px 0; opacity: 0.8;">Home</a>
                <a href="{{ route('menu') }}"
                    style="display: block; font-size: 13px; padding: 4px 0; opacity: 0.8;">Menu</a>
                <a href="#" style="display: block; font-size: 13px; padding: 4px 0; opacity: 0.8;">Offers</a>
                <a href="#" style="display: block; font-size: 13px; padding: 4px 0; opacity: 0.8;">Contact</a>
            </div>
            <div>
                <h4 style="font-size: 13px; margin-bottom: 12px; color: var(--yellow);">Contact</h4>
                <p style="font-size: 13px; opacity: 0.8; padding: 4px 0;">📞
                    {{ \App\Models\Setting::get('cafe_phone', '+91 9999999999') }}</p>
                <p style="font-size: 13px; opacity: 0.8; padding: 4px 0;">📍
                    {{ \App\Models\Setting::get('cafe_address', 'Main Road, Your City') }}</p>
            </div>
        </div>
        <div
            style="border-top: 2px solid rgba(255,255,255,0.15); padding-top: 20px; text-align: center; font-size: 12px; opacity: 0.6;">
            © {{ date('Y') }} BRO CAFE. Built with ☕ &amp; 🔥
        </div>
    </div>
</footer>
