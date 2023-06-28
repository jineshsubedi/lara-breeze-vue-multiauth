<script setup>
import SupervisorLayout from "@/Layouts/SupervisorLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";

const form = useForm({
    user_id: null
});
const props = defineProps({
    participants: {
        type: Object,
        default: () => ({}),
    },
    training: Object,
    can: Array
});
let SuperAdmin = props.can.includes('SuperAdmin');
let TrainingHandler = props.can.includes('TrainingHandler');

function  updateParticipant(id, training_id, user, status) {
    if (confirm("Are you sure?")) {
        Inertia.post(
            route('supervisor.trainings.actionParticipants', training_id),
            { user_id: user, status: status, id: id },
            {
                preserveState: true,
                preserveScroll: true,
                replace: true,
            }
        );
    }
}

</script>
<template>
    <Head title="Training Participant Page" />

    <SupervisorLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Training Participant
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.trainings.index')" :only="['trainings']"> Training </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('supervisor.trainings.participants', training.id)" :only="['participants']"> Training Participant </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Training Participant</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Description</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(training, index) in participants.data"
                                :key="training.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row">{{ training.user ? training.user.name : '' }}</td>
                                <td scope="row"><span v-html="training.status_label"></span></td>
                                <td scope="row">{{ training.description }}</td>
                                <td scope="row">
                                    <div class="btn-group" v-if="training.status == 0">
                                        <button
                                            class="btn btn-sm btn-outline-success"
                                            @click="updateParticipant(training.id, training.training_id, training.user_id, 1)"
                                        >
                                            <i class="bi bi-check"></i>
                                        </button>
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="updateParticipant(training.id, training.training_id, training.user_id, 2)"
                                        >
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="8">
                                    <Pagination class="mt-6" :links="participants.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </SupervisorLayout>
</template>
