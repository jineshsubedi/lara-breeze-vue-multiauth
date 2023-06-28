<script setup>
import SupervisorLayout from "@/Layouts/SupervisorLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    task : Object,
})

const form = useForm();

</script>
<template>
    <Head title="Help Desk Detail" />

    <SupervisorLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Help Desk Detail
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.helpdesks.index')"> Help Desk </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('supervisor.helpdesks.show', task.id)"> Detail </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Help Desk Detail Information</h5>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Title</th>
                                        <td>{{task.title}}</td>
                                    </tr>
                                    <tr>
                                        <th>Task From</th>
                                        <td>{{task.from_user ? task.from_user.name : ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Task To</th>
                                        <td>{{task.to_user ? task.to_user.name : ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>User KRA</th>
                                        <td>{{task.kra ? task.kra.title : ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Start From</th>
                                        <td>{{task.start_time}}</td>
                                    </tr>
                                    <tr>
                                        <th>Deadline Date</th>
                                        <td>{{task.finish_time}}</td>
                                    </tr>
                                    <tr>
                                        <th>Priority</th>
                                        <td>{{task.priority_label}}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td><span v-html="task.complete_status_label"></span></td>
                                    </tr>
                                    <tr>
                                        <th colspan="2">Description</th>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><p v-html="task.description"></p></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </SupervisorLayout>
</template>
