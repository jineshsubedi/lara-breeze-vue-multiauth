<script setup>
import SupervisorLayout from "@/Layouts/SupervisorLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const form = useForm();
const props = defineProps({
    trainer: {
        type: Object,
        default: () => ({}),
    },
    can: Array
});

</script>
<template>
    <Head title="Trainer InfoPage" />

    <SupervisorLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Trainer Info
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('supervisor.trainers.show', trainer.id)" :only="['trainers']"> Trainer InfoPage </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('supervisor.trainers.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> New Trainer
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Trainer InfoPage</h5>
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th>Name</th><td>{{trainer.name}}</td>
                            </tr>
                            <tr>
                                <th>Email</th><td>{{trainer.email}}</td>
                            </tr>
                            <tr>
                                <th>Designation</th><td>{{trainer.designation}}</td>
                            </tr>
                            <tr>
                                <th>Rate/Rate Type</th><td>{{trainer.rate}} {{trainer.charge_type == 1 ? 'Per Training' : 'Per Hour'}}</td>
                            </tr>
                            <tr>
                                <th>CV</th><td><a :href="trainer.cv" class="btn btn-sm btn-outline-primary" target="_blank">View CV</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </SupervisorLayout>
</template>
