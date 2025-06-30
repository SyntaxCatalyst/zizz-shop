<!DOCTYPE html>
<html>
<head>
    <title>Pesan Kontak Baru</title>
</head>
<body style="font-family: sans-serif; color: #333;">
    <h2>Anda menerima pesan baru dari website!</h2>
    <hr>
    <p><strong>Nama:</strong> {{ $data['name'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <p><strong>Pesan:</strong></p>
    <div style="padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
        <p>{!! nl2br(e($data['message'])) !!}</p>
    </div>
</body>
</html>