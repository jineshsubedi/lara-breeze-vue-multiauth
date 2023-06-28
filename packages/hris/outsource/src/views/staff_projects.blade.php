<table>
    <thead>
        <tr>
            <th>Employee Code</th>
            <th>Name</th>
            <th>Email</th>
            <th>Designation</th>
            <th>Department</th>
            <th>Temporary Address</th>
            <th>Phone</th>
            <th>Citizenship Number</th>
            <th>Gender</th>
            <th>Age</th>
            <th>PAN</th>
            <th>SSF</th>
            <th>Joining Date</th>
            <th>Contract Start</th>
            <th>Contract End</th>
            <th>Assetss</th>
            <th>Medical</th>
            <th>Document</th>
            <th>Status</th>
            <th>Checklist</th>
            <th>Group Medical Insurance</th>
            <th>Group Accidental Insurance</th>
            <th>Assets</th>
            <th>ID Card</th>
            <th>Experience Letter</th>
            <th>Salary Settlement</th>
            <th>Warning Letter</th>
            <th>Pending Work</th>
            <th>Advance Payment</th>
        </tr>
    </thead>
    <tbody>
        @foreach($staffs as $s)
        <tr>
            <td>{{$s['staff_code']}}</td>
            <td>{{$s['name']}}</td>
            <td>{{$s['email']}}</td>
            <td>{{$s['designation']}}</td>
            <td>{{$s['department']}}</td>
            <td>{{$s['temporary_address']}}</td>
            <td>{{$s['phone_number']}}</td>
            <td>{{$s['citizenship']}}</td>
            <td>{{$s['sex']}}</td>
            <td>{{$s['age']}}</td>
            <td>{{$s['pan_number']}}</td>
            <td>{{$s['ssf_number']}}</td>
            <td>{{\Carbon\Carbon::parse($s['join_date'])->format('d M, Y')}}</td>
            <td>{{\Carbon\Carbon::parse($s['contract_start'])->format('d M, Y')}}</td>
            <td>{{\Carbon\Carbon::parse($s['contract_end'])->format('d M, Y')}}</td>
            <td>
                @foreach ($s['asset_taken'] as $ataken)
                    <p>{{$ataken->asset_title}} : {{$ataken->asset_action == 1 ? 'No' : ($ataken->asset_action == 2 ? 'Yes' : 'Hold')}},</p>
                @endforeach
            </td>
            <td>
                @foreach ($s['medical'] as $med)
                    <p>{{$med->medical_type == 1 ? 'Group Medical Insurance' : 'Group Accidental Insurance'}} - {{$med->policy_number}} ({{$med->medical_from}} - {{$med->medical_to}})</p>
                @endforeach
            </td>
            <td>
                @foreach ($s['documents'] as $doc)
                    <p>{{$doc->document_label}}: {{$doc->document_file}},</p>
                @endforeach
            </td>
            <td>{{$s['status']}}</td>
            <td></td>
            <td>{{$s['group_medical_insurance']}}</td>
            <td>{{$s['group_accidental_insurance']}}</td>
            <td>{{$s['assets']}}</td>
            <td>{{$s['id_card']}}</td>
            <td>{{$s['experience_letter']}}</td>
            <td>{{$s['salary_settlement']}}</td>
            <td>{{$s['warning_letter']}}</td>
            <td>{{$s['pending_work']}}</td>
            <td>{{$s['advance_payment']}}</td>
                
        </tr>
        @endforeach

    </tbody>
</table>