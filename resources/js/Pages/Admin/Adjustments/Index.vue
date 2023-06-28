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
    adjustments: {
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
        form.delete(route("admin.adjustments.destroy", id));
    }
}
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
let branch = ref(props.filters.branch)
let category = ref(props.filters.category)
let staff = ref(props.filters.staff)
let from = ref(props.filters.from)
let to = ref(props.filters.to)

function loadFilter()
{
    Inertia.get(
        route('admin.adjustments.index'),
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
    <Head title="Adjustment Page" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Adjustment
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.adjustments.index')" :only="['adjustments']"> Adjustment </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('admin.adjustments.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> New Adjustment
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Adjustment</h5>
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <NavLink :active="filters.type == 0 || filters.type == null" :href="route('admin.adjustments.index',{type: null})" >My Adjustments</NavLink>
                        </li>
                        <li class="nav-item">
                            <NavLink :active="filters.type == 1" :href="route('admin.adjustments.index', {type:1})" >SubOrdinate Adjustments</NavLink>
                        </li>
                        <li class="nav-item" v-if="HrHandler">
                            <NavLink :active="filters.type == 2" :href="route('admin.adjustments.index', {type:2})">Staffs Adjustment</NavLink>
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
                                <th scope="col">Time To Adjust</th>
                                <th scope="col">Adjustment Reason</th>
                                <th scope="col">Inform To</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(adjustment, index) in adjustments.data"
                                :key="adjustment.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row" v-if="SuperAdmin">{{ adjustment.branch ? adjustment.branch.name : '' }}</td>
                                <td scope="row">{{ adjustment.user ? adjustment.user.name : '' }}</td>
                                <td scope="row">{{ adjustment.login_date }} ({{ adjustment.login_time }} - {{ adjustment.logout_time }})</td>
                                <td scope="row">{{ adjustment.time_to_be_adjusted }}</td>
                                <td scope="row">{{ adjustment.category ? adjustment.category.title : '' }}</td>
                                <td scope="row">{{ adjustment.inform ? adjustment.inform.name : '' }}</td>
                                <td scope="row"><p v-html="adjustment.status_label"></p></td>
                                <td scope="row">
                                    <div class="btn-group"  v-if="adjustment.user_id == $page.props.auth.user.id">
                                        <Link :href="route('admin.adjustments.show', adjustment.id)"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </Link>
                                        <Link :href="route('admin.adjustments.edit', adjustment.id)"
                                            class="btn btn-sm btn-outline-warning"
                                            v-if="adjustment.status == '0'">
                                            <i class="bi bi-pencil-square"></i>
                                        </Link>
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="destroy(adjustment.id)"
                                            v-if="adjustment.status == '0'"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                    <div class="btn-group" v-if="filters.type == '1' && adjustment.status == '0'">
                                        <Link :href="route('admin.adjustments.show', adjustment.id)"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </Link>
                                        <button type="button" @click="sApproveForm(adjustment.id)" class="btn btn-sm btn-outline-success"><i class="bi bi-check2"></i></button>
                                        <button type="button" @click="rejectAdjustmentForm(adjustment.id)" class="btn btn-sm btn-outline-danger"><i class="bi bi-x-lg"></i></button>
                                    </div>
                                    <div class="btn-group" v-if="HrHandler && adjustment.status == '1'">
                                        <Link :href="route('admin.adjustments.show', adjustment.id)"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </Link>
                                        <button type="button" @click="hrApproveForm(adjustment.id)" class="btn btn-sm btn-outline-success"><i class="bi bi-check2"></i></button>
                                        <button type="button" @click="rejectAdjustmentForm(adjustment.id)" class="btn btn-sm btn-outline-danger"><i class="bi bi-x-lg"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="8">
                                    <Pagination class="mt-6" :links="adjustments.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
