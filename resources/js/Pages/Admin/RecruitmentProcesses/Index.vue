<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";

const form = useForm();
const props = defineProps({
    recruitmentprocesses: {
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
        form.delete(route("admin.recruitmentprocesses.destroy", id));
    }
}
</script>
<template>
    <Head title="RecruitmentProcess Page" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                RecruitmentProcess
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.recruitmentprocesses.index')" :only="['recruitmentprocesses']"> RecruitmentProcess </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('admin.recruitmentprocesses.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> New RecruitmentProcess
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">RecruitmentProcess</h5>
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
                                v-for="(recruitmentprocess, index) in recruitmentprocesses.data"
                                :key="recruitmentprocess.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row">{{ recruitmentprocess.title }}</td>
                                <td scope="row">
                                    <div class="btn-group">
                                        <Link :href="route('admin.recruitmentprocesses.edit', recruitmentprocess.id)"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </Link>
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="destroy(recruitmentprocess.id)"
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
                                    <Pagination class="mt-6" :links="recruitmentprocesses.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
