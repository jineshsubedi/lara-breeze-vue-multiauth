<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    notice: Object,
})

</script>
<template>
    <Head title="Notice Information" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Notice Information
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.notices.index')"> Notice </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.notices.show', notice.id)"> Information </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Notice Information</h5>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Title</th>
                                        <td>{{notice.title}}</td>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <td>{{notice.start_date}} - {{notice.end_date}}</td>
                                    </tr>
                                    <tr>
                                        <th colspan="2">Description</th>
                                        
                                    </tr>
                                    <tr>
                                        <td colspan="2"><p v-html="notice.description"></p></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
