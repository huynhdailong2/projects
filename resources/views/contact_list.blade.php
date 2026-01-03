<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .body-wrapper {
            margin-left: 600px;
            /* Đẩy nội dung sang phải để nhường chỗ cho sidebar */
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        h2 {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .btn-add {
            background: linear-gradient(to right, #249cff, #a2ffd4);
            color: #fff;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            display: inline-flex;
            align-items: center;
            transition: background 0.4s ease, transform 0.2s ease;
        }

        .btn-add i {
            margin-right: 8px;
        }

        .btn-add:hover {
            background: linear-gradient(45deg, #f0e68c, #ff6b6b);
            transform: scale(1.05);
            text-decoration: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        table {
            width: 60%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: rgb(61, 171, 255);
            color: #fff;
            font-weight: bold;
            border-bottom: 2px solid #ddd;
        }


        td {
            border-bottom: 1px solid #ddd;
            color: #333;
        }

        .icon {
            width: 20px;
            height: 20px;
            margin: 0 5px;
            transition: transform 0.3s ease, filter 0.3s ease;
        }

        .icon:hover {
            transform: scale(1.2);
            filter: brightness(1.2);
        }
    </style>
</head>
@include('dashboard')
<body>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif
    
    <div class="body-wrapper">
        
    <table border="1" >
        <thead>
            <tr>
             
                <th>Tên</th>
                <th>Email</th>
                <th>Ghi chú</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contacts as $contact)
                <tr>
                  
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->note }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</body>
</html>
