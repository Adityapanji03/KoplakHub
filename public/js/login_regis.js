$(document).ready(function () {

    $('#provinsi').empty().append('<option selected disabled>Memuat...</option>');
    $.getJSON("https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json", function (data) {
        $('#provinsi').empty().append('<option value="">Pilih Provinsi</option>');
        let jatimSelected = false;
        $.each(data, function (i, item) {
            const option = `<option value="${item.id}">${item.name}</option>`;
            $('#provinsi').append(option);

            if (item.id == 35) {
                jatimSelected = true;
            }
        });

        if (jatimSelected) {
            $('#provinsi').val('35');
            const jatimName = $('#provinsi option[value="35"]').text();
            $('#provinsi_nama').val(jatimName);
            $('#provinsi').trigger('change');
        } else {
             $('#provinsi_nama').val('');
             $('#kabupatenKota').empty().append('<option value="">Pilih Kabupaten/Kota</option>');
             $('#kecamatan').empty().append('<option value="">Pilih Kecamatan</option>');
             $('#kelurahan').empty().append('<option value="">Pilih Kelurahan</option>');
        }
    }).fail(function() {
         $('#provinsi').empty().append('<option value="">Gagal memuat Provinsi</option>');
         alert("Gagal memuat data provinsi. Silakan cek koneksi atau coba lagi nanti.");
    });


    $('#provinsi').on('change', function () {
        const provId = $(this).val();
        const provName = $(this).find('option:selected').text();

        $('#provinsi_nama').val(provId ? provName : '');

        $('#kabupatenKota').empty().append('<option selected disabled>Loading...</option>');
        $('#kabupatenKota_nama').val('');
        $('#kecamatan').empty().append('<option value="">Pilih Kecamatan</option>');
        $('#kecamatan_nama').val('');
        $('#kelurahan').empty().append('<option value="">Pilih Kelurahan</option>');
        $('#kelurahan_nama').val('');

        if (provId) {
            $.getJSON(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provId}.json`, function (data) {
                $('#kabupatenKota').empty().append('<option value="">Pilih Kabupaten/Kota</option>');
                $.each(data, function (i, item) {
                    $('#kabupatenKota').append(`<option value="${item.id}">${item.name}</option>`);
                });
            }).fail(function() {
                 $('#kabupatenKota').empty().append('<option value="">Gagal memuat Kabupaten/Kota</option>');
                 alert("Gagal memuat data kabupaten/kota.");
            });
        } else {
             $('#kabupatenKota').empty().append('<option value="">Pilih Kabupaten/Kota</option>');
        }
    });

    $('#kabupatenKota').on('change', function () {
        const kabId = $(this).val();
        const kabName = $(this).find('option:selected').text();
        $('#kabupatenKota_nama').val(kabId ? kabName : '');

        $('#kecamatan').empty().append('<option selected disabled>Loading...</option>');
        $('#kecamatan_nama').val('');
        $('#kelurahan').empty().append('<option value="">Pilih Kelurahan</option>');
        $('#kelurahan_nama').val('');

        if (kabId) {
            $.getJSON(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${kabId}.json`, function (data) {
                $('#kecamatan').empty().append('<option value="">Pilih Kecamatan</option>');
                $.each(data, function (i, item) {
                    $('#kecamatan').append(`<option value="${item.id}">${item.name}</option>`);
                });
            }).fail(function() {
                 $('#kecamatan').empty().append('<option value="">Gagal memuat Kecamatan</option>');
                 alert("Gagal memuat data kecamatan.");
            });
        } else {
             $('#kecamatan').empty().append('<option value="">Pilih Kecamatan</option>');
        }
    });

    $('#kecamatan').on('change', function () {
        const kecId = $(this).val();
        const kecName = $(this).find('option:selected').text();

        $('#kecamatan_nama').val(kecId ? kecName : '');

        $('#kelurahan').empty().append('<option selected disabled>Loading...</option>');
         $('#kelurahan_nama').val('');

        if (kecId) {
            $.getJSON(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${kecId}.json`, function (data) {
                $('#kelurahan').empty().append('<option value="">Pilih Kelurahan</option>');
                $.each(data, function (i, item) {
                    $('#kelurahan').append(`<option value="${item.id}">${item.name}</option>`);
                });
            }).fail(function() {
                 $('#kelurahan').empty().append('<option value="">Gagal memuat Kelurahan</option>');
                 alert("Gagal memuat data kelurahan.");
            });
        } else {
            $('#kelurahan').empty().append('<option value="">Pilih Kelurahan</option>');
        }
    });

    // 5. Jika Kelurahan berubah, set hidden input nya
    $('#kelurahan').on('change', function () {
        const kelId = $(this).val();
        // Ambil nama dari opsi yang dipilih
        const kelName = $(this).find('option:selected').text();
         // Set nilai hidden input kelurahan
        $('#kelurahan_nama').val(kelId ? kelName : '');
    });
});
