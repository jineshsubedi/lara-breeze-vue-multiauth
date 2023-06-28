<script setup>
import SupervisorLayout from "@/Layouts/SupervisorLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";

const form = useForm();
const props = defineProps({
    trainingcosts: {
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
        form.delete(route("supervisor.trainingcosts.destroy", id));
    }
}
</script>
<template>
    <Head title="TrainingCost Page" />

    <SupervisorLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                TrainingCost
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('supervisor.trainingcosts.index')" :only="['trainingcosts']"> TrainingCost </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('supervisor.trainingcosts.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> New TrainingCost
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">TrainingCost</h5>
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
                                v-for="(trainingcost, index) in trainingcosts.data"
                                :key="trainingcost.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row">{{ trainingcost.title }}</td>
                                <td scope="row">
                                    <div class="btn-group">
                                        <Link :href="route('supervisor.trainingcosts.edit', trainingcost.id)"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </Link>
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="destroy(trainingcost.id)"
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
                                    <Pagination class="mt-6" :links="trainingcosts.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </SupervisorLayout>
</template>
