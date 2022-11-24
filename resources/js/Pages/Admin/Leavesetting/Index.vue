<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";

const form = useForm();
const props = defineProps({
    leavesettings: {
        type: Object,
        default: () => ({}),
    },
    branches: Object,
    filters: {
        type: Object,
        default: () => ({}),
    },
    can: Array
});
let SuperAdmin = props.can.includes('SuperAdmin');
let branch = ref(props.filters.branch_id);

function loadFilter()
{
    Inertia.get(
        route('admin.leave_setting.index'),
        { branch: branch.value },
        {
            preserveState: true,
            replace: true,
        }
    );
}

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("admin.leave_setting.destroy", id));
    }
}
</script>
<template>
    <Head title="Leave Setting Page" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Leave Setting
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.leave_setting.index')" :only="['leavesettings']"> Leave Setting </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('admin.leave_setting.create')" class="btn btn-sm btn-outline-info" v-if="SuperAdmin">
                    <i class="bi bi-plus"></i> New Leave Setting
                </Link>
            </div>
            <div class="card">
                <div class="card-body table-responsive">
                    <h5 class="card-title">Leave Setting</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col" v-if="SuperAdmin">Branch</th>
                                <th scope="col">Quarter Day</th>
                                <th scope="col">Half Day</th>
                                <th scope="col">Sandwich</th>
                                <th scope="col">Handover</th>
                                <th scope="col">Supervisor Approval</th>
                                <th scope="col">HR Approval</th>
                                <th scope="col">Manager Approval</th>
                                <th scope="col">Accural Basis</th>
                                <th scope="col">Hr Person</th>
                                <th scope="col">Manager</th>
                                <th scope="col">Leave Handler</th>
                                <th scope="col">Maximum Leave</th>
                                <th scope="col">Action</th>
                            </tr>
                            <tr v-if="SuperAdmin">
                                <th></th>
                                <th>
                                    <select v-model="branch" class="form-control" @change="loadFilter">
                                        <option value="">Select Branch</option>
                                        <option v-for="(branch, bindex) in branches" :key="bindex" :value="branch.id">{{branch.name}}</option>
                                    </select>
                                </th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(leave, index) in leavesettings.data"
                                :key="leave.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row" v-if="SuperAdmin">{{ leave.branch.name }}</td>
                                <td>{{ leave.quarter_day == 1 ? "Allow" : "Not Allow" }}</td>
                                <td>{{ leave.half_day == 1 ? "Allow" : "Not Allow" }}</td>
                                <td>{{ leave.sandwich == 1 ? "Allow" : "Not Allow" }}</td>
                                <td>{{ leave.handover == 1 ? "Required" : "Not Required" }}</td>
                                <td>{{ leave.s_approval == 1 ? "Required" : "Not Required" }}</td>
                                <td>{{ leave.h_approval == 1 ? "Required" : "Not Required" }}</td>
                                <td>{{ leave.m_approval == 1 ? "Required" : "Not Required"}}</td>
                                <td>{{ leave.accrual_basis == 1 ? "Yes" : "No"}}</td>
                                <td>{{ leave.hr ? leave.hr.name : "" }}</td>
                                <td>{{ leave.manager ? leave.manager.name : "" }}</td>
                                <td>{{ leave.handler ? leave.handler.name : "" }}</td>
                                <td>{{ leave.maximum_leave }}</td>
                                <td scope="row">
                                    <div class="btn-group">
                                        <Link :href="route('admin.leave_setting.edit', leave.id)"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </Link>
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="destroy(leave.id)"
                                            v-if="SuperAdmin"
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
                                    <Pagination class="mt-6" :links="leavesettings.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
