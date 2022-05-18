<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-dark"><b><?= $title ?></b> | <?= $app_name ?></h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <?php if ($this->session->flashdata("gagal")) : ?>
            <div class="alert bg-danger alert-dismissible fade show" role="alert">
                <strong>Gagal !</strong> <?= $this->session->flashdata("gagal") ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php unset($_SESSION["gagal"]);
        endif; ?>

        <?php if ($this->session->flashdata("sukses")) : ?>
            <div class="alert bg-success alert-dismissible fade show" role="alert">
                <strong>Sukses !</strong> <?= $this->session->flashdata("sukses") ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php unset($_SESSION["sukses"]);
        endif; ?>

        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <a href="<?= back() ?>" type="button" class="btn btn-primary float-left"><i class="fas fa-chevron-left"></i> Kembali</a>
                    <!-- <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#modal_tambah"><i class="fas fa-plus"></i> Tambah Data Admin</button> -->
                </div>
                <div class="card-body">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-2" style="width:100%">
                                <label for="recipient-name" class="control-label">Pilih Region <span class="text-danger">*</span></label>
                                <select class="select2bs4 form-control" name="id_region" id="id_region" required>
                                    <option value="">-- PILIH REGION --</option>
                                    <?php foreach ($region as $r) : ?>
                                        <option value="<?= $r["id"] ?>"><?= $r["nama"] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="col-md-4 mb-2" style="width:100%">
                                <label for="recipient-name" class="control-label">Perusahaan <span class="text-danger">*</span></label>
                                <select class="select2bs4 form-control" name="id_perusahaan" id="id_perusahaan" required>
                                    <option value="">Silahkan pilih region terlebih dahulu</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-2" style="width:100%">
                                <label for="recipient-name" class="control-label">Unit <span class="text-danger">*</span></label>
                                <select class="select2bs4 form-control" name="id_unit" id="id_unit" required>
                                    <option value="">Silahkan pilih perusahaan terlebih dahulu</option>
                                </select>
                            </div>

                            <div class="col-md-6" style="width:100%">
                                <label for="recipient-name" class="control-label">Bulan <span class="text-danger">*</span></label>
                                <select class="select2bs4 form-control" name="bulan" id="bulan" required>
                                    <option value="">-- PILIH BULAN --</option>
                                    <?php for ($i = 1; $i <= 12; $i++) : ?>
                                        <option value="<?= $i ?>"><?= bulan($i) ?></option>
                                    <?php endfor ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="">Tahun</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input required autocomplete="off" type="text" class="form-control float-right" name="tahun" id="tahun">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-6">
                            <button class="btn btn-md btn-success" style="margin-top: 10px; width:100%" onclick="filter()">
                                LIHAT LAPORAN
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-md btn-danger" style="margin-top: 10px; width:100%" onclick="download()">
                                UNDUH LAPORAN
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-primary card-outline" id="layoutTable">
                <div class="card-header">
                    <h5 class="m-0 text-dark text-bold">Rekap Inspeksi APAR</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_data" class="table nowrap table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 3%">No.</th>
                                    <th>Tanggal</th>
                                    <th>Lokasi</th>
                                    <th>Kode APAR</th>
                                    <th>Jenis APAR</th>
                                    <th>Berat APAR</th>
                                    <th>Handle</th>
                                    <th>Pressure Gauge</th>
                                    <th>Pin / Segel</th>
                                    <th>Selang / Nozzle</th>
                                    <th>Tabung</th>
                                    <th>Posisi APAR</th>
                                    <th>Segitiga APAR</th>
                                    <th>Label</th>
                                    <th>Berat Isi (CO2)</th>
                                    <th>Kondisi Powder (DCP)</th>
                                    <th>Terakhir</th>
                                    <th>Berikutnya</th>
                                    <th>Keterangan</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>

