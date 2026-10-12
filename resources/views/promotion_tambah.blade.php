<!DOCTYPE html>
<html>
<head>
    <title>Tambah Promo</title>
</head>
<body>

<h2>Tambah Promo</h2>

<form action="/admin/promotion/store"
      method="POST"
      enctype="multipart/form-data">

    @csrf

    <p>Judul Promo</p>
    <input type="text" name="title" required>

    <p>Deskripsi</p>
    <textarea name="description"></textarea>

    <p>Tanggal Mulai</p>
    <input type="date" name="start_date">

    <p>Tanggal Selesai</p>
    <input type="date" name="end_date">

    <p>Gambar Promo</p>
    <input type="file"
           name="image"
           accept="image/*">

    <br><br>

    <button type="submit">
        Simpan Promo
    </button>

</form>

</body>
</html>