<table>
    <thead>
        <tr>
            <th>Project Name</th>
            <th>Client Name</th>
            <th>Contract Start</th>
            <th>Contract End</th>
            <th>Staffs</th>
            <th>Manager</th>
            <th>Supervisor</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($datas['outsources'] as $outsource)
        <tr>
            <td>{{ $outsource->project_name }}</td>
            <td>{{ $outsource->client_name }}</td>
            <td>{{ $outsource->contract_start }}</td>
            <td>{{ $outsource->contract_end }}</td>
            <td>
                Active: {{$outsource->active_staff}},
                Resigned: {{$outsource->resigned_staff}},
                Terminated: {{$outsource->terminated_staff}},
                Abscond: {{$outsource->abscond_staff}}
            </td>
            <td>{{ $outsource->manager_person ? $outsource->manager_person->name : '' }}</td>
            <td>{{ $outsource->supervisor_person ? $outsource->supervisor_person->name : '' }}</td>
            <td>{{ $outsource->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>