<script src="<?= lte("plugins/daterangepicker/daterangepicker.js") ?>"></script>
<link href="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet" />
<script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script>
    $("#id_region").change(() => {
        let id_region = $("#id_region").val()
        $("#id_perusahaan").html(`<option value="" selected disabled>Sedang mencari data perusahaan..</option>`)
        $("#id_unit").html(`<option value="" selected disabled>Silahkan pilih perusahaan terlebih dahulu</option>`)
        $.ajax({
            url: "<?= base_url('laporan/apar/bulan/findPerusahaan/') ?>" + id_region,
            type: "GET",
            dataType: "JSON",
            contentType: "application/json; charset=utf-8",
            success: function(result) {
                let _dataPerusahaan = `<option value="" selected>-- PILIH REGION TERLEBIH DAHULU --</option>`
                if (result.code == 200) {
                    _dataPerusahaan = `<option value="" selected>-- PILIH PERUSAHAAN --</option>`
                    result.data.forEach((currentValue, index, arr) => {
                        _dataPerusahaan += `<option value="${currentValue.id}">${currentValue.nama}</option>`
                    })
                } else {
                    _dataPerusahaan = `<option value="" selected>${result.message}</option>`
                }
                $("#id_perusahaan").html(_dataPerusahaan)
            },
            error: function(xhr, ajaxOptions, thrownError) {
                Swal.fire("Oops", xhr.responseText, "error")
            }
        })
    })

    $("#id_perusahaan").change(() => {
        let id_perusahaan = $("#id_perusahaan").val()
        $("#id_unit").html(`<option value="" selected disabled>Silahkan pilih perusahaan terlebih dahulu</option>`)
        $.ajax({
            url: "<?= base_url('laporan/apar/bulan/findUnit/') ?>" + id_perusahaan,
            type: "GET",
            dataType: "JSON",
            contentType: "application/json; charset=utf-8",
            success: function(result) {
                let _dataUnit = `<option value="" selected>-- PILIH PERUSAHAAN TERLEBIH DAHULU --</option>`
                if (result.code == 200) {
                    _dataUnit = `<option value="" selected>-- PILIH UNIT --</option>`
                    result.data.forEach((currentValue, index, arr) => {
                        _dataUnit += `<option value="${currentValue.id}">${currentValue.nama}</option>`
                    })
                } else {
                    _dataUnit = `<option value="" selected>${result.message}</option>`
                }
                $("#id_unit").html(_dataUnit)
            },
            error: function(xhr, ajaxOptions, thrownError) {
                Swal.fire("Oops", xhr.responseText, "error")
            }
        })
    })
</script>

<script>
    $("#tahun").keypress(function(event) {
        event.preventDefault();
    })
    $('#tahun').datepicker({
        autoclose: true,
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years"
    });
</script>

