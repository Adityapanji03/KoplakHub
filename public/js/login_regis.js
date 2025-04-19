$(document).ready(function() {
// form
    $('#provinsi').change(function() {
        const selectedProvinsi = $(this).val();
        $('#kabupatenKota').empty().append('<option value="">Pilih Kabupaten/Kota</option>');
        $('#kecamatan').empty().append('<option value="">Pilih Kecamatan</option>');
        $('#kelurahan').empty().append('<option value="">Pilih Kelurahan</option>');

        if (selectedProvinsi === 'Jawa Barat') {
            $('#kabupatenKota').append('<option value="Bandung">Bandung</option>');
            $('#kabupatenKota').append('<option value="Bogor">Bogor</option>');
        } else if (selectedProvinsi === 'Jawa Tengah') {
            $('#kabupatenKota').append('<option value="Semarang">Semarang</option>');
            $('#kabupatenKota').append('<option value="Solo">Solo</option>');
        } else if (selectedProvinsi === 'Jawa Timur') {
            $('#kabupatenKota').append('<option value="Surabaya">Surabaya</option>');
            $('#kabupatenKota').append('<option value="Malang">Malang</option>');
        }
    });

    $('#kabupatenKota').change(function() {
        const selectedKabupatenKota = $(this).val();
        $('#kecamatan').empty().append('<option value="">Pilih Kecamatan</option>');
        $('#kelurahan').empty().append('<option value="">Pilih Kelurahan</option>');

        if (selectedKabupatenKota === 'Bandung') {
            $('#kecamatan').append('<option value="Sukasari">Sukasari</option>');
            $('#kecamatan').append('<option value="Cidadap">Cidadap</option>');
        } else if (selectedKabupatenKota === 'Semarang') {
            $('#kecamatan').append('<option value="Semarang Tengah">Semarang Tengah</option>');
            $('#kecamatan').append('<option value="Semarang Utara">Semarang Utara</option>');
        }
    });

    $('#kecamatan').change(function() {
        const selectedKecamatan = $(this).val();
        $('#kelurahan').empty().append('<option value="">Pilih Kelurahan</option>');

        if (selectedKecamatan === 'Sukasari') {
            $('#kelurahan').append('<option value="Gegerkalong">Gegerkalong</option>');
            $('#kelurahan').append('<option value="Isola">Isola</option>');
        } else if (selectedKecamatan === 'Semarang Tengah') {
            $('#kelurahan').append('<option value="Sekayu">Sekayu</option>');
            $('#kelurahan').append('<option value="Karangkidul">Karangkidul</option>');
        }
    });
});

