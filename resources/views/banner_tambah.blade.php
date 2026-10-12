<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Tambah Banner</title>
</head>
<body>

<h2>Tambah Banner</h2>

<form
action="/admin/banner/store"
method="POST"
enctype="multipart/form-data">

@csrf

<p>Judul Banner</p>

<input
type="text"
name="title"
required>

<br><br>

<p>Gambar Banner</p>

<input
type="file"
name="image">

<br><br>

<button type="submit">
Simpan
</button>

</form>

</body>
</html>