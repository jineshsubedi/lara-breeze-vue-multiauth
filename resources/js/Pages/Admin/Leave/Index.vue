<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import { ref } from "vue";
import NavLink from "@/Components/NavLink.vue";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
    leaves: {
        type: Object,
        default: () => ({}), 
    },
    staffs: Object,
    branches: Object,
    defBranch: Number,
    leaveSetting: Object,
    countData: Object,
    filters: {
        type: Object,
        default: () => ({}),
    },
    can: Array
});
const form = useForm();
const approveForm = useForm({
    s_approve: 0,
    h_approve: 0,
    m_approve: 0,
});
let SuperAdmin = props.can.includes('SuperAdmin');
let LeaveManager = props.can.includes('LeaveManager');

let from = ref(props.filters.from);
let to = ref(props.filters.to);
let branch = ref(props.defBranch);
let staff = ref('');
function loadFilter()
{
    Inertia.get(
        route('admin.leaves.index'),
        { from: from.value, to: to.value, branch: branch.value, staff: staff.value},
        {
            preserveState: true,
            replace: true,
        }
    );
}

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("admin.leaves.destroy", id));
    }
}
function approvalLeaveRequest(id, supervisor, hr, manager) {
    approveForm.s_approve = supervisor;
    approveForm.h_approve = hr;
    approveForm.m_approve = manager;
    
    approveForm.patch(route("admin.leaves.approval", id));
}
</script>
<template>
    <Head title="Leave Request Page" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Leave Request
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.leaves.index')"> Leave Request </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('admin.leaves.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> Request Leave
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <NavLink :active="filters.type == 0 || filters.type == null" :href="route('admin.leaves.index',{type: 0})" >All</NavLink>
                        </li>
                        <li class="nav-item">
                            <NavLink :active="filters.type == 1" :href="route('admin.leaves.index', {type:1})" >My Requests</NavLink>
                        </li>
                        <li class="nav-item" v-if="leaveSetting.s_approval == '1'">
                            <NavLink :active="filters.type == 2" :href="route('admin.leaves.index', {type:2})">Approval <span class="badge bg-danger">{{countData.s_count}}</span></NavLink>
                        </li>
                        <li class="nav-item" v-if="leaveSetting.h_approval == '1' && leaveSetting.hr_person == $page.props.auth.user.id">
                            <NavLink :active="filters.type == 3" :href="route('admin.leaves.index', {type:3})">HR Approval <span class="badge bg-danger">{{countData.h_count}}</span></NavLink>
                        </li>
                        <li class="nav-item" v-if="leaveSetting.m_approval == '1' && leaveSetting.m_person == $page.props.auth.user.id">
                            <NavLink :active="filters.type == 4" :href="route('admin.leaves.index', {type:4})">Chairman Approval <span class="badge bg-danger">{{countData.m_count}}</span> </NavLink>
                        </li>
                    </ul>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col" v-if="SuperAdmin">Branch</th>
                                    <th scope="col">Requested By</th>
                                    <th scope="col">Leave Type</th>
                                    <!-- <th scope="col">Request Date</th> -->
                                    <th scope="col">Start Date</th>
                                    <th scope="col">End Date</th>
                                    <th scope="col">Duration</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th v-if="SuperAdmin">
                                        <select v-model="branch" class="form-control" @change="loadFilter" >
                                            <option value="">Select Branch</option>
                                            <option v-for="(branch, bindex) in branches" :key="bindex" :value="branch.id">{{branch.name}}</option>
                                        </select>
                                    </th>
                                    <th>
                                        <select v-model="staff" class="form-control" @change="loadFilter" >
                                            <option value="">Select Staff</option>
                                            <option v-for="(staff, sindex) in staffs" :key="sindex" :value="staff.id">{{staff.name}}</option>
                                        </select>
                                    </th>
                                    <!-- <th></th> -->
                                    <th></th>
                                    <th>
                                        <input
                                            type="date"
                                            v-model="from"
                                            class="form-control"
                                            @change="loadFilter"
                                        />
                                    </th>
                                    <th>
                                        <input
                                            type="date"
                                            v-model="to"
                                            class="form-control"
                                            @change="loadFilter"
                                        />
                                    </th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr 
                                    v-for="(leave, index) in leaves.data"
                                    :key="index"
                                >
                                    <th scope="row">{{ ++index }}</th>
                                    <td scope="row" v-if="SuperAdmin">{{ leave.branch ? leave.branch.name : '' }}</td>
                                    <td scope="row">{{ leave.user ? leave.user.name : '' }}</td>
                                    <td scope="row">{{ leave.leave_type.title }}</td>
                                    <!-- <td scope="row">{{ leave.request_date }}</td> -->
                                    <td scope="row">{{ leave.start_date }}</td>
                                    <td scope="row">{{ leave.end_date }}</td>
                                    <td scope="row">{{ leave.duration }} Days</td>
                                    <td scope="row"><p v-html="leave.status"></p> </td>
                                    <td scope="row">
                                        <div class="btn-group">
                                            <Link :href="route('admin.leaves.show', leave.id)"
                                                class="btn btn-sm btn-outline-info"
                                            >
                                                <i class="bi bi-eye"></i>
                                            </Link>
                                            <button 
                                                class="btn btn-sm btn-outline-success"
                                                v-if="(filters.type == 2 && leaveSetting.s_approval == '1' && leave.s_approve == '0')"
                                                @click="approvalLeaveRequest(leave.id, '1', leave.h_approve, leave.m_approve)"
                                            >
                                                Approve
                                            </button>
                                            <button 
                                                class="btn btn-sm btn-outline-success"
                                                v-if="filters.type == 3 && leaveSetting.h_approval == '1' && leave.h_approve == '0'"
                                                @click="approvalLeaveRequest(leave.id, leave.s_approve, '1', leave.m_approve)"
                                            >
                                                Approve
                                            </button>
                                            <button 
                                                class="btn btn-sm btn-outline-success"
                                                v-if="filters.type == 4 && leaveSetting.m_approval == '1' && leave.m_approve == '0'"
                                                @click="approvalLeaveRequest(leave.id, leave.s_approve, leave.h_approve, '1')"
                                            >
                                                Approve
                                            </button>
                                            <button 
                                                class="btn btn-sm btn-outline-danger"
                                                v-if="filters.type == 2 && leaveSetting.s_approval == '1' && leave.s_approve == '0'"
                                                @click="approvalLeaveRequest(leave.id, '2', leave.h_approve, leave.m_approve)"
                                            >
                                                Reject
                                            </button>
                                            <button 
                                                class="btn btn-sm btn-outline-danger"
                                                v-if="filters.type == 3 && leaveSetting.h_approval == '1' && leave.h_approve == '0'"
                                                @click="approvalLeaveRequest(leave.id, leave.s_approve, '2', leave.m_approve)"
                                            >
                                                Reject
                                            </button>
                                            <button 
                                                class="btn btn-sm btn-outline-danger"
                                                v-if="filters.type == 4 && leaveSetting.m_approval == '1' && leave.m_approve == '0'"
                                                @click="approvalLeaveRequest(leave.id, leave.s_approve, leave.h_approve, '2')"
                                            >
                                                Reject
                                            </button>
                                            <button
                                                class="btn btn-sm btn-outline-danger"
                                                @click="destroy(leave.id)"
                                                v-if="(leave.user_id === $page.props.auth.user.id && leave.s_approve == '0' && leave.h_approve == '0')"
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
                                        <Pagination class="mt-6" :links="leaves.links" />
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    </AdminLayout>
</template>
