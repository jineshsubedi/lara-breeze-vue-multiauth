<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    overtime: Object,
    categories: Object,
    staffs: Object,
    is_supervisor: Boolean,
    can: Object
})
let HrHandler = props.can.includes('HrHandler');

const form = useForm({
    login_time: props.overtime.login_time,
    logout_time: props.overtime.logout_time,
    overtime_reason_id: props.overtime.overtime_reason_id,
    holiday: props.overtime.holiday,
    ot_hour: props.overtime.ot_hour,
    remarks: props.overtime.remarks,
    login_date: props.overtime.login_date,
});

const sApproveform = useForm({
    status: '1'
});
const hrApproveform = useForm({
    status: '2'
});
const rejectForm = useForm({
    status: '3'
});

function sApproveForm(id)
{
    if (confirm("Are you sure you want to Approve")) {
        sApproveform.patch(route("staffs.overtimes.status", id));
    }
}
function hrApproveForm(id)
{
    if (confirm("Are you sure you want to Approve")) {
        hrApproveform.patch(route("staffs.overtimes.status", id));
    }
}
function rejectOvertimeForm(id)
{
    if (confirm("Are you sure you want to Reject")) {
        rejectForm.patch(route("staffs.overtimes.status", id));
    }
}
</script>
<template>
    <Head title="Overtime Edit" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Overtime Edit
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.overtimes.index')"> Overtime </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.overtimes.show', overtime.id)"> Information </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Overtime Information</h5>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Requested By</th>
                                        <td>{{ overtime.user ? overtime.user.name : '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Login Date</th>
                                        <td>{{ overtime.login_date }} ({{ overtime.login_time }} - {{ overtime.logout_time }})</td>
                                    </tr>
                                    <tr>
                                        <th>overtime Time</th>
                                        <td>{{ overtime.ot_hour }}</td>
                                    </tr>
                                    <tr>
                                        <th>overtime Category</th>
                                        <td>{{ overtime.category ? overtime.category.title : '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Holiday</th>
                                        <td>{{ overtime.holiday == '1' ? 'Yes' : 'No' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td><p v-html="overtime.status_label"></p></td>
                                    </tr>
                                    <tr>
                                        <th>Remarks</th>
                                        <td><p v-html="overtime.remarks"></p></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div v-if="is_supervisor && overtime.status == '0'">
                                <button class="btn btn-sm btn-outline-success" @click="sApproveForm(overtime.id)"><i class="bi bi-check2"></i>Approve</button>
                                <button class="btn btn-sm btn-outline-danger" @click="rejectOvertimeForm(overtime.id)"><i class="bi bi-check2"></i>Reject</button>
                            </div>
                            <div v-if="HrHandler && overtime.status == '1'">
                                <button class="btn btn-sm btn-outline-success" @click="hrApproveForm(overtime.id)"><i class="bi bi-check2"></i>Approve</button>
                                <button class="btn btn-sm btn-outline-danger" @click="rejectOvertimeForm(overtime.id)"><i class="bi bi-check2"></i>Reject</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </StaffLayout>
</template>
