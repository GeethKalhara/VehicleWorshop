<?php
/**
 * @var string|null $flashMessage
 * @var string|null $flashType
 */
if (!empty($flashMessage)):
    $isError = ($flashType ?? 'success') === 'error';
    ?>
<div id="authToast" class="auth-toast show" role="status" aria-live="polite">
    <svg class="w-5 h-5" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="<?= $isError ? '#EF4444' : '#10B981' ?>" stroke-width="2.5">
        <?php if ($isError): ?>
            <circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line>
        <?php else: ?>
            <polyline points="20 6 9 17 4 12"></polyline>
        <?php endif; ?>
    </svg>
    <span id="authToastMessage"><?= htmlspecialchars($flashMessage) ?></span>
</div>
<script>
    setTimeout(() => {
        const toast = document.getElementById('authToast');
        if (toast) toast.classList.remove('show');
    }, 4000);
</script>
<?php endif; ?>
