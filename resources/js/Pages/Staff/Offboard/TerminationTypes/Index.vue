<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";

const form = useForm();
const props = defineProps({
    terminationtypes: {
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
        form.delete(route("staffs.terminationtypes.destroy", id));
    }
}
</script>
<template>
    <Head title="TerminationType Page" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                TerminationType
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.terminationtypes.index')" :only="['terminationtypes']"> TerminationType </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('staffs.terminationtypes.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> New TerminationType
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">TerminationType</h5>
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
                                v-for="(terminationtype, index) in terminationtypes.data"
                                :key="terminationtype.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row">{{ terminationtype.title }}</td>
                                <td scope="row">
                                    <div class="btn-group">
                                        <Link :href="route('staffs.terminationtypes.edit', terminationtype.id)"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </Link>
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="destroy(terminationtype.id)"
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
                                    <Pagination class="mt-6" :links="terminationtypes.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </StaffLayout>
</template>
