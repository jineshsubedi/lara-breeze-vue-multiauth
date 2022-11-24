<table>
    <thead>
        <tr>
            <th colspan="10"><b>Rolling Plans Pvt. Ltd.</b> <br> Time Sheet</th>
        </tr>
        <tr>
            <th colspan="4"><b>Staff Name: {{$datas['staff']->name}}</b></th>
            <th colspan="3"><b>Employee ID: {{$datas['staff']->employee_id}}</b></th>
            <th colspan="3"><b>Email: {{$datas['staff']->email}}</b></th>
        </tr>
    </thead>
    <thead>
        <tr>
            <th>Date</th>
            <th>Week</th>
            <th>Clock In</th>
            <th>Clock Out</th>
            <th>Total Duration</th>
            <th>Attendance Type</th>
            <th>Location In</th>
            <th>Location Out</th>
            <th>Status</th>
            <th>Remark</th>
        </tr>
    </thead>
    <tbody>
        @foreach($datas['attendance'] as $attend)
        <tr>
            <td>{{$attend['n_date']}} ({{$attend['e_date']}})</td>
            <td>{{$attend['week']}}</td>
            <td>{{$attend['clock_in']}}</td>
            <td>{{$attend['clock_out']}}</td>
            <td>{{$attend['duration']}}</td>
            <td>{{$attend['attendance_type']}}</td>
            <td>{{$attend['in_location']}}</td>
            <td>{{$attend['out_location']}}</td>
            <td>{{$attend['status']}}</td>
            <td>{{$attend['remarks']}}</td>
        </tr>
        @endforeach
    </tbody>
</table>