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
</div><?php /**PATH C:\xampp\htdocs\bemv2\resources\views/components/alert.blade.php ENDPATH**/ ?>