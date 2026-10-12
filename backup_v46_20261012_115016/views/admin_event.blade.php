<!DOCTYPE html>
<html>
<head>
    <title>Data Event</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>

        body{
            font-family:Arial,sans-serif;
            background:#f5f6fa;
            margin:0;
            padding:15px;
        }

        .header{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:15px;
        }

        .title{
            font-size:22px;
            font-weight:bold;
        }

        .btn-tambah{
            background:#00b140;
            color:white;
            padding:10px 14px;
            text-decoration:none;
            border-radius:8px;
            font-size:14px;
        }

        table{
            width:100%;
            border-collapse:collapse;
            background:white;
            border-radius:10px;
            overflow:hidden;
        }

        th{
            background:#00b140;
            color:white;
            padding:12px;
        }

        td{
            padding:10px;
            border-bottom:1px solid #eee;
            text-align:center;
        }

        .img{
            width:70px;
            height:70px;
            object-fit:cover;
            border-radius:8px;
        }

        .btn-edit{
            background:orange;
            color:white;
            padding:6px 10px;
            border-radius:5px;
            text-decoration:none;
        }

        .btn-hapus{
            background:red;
            color:white;
            padding:6px 10px;
            border-radius:5px;
            text-decoration:none;
        }

        .aktif{
            color:green;
            font-weight:bold;
        }

        .nonaktif{
            color:red;
            font-weight:bold;
        }

        @media(max-width:768px){

            table{
                font-size:12px;
            }

            .img{
                width:50px;
                height:50px;
            }

            .btn-edit,
            .btn-hapus{
                display:block;
                margin:3px;
            }
        }

    </style>
</head>
<body>

<div class="header">

    <div class="title">
        📅 Data Event
    </div>

    <a href="/admin/event/create"
       class="btn-tambah">
       + Tambah Event
    </a>

</div>

<table>

    <tr>
        <th>ID</th>
        <th>Gambar</th>
        <th>Judul</th>
        <th>Tanggal</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    @foreach($events as $event)

    <tr>

        <td>{{ $event->id }}</td>

        <td>

            @if($event->image)

                <img
                    src="{{ asset('uploads/'.$event->image) }}"
                    class="img">

            @endif

        </td>

        <td>{{ $event->title }}</td>

        <td>{{ $event->event_date }}</td>

        <td>

            @if($event->is_active)
                <span class="aktif">Aktif</span>
            @else
                <span class="nonaktif">Nonaktif</span>
            @endif

        </td>

        <td>

            <a
                href="/admin/event/edit/{{ $event->id }}"
                class="btn-edit">
                Edit
            </a>

            <a
                href="/admin/event/hapus/{{ $event->id }}"
                class="btn-hapus"
                onclick="return confirm('Yakin hapus event?')">
                Hapus
            </a>

        </td>

    </tr>

    @endforeach

</table>

</body>
</html>