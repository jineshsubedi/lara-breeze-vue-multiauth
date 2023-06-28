<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import CenterModal from "@/Components/CenterModal.vue";
import CenterModal2 from "@/Components/CenterModal.vue";

const form = useForm();
const props = defineProps({
    resignationstaffs: {
        type: Object,
        default: () => ({}),
    },
    resignation_status: Object,
    filters: {
        type: Object,
        default: () => ({}),
    },
    can: Array
});
let SuperAdmin = props.can.includes('SuperAdmin');

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("admin.resignationstaffs.destroy", id));
    }
}
const approveForm = useForm({
    resignation_id: null,
    supervisor_approval_status: null,
    supervisor_approval_detail: null,
    offBoarding_date: null,
    type: null
});
function openApprovalModal(id, type)
{
    approveForm.resignation_id = id;
    approveForm.type = type;
    $('#approveResignationRequestModel').modal('show');
}
function closeApprovalModal()
{
    $('#approveResignationRequestModel').modal('hide');
    approveForm.reset();
}
const retractForm = useForm({
    resignation_id: null,
    description: null,
    work_commitment: null,
    retraction_reason: null,
    hr_approval: null,
    hr_remark: null
});
function openRetractApprovalModel(retraction)
{
    retractForm.resignation_id= retraction.resignation_staffs_id
    retractForm.description= retraction.description
    retractForm.work_commitment= retraction.work_commitment
    retractForm.retraction_reason= retraction.retraction_reason
    $('#retractApprovalModal').modal('show')
}
function closeRetractApprovalModel()
{
    $('#retractApprovalModal').modal('hide')
    retractForm.reset();
}
</script>
<template>
    <Head title="ResignationStaff Page" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ResignationStaff
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.resignationstaffs.index')" :only="['resignationstaffs']"> ResignationStaff </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('admin.resignationstaffs.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> New ResignationStaff
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">ResignationStaff</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th>Staff</th>
                                    <th>Reason</th>
                                    <th>Type</th>
                                    <th>Resignation Date</th>
                                    <th>Supervisor Approval</th>
                                    <th>Hr Approval</th>
                                    <th>OffBoarding Date</th>
                                    <th>Retract</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr 
                                    v-for="(resignationstaff, index) in resignationstaffs.data"
                                    :key="resignationstaff.id"
                                >
                                    <th scope="row">{{ ++index }}</th>
                                    <td scope="row">{{ resignationstaff.user ? resignationstaff.user.name : '' }}</td>
                                    <td scope="row">{{ resignationstaff.reason ? resignationstaff.reason.title : '' }}</td>
                                    <td scope="row">{{ resignationstaff.type ? resignationstaff.type.title : '' }}</td>
                                    <td scope="row">{{ resignationstaff.resignation_date }}</td>
                                    <td scope="row">{{ resignationstaff.supervisor_approval_status }}</td>
                                    <td scope="row">{{ resignationstaff.status }}</td>
                                    <td scope="row">{{ resignationstaff.offBoarding_date }}</td>
                                    <td scope="row">
                                        <div v-if="resignationstaff.retraction != null">
                                            <div v-if="resignationstaff.retraction.hr_approval != null">
                                                <span v-html="resignationstaff.retract"></span>
                                            </div>
                                            <div v-else>
                                                <button type="button" class="btn btn-sm btn-outline-warning" @click="openRetractApprovalModel(resignationstaff.retraction)">Retract Request</button>
                                            </div>
                                        </div>
                                        <div v-else>
                                            <span v-html="resignationstaff.retract"></span>
                                        </div>
                                    </td>
                                    <td scope="row">
                                        <div class="btn-group">
                                            <Link :href="route('admin.resignationstaffs.show', resignationstaff.id)"
                                                class="btn btn-sm btn-outline-info">
                                                <i class="bi bi-eye"></i>
                                            </Link>
                                            <Link :href="route('admin.resignationstaffs.edit', resignationstaff.id)"
                                                class="btn btn-sm btn-outline-warning"
                                                v-if="resignationstaff.status != 'approved'">
                                                <i class="bi bi-pencil-square"></i>
                                            </Link>
                                            <button
                                                class="btn btn-sm btn-outline-danger"
                                                @click="destroy(resignationstaff.id)"
                                                v-if="resignationstaff.status != 'approved'"
                                            >
                                                <i class="bi bi-trash"></i>
                                            </button>
                                            <button
                                                class="btn btn-sm btn-outline-primary"
                                                @click="openApprovalModal(resignationstaff.id, 'hr')"
                                                v-if="resignationstaff.supervisor_approval_status == 'approved' && resignationstaff.status == 'pending'"
                                            >
                                                <i class="bi bi-person-check"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="10">
                                        <Pagination class="mt-6" :links="resignationstaffs.links" />
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <CenterModal
                id="approveResignationRequestModel"
                title="Resignation Approval Form"
            >
                <form
                    class="form-horizontal"
                    @submit.prevent="
                        approveForm.post(route('admin.resignations.approval'), {
                            onSuccess: () => closeApprovalModal()
                        })
                    "
                >
                    <div class="form-group row mb-3">
                        <label
                            for="supervisor_approval_status"
                            class="col-sm-4 col-form-label"
                            >Approval</label
                        >
                        <div class="col-sm-8">
                            <select
                                v-model="approveForm.supervisor_approval_status"
                                id="supervisor_approval_status"
                                class="form-control"
                            >
                                <option
                                    v-for="(
                                        status, sindex
                                    ) in resignation_status"
                                    :key="sindex"
                                    :value="status"
                                >
                                    {{ status }}
                                </option>
                            </select>
                            <div
                                class="text-red-400 text-sm"
                                v-if="approveForm.errors.supervisor_approval_status"
                            >
                                {{ approveForm.errors.supervisor_approval_status }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-3" v-if="approveForm.type == 'hr'">
                        <label
                            for="offBoarding_date"
                            class="col-sm-4 col-form-label"
                            >Offboarding Date</label
                        >
                        <div class="col-sm-8">
                            <input type="date" class="form-control" v-model="approveForm.offBoarding_date">
                            <div
                                class="text-red-400 text-sm"
                                v-if="approveForm.errors.offBoarding_date"
                            >
                                {{ approveForm.errors.offBoarding_date }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label
                            for="supervisor_approval_detail"
                            class="col-sm-4 col-form-label"
                            >Remarks</label
                        >
                        <div class="col-sm-8">
                            <textarea rows="5" class="form-control" v-model="approveForm.supervisor_approval_detail"></textarea>
                            <div
                                class="text-red-400 text-sm"
                                v-if="approveForm.errors.supervisor_approval_detail"
                            >
                                {{ approveForm.errors.supervisor_approval_detail }}
                            </div>
                        </div>
                    </div>
                    <div class="offset-sm-2 col-sm-10">
                        <button
                            type="submit"
                            class="btn btn-outline-primary btn-sm"
                        >
                            Submit
                        </button>
                    </div>
                </form>
            </CenterModal>
            <CenterModal2
                id="retractApprovalModal"
                title="Resignation Retraction Form"
            >
                <form
                    class="form-horizontal"
                    @submit.prevent="
                        retractForm.post(route('admin.retraction.approval'), {
                            onSuccess: () => closeRetractApprovalModel()
                        })
                    "
                >
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Retract Reason</th>
                                <td>{{retractForm.retraction_reason}}</td>
                            </tr>
                            <tr>
                                <th>Work Commitment</th>
                                <td>{{retractForm.work_commitment}} Year</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td><span v-html="retractForm.description"></span></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="form-group row mb-3">
                        <label
                            for="hr_approval"
                            class="col-sm-4 col-form-label"
                            >Approval</label
                        >
                        <div class="col-sm-8">
                            <select
                                v-model="retractForm.hr_approval"
                                id="hr_approval"
                                class="form-control"
                            >
                                <option
                                    v-for="(
                                        status, sindex
                                    ) in resignation_status"
                                    :key="sindex"
                                    :value="status"
                                >
                                    {{ status }}
                                </option>
                            </select>
                            <div
                                class="text-red-400 text-sm"
                                v-if="retractForm.errors.hr_approval"
                            >
                                {{ retractForm.errors.hr_approval }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label
                            for="hr_remark"
                            class="col-sm-4 col-form-label"
                            >Remarks</label
                        >
                        <div class="col-sm-8">
                            <textarea rows="5" class="form-control" v-model="retractForm.hr_remark"></textarea>
                            <div
                                class="text-red-400 text-sm"
                                v-if="retractForm.errors.hr_remark"
                            >
                                {{ retractForm.errors.hr_remark }}
                            </div>
                        </div>
                    </div>
                    <div class="offset-sm-2 col-sm-10">
                        <button
                            type="submit"
                            class="btn btn-outline-primary btn-sm"
                        >
                            Submit
                        </button>
                    </div>
                </form>
            </CenterModal2>
        </div>
    </AdminLayout>
</template>
