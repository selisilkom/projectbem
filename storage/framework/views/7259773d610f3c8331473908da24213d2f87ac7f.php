

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
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h4>List Data <?php echo e($title); ?></h4>
                </div>
                <div class="card-body">
                    <?php if(Auth::guard('petugas')->check()): ?>
                        <a href="<?php echo e(url('/app-admin/pengeluaran/create')); ?>" class="btn btn-primary mb-4">Tambah
                            <?php echo e($title); ?></a>
                    <?php endif; ?>
                    <?php if(Session::get('success')): ?>
                        <?php if (isset($component)) { $__componentOriginalb41a9f76cdbb797a0d9c929463ddbcbd7e7b2f9c = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AlertBootstrap::class, ['status' => 'success','message' => Session::get('success')]); ?>
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

                    <?php if($rows_pengeluaran->isEmpty()): ?>
                        <div class="d-flex flex-column align-items-center justify-content-center">
                            <div class="row w-100">
                                <div class="col-10 offset-1 col-lg-4 offset-lg-4">
                                    <img src="<?php echo e(asset('/admin/assets/img/No data-amico.svg')); ?>" class="w-100">
                                </div>
                            </div>
                            <h2>Tidak ada data</h2>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <tbody>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Pengeluaran</th>
                                        <th>Jumlah</th>
                                        <th>Deskripsi</th>
                                        <th>PDF</th>
                                        <?php if(Auth::guard('petugas')->check()): ?>
                                            <th>Aksi</th>
                                        <?php endif; ?>
                                    </tr>
                                    <?php $__currentLoopData = $rows_pengeluaran; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pengeluaran): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($loop->iteration + $rows_pengeluaran->firstItem() - 1); ?></td>
                                            <td><?php echo e($pengeluaran->nama_pengeluaran); ?></td>
                                            <td>Rp. <?php echo e(number_format($pengeluaran->jumlah, 0, '.', '.')); ?></td>
                                            <td><?php echo e($pengeluaran->deskripsi); ?></td>
                                            <td><a target="_blank" href="<?php echo e(url('/storage/images/pengeluaran/' . $pengeluaran->pdf_file)); ?>" class="btn btn-sm btn-success"><i class="fas fa-download"></i> Download</a></td>
                                            <?php if(Auth::guard('petugas')->check()): ?>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-danger" onclick="deleteRow('Pengeluaran <?php echo e($pengeluaran->nama_pengeluaran); ?>', '<?php echo e(url('/app-admin/pengeluaran/' . encrypt($pengeluaran->id_pengeluaran))); ?>')"><i class="fas fa-trash"></i> Hapus</a>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>

                </div>
                <div class="card-footer text-left mb-4">
                    <?php echo e($rows_pengeluaran->links()); ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\bemv2\resources\views/admin/pages/pengeluaran/index.blade.php ENDPATH**/ ?>