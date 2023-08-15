<div>
    <?php if( $status == 'success' ): ?> 
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil, </strong> <?php echo e($message); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php else: ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal, </strong> <?php echo e($message); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
</div><?php /**PATH C:\xampp\htdocs\mhmmdd-bem-pembayaran\resources\views/components/alert-bootstrap.blade.php ENDPATH**/ ?>