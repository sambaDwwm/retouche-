<div id="message" class="alert alert-dismissible alert-<?= $typeMessage ?>">
    <button type="button" onclick="fermerMessage()" class="btn-close" data-bs-dismiss="alert"></button>
    <?= $_SESSION['message'] ?>
</div>
<script>
    setTimeout(fermerMessage, 5000);

    function fermerMessage() {
        const message = document.querySelector("#message");
        if (message) {
            message.remove();
        }
    }
</script>