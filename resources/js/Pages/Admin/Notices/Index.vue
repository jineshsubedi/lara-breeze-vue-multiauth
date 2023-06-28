<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";

const form = useForm();
const props = defineProps({
    notices: {
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
        form.delete(route("admin.notices.destroy", id));
    }
}
</script>
<template>
    <Head title="Notice Page" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Notice
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.notices.index')" :only="['notices']"> Notice </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('admin.notices.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> New Notice
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Notice</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">End Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(notice, index) in notices.data"
                                :key="notice.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row">{{ notice.title }}</td>
                                <td scope="row">{{ notice.start_date }}</td>
                                <td scope="row">{{ notice.end_date }}</td>
                                <td scope="row">
                                    <div class="btn-group">
                                        <Link :href="route('admin.notices.show', notice.id)"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </Link>
                                        <Link :href="route('admin.notices.edit', notice.id)"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </Link>
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="destroy(notice.id)"
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
                                    <Pagination class="mt-6" :links="notices.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
