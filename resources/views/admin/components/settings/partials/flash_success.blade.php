@if(session('success'))
    <div class="settings-flash-success" id="settings-flash-success">
        {{ session('success') }}
    </div>
@endif

<style>
    .settings-flash-success {
        position: relative;
        margin: 0 0 18px;
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
</style>

<script>
    (function () {
        const alertBox = document.getElementById('settings-flash-success');
        if (!alertBox) return;

        setTimeout(() => {
            alertBox.style.transition = 'opacity .2s ease, transform .2s ease';
            alertBox.style.opacity = '0';
            alertBox.style.transform = 'translateY(-8px)';
            setTimeout(() => alertBox.remove(), 220);
        }, 2500);
    })();
</script>