<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import { ref, watch } from "vue";
import { Inertia } from "@inertiajs/inertia";
import throttle from "lodash/throttle";

const form = useForm();
const props = defineProps({
    departments: {
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
let title = ref(props.filters.title);

function loadFilter()
{
    Inertia.get(
        route('admin.departments.index'),
        { branch: branch.value, title: title.value },
        {
            preserveState: true,
            replace: true,
        }
    );
}
watch(title, throttle(function (value){
    Inertia.get(
        route('admin.departments.index'),
        { branch: branch.value, title: title.value },
        {
            preserveState: true,
            replace: true,
        }
    );
}, 500
));
function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("admin.departments.destroy", id));
    }
}
</script>
<template>
    <Head title="Departments Page" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Departments
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.departments.index')" :only="['departments']"> Departments </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('admin.departments.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> Add New Role
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">User Department</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col" v-if="SuperAdmin">Branch</th>
                                <th scope="col">Title</th>
                                <th scope="col">Head</th>
                                <th scope="col">Minimum Leave</th>
                                <th scope="col">Maximum Leave</th>
                                <th scope="col">Action</th>
                            </tr>
                            <tr>
                                <td></td>
                                <td v-if="SuperAdmin">
                                    <select v-model="branch" class="form-control" @change="loadFilter" >
                                        <option value="">Select Branch</option>
                                        <option v-for="(branch, bindex) in branches" :key="bindex" :value="branch.id">{{branch.name}}</option>
                                    </select>
                                </td>
                                <td>
                                    <input
                                        type="text"
                                        v-model="title"
                                        placeholder="Search Department By Title"
                                        class="form-control"
                                    />
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(department, index) in departments.data"
                                :key="department.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row">{{ department.branch ? department.branch.name : '' }}</td>
                                <td scope="row">{{ department.title }}</td>
                                <td scope="row">{{ department.user ? department.user.name : '' }}</td>
                                <td scope="row">{{ department.minimum_leave }}</td>
                                <td scope="row">{{ department.maximum_leave }}</td>
                                <td scope="row">
                                    <div class="btn-group">
                                        <Link :href="route('admin.departments.edit', department.id)"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </Link>
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="destroy(department.id)"
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
                                    <Pagination class="mt-6" :links="departments.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
