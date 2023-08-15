<div>
    <script>
        <?php if( $status == 'success' ): ?> 
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '<?php echo e($message); ?>',
            })
        <?php else: ?>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '<?php echo e($message); ?>',
            })
        <?php endif; ?> 
    </script>
</div><?php /**PATH /home/tomy/htdocs/matursoft/clients/mhmmdd-bem-pembayaran/resources/views/components/alert.blade.php ENDPATH**/ ?>