<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";

const form = useForm();
const props = defineProps({
    shifts: {
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
        route('admin.shift_times.index'),
        { branch: branch.value },
        {
            preserveState: true,
            replace: true,
        }
    );
}

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("admin.shift_times.destroy", id));
    }
}
</script>
<template>
    <Head title="Shift Time Page" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Shift Time
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.shift_times.index')" :only="['shifts']"> Shift Time </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('admin.shift_times.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> New Shift Time
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Shift Time</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col" v-if="SuperAdmin">Branch</th>
                                <th scope="col">Title</th>
                                <th scope="col">Start Time</th>
                                <th scope="col">End Time</th>
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
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(shift, index) in shifts.data"
                                :key="shift.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row" v-if="SuperAdmin">{{ shift.branch.name }}</td>
                                <td scope="row">{{ shift.title }}</td>
                                <td scope="row">{{ shift.start_time }}</td>
                                <td scope="row">{{ shift.end_time }}</td>
                                <td scope="row">
                                    <div class="btn-group">
                                        <Link :href="route('admin.shift_times.edit', shift.id)"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </Link>
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="destroy(shift.id)"
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
                                    <Pagination class="mt-6" :links="shifts.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
