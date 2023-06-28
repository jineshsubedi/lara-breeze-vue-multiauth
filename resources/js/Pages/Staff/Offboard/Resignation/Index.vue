<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import CenterModal from "@/Components/CenterModal.vue";
import CenterModal2 from "@/Components/CenterModal.vue";
import ReportLink from "@/Components/ReportLink.vue";
import { ref } from "vue";

const form = useForm();
const approveForm = useForm({
    resignation_id: null,
    supervisor_approval_status: null,
    supervisor_approval_detail: null,
    offBoarding_date: null,
    type: null
});
const retractForm = useForm({
    resignation_staffs_id: null,
    description: null,
    work_commitment: null,
    retraction_reason: null,
});

const props = defineProps({
    resignationstaffs: {
        type: Object,
        default: () => ({}),
    },
    resignation_status: Object,
    retraction_status:Object,
    filters: {
        type: Object,
        default: () => ({}),
    },
    can: Array
});
let SuperAdmin = props.can.includes('SuperAdmin');
let HrHandler = props.can.includes('HrHandler');

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("staffs.resignations.destroy", id));
    }
}

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
function openRetractionModel(id)
{
    retractForm.resignation_staffs_id = id;
    $('#approveResignationRetractModel').modal('show');
}
function closeRetractionModel()
{
    $('#approveResignationRetractModel').modal('hide');
    retractForm.reset();
}
</script>
<template>
    <Head title="Resignations Page" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Resignation
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.resignations.index')" :only="['resignationstaffs']"> Resignations </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('staffs.resignations.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> Request Resignation
                </Link>
            </div>
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <ReportLink
                                :active="
                                    filters.tab == null
                                "
                                :href="
                                    route('staffs.resignations.index', [
                                        { tab: null },
                                    ])
                                "
                                :only="['resignationstaffs', 'filters']"
                                >Resignation</ReportLink
                            >
                        </li>
                        <li class="nav-item">
                            <ReportLink
                                :active="
                                    filters.tab == 'approval'
                                "
                                :href="
                                    route('staffs.resignations.index', [
                                        { tab: 'approval' },
                                    ])
                                "
                                :only="['resignationstaffs', 'filters']"
                                >Waiting For Approval</ReportLink
                            >
                        </li>
                        <li class="nav-item" v-if="HrHandler | SuperAdmin">
                            <ReportLink
                                :active="
                                    filters.tab == 'hrapproval'
                                "
                                :href="
                                    route('staffs.resignations.index', [
                                        { tab: 'hrapproval' },
                                    ])
                                "
                                :only="['resignationstaffs', 'filters']"
                                >Waiting For HR Approval</ReportLink
                            >
                        </li>
                    </ul>
                </div>
                <div class="card-body" v-if="filters.tab == null">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
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
                                    <td scope="row">{{ resignationstaff.reason ? resignationstaff.reason.title : '' }}</td>
                                    <td scope="row">{{ resignationstaff.type ? resignationstaff.type.title : '' }}</td>
                                    <td scope="row">{{ resignationstaff.resignation_date }}</td>
                                    <td scope="row">{{ resignationstaff.supervisor_approval_status }}</td>
                                    <td scope="row">{{ resignationstaff.status }}</td>
                                    <td scope="row">{{ resignationstaff.offBoarding_date }}</td>
                                    <td scope="row">
                                        <div v-if="resignationstaff.retractAction == true">
                                            <button type="button" class="btn btn-sm btn-outline-warning" @click="openRetractionModel(resignationstaff.id)">Retract Request</button>
                                        </div>
                                        <div v-else>
                                            <span v-html="resignationstaff.retract"></span>
                                        </div>
                                    </td>
                                    <td scope="row">
                                        <div class="btn-group" v-if="resignationstaff.supervisor_approval_status == 'pending'">
                                            <Link :href="route('staffs.resignations.show', resignationstaff.id)"
                                                class="btn btn-sm btn-outline-info">
                                                <i class="bi bi-eye"></i>
                                            </Link>
                                            <Link :href="route('staffs.resignations.edit', resignationstaff.id)"
                                                class="btn btn-sm btn-outline-warning">
                                                <i class="bi bi-pencil-square"></i>
                                            </Link>
                                            <button
                                                class="btn btn-sm btn-outline-danger"
                                                @click="destroy(resignationstaff.id)"
                                            >
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                        <div v-else>
                                            <Link :href="route('staffs.resignations.show', resignationstaff.id)"
                                                class="btn btn-sm btn-outline-info">
                                                <i class="bi bi-eye"></i>
                                            </Link>
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
                <div class="card-body" v-if="filters.tab == 'approval'">
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
                                    <td scope="row"><span v-html="resignationstaff.retract"></span></td>
                                    <td scope="row">
                                        <div class="btn-group">
                                            <Link :href="route('staffs.resignations.show', resignationstaff.id)"
                                                class="btn btn-sm btn-outline-info">
                                                <i class="bi bi-eye"></i>
                                            </Link>
                                            <button
                                                class="btn btn-sm btn-outline-primary"
                                                @click="openApprovalModal(resignationstaff.id, 'supervisor')"
                                                v-if="resignationstaff.supervisor_approval_date == null"
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
                <div class="card-body" v-if="filters.tab == 'hrapproval' && (HrHandler || SuperAdmin)">
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
                                    <td scope="row"></td>
                                    <td scope="row">
                                        <div class="btn-group">
                                            <Link :href="route('staffs.resignations.show', resignationstaff.id)"
                                                class="btn btn-sm btn-outline-info">
                                                <i class="bi bi-eye"></i>
                                            </Link>
                                            <button
                                                class="btn btn-sm btn-outline-primary"
                                                @click="openApprovalModal(resignationstaff.id, 'hr')"
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
                        approveForm.post(route('staffs.resignations.approval'), {
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
                id="approveResignationRetractModel"
                title="Resignation Retraction Form"
            >
                <form
                    class="form-horizontal"
                    @submit.prevent="
                        retractForm.post(route('staffs.retraction.save'), {
                            onSuccess: () => closeRetractionModel()
                        })
                    "
                >
                    <div class="form-group row mb-3">
                        <label
                            for="retraction_reason"
                            class="col-sm-4 col-form-label"
                            >Retraction Reason</label
                        >
                        <div class="col-sm-8">
                            <select
                                v-model="retractForm.retraction_reason"
                                id="retraction_reason"
                                class="form-control"
                            >
                                <option
                                    v-for="(
                                        status, sindex
                                    ) in retraction_status"
                                    :key="sindex"
                                    :value="status.value"
                                >
                                    {{ status.title }}
                                </option>
                            </select>
                            <div
                                class="text-red-400 text-sm"
                                v-if="approveForm.errors.retraction_reason"
                            >
                                {{ approveForm.errors.retraction_reason }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label
                            for="work_commitment"
                            class="col-sm-4 col-form-label"
                            >Work Commitment</label
                        >
                        <div class="col-sm-8">
                            <input type="number" min="1" max="10" class="form-control" v-model="retractForm.work_commitment">
                            <div
                                class="text-red-400 text-sm"
                                v-if="retractForm.errors.work_commitment"
                            >
                                {{ retractForm.errors.work_commitment }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label
                            for="description"
                            class="col-sm-4 col-form-label"
                            >Description</label
                        >
                        <div class="col-sm-8">
                            <textarea rows="5" class="form-control" v-model="retractForm.description"></textarea>
                            <div
                                class="text-red-400 text-sm"
                                v-if="retractForm.errors.description"
                            >
                                {{ retractForm.errors.description }}
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
    </StaffLayout>
</template>
