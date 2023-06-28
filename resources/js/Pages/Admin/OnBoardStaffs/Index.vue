<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import { ref, watch } from "vue";
import { Inertia } from "@inertiajs/inertia";
import throttle from "lodash/throttle";
import ReportLink from "@/Components/ReportLink.vue";
import CenterModal from "@/Components/CenterModal.vue";

const form = useForm();
const props = defineProps({
    onboardstaffs: {
        type: Object,
        default: () => ({}),
    },
    ostatus: Object,
    filters: {
        type: Object,
        default: () => ({}),
    },
    can: Array
});
let SuperAdmin = props.can.includes('SuperAdmin');
let HrHandler = props.can.includes('HrHandler');

let name = ref(props.filters.name);
let email = ref(props.filters.email);

watch([name, email], throttle(function (value){
    Inertia.get(
        route('admin.outsources.index'),
        { name: name.value, email: email.value },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    );
}, 500
));
function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("admin.onboardings.destroy", id));
    }
}
const approveForm = useForm({
    id: '',
    type: '',
    status: '',
    comment: '',
});
function approvalModel(id, type)
{
    approveForm.id = id;
    approveForm.type = type;
    $('#approvalModel').modal('show');
}
function updateStatus()
{
    approveForm.post(route("admin.onboardings.approve"), {
        preserveScroll: true,
        onSuccess: () => {
            closeApprovalModel()
        },
    });
}
function closeApprovalModel(id, type)
{
    approveForm.reset();
    $('#approvalModel').modal('hide');
}
</script>
<template>
    <Head title="OnBoardStaff Page" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                OnBoardStaff
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.onboardings.index')" :only="['onboardstaffs']"> OnBoardStaff </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right" v-if="HrHandler || SuperAdmin">
                <Link :href="route('admin.onboardings.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> New OnBoardStaff
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
                                    route('admin.onboardings.index', [
                                        { tab: null },
                                    ])
                                "
                                :only="['onboardstaffs', 'filters']"
                                >OnBoard Staffs</ReportLink
                            >
                        </li>
                        <li class="nav-item">
                            <ReportLink
                                :active="
                                    filters.tab == 'supervisor'
                                "
                                :href="
                                    route('admin.onboardings.index', [
                                        { tab: 'supervisor' },
                                    ])
                                "
                                :only="['onboardstaffs', 'filters']"
                                >Supervisor Approval</ReportLink
                            >
                        </li>
                        <li class="nav-item" v-if="HrHandler || SuperAdmin">
                            <ReportLink
                                :active="
                                    filters.tab == 'hr'
                                "
                                :href="
                                    route('admin.onboardings.index', [
                                        { tab: 'hr' },
                                    ])
                                "
                                :only="['onboardstaffs', 'filters']"
                                >HR Approval</ReportLink
                            >
                        </li>
                        <li class="nav-item" v-if="HrHandler || SuperAdmin">
                            <ReportLink
                                :active="
                                    filters.tab == 'rejected'
                                "
                                :href="
                                    route('admin.onboardings.index', [
                                        { tab: 'rejected' },
                                    ])
                                "
                                :only="['onboardstaffs', 'filters']"
                                >Rejected</ReportLink
                            >
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div v-if="
                        filters.tab == null
                    ">
                        <h5 class="card-title">OnBoardStaff</h5>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Supervisor</th>
                                    <th scope="col">HR</th>
                                    <th scope="col">Trail</th>
                                    <th scope="col">Joining Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">
                                        <input
                                            type="text"
                                            v-model="name"
                                            placeholder="Staff Name"
                                            class="form-control"
                                        />
                                    </th>
                                    <th scope="col">
                                        <input
                                            type="text"
                                            v-model="email"
                                            placeholder="Staff Email"
                                            class="form-control"
                                        />
                                    </th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr 
                                    v-for="(onboardstaff, index) in onboardstaffs.data"
                                    :key="onboardstaff.id"
                                >
                                    <th scope="row">{{ ++index }}</th>
                                    <td scope="row">{{ onboardstaff.name }}</td>
                                    <td scope="row">{{ onboardstaff.email }}</td>
                                    <td scope="row">{{ onboardstaff.supervisor_approval }}</td>
                                    <td scope="row">{{ onboardstaff.hr_approval }}</td>
                                    <td scope="row">{{ onboardstaff.trail_period == 1 ? 'Yes' : 'No' }}</td>
                                    <td scope="row">{{ onboardstaff.joining_date }}</td>
                                    <td scope="row">
                                        <div class="btn-group" v-if="HrHandler || SuperAdmin">
                                            <Link :href="route('admin.onboardings.show', onboardstaff.id)"
                                                class="btn btn-sm btn-outline-info">
                                                <i class="bi bi-eye"></i>
                                            </Link>
                                            <Link :href="route('admin.onboardings.edit', onboardstaff.id)"
                                                class="btn btn-sm btn-outline-warning">
                                                <i class="bi bi-pencil-square"></i>
                                            </Link>
                                            <button
                                                class="btn btn-sm btn-outline-danger"
                                                @click="destroy(onboardstaff.id)"
                                            >
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="8">
                                        <Pagination class="mt-6" :links="onboardstaffs.links" />
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div v-if="
                        filters.tab == 'supervisor'
                    ">
                        <h5 class="card-title">OnBoardStaff</h5>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Supervisor</th>
                                    <th scope="col">HR</th>
                                    <th scope="col">Trail</th>
                                    <th scope="col">Joining Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr 
                                    v-for="(onboardstaff, index) in onboardstaffs.data"
                                    :key="onboardstaff.id"
                                >
                                    <th scope="row">{{ ++index }}</th>
                                    <td scope="row">{{ onboardstaff.name }}</td>
                                    <td scope="row">{{ onboardstaff.email }}</td>
                                    <td scope="row">{{ onboardstaff.supervisor_approval }}</td>
                                    <td scope="row">{{ onboardstaff.hr_approval }}</td>
                                    <td scope="row">{{ onboardstaff.trail_period == 1 ? 'Yes' : 'No' }}</td>
                                    <td scope="row">{{ onboardstaff.joining_date }}</td>
                                    <td scope="row">
                                        <div class="btn-group" v-if="HrHandler || SuperAdmin">
                                            <button
                                                class="btn btn-sm btn-outline-primary"
                                                @click="approvalModel(onboardstaff.id, 'supervisor')"
                                            >
                                                <i class="bi bi-person-check"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="8">
                                        <Pagination class="mt-6" :links="onboardstaffs.links" />
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div v-if="
                        filters.tab == 'hr'
                    ">
                        <h5 class="card-title">OnBoardStaff</h5>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Supervisor</th>
                                    <th scope="col">HR</th>
                                    <th scope="col">Trail</th>
                                    <th scope="col">Joining Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr 
                                    v-for="(onboardstaff, index) in onboardstaffs.data"
                                    :key="onboardstaff.id"
                                >
                                    <th scope="row">{{ ++index }}</th>
                                    <td scope="row">{{ onboardstaff.name }}</td>
                                    <td scope="row">{{ onboardstaff.email }}</td>
                                    <td scope="row">{{ onboardstaff.supervisor_approval }}</td>
                                    <td scope="row">{{ onboardstaff.hr_approval }}</td>
                                    <td scope="row">{{ onboardstaff.trail_period == 1 ? 'Yes' : 'No' }}</td>
                                    <td scope="row">{{ onboardstaff.joining_date }}</td>
                                    <td scope="row">
                                        <div class="btn-group" v-if="HrHandler || SuperAdmin">
                                            <button
                                                class="btn btn-sm btn-outline-primary"
                                                @click="approvalModel(onboardstaff.id, 'hr')"
                                            >
                                                <i class="bi bi-person-check"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="8">
                                        <Pagination class="mt-6" :links="onboardstaffs.links" />
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div v-if="
                        filters.tab == 'rejected'
                    ">
                        <h5 class="card-title">OnBoardStaff</h5>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Supervisor</th>
                                    <th scope="col">HR</th>
                                    <th scope="col">Trail</th>
                                    <th scope="col">Joining Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr 
                                    v-for="(onboardstaff, index) in onboardstaffs.data"
                                    :key="onboardstaff.id"
                                >
                                    <th scope="row">{{ ++index }}</th>
                                    <td scope="row">{{ onboardstaff.name }}</td>
                                    <td scope="row">{{ onboardstaff.email }}</td>
                                    <td scope="row">{{ onboardstaff.supervisor_approval }}</td>
                                    <td scope="row">{{ onboardstaff.hr_approval }}</td>
                                    <td scope="row">{{ onboardstaff.trail_period == 1 ? 'Yes' : 'No' }}</td>
                                    <td scope="row">{{ onboardstaff.joining_date }}</td>
                                    <td scope="row">
                                        <div class="btn-group" v-if="HrHandler || SuperAdmin">
                                            <Link :href="route('admin.onboardings.show', onboardstaff.id)"
                                                class="btn btn-sm btn-outline-info">
                                                <i class="bi bi-eye"></i>
                                            </Link>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="8">
                                        <Pagination class="mt-6" :links="onboardstaffs.links" />
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <CenterModal
                :id="'approvalModel'"
                title="Approval Form"
            >
                <form
                    class="form-horizontal"
                    @submit.prevent="updateStatus()"
                >
                    <div class="form-group row mb-3">
                        <label
                            for="status"
                            class="col-sm-4 col-form-label"
                            >Status</label
                        >
                        <div class="col-sm-8">
                            <select
                                v-model="approveForm.status"
                                id="status"
                                class="form-control"
                            >
                                <option value="">
                                    Select Status
                                </option>
                                <option
                                    v-for="(
                                        sta, index
                                    ) in ostatus"
                                    :key="index"
                                    :value="sta"
                                >
                                    {{ sta }}
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
                            for="Comment"
                            class="col-sm-4 col-form-label"
                            >Comment</label
                        >
                        <div class="col-sm-8">
                            <textarea rows="3" v-model="approveForm.comment" class="form-control"></textarea>
                            <div
                                class="text-red-400 text-sm"
                                v-if="approveForm.errors.comment"
                            >
                                {{ approveForm.errors.comment }}
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
        </div>
    </AdminLayout>
</template>
