<!DOCTYPE html>
<html>
<head>
    <title>Edit Promo</title>
</head>
<body>

<h2>Edit Promo</h2>

<form action="/admin/promotion/update/{{$promotion->id}}"
      method="POST"
      enctype="multipart/form-data">

    @csrf

    <p>Judul Promo</p>
    <input type="text"
           name="title"
           value="{{$promotion->title}}"
           required>

    <p>Deskripsi</p>
    <textarea name="description">{{$promotion->description}}</textarea>

    <p>Tanggal Mulai</p>
    <input type="date"
           name="start_date"
           value="{{$promotion->start_date}}">

    <p>Tanggal Selesai</p>
    <input type="date"
           name="end_date"
           value="{{$promotion->end_date}}">

    <p>Gambar Saat Ini</p>

    @if($promotion->image)
        <img src="/uploads/{{$promotion->image}}" width="120">
    @endif

    <p>Ganti Gambar</p>
    <input type="file"
           name="image"
           accept="image/*">

    <br><br>

    <button type="submit">
        Update Promo
    </button>

</form>

</body>
</html>