<script>
    var table_data = $("#table_data").DataTable({})
    const filter = () => {
        let _idRegion = $("#id_region").val()
        let _idPerusahaan = $("#id_perusahaan").val()
        let _idUnit = $("#id_unit").val()
        let _bulan = $("#bulan").val()
        let _tahun = $("#tahun").val()
        if (_idRegion == "") {
            return Swal.fire({
                title: 'Oopss',
                text: "Silahkan pilih region terlebih dahulu",
                icon: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Oke Siap !'
            })
        }

        if (_idPerusahaan == "") {
            return Swal.fire({
                title: 'Oopss',
                text: "Silahkan pilih perusahaan terlebih dahulu",
                icon: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Oke Siap !'
            })
        }

        if (_idUnit == "") {
            return Swal.fire({
                title: 'Oopss',
                text: "Silahkan pilih Unit terlebih dahulu",
                icon: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Oke Siap !'
            })
        }

        if (_bulan == "") {
            return Swal.fire({
                title: 'Oopss',
                text: "Silahkan pilih Bulan terlebih dahulu",
                icon: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Oke Siap !'
            })
        }

        if (_tahun == "") {
            return Swal.fire({
                title: 'Oopss',
                text: "Silahkan pilih tahun terlebih dahulu",
                icon: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Oke Siap !'
            })
        }
        findData(_idRegion, _idPerusahaan, _idUnit, _bulan, _tahun)
    }

    const findData = (_idRegion, _idPerusahaan, _idUnit, _bulan, _tahun) => {
        $("#table_data").dataTable().fnDestroy()
        $("#table_data").DataTable({
            "pagingType": "full_numbers",
            "language": {
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Data Tidak Ditemukan",
                "info": "Menampilkan Halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Oops, data tidak ditemukan",
                "infoFiltered": "(di filter dari _MAX_ total data)",
                "loadingRecords": "Loading...",
                "processing": "Sedang memuat data...",
                "paginate": {
                    "first": "First",
                    "last": "Last",
                    "next": "Next",
                    "previous": "Previous"
                },
            },
            "processing": true,
            "serverSide": true,
            "searching": true,
            "order": [],
            "columnDefs": [{
                    "targets": [0],
                    "orderable": false
                },
                {
                    "targets": [1],
                    "orderable": false
                }, {
                    "targets": [2],
                    "orderable": false
                },
                {
                    "targets": [3],
                    "orderable": false
                },
                {
                    "targets": [4],
                    "orderable": false
                },
                {
                    "targets": [5],
                    "orderable": false
                },
                {
                    "targets": [6],
                    "orderable": false
                },
                {
                    "targets": [7],
                    "orderable": false
                },
                {
                    "targets": [8],
                    "orderable": false
                },
                {
                    "targets": [9],
                    "orderable": false
                },
                {
                    "targets": [10],
                    "orderable": false
                },
                {
                    "targets": [11],
                    "orderable": false
                },
                {
                    "targets": [12],
                    "orderable": false
                },
                {
                    "targets": [13],
                    "orderable": false
                },
                {
                    "targets": [14],
                    "orderable": false
                },
                {
                    "targets": [15],
                    "orderable": false
                },
                {
                    "targets": [16],
                    "orderable": false
                },
                {
                    "targets": [17],
                    "orderable": false
                },
                {
                    "targets": [18],
                    "orderable": false
                },
                {
                    "targets": [19],
                    "orderable": false
                },
            ],
            "ajax": {
                "url": `<?= base_url("laporan/apar/bulan/get_data/") ?>${_idRegion}/${_idPerusahaan}/${_idUnit}/${_bulan}/${_tahun}`,
                "type": "POST"
            },
            "columns": [{
                    "data": null,
                    "sortable": false,
                    className: "text-center align-middle",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    "data": "tanggal",
                },
                {
                    "data": "lokasi",
                },
                {
                    "data": "kode_apar",
                },
                {
                    "data": "jenis.nama",
                },
                {
                    "data": "berat_apar",
                },
                {
                    "data": "handle",
                },
                {
                    "data": "pressure",
                },
                {
                    "data": "pin",
                },
                {
                    "data": "selang",
                },
                {
                    "data": "tabung",
                },
                {
                    "data": "posisi",
                },
                {
                    "data": "segitiga",
                },
                {
                    "data": "label",
                },
                {
                    "data": "berat",
                },
                {
                    "data": "powder",
                },
                {
                    "data": "pengisian_terakhir",
                },
                {
                    "data": "pengisian_berikutnya",
                },
                {
                    "data": "keterangan",
                },
                {
                    "data": "created_at",
                },
            ]
        })
    }

    const download = () => {
        let _idRegion = $("#id_region").val()
        let _idPerusahaan = $("#id_perusahaan").val()
        let _idUnit = $("#id_unit").val()
        let _bulan = $("#bulan").val()
        let _tahun = $("#tahun").val()
        if (_idRegion == "") {
            return Swal.fire({
                title: 'Oopss',
                text: "Silahkan pilih region terlebih dahulu",
                icon: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Oke Siap !'
            })
        }

        if (_idPerusahaan == "") {
            return Swal.fire({
                title: 'Oopss',
                text: "Silahkan pilih perusahaan terlebih dahulu",
                icon: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Oke Siap !'
            })
        }

        if (_idUnit == "") {
            return Swal.fire({
                title: 'Oopss',
                text: "Silahkan pilih Unit terlebih dahulu",
                icon: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Oke Siap !'
            })
        }

        if (_bulan == "") {
            return Swal.fire({
                title: 'Oopss',
                text: "Silahkan pilih Bulan terlebih dahulu",
                icon: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Oke Siap !'
            })
        }

        if (_tahun == "") {
            return Swal.fire({
                title: 'Oopss',
                text: "Silahkan pilih tahun terlebih dahulu",
                icon: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Oke Siap !'
            })
        }
        window.location = `<?= base_url("laporan/apar/bulan/download/") ?>${_idRegion}/${_idPerusahaan}/${_idUnit}/${_bulan}/${_tahun}`
    }
</script>