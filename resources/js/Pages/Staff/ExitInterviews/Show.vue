<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    exitinterview: Object,
})

const form = useForm();

</script>
<template>
    <Head title="ExitInterview Information" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Exit Interview Information
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.exitinterviews.index')"> Exit Interview </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.exitinterviews.show', exitinterview.id)"> Information </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Exit Interview</h5>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Staff</th>
                                        <td>{{ exitinterview.user ? exitinterview.user.name : '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Received By</th>
                                        <td>{{ exitinterview.received ? exitinterview.received.name : '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Interview Date</th>
                                        <td>{{ exitinterview.interview_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tenure</th>
                                        <td>{{ exitinterview.service_tenure }}</td>
                                    </tr>
                                    <tr v-for="(des, din) in exitinterview.description" :key="din">
                                        <th>{{ des.question }}</th>
                                        <td>{{ des.answer }}</td>
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
