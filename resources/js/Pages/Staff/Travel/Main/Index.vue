<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import ReportLink from "@/Components/ReportLink.vue";
import CenterModal from "@/Components/CenterModal.vue";
import { ref } from "vue";

const form = useForm();
const approveForm = useForm({
    travel_id: null,
    remarks: null,
    status: null,
    type: null
});
const props = defineProps({
    travels: {
        type: Object,
        default: () => ({}),
    },
    supervisorApprovals: Object,
    accountApprovals: Object,
    managerApprovals: Object,
    hrApprovals: Object,
    approval: Object,
    types: Object,
    counter: Object,
    manager: Boolean,
    filters: {
        type: Object,
        default: () => ({}),
    },
    can: Array
});
let SuperAdmin = props.can.includes('SuperAdmin');
let HrHandler = props.can.includes('HrHandler');
let PayrollHandler = props.can.includes('PayrollHandler');

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("staffs.travels.destroy", id));
    }
}
function approveTravelRequestModel(id, type)
{
    approveForm.travel_id = id;
    approveForm.type = type;
    $('#approveTravelRequestModel').modal('show');
}
function closeApproveTravelRequestModel()
{
    approveForm.reset();
    $('#approveTravelRequestModel').modal('hide');
}
</script>
<template>
    <Head title="Travel Page" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Travel
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.travels.index')" :only="['travel']"> Travel </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('staffs.travels.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> New Travel
                </Link>
            </div>
            <ul class="nav nav-tabs">
                <li class="nav-item" v-if="SuperAdmin || HrHandler">
                    <ReportLink
                        :active="
                            filters.tab == 'all'
                        "
                        :href="
                            route('staffs.travels.index', [
                                { tab: 'all' },
                            ])
                        "
                        :only="['travels', 'filters']"
                        >ALl Requests</ReportLink
                    >
                </li>
                <li class="nav-item">
                    <ReportLink
                        :active="
                            filters.tab == 'mytravel'
                        "
                        :href="
                            route('staffs.travels.index', [
                                { tab: 'mytravel' },
                            ])
                        "
                        :only="['travels', 'filters']"
                        >My Travel</ReportLink
                    >
                </li>
                <li class="nav-item">
                    <ReportLink
                        :active="
                            filters.tab == null
                        "
                        :href="
                            route('staffs.travels.index', [
                                { tab: null },
                            ])
                        "
                        :only="['travels', 'filters']"
                        >Requests</ReportLink
                    >
                </li>
                <li class="nav-item">
                    <ReportLink
                        :active="
                            filters.tab == 'swaiting'
                        "
                        :href="
                            route('staffs.travels.index', [
                                { tab: 'swaiting' },
                            ])
                        "
                        :only="['supervisorApprovals', 'counter', 'filters']"
                        >Supervisor <span class="badge bg-danger">{{counter.supervisor}}</span></ReportLink
                    >
                </li>
                <li class="nav-item" v-if="PayrollHandler">
                    <ReportLink
                        :active="
                            filters.tab == 'awaiting'
                        "
                        :href="
                            route('staffs.travels.index', [
                                { tab: 'awaiting' },
                            ])
                        "
                        :only="['accountApprovals', 'counter','filters']"
                        >Account <span class="badge bg-danger">{{counter.account}}</span></ReportLink
                    >
                </li>
                <li class="nav-item" v-if="HrHandler">
                    <ReportLink
                        :active="
                            filters.tab == 'hwaiting'
                        "
                        :href="
                            route('staffs.travels.index', [
                                { tab: 'hwaiting' },
                            ])
                        "
                        :only="['hrApprovals', 'counter','filters']"
                        >Hr <span class="badge bg-danger">{{counter.hr}}</span></ReportLink
                    >
                </li>
                <li class="nav-item" v-if="manager">
                    <ReportLink
                        :active="
                            filters.tab == 'mwaiting'
                        "
                        :href="
                            route('staffs.travels.index', [
                                { tab: 'mwaiting' },
                            ])
                        "
                        :only="['managerApprovals', 'counter','filters']"
                        >Manager <span class="badge bg-danger">{{counter.chairman}}</span></ReportLink
                    >
                </li>
            </ul>
            <div class="card">
                <div class="card-body table-responsive" v-if="filters.tab == 'all' || filters.tab == 'mytravel' || filters.tab == null">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Type</th>
                                <th scope="col">Assigned To</th>
                                <th scope="col">From</th>
                                <th scope="col">To</th>
                                <th scope="col">Assignment</th>
                                <th scope="col">Supervisor</th>
                                <th scope="col">Account</th>
                                <th scope="col">HR</th>
                                <th scope="col">Chairman</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(travel, index) in travels.data"
                                :key="travel.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row">{{ travel.type }}</td>
                                <td scope="row">{{ travel.assign_to ? travel.assign_to.name : '' }}</td>
                                <td scope="row">{{ travel.from }}</td>
                                <td scope="row">{{ travel.to }}</td>
                                <td scope="row">{{ travel.assign_type ? travel.assign_type.title : '' }} - {{travel.assign_category ? travel.assign_category.title : ''}}</td>
                                <td scope="row"><span v-html="travel.supervisor_action"></span></td>
                                <td scope="row"><span v-html="travel.account_action"></span></td>
                                <td scope="row"><span v-html="travel.hr_action"></span></td>
                                <td scope="row"><span v-html="travel.chairman_action"></span></td>
                                <td scope="row">
                                    <div class="btn-group" v-if="travel.assigned_from == $page.props.auth.user.id || travel.assigned_to == $page.props.auth.user.id">
                                        <Link :href="route('staffs.travels.show', travel.id)"
                                            class="btn btn-sm btn-outline-info btn-group">
                                            <i class="bi bi-eye"></i> &nbsp;<span class="badge bg-danger">{{travel.reply_count}}</span>
                                        </Link>
                                        <Link :href="route('staffs.travels.edit', travel.id)"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </Link>
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="destroy(travel.id)"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                    <div v-else>
                                        <Link :href="route('staffs.travels.show', travel.id)"
                                            class="btn btn-sm btn-outline-info btn-group">
                                            <i class="bi bi-eye"></i> &nbsp;<span class="badge bg-danger">{{travel.reply_count}}</span>
                                        </Link>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="11">
                                    <Pagination class="mt-6" :links="travels.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="card-body" v-if="filters.tab == 'swaiting'">
                    <table class="table table-striped mt-3">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Type</th>
                                <th scope="col">Assigned To</th>
                                <th scope="col">From</th>
                                <th scope="col">To</th>
                                <th scope="col">Assignment</th>
                                <th scope="col">Supervisor</th>
                                <th scope="col">Account</th>
                                <th scope="col">HR</th>
                                <th scope="col">Chairman</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(travel, index) in supervisorApprovals"
                                :key="travel.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row">{{ travel.type }}</td>
                                <td scope="row">{{ travel.assign_to ? travel.assign_to.name : '' }}</td>
                                <td scope="row">{{ travel.from }}</td>
                                <td scope="row">{{ travel.to }}</td>
                                <td scope="row">{{ travel.assign_type ? travel.assign_type.title : '' }} - {{travel.assign_category ? travel.assign_category.title : ''}}</td>
                                <td scope="row"><span v-html="travel.supervisor_action"></span></td>
                                <td scope="row"><span v-html="travel.account_action"></span></td>
                                <td scope="row"><span v-html="travel.hr_action"></span></td>
                                <td scope="row"><span v-html="travel.chairman_action"></span></td>
                                <td scope="row">
                                    <div class="btn-group">
                                        <Link :href="route('staffs.travels.show', travel.id)"
                                            class="btn btn-sm btn-outline-info btn-group">
                                            <i class="bi bi-eye"></i> &nbsp;<span class="badge bg-danger">{{travel.reply_count}}</span>
                                        </Link>
                                        <button type="button" class="btn btn-sm btn-outline-primary"><i class="bi bi-person-check" @click="approveTravelRequestModel(travel.id, 'supervisor')"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-body" v-if="filters.tab == 'awaiting'">
                    <table class="table table-striped mt-3">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Type</th>
                                <th scope="col">Assigned To</th>
                                <th scope="col">From</th>
                                <th scope="col">To</th>
                                <th scope="col">Assignment</th>
                                <th scope="col">Supervisor</th>
                                <th scope="col">Account</th>
                                <th scope="col">HR</th>
                                <th scope="col">Chairman</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(travel, index) in accountApprovals"
                                :key="travel.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row">{{ travel.type }}</td>
                                <td scope="row">{{ travel.assign_to ? travel.assign_to.name : '' }}</td>
                                <td scope="row">{{ travel.from }}</td>
                                <td scope="row">{{ travel.to }}</td>
                                <td scope="row">{{ travel.assign_type ? travel.assign_type.title : '' }} - {{travel.assign_category ? travel.assign_category.title : ''}}</td>
                                <td scope="row"><span v-html="travel.supervisor_action"></span></td>
                                <td scope="row"><span v-html="travel.account_action"></span></td>
                                <td scope="row"><span v-html="travel.hr_action"></span></td>
                                <td scope="row"><span v-html="travel.chairman_action"></span></td>
                                <td scope="row">
                                    <div class="btn-group">
                                        <Link :href="route('staffs.travels.show', travel.id)"
                                            class="btn btn-sm btn-outline-info btn-group">
                                            <i class="bi bi-eye"></i> &nbsp;<span class="badge bg-danger">{{travel.reply_count}}</span>
                                        </Link>
                                        <button type="button" class="btn btn-sm btn-outline-primary"><i class="bi bi-person-check" @click="approveTravelRequestModel(travel.id, 'account')"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-body" v-if="filters.tab == 'hwaiting'">
                    <table class="table table-striped mt-3">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Type</th>
                                <th scope="col">Assigned To</th>
                                <th scope="col">From</th>
                                <th scope="col">To</th>
                                <th scope="col">Assignment</th>
                                <th scope="col">Supervisor</th>
                                <th scope="col">Account</th>
                                <th scope="col">HR</th>
                                <th scope="col">Chairman</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(travel, index) in hrApprovals"
                                :key="travel.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row">{{ travel.type }}</td>
                                <td scope="row">{{ travel.assign_to ? travel.assign_to.name : '' }}</td>
                                <td scope="row">{{ travel.from }}</td>
                                <td scope="row">{{ travel.to }}</td>
                                <td scope="row">{{ travel.assign_type ? travel.assign_type.title : '' }} - {{travel.assign_category ? travel.assign_category.title : ''}}</td>
                                <td scope="row"><span v-html="travel.supervisor_action"></span></td>
                                <td scope="row"><span v-html="travel.account_action"></span></td>
                                <td scope="row"><span v-html="travel.hr_action"></span></td>
                                <td scope="row"><span v-html="travel.chairman_action"></span></td>
                                <td scope="row">
                                    <div class="btn-group">
                                        <Link :href="route('staffs.travels.show', travel.id)"
                                            class="btn btn-sm btn-outline-info btn-group">
                                            <i class="bi bi-eye"></i> &nbsp;<span class="badge bg-danger">{{travel.reply_count}}</span>
                                        </Link>
                                        <button type="button" class="btn btn-sm btn-outline-primary"><i class="bi bi-person-check" @click="approveTravelRequestModel(travel.id, 'hr')"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-body" v-if="filters.tab == 'mwaiting'">
                    <table class="table table-striped mt-3">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Type</th>
                                <th scope="col">Assigned To</th>
                                <th scope="col">From</th>
                                <th scope="col">To</th>
                                <th scope="col">Assignment</th>
                                <th scope="col">Supervisor</th>
                                <th scope="col">Account</th>
                                <th scope="col">HR</th>
                                <th scope="col">Chairman</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(travel, index) in managerApprovals"
                                :key="travel.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row">{{ travel.type }}</td>
                                <td scope="row">{{ travel.assign_to ? travel.assign_to.name : '' }}</td>
                                <td scope="row">{{ travel.from }}</td>
                                <td scope="row">{{ travel.to }}</td>
                                <td scope="row">{{ travel.assign_type ? travel.assign_type.title : '' }} - {{travel.assign_category ? travel.assign_category.title : ''}}</td>
                                <td scope="row"><span v-html="travel.supervisor_action"></span></td>
                                <td scope="row"><span v-html="travel.account_action"></span></td>
                                <td scope="row"><span v-html="travel.hr_action"></span></td>
                                <td scope="row"><span v-html="travel.chairman_action"></span></td>
                                <td scope="row">
                                    <div class="btn-group">
                                        <Link :href="route('staffs.travels.show', travel.id)"
                                            class="btn btn-sm btn-outline-info btn-group">
                                            <i class="bi bi-eye"></i> &nbsp;<span class="badge bg-danger">{{travel.reply_count}}</span>
                                        </Link>
                                        <button type="button" class="btn btn-sm btn-outline-primary"><i class="bi bi-person-check" @click="approveTravelRequestModel(travel.id, 'manager')"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <CenterModal
            id="approveTravelRequestModel"
            title="Travel Approval Form"
        >
            <form
                class="form-horizontal"
                @submit.prevent="
                    approveForm.post(route('staffs.travels.approval'), {
                        onSuccess: () => closeApproveTravelRequestModel()
                    })
                "
            >
                <div class="form-group row mb-3">
                    <label
                        for="status"
                        class="col-sm-4 col-form-label"
                        >Approval</label
                    >
                    <div class="col-sm-8">
                        <select
                            v-model="approveForm.status"
                            id="status"
                            class="form-control"
                        >
                            <option
                                v-for="(
                                    status, sindex
                                ) in approval"
                                :key="sindex"
                                :value="status.value"
                            >
                                {{ status.title }}
                            </option>
                        </select>
                        <div
                            class="text-red-400 text-sm"
                            v-if="approveForm.errors.status"
                        >
                            {{ approveForm.errors.status }}
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label
                        for="Remarks"
                        class="col-sm-4 col-form-label"
                        >Remarks</label
                    >
                    <div class="col-sm-8">
                        <textarea rows="5" class="form-control" v-model="approveForm.remarks"></textarea>
                        <div
                            class="text-red-400 text-sm"
                            v-if="approveForm.errors.remarks"
                        >
                            {{ approveForm.errors.remarks }}
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
    </StaffLayout>
</template>
