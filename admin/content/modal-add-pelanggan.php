<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Pelanggan Baru</h5>
        </div>
        <div class="modal-body">
            <form id="form-add-pelanggan">
                <div class="row mb-3">
                    <div class="col-lg-6 col-sm-12">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required value="123">
                        <small class="text-danger">Default password: 123</small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-12 col-sm-12">
                        <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
                        <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-6 col-sm-12">
                        <label for="no_hp" class="form-label">No Hp</label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-12 col-sm-12">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" required></textarea>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" onclick="addPelanggan()" class="btn btn-primary">Simpan</button>
        </div>
    </div>
</div>
<script>
    function addPelanggan() {
        let data = $('#form-add-pelanggan').serializeArray();
        let send = {};
        let cek = [];
        data.map(item => {
            if (item.value == '') {
                cek.push(item.name);
            } else {
                send[item.name] = item.value;
            }
        })
        if (cek.length != 0) {
            let text = cek.join(', ');
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
                msg: `Field ${text} harus diisi!`
            });
            return;
        } else {
            $.ajax({
                url: 'classes/Pelanggan.php',
                type: 'POST',
                data: {
                    action: 'add_pelanggan',
                    data: send
                },
                success: function(response) {
                    let res = JSON.parse(response);

                    Lobibox.notify(`${res.status}`, {
                        pauseDelayOnHover: true,
                        size: "mini",
                        rounded: true,
                        delayIndicator: false,
                        delay: 2500,
                        icon: `${res.icon}`,
                        continueDelayOnInactiveTab: false,
                        sound: false,
                        position: "center top",
                        msg: `${res.message}`
                    });

                    if (res.status == 'success') {
                        setTimeout(() => {
                            location.reload();
                        }, 2500);
                    }
                }
            })
        }
    }
</script>