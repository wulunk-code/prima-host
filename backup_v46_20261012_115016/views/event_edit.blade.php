<!DOCTYPE html>
<html>
<head>
<title>Edit Event</title>
</head>
<body>

<h2>Edit Event</h2>

<form action="/admin/event/update/{{$event->id}}"
      method="POST"
      enctype="multipart/form-data">

@csrf

<p>Judul</p>
<input
type="text"
name="title"
value="{{$event->title}}">

<p>Deskripsi</p>

<textarea name="description">
{{$event->description}}
</textarea>

<p>Lokasi</p>

<input
type="text"
name="location"
value="{{$event->location}}">

<p>Tanggal Event</p>

<input
type="date"
name="event_date"
value="{{date('Y-m-d',strtotime($event->event_date))}}">

<p>Gambar Baru</p>

<input type="file" name="image">

<br><br>

<button type="submit">
Update Event
</button>

</form>

</body>
</html>