<?php 
require_once 'includes/header.php';
require_once 'includes/classes/VideoDetailsFormProvider.php';
?>

<div class="column">

    <?php
    $formProvider = new VideoDetailsFormProvider($con);
    echo $formProvider->createUploadForm();
    ?>

</div>

<script>
$("form").submit(() => $("#loadingModal").modal("show"));
</script>

<div class="modal fade" id="loadingModal" tabindex="-1" aria-labelledby="loadingModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="assets/img/icons/loading-spinner.gif">
                <p><small>Please Wait. This might take a while..</small></p>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php' ?>
