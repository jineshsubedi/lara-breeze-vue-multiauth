<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    event: Object
})

const form = useForm();

</script>
<template>
    <Head title="Event Information" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Event Information
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.events.index')"> Event </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.events.show', event.id)"> Information </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ event.title }}</h5>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr v-if="event.banner != null">
                                        <th colspan="2">
                                            <img :src="event.banner_url" style="width:100%">
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Start Date</th>
                                        <td>{{ event.start_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>End Date</th>
                                        <td>{{ event.end_date }}</td>
                                    </tr>
                                    <tr v-if="event.document != null">
                                        <th>Document</th>
                                        <td><a :href="event.document_url" target="_blank">Click to Open</a> </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><p v-html="event.description"></p></td>
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
