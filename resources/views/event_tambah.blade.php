<!DOCTYPE html>
<html>
<head>
    <title>Tambah Event</title>
</head>
<body>

<h2>Tambah Event</h2>

<form action="/admin/event/store"
      method="POST"
      enctype="multipart/form-data">

    @csrf

    <p>Judul</p>
    <input type="text" name="title" required>

    <p>Deskripsi</p>
    <textarea name="description"></textarea>

    <p>Lokasi</p>
    <input type="text" name="location">

    <p>Tanggal Event</p>
    <input type="date" name="event_date">

    <p>Gambar Event</p>
    <input
        type="file"
        name="image"
        accept="image/*">

    <br><br>

    <button type="submit">
        Simpan Event
    </button>

</form>

</body>
</html>