<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";

const form = useForm();
const props = defineProps({
    adjustmentreasons: {
        type: Object,
        default: () => ({}),
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
    can: Array
});
let SuperAdmin = props.can.includes('SuperAdmin');

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("admin.adjustmentreasons.destroy", id));
    }
}
</script>
<template>
    <Head title="Adjustmentreason Page" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Adjustmentreason
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.adjustmentreasons.index')" :only="['adjustmentreasons']"> Adjustmentreason </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('admin.adjustmentreasons.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> New Adjustmentreason
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Adjustmentreason</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(adjustmentreason, index) in adjustmentreasons.data"
                                :key="adjustmentreason.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row">{{ adjustmentreason.title }}</td>
                                <td scope="row">
                                    <div class="btn-group">
                                        <Link :href="route('admin.adjustmentreasons.edit', adjustmentreason.id)"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </Link>
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="destroy(adjustmentreason.id)"
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
                                    <Pagination class="mt-6" :links="adjustmentreasons.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
