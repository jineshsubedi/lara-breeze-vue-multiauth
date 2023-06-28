<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";

const form = useForm();
const props = defineProps({
    exitinterviews: {
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
        form.delete(route("staffs.exitinterviews.destroy", id));
    }
}
</script>
<template>
    <Head title="ExitInterview Page" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ExitInterview
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.exitinterviews.index')" :only="['exitinterviews']"> ExitInterview </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('staffs.exitinterviews.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> New ExitInterview
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">ExitInterview</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col" v-if="SuperAdmin">Branch</th>
                                <th scope="col">Name</th>
                                <th scope="col">Received By</th>
                                <th scope="col">Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(exitinterview, index) in exitinterviews.data"
                                :key="exitinterview.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row" v-if="SuperAdmin">{{ exitinterview.branch ? exitinterview.branch.name : '' }}</td>
                                <td scope="row">{{ exitinterview.user ? exitinterview.user.name : '' }}</td>
                                <td scope="row">{{ exitinterview.received ? exitinterview.received.name : '' }}</td>
                                <td scope="row">{{ exitinterview.interview_date }}</td>
                                <td scope="row">
                                    <div class="btn-group">
                                        <Link :href="route('staffs.exitinterviews.show', exitinterview.id)"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </Link>
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="destroy(exitinterview.id)"
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
                                    <Pagination class="mt-6" :links="exitinterviews.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </StaffLayout>
</template>
