

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
                    <h3 class="mb-4">Kelas <?php echo e($organisasi->nama_organisasi); ?></h3>

                    <?php if(Auth::guard('petugas')->user()->level == 'admin'): ?>
                        <div class="row">
                            <div class="col-md-6">
                                <a href="<?php echo e(url('/app-admin/mahasiswa/' . encrypt($organisasi->id_organisasi) . '/create')); ?>"
                                    class="btn btn-primary mb-4">Tambah <?php echo e($title); ?></a>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end">
                                <button type="button" class="btn btn-success mb-4" data-toggle="modal"
                                    data-target="#exampleModal"><i class='fas fa-download'></i>
                                    <?php echo e(__('Import Mahasiswa')); ?>

                                </button>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if(count($errors) > 0): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Failed!</strong>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
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

                    <?php if($rows_mahasiswa->isEmpty()): ?>
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
                                <tbody id="table-body">
                                    <tr>
                                        <th>#</th>
                                        <th>Photo</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Email</th>
                                        <th>NIM</th>
                                        <th>Jenis Kelamin</th>
                                        <th>No HP</th>
                                        <th>Alamat</th>
                                        <th>Aksi</th>
                                    </tr>
                                    <?php $__currentLoopData = $rows_mahasiswa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mahasiswa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($loop->iteration); ?></td>
                                            <td><img src="<?php echo e($mahasiswa->photo != null ? asset('/storage/images/mahasiswa/' . $mahasiswa->photo) : asset('/images/icons/no-photo-rounded.png')); ?>"
                                                    alt=""
                                                    style="width: 75px; object-fit: cover; object-position: center"
                                                    class="rounded"></td>
                                            <td><?php echo e($mahasiswa->nama); ?></td>
                                            <td><?php echo e($mahasiswa->email); ?></td>
                                            <td><?php echo e($mahasiswa->nim); ?></td>
                                            <td><?php echo e($mahasiswa->jenis_kelamin); ?></td>
                                            <td><?php echo e($mahasiswa->no_telp); ?></td>
                                            <td><?php echo e($mahasiswa->alamat); ?></td>
                                            <td style="white-space: nowrap">
                                                <a href="<?php echo e(url('/app-admin/mahasiswa/' . encrypt($mahasiswa->nim) . '/lihat-iuran')); ?>"
                                                    class="btn btn-sm btn-success"><i class="fas fa-edit"></i> Lihat
                                                    Iuran</a>
                                                <?php if(Auth::guard('petugas')->user()->level == 'admin'): ?>
                                                    <a href="<?php echo e(url('/app-admin/mahasiswa/' . encrypt($mahasiswa->nim) . '/edit')); ?>"
                                                        class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                                    <a href="#" class="btn btn-sm btn-danger"
                                                        onclick="deleteRow('Mahasiswa <?php echo e($mahasiswa->nama); ?>', '<?php echo e(url('/app-admin/mahasiswa/' . encrypt($mahasiswa->nim))); ?>')"><i
                                                            class="fas fa-trash"></i> Hapus</a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>

                </div>
                <div class="card-footer text-left mb-4">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Mahasiswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST"
                    action="<?php echo e(url('/app-admin/mahasiswa/organisasi/' . encrypt($organisasi->id_organisasi) . '/action-import-mahasiswa')); ?>"
                    enctype="multipart/form-data">
                    <div class="modal-body">
                        <?php echo e(csrf_field()); ?>

                        <div class="mb-3">
                            <input type="file" class="form-control" id="import_mahasiswa"
                                aria-describedby="import_mahasiswa" name="import_mahasiswa" accept=".xlsx" required>
                            <div id="downloadFormat" class="form-text"> <a href="#"><i class="fa fa-download"
                                        aria-hidden="true"></i> Download Format</a> </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.all.min.js"></script>

    <script>
        const showLoading = function() {
            swal({
                title: 'Now loading',
                allowEscapeKey: false,
                allowOutsideClick: false,
                timer: 2000,
                onOpen: () => {
                    swal.showLoading();
                }
            }).then(
                () => {},
                (dismiss) => {
                    if (dismiss === 'timer') {
                        console.log('closed by timer!!!!');
                        swal({
                            title: 'Finished!',
                            type: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        })
                    }
                }
            )
        };

        $(document).on('click', '#downloadFormat', function(event) {
            event.preventDefault();
            downloadFormat();

        });

        var downloadFormat = function() {
            var url = '/app-admin/mahasiswa/download-format-mahasiswa';
            $.ajax({
                url: url,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                },
                data: {},
                xhrFields: {
                    responseType: 'blob'
                },
                beforeSend: function() {
                    Swal.fire({
                        title: 'Please Wait !',
                        html: 'Sedang melakukan download format import',
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    });

                },
                success: function(data) {
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(data);
                    var nameFile = 'import_mahasiswa.xlsx'
                    console.log(nameFile)
                    link.download = nameFile;
                    link.click();
                    swal.close()
                },
                error: function(data) {
                    console.log(data)
                    Swal.fire({
                        icon: 'error',
                        title: "Download Format Import failed",
                        text: "Please check",
                        allowOutsideClick: false,
                    })
                }
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\mhmmdd-bem-pembayaran\resources\views/admin/pages/mahasiswa/index.blade.php ENDPATH**/ ?>