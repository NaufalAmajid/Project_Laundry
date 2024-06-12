<input type="hidden" name="pemilik_id" id="pemilik_id" value="<?= $_SESSION['the_id'] ?>">
<input type="hidden" name="notrans" id="notrans" value="<?= $_GET['notrans'] ?>">
<div class="card-header py-3">
    <div class="row g-3 align-items-center">
        <div class="col-12 col-lg-4 col-md-6 me-auto">
            <h5 class="mb-1"><?= $func->dateIndonesia(date('Y-m-d')) . ' ' . date('H:i') ?></h5>
            <p class="mb-0">No Transaksi : <?= isset($_GET['notrans']) ? $_GET['notrans'] : '-' ?></p>
        </div>
    </div>
</div>
<div class="card-body">
    <div class="row">
        <div class="col-12 col-lg-4">
            <div class="row">
                <div class="col">
                    <div class="card border shadow-none radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-box bg-light-success border-0">
                                    <i class="bx bx-user-pin fs-3 text-success"></i>
                                </div>
                                <div class="info">
                                    <h6 class="mb-2">Kasir</h6>
                                    <p class="mb-1"><strong>Username</strong> : <?= ucwords($_SESSION['username']) ?></p>
                                    <p class="mb-1"><strong>Nama</strong> : <?= ucwords($_SESSION['nama']) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card border shadow-none radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="info">
                                    <h6 class="mb-2">Pelanggan <span><a href="javascript:;" onclick="modalAddPelanggan()" class="text-info" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Buat Pelanggan Baru" aria-label="pelanggan_baru"><i class="bx bx-error-alt fs-5"></i></a></span></h6>
                                    <div class="mb-1">
                                        <select name="pelanggan" id="pelanggan" class="select2 custom-border-bottom form-control" onchange="detailPelanggan()">
                                            <option value="">Pilih Pelanggan</option>
                                            <?php
                                            require_once 'classes/Pelanggan.php';
                                            $pelanggan = new Pelanggan();
                                            $pelanggans = $pelanggan->getAllPelanggan();
                                            foreach ($pelanggans as $pelanggan) :
                                            ?>
                                                <option value="<?= $pelanggan['pelanggan_id'] ?>" data-username="<?= $pelanggan['username'] ?>" data-nama="<?= $pelanggan['nama_pelanggan'] ?>" data-nohp="<?= $pelanggan['no_hp'] ?>" data-alamat="<?= $pelanggan['alamat'] ?>"><?= ucwords($pelanggan['nama_pelanggan']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <p class="mb-1"><strong>Username</strong> : <span id="username-pelanggan"></span></p>
                                    <p class="mb-1"><strong>Nama</strong> : <span id="nama-pelanggan"></span></p>
                                    <p class="mb-1"><strong>No</strong> : <span id="nohp-pelanggan"></span></p>
                                    <p class="mb-1"><strong>Alamat</strong> : <span id="alamat-pelanggan"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-8">
            <div class="row">
                <div class="col">
                    <div class="card border shadow-none radius-10">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">
                                    <thead>
                                        <td colspan="2">
                                            <?php
                                            require_once 'classes/Jasa.php';
                                            $jasa = new Jasa();
                                            ?>
                                            <select name="jasa" id="jasa" class="select2 custom-border-bottom form-control" onchange="transOperation()">
                                                <option value="">-- Pilih Jasa --</option>
                                                <?php foreach ($jasa->getAllJasa() as $jasa) : ?>
                                                    <option value="<?= $jasa['jasa_id'] ?>" data-harga="<?= $jasa['harga_satuan'] ?>"><?= ucwords($jasa['nama_jasa']) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td align="center" id="disHargaSatuan">0</td>
                                        <td align="center"><input type="text" name="quantity" id="quantity" class="input-border-bottom-center" size="3" placeholder="Jml" onkeyup="transOperation(true)"></td>
                                        <td align="center" id="disTotal">0</td>
                                        <td align="center"><a href="javascript:;" class="text-primary d-none" id="btn-addTrans" onclick="addTransaksi()"><i class="bx bx-download fs-5"></i></a></td>
                                    </thead>
                                    <thead class="table-secondary">
                                        <tr>
                                            <th></th>
                                            <th>Jasa</th>
                                            <th>Harga Satuan</th>
                                            <th>Jumlah / Berat</th>
                                            <th colspan="2">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th><a href="javascript:;" class="text-danger"><i class="bx bx-trash"></i></a></th>
                                            <td>Laundry Reguler</td>
                                            <td align="center">3.500</td>
                                            <td align="center">2</td>
                                            <td align="center" colspan="2">7.000</td>
                                        </tr>
                                    </tbody>
                                    <tr>
                                        <td colspan="5">
                                            <hr>
                                        </td>
                                    </tr>
                                    <tfoot>
                                        <tr>
                                            <td align="end" colspan="4" class="fs-5">Total</td>
                                            <td align="center" class="fs-5" colspan="2">14.000</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('#jasa').select2({
            placeholder: 'Pilih Jasa',
        })
    })

    function transOperation(showBtn = false) {
        if (isNaN($('#quantity').val())) {
            $('#quantity').val('');
            return;
        }

        let jasa = $('#jasa').find(':selected');

        let harga = jasa.data('harga');
        let disHargaSatuan = new Intl.NumberFormat('id', {
            maximumFractionDigits: 0
        }).format(harga);

        let quantity = $('#quantity').val();
        let total = new Intl.NumberFormat('id', {
            maximumFractionDigits: 0
        }).format(harga * quantity);

        if (showBtn) {
            if (quantity == '' || quantity == 0) {
                $('#btn-addTrans').addClass('d-none');
            } else {
                $('#btn-addTrans').removeClass('d-none');
            }
        }

        $('#disHargaSatuan').text(disHargaSatuan);
        $('#disTotal').text(total);
    }

    function addTransaksi() {
        let pemilik_id = $('#pemilik_id').val();
        let notrans = $('#notrans').val();
        let pelanggan_id = localStorage.getItem('pelanggan_id');
        if (pelanggan_id == null) {
            Lobibox.notify("warning", {
                pauseDelayOnHover: true,
                size: "mini",
                rounded: true,
                delayIndicator: false,
                delay: 2500,
                icon: "bx bx-error",
                continueDelayOnInactiveTab: false,
                sound: false,
                position: "center top",
                msg: "Pilih pelanggan terlebih dahulu"
            });
            return;
        }
        let jasa_id = $('#jasa').find(':selected').val();
        let quantity = $('#quantity').val();
        alert(`Pemilik ID : ${pemilik_id} \n No Trans : ${notrans} \n Pelanggan ID : ${pelanggan_id} \n Jasa ID : ${jasa_id} \n Quantity : ${quantity}`);
    }
</script>