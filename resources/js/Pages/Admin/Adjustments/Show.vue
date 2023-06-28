<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    adjustment: Object,
    categories: Object,
    staffs: Object,
    is_supervisor: Boolean,
    can: Object
})
let HrHandler = props.can.includes('HrHandler');

const form = useForm({
    login_time: props.adjustment.login_time,
    logout_time: props.adjustment.logout_time,
    adjustment_reason_id: props.adjustment.adjustment_reason_id,
    time_to_be_adjusted: props.adjustment.time_to_be_adjusted,
    informed_to: props.adjustment.informed_to,
    remarks: props.adjustment.remarks,
    login_date: props.adjustment.login_date,
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
        sApproveform.patch(route("admin.adjustments.status", id));
    }
}
function hrApproveForm(id)
{
    if (confirm("Are you sure you want to Approve")) {
        hrApproveform.patch(route("admin.adjustments.status", id));
    }
}
function rejectAdjustmentForm(id)
{
    if (confirm("Are you sure you want to Reject")) {
        rejectForm.patch(route("admin.adjustments.status", id));
    }
}
</script>
<template>
    <Head title="Adjustment Edit" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Adjustment Edit
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.adjustments.index')"> Adjustment </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.adjustments.show', adjustment.id)"> Information </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Adjustment Information</h5>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Requested By</th>
                                        <td>{{ adjustment.user ? adjustment.user.name : '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Login Date</th>
                                        <td>{{ adjustment.login_date }} ({{ adjustment.login_time }} - {{ adjustment.logout_time }})</td>
                                    </tr>
                                    <tr>
                                        <th>Adjustment Time</th>
                                        <td>{{ adjustment.time_to_be_adjusted }}</td>
                                    </tr>
                                    <tr>
                                        <th>Adjustment Category</th>
                                        <td>{{ adjustment.category ? adjustment.category.title : '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Inform To</th>
                                        <td>{{ adjustment.inform ? adjustment.inform.name : '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td><p v-html="adjustment.status_label"></p></td>
                                    </tr>
                                    <tr>
                                        <th>Remarks</th>
                                        <td><p v-html="adjustment.remarks"></p></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div v-if="is_supervisor && adjustment.status == '0'">
                                <button class="btn btn-sm btn-outline-success" @click="sApproveForm(adjustment.id)"><i class="bi bi-check2"></i>Approve</button>
                                <button class="btn btn-sm btn-outline-danger" @click="rejectAdjustmentForm(adjustment.id)"><i class="bi bi-check2"></i>Reject</button>
                            </div>
                            <div v-if="HrHandler && adjustment.status == '1'">
                                <button class="btn btn-sm btn-outline-success" @click="hrApproveForm(adjustment.id)"><i class="bi bi-check2"></i>Approve</button>
                                <button class="btn btn-sm btn-outline-danger" @click="rejectAdjustmentForm(adjustment.id)"><i class="bi bi-check2"></i>Reject</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
