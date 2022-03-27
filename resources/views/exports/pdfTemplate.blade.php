<!DOCTYPE html>
<html lang="en">

    <body>
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Contract start date</th>
                <th>Contract end date</th>
                <th>Verified</th>
                <th>Type</th>
            </tr>
            @foreach ($users as $user)
            <tr>
                <th> {{ $user['name'] }} </th>
                <th> {{ $user['email'] }} </th>
                <th> {{ $user['contract_start_date'] }} </th>
                <th> {{ $user['contract_end_date'] }} </th>
                <th> {{ $user['verified'] }} </th>
                <th> {{ $user['type'] }} </th>
            </tr>
            @endforeach
        </table>
    </body>
</html>