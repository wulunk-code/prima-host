<h2>Daftar Member</h2>

<table border="1" width="100%">
<tr>
    <th>ID</th>
    <th>Nama</th>
    <th>WA</th>
    <th>Email</th>
</tr>

@foreach($members as $member)

<tr>
    <td>{{ $member->id }}</td>
    <td>{{ $member->nama }}</td>
    <td>{{ $member->wa }}</td>
    <td>{{ $member->email }}</td>
</tr>

@endforeach

</table>