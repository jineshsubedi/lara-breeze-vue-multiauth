<script setup>
import SupervisorLayout from "@/Layouts/SupervisorLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";

const form = useForm();
const props = defineProps({
    offboardprocesses: {
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
        form.delete(route("supervisor.offboardprocesses.destroy", id));
    }
}
</script>
<template>
    <Head title="OffboardProcess Page" />

    <SupervisorLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                OffboardProcess
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('supervisor.offboardprocesses.index')" :only="['offboardprocesses']"> OffboardProcess </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('supervisor.offboardprocesses.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> New OffboardProcess
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">OffboardProcess</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Department</th>
                                <th scope="col">Title</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(offboardprocess, index) in offboardprocesses.data"
                                :key="offboardprocess.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row">{{ offboardprocess.department ? offboardprocess.department.title : '' }}</td>
                                <td scope="row">{{ offboardprocess.title }}</td>
                                <td scope="row">
                                    <div class="btn-group">
                                        <Link :href="route('supervisor.offboardprocesses.edit', offboardprocess.id)"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </Link>
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="destroy(offboardprocess.id)"
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
                                    <Pagination class="mt-6" :links="offboardprocesses.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </SupervisorLayout>
</template>
