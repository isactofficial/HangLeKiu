<div class="settings-inline-notice-slot" id="settings-inline-notice-slot"></div>

<style>
    .settings-inline-notice-slot {
        display: block;
        width: 100%;
        margin: 0 0 18px;
    }
    .settings-inline-notice {
        padding: 14px 18px;
        border-radius: 14px;
        background: #FFF7F1;
        color: #582C0C;
        border: 1px solid #D9B69A;
        font-size: 14px;
        font-weight: 600;
        line-height: 1.5;
        box-shadow: 0 10px 24px rgba(88, 44, 12, 0.08);
    }
    .settings-inline-notice.error {
        background: #FEF7F4;
        color: #582C0C;
        border-color: #D6B191;
    }
</style>

<script>
    (function () {
        window.showSettingsInlineNotice = function (message, type = 'success') {
            const slot = document.getElementById('settings-inline-notice-slot');
            if (!slot) return;

            const existing = slot.querySelector('.settings-inline-notice');
            if (existing) existing.remove();

            const notice = document.createElement('div');
            notice.className = `settings-inline-notice ${type === 'error' ? 'error' : ''}`;
            notice.textContent = message;
            notice.style.opacity = '0';
            notice.style.transform = 'translateY(-6px)';
            notice.style.transition = 'opacity .2s ease, transform .2s ease';

            slot.appendChild(notice);
            requestAnimationFrame(() => {
                notice.style.opacity = '1';
                notice.style.transform = 'translateY(0)';
            });

            setTimeout(() => {
                notice.style.opacity = '0';
                notice.style.transform = 'translateY(-6px)';
                setTimeout(() => notice.remove(), 220);
            }, 2500);
        };
    })();
</script>