<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";

const form = useForm();
const props = defineProps({
    letters: {
        type: Object,
        default: () => ({}),
    },
    branches: Object,
    types: Object,
    departments: Object,
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
        form.delete(route("admin.letters.destroy", id));
    }
}
let branch = ref(props.filters.branch);
let type = ref(props.filters.type);
let department = ref(props.filters.department);
function loadFilter()
{
    Inertia.get(
        route('admin.letters.index'),
        { branch: branch.value, type: type.value, department: department.value },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    );
}

</script>
<template>
    <Head title="Letter Page" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Letter
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.letters.index')" :only="['letters']"> Letter </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('admin.letters.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> New Letter
                </Link>
                <Link :href="route('admin.letters.generate')" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-gear"></i> Generate Staff Letter
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Letter</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col" v-if="SuperAdmin">Branch</th>
                                <th scope="col">Letter Type</th>
                                <th scope="col">Department</th>
                                <th scope="col">Handler</th>
                                <th scope="col">Action</th>
                            </tr>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col" v-if="SuperAdmin">
                                    <select v-model="branch" class="form-control" @change="loadFilter" >
                                        <option value="">Select Branch</option>
                                        <option v-for="(branch, bindex) in branches" :key="bindex" :value="branch.id">{{branch.name}}</option>
                                    </select>
                                </th>
                                <th scope="col">
                                    <select v-model="type" class="form-control" @change="loadFilter" >
                                        <option value="">Select Letter Type</option>
                                        <option v-for="(type, tindex) in types" :key="tindex" :value="type.id">{{type.title}}</option>
                                    </select>
                                </th>
                                <th scope="col">
                                    <select v-model="department" class="form-control" @change="loadFilter" >
                                        <option value="">Select Department</option>
                                        <option v-for="(department, dindex) in departments" :key="dindex" :value="department.id">{{department.title}}</option>
                                    </select>
                                </th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(letter, index) in letters.data"
                                :key="letter.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row">{{ letter.branch ? letter.branch.name : '' }}</td>
                                <td scope="row">{{ letter.type ? letter.type.title : '' }}</td>
                                <td scope="row">{{ letter.department ? letter.department.title : '' }}</td>
                                <td scope="row">{{ letter.handler ? letter.handler.name : '' }}</td>
                                <td scope="row">
                                    <div class="btn-group">
                                        <Link :href="route('admin.letters.edit', letter.id)"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </Link>
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="destroy(letter.id)"
                                            v-if="SuperAdmin || HrHandler"
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
                                    <Pagination class="mt-6" :links="letters.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
