<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    subordinate: Object
})

</script>
<template>
    <Head title="Subordinate Note Information" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Subordinate Note Information
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.subordinates.index')"> Subordinate </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.subordinates.show', subordinate.id)"> Information </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Subordinate Note Information</h5>
                            <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th>Comment From</th>
                                    <td>{{subordinate.user ? subordinate.user.name  : ''}}</td>
                                </tr>
                                <tr>
                                    <th>Comment To</th>
                                    <td>{{subordinate.supervisor ? subordinate.supervisor.name  : ''}}</td>
                                </tr>
                                <tr>
                                    <th>Rating</th>
                                    <td>{{subordinate.rating}}</td>
                                </tr>
                                <tr>
                                    <th>Comment</th>
                                    <td>{{subordinate.comment}}</td>
                                </tr>
                                <tr>
                                    <th>Comment Date</th>
                                    <td>{{subordinate.created_at}}</td>
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
