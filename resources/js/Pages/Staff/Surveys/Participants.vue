<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    survey : Object,
    participants : Object
})

const form = useForm();

</script>
<template>
    <Head title="Survey Participants" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Survey Participants
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.surveys.index')"> Survey </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.surveys.participants', survey.id)"> Participants </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">New Survey</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(part, pindex) in participants" :key="pindex">
                                        <td>{{++pindex}}</td>
                                        <td>{{part.user ? part.user.name : ''}}</td>
                                        <td>{{part.created_at}}</td>
                                        <td>
                                            <Link :href="route('staffs.surveys.participants_detail', [survey.id, part.user.id])"
                                                    class="btn btn-sm btn-outline-info">
                                                <i class="bi bi-eye"></i> VIEW 
                                            </Link>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </StaffLayout>
</template>
