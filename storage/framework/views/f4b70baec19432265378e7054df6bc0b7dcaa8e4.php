<?php $__env->startSection('content'); ?>
    <?php if (isset($component)) { $__componentOriginal46181af093c0588736b695b142193e4826bffbfd = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\HeaderBreadcrumb::class, ['header' => $title]); ?>
<?php $component->withName('header-breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal46181af093c0588736b695b142193e4826bffbfd)): ?>
<?php $component = $__componentOriginal46181af093c0588736b695b142193e4826bffbfd; ?>
<?php unset($__componentOriginal46181af093c0588736b695b142193e4826bffbfd); ?>
<?php endif; ?>
    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h4><?php echo e($title); ?></h4>
                </div>
                <div class="card-body">
                    <?php if(Session::get('failed')): ?>
                        <?php if (isset($component)) { $__componentOriginalb41a9f76cdbb797a0d9c929463ddbcbd7e7b2f9c = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AlertBootstrap::class, ['status' => 'failed','message' => Session::get('failed')]); ?>
<?php $component->withName('alert-bootstrap'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb41a9f76cdbb797a0d9c929463ddbcbd7e7b2f9c)): ?>
<?php $component = $__componentOriginalb41a9f76cdbb797a0d9c929463ddbcbd7e7b2f9c; ?>
<?php unset($__componentOriginalb41a9f76cdbb797a0d9c929463ddbcbd7e7b2f9c); ?>
<?php endif; ?>
                    <?php endif; ?>
                    <form action="<?php echo e(url('app-admin/mahasiswa/' . $mahasiswa->nim . '/bayar/' . encrypt($iuran->id) . '/' . $iuran->id)); ?>" method="post" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label for="nim" class="font-weight-bold">Nama Mahasiswa <span class="text-danger">*</span></label>
                            <input type="text" placeholder="nama mahasiswa" class="form-control" autocomplete="off" readonly="" value="<?php echo e($mahasiswa->nama); ?>">
                            <input type="hidden" name="nim" value="<?php echo e(encrypt($mahasiswa->nim)); ?>">
                        </div>
                        <div class="form-group">
                            <label for="id_iuran" class="font-weight-bold">Iuran Tahun Akademik <span class="text-danger">*</span></label>
                            <input type="text" placeholder="tahun akademik" class="form-control" autocomplete="off" readonly="" value="<?php echo e(\App\Models\TahunAjaran::findActivedTahunAjaran()->start_year); ?> / <?php echo e(\App\Models\TahunAjaran::findActivedTahunAjaran()->end_year); ?>">
                            <input type="hidden" name="id_iuran" value="<?php echo e(encrypt($iuran->id_iuran)); ?>">
                        </div>
                        <div class="form-group">
                            <label for="id_iuran" class="font-weight-bold">Iuran Semester <span class="text-danger">*</span></label>
                            <input type="text" placeholder="semester" class="form-control" autocomplete="off" readonly="" value="<?php echo e($semester); ?>">
                            <input type="hidden" name="semester_iuran" value="<?php echo e($semester); ?>">
                        </div>
                        <div class="form-group">
                            <label for="id_iuran" class="font-weight-bold">Nominal Iuran<span class="text-danger">*</span></label>
                            <input type="text" placeholder="nominal iuran" class="form-control" autocomplete="off" readonly="" value="Rp. <?php echo e(number_format($iuran->nominal, 0, '.', '.')); ?>">
                        </div>
                        <div class="form-group">
                            <label for="jumlah_bayar" class="font-weight-bold">Jumlah Bayar</label>
                            <input type="text" name="jumlah_bayar" class="form-control <?php $__errorArgs = ['jumlah_bayar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="jumlah bayar" value="<?php echo e(old('jumlah_bayar')); ?>" id="jumlah_bayar" autocomplete="off" required max="<?php echo e($iuran->nominal); ?>">
                        </div>
                        <hr>
                        <div class="form-group d-flex justify-content-between">
                            <button class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
                            <a href="<?php echo e(url('/app-admin/mahasiswa/' . encrypt($mahasiswa->nim) . '/lihat-iuran')); ?>" class="btn btn-dark">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<?php $__env->startSection('script'); ?>
    <script>
        const jumlah_bayar = document.getElementById('jumlah_bayar');
        jumlah_bayar.addEventListener('keydown', function(event) {
            return isNumberKey(event);
        });
        jumlah_bayar.addEventListener('keyup', function() {
            jumlah_bayar.value = convertRupiah(this.value, 'Rp. ');
        });
    </script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/tomy/htdocs/matursoft/clients/mhmmdd-bem-pembayaran/resources/views/admin/pages/mahasiswa/create-iuran.blade.php ENDPATH**/ ?>