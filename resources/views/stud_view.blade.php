<html>

<head>
    <title>View Student Record</title>
</head>

<body>
    <table>
        <tr>
            <td>Username</td>
            <td>Password</td>
        </tr>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->username }}</td>
                <td>{{ $user->password }}</td>
            </tr>
        @endforeach
    </table>
</body>

</html>
