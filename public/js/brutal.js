/* ============================================================
   BRO CAFE — JS
   ============================================================ */
(function(window) {
    'use strict';

    const BRO = {
        csrf() {
            return document.querySelector('meta[name="csrf-token"]')?.content || '';
        },

        /* ---------- THEME ---------- */
        toggleTheme() {
            const html = document.documentElement;
            const current = html.getAttribute('data-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
            window.dispatchEvent(new Event('theme-changed'));

            fetch('/account/theme', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': BRO.csrf(),
                },
                body: JSON.stringify({ theme_preference: next })
            }).catch(() => {});
        },

        /* ---------- REVEAL ---------- */
        initReveal() {
            if (!('IntersectionObserver' in window)) {
                document.querySelectorAll('.reveal').forEach(el => el.classList.add('visible'));
                return;
            }
            const obs = new IntersectionObserver((entries) => {
                entries.forEach((e, i) => {
                    if (e.isIntersecting) {
                        setTimeout(() => e.target.classList.add('visible'), i * 60);
                        obs.unobserve(e.target);
                    }
                });
            }, { threshold: 0.1 });
            document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
        },

        /* ---------- CART ---------- */
        async addToCart(productId, qty = 1, btnEl = null) {
            try {
                const res = await fetch('/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': BRO.csrf(),
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ product_id: productId, quantity: qty })
                });
                if (res.status === 401) {
                    window.location.href = '/login';
                    return;
                }
                const data = await res.json();
                if (data.success) {
                    BRO.updateCartCount(data.cart_count);
                    BRO.toast(data.message || 'Added to cart!', 'success');
                    if (btnEl) BRO.pulse(btnEl);
                }
            } catch (e) {
                BRO.toast('Could not add to cart', 'error');
            }
        },

        async updateCartItem(itemId, qty) {
            const res = await fetch(`/cart/update/${itemId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': BRO.csrf(),
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ quantity: qty })
            });
            const data = await res.json();
            if (data.success) {
                BRO.updateCartCount(data.cart_count);
                window.location.reload();
            }
        },

        updateCartCount(count) {
            const el = document.getElementById('cart-count');
            if (!el) return;
            el.textContent = count;
            el.classList.remove('pop');
            void el.offsetWidth;
            el.classList.add('pop');
        },

        pulse(el) {
            el.style.transform = 'scale(0.95)';
            setTimeout(() => el.style.transform = 'scale(1)', 120);
        },

        /* ---------- TOAST ---------- */
        toast(message, type = 'success') {
            const el = document.createElement('div');
            el.className = `toast toast-${type}`;
            el.textContent = message;
            document.body.appendChild(el);
            setTimeout(() => {
                el.style.opacity = '0';
                el.style.transform = 'translateX(120%)';
                el.style.transition = 'all 300ms ease';
                setTimeout(() => el.remove(), 300);
            }, 2500);
        },

        /* ---------- INIT ---------- */
        init() {
            BRO.initReveal();

            document.body.addEventListener('click', (e) => {
                const addBtn = e.target.closest('[data-add-to-cart]');
                if (addBtn) {
                    e.preventDefault();
                    BRO.addToCart(addBtn.dataset.addToCart, 1, addBtn);
                }

                const updBtn = e.target.closest('[data-cart-update]');
                if (updBtn) {
                    e.preventDefault();
                    BRO.updateCartItem(updBtn.dataset.cartUpdate, parseInt(updBtn.dataset.qty));
                }

                const remBtn = e.target.closest('[data-cart-remove]');
                if (remBtn) {
                    e.preventDefault();
                    fetch(`/cart/remove/${remBtn.dataset.cartRemove}`, {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': BRO.csrf(), 'Accept': 'application/json' }
                    }).then(() => window.location.reload());
                }
            });

            // Auto-dismiss toasts
            document.querySelectorAll('[data-toast]').forEach(t => {
                setTimeout(() => {
                    t.style.transition = 'all 300ms ease';
                    t.style.opacity = '0';
                    t.style.transform = 'translateX(120%)';
                    setTimeout(() => t.remove(), 300);
                }, 3000);
            });
        }
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', BRO.init);
    } else {
        BRO.init();
    }

    window.BRO = BRO;
})(window);