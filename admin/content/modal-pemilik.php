<?php
$action = isset($_POST['action']) ? $_POST['action'] : '';
$title  = $action ? $action : 'baru';
if ($action == 'detail') {
    require_once '../config/connection.php';
    require_once '../classes/Pemilik.php';

    $pemilik = new Pemilik();
    $pemilik = $pemilik->getPemilikById($_POST['pemilik_id']);
}
?>
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Pemilik <?= ucwords($title) ?></h5>
        </div>
        <div class="modal-body">
            <form id="form-add-pemilik">
                <div class="row mb-3">
                    <div class="col-lg-6 col-sm-12">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required value="<?= $action ? $pemilik['username'] : '' ?>">
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required value="123" <?= $action ? 'disabled' : '' ?>>
                        <small class="text-danger"><?= $action ? 'Update password hanya bisa dilakukan oleh masing-masing user.' : 'Default password: 123' ?></small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-12 col-sm-12">
                        <label for="nama_pemilik" class="form-label">Nama Pemilik</label>
                        <input type="text" class="form-control" id="nama_pemilik" name="nama_pemilik" required value="<?= $action ? $pemilik['nama_pemilik'] : '' ?>">
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <?php if ($action) : ?>
                <button type="button" onclick="editPemilik('<?= $pemilik['pemilik_id'] ?>', '<?= $pemilik['user_id'] ?>')" class="btn btn-warning">Update</button>
            <?php else : ?>
                <button type="button" onclick="addPemilik()" class="btn btn-primary">Simpan</button>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
    function addPemilik() {
        let data = $('#form-add-pemilik').serializeArray();
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
                url: 'classes/Pemilik.php',
                type: 'POST',
                data: {
                    action: 'add_pemilik',
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

    function editPemilik(pemilik_id, user_id) {
        let data = $('#form-add-pemilik').serializeArray();
        let send = {};
        let cek = [];
        data.map(item => {
            if (item.value == '') {
                cek.push(item.name);
            } else {
                send[item.name] = item.value;
            }
        })
        send['pemilik_id'] = pemilik_id;
        send['user_id'] = user_id;
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
                url: 'classes/Pemilik.php',
                type: 'POST',
                data: {
                    action: 'edit_pemilik',
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