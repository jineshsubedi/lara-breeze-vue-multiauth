<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import NavLink from "@/Components/NavLink.vue";
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";

const sApproveform = useForm({
    status: '1'
});
const hrApproveform = useForm({
    status: '2'
});
const rejectForm = useForm({
    status: '3'
});
const form = useForm();

const props = defineProps({
    overtimes: {
        type: Object,
        default: () => ({}),
    },
    branches: Object,
    categories: Object,
    staffs: Object,
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
        form.delete(route("admin.overtimes.destroy", id));
    }
}
function sApproveForm(id)
{
    if (confirm("Are you sure you want to Approve")) {
        sApproveform.patch(route("admin.overtimes.status", id));
    }
}
function hrApproveForm(id)
{
    if (confirm("Are you sure you want to Approve")) {
        hrApproveform.patch(route("admin.overtimes.status", id));
    }
}
function rejectovertimeForm(id)
{
    if (confirm("Are you sure you want to Reject")) {
        rejectForm.patch(route("admin.overtimes.status", id));
    }
}
let branch = ref(props.filters.branch)
let category = ref(props.filters.category)
let staff = ref(props.filters.staff)
let from = ref(props.filters.from)
let to = ref(props.filters.to)

function loadFilter()
{
    Inertia.get(
        route('admin.overtimes.index'),
        { branch: branch.value, from: from.value, to: to.value, category: category.value, staff: staff.value, type: props.filters.type },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    );
}

</script>
<template>
    <Head title="Overtime Page" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Overtime
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.overtimes.index')" :only="['overtimes']"> Overtime </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('admin.overtimes.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> New Overtime
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Overtime</h5>
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <NavLink :active="filters.type == 0 || filters.type == null" :href="route('admin.overtimes.index',{type: null})" >My Overtimes</NavLink>
                        </li>
                        <li class="nav-item">
                            <NavLink :active="filters.type == 1" :href="route('admin.overtimes.index', {type:1})" >SubOrdinate Overtimes</NavLink>
                        </li>
                        <li class="nav-item" v-if="HrHandler">
                            <NavLink :active="filters.type == 2" :href="route('admin.overtimes.index', {type:2})">Staffs Overtime</NavLink>
                        </li>
                    </ul>
                    <div class="row mt-3">
                        <div class="col-md-3" v-if="SuperAdmin">
                            <label for="">Select Branch</label>
                            <select v-model="branch" class="form-control" @change="loadFilter">
                                <option value="">Select branch</option>
                                <option v-for="(branch, bin) in branches" :key="bin" :value="branch.id">{{ branch.name }}</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="">Select Category</label>
                            <select v-model="category" class="form-control" @change="loadFilter">
                                <option value="">Select Category</option>
                                <option v-for="(category, cin) in categories" :key="cin" :value="category.id">{{ category.title }}</option>
                            </select>
                        </div>
                        <div class="col-md-3" v-if="HrHandler || SuperAdmin">
                            <label for="">Select Staff</label>
                            <select v-model="staff" class="form-control" @change="loadFilter">
                                <option value="">Select Staff</option>
                                <option v-for="(staff, sin) in staffs" :key="sin" :value="staff.id">{{ staff.name }}</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="">From</label>
                            <input type="date" v-model="from" class="form-control" @change="loadFilter">
                        </div>
                        <div class="col-md-3">
                            <label for="">To</label>
                            <input type="date" v-model="to" class="form-control" @change="loadFilter">
                        </div>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col" v-if="SuperAdmin">Branch</th>
                                <th scope="col">Name</th>
                                <th scope="col">Login (Login - Logout)</th>
                                <th scope="col">Overtime Hour</th>
                                <th scope="col">Overtime Reason</th>
                                <th scope="col">Holiday</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(overtime, index) in overtimes.data"
                                :key="overtime.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row" v-if="SuperAdmin">{{ overtime.branch ? overtime.branch.name : '' }}</td>
                                <td scope="row">{{ overtime.user ? overtime.user.name : '' }}</td>
                                <td scope="row">{{ overtime.login_date }} ({{ overtime.login_time }} - {{ overtime.logout_time }})</td>
                                <td scope="row">{{ overtime.ot_hour }}</td>
                                <td scope="row">{{ overtime.category ? overtime.category.title : '' }}</td>
                                <td scope="row">{{ overtime.holiday == 1 ? 'Yes' : 'No' }}</td>
                                <td scope="row"><p v-html="overtime.status_label"></p></td>
                                <td scope="row">
                                    <div class="btn-group"  v-if="overtime.user_id == $page.props.auth.user.id">
                                        <Link :href="route('admin.overtimes.show', overtime.id)"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </Link>
                                        <Link :href="route('admin.overtimes.edit', overtime.id)"
                                            class="btn btn-sm btn-outline-warning"
                                            v-if="overtime.status == '0'">
                                            <i class="bi bi-pencil-square"></i>
                                        </Link>
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="destroy(overtime.id)"
                                            v-if="overtime.status == '0'"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                    <div class="btn-group" v-if="filters.type == '1' && overtime.status == '0'">
                                        <Link :href="route('admin.overtimes.show', overtime.id)"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </Link>
                                        <button type="button" @click="sApproveForm(overtime.id)" class="btn btn-sm btn-outline-success"><i class="bi bi-check2"></i></button>
                                        <button type="button" @click="rejectovertimeForm(overtime.id)" class="btn btn-sm btn-outline-danger"><i class="bi bi-x-lg"></i></button>
                                    </div>
                                    <div class="btn-group" v-if="HrHandler && overtime.status == '1'">
                                        <Link :href="route('admin.overtimes.show', overtime.id)"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </Link>
                                        <button type="button" @click="hrApproveForm(overtime.id)" class="btn btn-sm btn-outline-success"><i class="bi bi-check2"></i></button>
                                        <button type="button" @click="rejectovertimeForm(overtime.id)" class="btn btn-sm btn-outline-danger"><i class="bi bi-x-lg"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="8">
                                    <Pagination class="mt-6" :links="overtimes.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
