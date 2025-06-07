$(document).ready(function () {
    const initialProvinsiId = $('#provinsi_nama').val();
    const initialKabupatenKotaId = $('#kabupatenKota_nama').val();
    const initialKecamatanId = $('#kecamatan_nama').val();
    const initialKelurahanId = $('#kelurahan_nama').val();

    $('#provinsi').empty().append('<option selected disabled>Memuat...</option>');
    $.getJSON("https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json", function (data) {
        $('#provinsi').empty().append('<option value="">Pilih Provinsi</option>');
        $.each(data, function (i, item) {
            const option = `<option value="${item.id}" ${item.name === initialProvinsiId ? 'selected' : ''}>${item.name}</option>`;
            $('#provinsi').append(option);
        });

        // Jika ada provinsi awal, trigger change untuk memuat kabupaten/kota
        if (initialProvinsiId) {
            $('#provinsi').val($('#provinsi option').filter(function() {
                return $(this).text() === initialProvinsiId;
            }).val()).trigger('change');
        } else {
            $('#kabupatenKota').empty().append('<option value="">Pilih Kabupaten/Kota</option>');
            $('#kecamatan').empty().append('<option value="">Pilih Kecamatan</option>');
            $('#kelurahan').empty().append('<option value="">Pilih Kelurahan</option>');
        }
    }).fail(function() {
        $('#provinsi').empty().append('<option value="">Gagal memuat Provinsi</option>');
        alert("Gagal memuat data provinsi. Silakan cek koneksi atau coba lagi nanti.");
    });

    $('#provinsi').on('change', function () {
        // ... (kode change provinsi Anda) ...
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
                    const isSelected = item.name === initialKabupatenKotaId && initialProvinsiId === $('#provinsi').find('option:selected').text();
                    $('#kabupatenKota').append(`<option value="${item.id}" ${isSelected ? 'selected' : ''}>${item.name}</option>`);
                });
                if (initialKabupatenKotaId && initialProvinsiId === $('#provinsi').find('option:selected').text()) {
                    $('#kabupatenKota').trigger('change');
                }
            }).fail(function() {
                $('#kabupatenKota').empty().append('<option value="">Gagal memuat Kabupaten/Kota</option>');
                alert("Gagal memuat data kabupaten/kota.");
            });
        } else {
            $('#kabupatenKota').empty().append('<option value="">Pilih Kabupaten/Kota</option>');
        }
    });

    $('#kabupatenKota').on('change', function () {
        // ... (kode change kabupaten/kota Anda) ...
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
                    const isSelected = item.name === initialKecamatanId && initialKabupatenKotaId === $('#kabupatenKota').find('option:selected').text();
                    $('#kecamatan').append(`<option value="${item.id}" ${isSelected ? 'selected' : ''}>${item.name}</option>`);
                });
                if (initialKecamatanId && initialKabupatenKotaId === $('#kabupatenKota').find('option:selected').text()) {
                    $('#kecamatan').trigger('change');
                }
            }).fail(function() {
                $('#kecamatan').empty().append('<option value="">Gagal memuat Kecamatan</option>');
                alert("Gagal memuat data kecamatan.");
            });
        } else {
            $('#kecamatan').empty().append('<option value="">Pilih Kecamatan</option>');
        }
    });

    $('#kecamatan').on('change', function () {
        // ... (kode change kecamatan Anda) ...
        const kecId = $(this).val();
        const kecName = $(this).find('option:selected').text();
        $('#kecamatan_nama').val(kecId ? kecName : '');

        $('#kelurahan').empty().append('<option selected disabled>Loading...</option>');
        $('#kelurahan_nama').val('');

        if (kecId) {
            $.getJSON(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${kecId}.json`, function (data) {
                $('#kelurahan').empty().append('<option value="">Pilih Kelurahan</option>');
                $.each(data, function (i, item) {
                    const isSelected = item.name === initialKelurahanId && initialKecamatanId === $('#kecamatan').find('option:selected').text();
                    $('#kelurahan').append(`<option value="${item.id}" ${isSelected ? 'selected' : ''}>${item.name}</option>`);
                });
                if (initialKelurahanId && initialKecamatanId === $('#kecamatan').find('option:selected').text()) {
                    $('#kelurahan').trigger('change');
                }
            }).fail(function() {
                $('#kelurahan').empty().append('<option value="">Gagal memuat Kelurahan</option>');
                alert("Gagal memuat data kelurahan.");
            });
        } else {
            $('#kelurahan').empty().append('<option value="">Pilih Kelurahan</option>');
        }
    });

    $('#kelurahan').on('change', function () {
        const kelId = $(this).val();
        const kelName = $(this).find('option:selected').text();
        $('#kelurahan_nama').val(kelId ? kelName : '');
    });
});
