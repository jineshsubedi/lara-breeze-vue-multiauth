<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";

const form = useForm();
const props = defineProps({
    designations: {
        type: Object,
        default: () => ({}),
    },
    can: Array
});
function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("admin.designations.destroy", id));
    }
}
</script>
<template>
    <Head title="Designations Page" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Designations
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.designations.index')" :only="['designations']"> Designations </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('admin.designations.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> Add New Designation
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Designation</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Department</th>
                                <th scope="col">TOR</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(designation, index) in designations.data"
                                :key="designation.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row">{{ designation.title }}</td>
                                <td scope="row">{{ designation.department ? designation.department.title : '' }}</td>
                                <td scope="row">
                                    <a :href="designation.tor" v-if="designation.tor != ''">
                                        <img src="/images/pdf_icon.png" style="width: 50px">
                                    </a>
                                </td>
                                <td scope="row">
                                    <div class="btn-group">
                                        <Link :href="route('admin.designations.edit', designation.id)"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </Link>
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="destroy(designation.id)"
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
                                    <Pagination class="mt-6" :links="designations.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
