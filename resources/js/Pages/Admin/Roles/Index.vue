<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";

const form = useForm();
const props = defineProps({
    roles: {
        type: Object,
        default: () => ({}),
    },
    can: Array
});
function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("admin.roles.destroy", id));
    }
}
</script>
<template>
    <Head title="Roles Page" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Roles
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.roles.index')" :only="['roles']"> Roles </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('admin.roles.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> Add New Role
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">User Roles</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Roles</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(role, index) in roles.data"
                                :key="role.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row">{{ role.name }}</td>
                                <td scope="row">
                                    <div class="btn-group">
                                        <Link :href="route('admin.roles.edit', role.id)"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </Link>
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="destroy(role.id)"
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
                                    <Pagination class="mt-6" :links="roles.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
