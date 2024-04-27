<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<style>
    #table-border {
        border-collapse: collapse; /* Menggabungkan batas sel menjadi satu garis */
        width: 50%; /* Menetapkan lebar tabel */
        margin: 0 auto; /* Memusatkan tabel */
    }
    #table-border th, #table-border td {
        border: 1px solid black; /* Mengatur garis tepi */
        padding: 8px; /* Menambahkan ruang di dalam sel */
        text-align: center; /* Pusatkan teks di dalam sel */
    }
</style>

<table id="table-border" class="table mx-auto align-center">
    <thead>
        <tr>
            <th>Nomor</th>
            <th>Judul</th>
            <th>Penulis</th>
            <th>Kategori</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($data as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->judul }}</td>
                <td>{{ $item->penulis }}</td>
                <td>{{ $item->kategorii->nama_kategori }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>