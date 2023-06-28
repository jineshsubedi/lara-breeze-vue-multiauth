<script setup>
import SupervisorLayout from "@/Layouts/SupervisorLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";

const form = useForm();
const props = defineProps({
    terminationstaffs: {
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
        form.delete(route("supervisor.terminatestaffs.destroy", id));
    }
}
</script>
<template>
    <Head title="Termination Staffs Page" />

    <SupervisorLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Termination Staffs
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('supervisor.terminatestaffs.index')" :only="['terminationstaffs']"> Termination Staffs </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('supervisor.terminatestaffs.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> New TerminationType
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Terminate Staff</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Staff</th>
                                <th scope="col">Type</th>
                                <th scope="col">Termination End Date</th>
                                <th scope="col">Offboarding Date</th>
                                <th scope="col">Approval</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(terminatestaff, index) in terminationstaffs.data"
                                :key="terminatestaff.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row">{{ terminatestaff.user ? terminatestaff.user.name : '' }}</td>
                                <td scope="row">{{ terminatestaff.type ? terminatestaff.type.title : '' }}</td>
                                <td scope="row">{{ terminatestaff.end_date}}</td>
                                <td scope="row">{{ terminatestaff.offBoarding_date}}</td>
                                <td scope="row">{{ terminatestaff.status}}</td>
                                <td scope="row">
                                    <div class="btn-group">
                                        <Link :href="route('supervisor.terminatestaffs.show', terminatestaff.id)"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </Link>
                                        <Link :href="route('supervisor.terminatestaffs.edit', terminatestaff.id)"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </Link>
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="destroy(terminatestaff.id)"
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
                                    <Pagination class="mt-6" :links="terminationstaffs.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </SupervisorLayout>
</template>
