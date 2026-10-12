<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Edit Banner</title>
</head>
<body>

<h2>Edit Banner</h2>

<form
action="/admin/banner/update/{{ $banner->id }}"
method="POST"
enctype="multipart/form-data">

@csrf

<p>Judul Banner</p>

<input
type="text"
name="title"
value="{{ $banner->title }}">

<br><br>

@if($banner->image)

<img
src="/uploads/{{ $banner->image }}"
width="250">

<br><br>

@endif

<input
type="file"
name="image">

<br><br>

<button type="submit">
Update
</button>

</form>

</body>
</html>