<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";

const form = useForm();
const props = defineProps({
    ltypes: {
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
        route('admin.leave_types.index'),
        { branch: branch.value },
        {
            preserveState: true,
            replace: true,
        }
    );
}

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("admin.leave_types.destroy", id));
    }
}
</script>
<template>
    <Head title="Leave Type Page" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Leave Type
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.leave_types.index')" :only="['ltypes']"> Leave Type </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('admin.leave_types.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> New Leave Type
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Leave Type</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col" v-if="SuperAdmin">Branch</th>
                                <th scope="col">Title</th>
                                <th scope="col">Days</th>
                                <th scope="col">Apply Before (Days)</th>
                                <th scope="col">Eligible (Month)</th>
                                <th scope="col">Continious (Days)</th>
                                <th scope="col">Accrual Number</th>
                                <th scope="col">Accrual Basis</th>
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
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(type, index) in ltypes.data"
                                :key="type.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row" v-if="SuperAdmin">{{ type.branch.name }}</td>
                                <td scope="row">{{ type.title }}</td>
                                <td scope="row">{{ type.days }}</td>
                                <td scope="row">{{ type.apply_before }}</td>
                                <td scope="row">{{ type.eligible }}</td>
                                <td scope="row">{{ type.continuous }}</td>
                                <td scope="row">{{ type.accrual }}</td>
                                <td scope="row">{{ type.accrual_basis == '1' ? 'Yes' : 'No' }}</td>
                                <td scope="row">
                                    <div class="btn-group">
                                        <Link :href="route('admin.leave_types.edit', type.id)"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </Link>
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="destroy(type.id)"
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
                                    <Pagination class="mt-6" :links="ltypes.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
