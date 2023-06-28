<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    departments : Object,
})

const form = useForm({
    title: null,
    department_id: null,
    document: null
});

</script>
<template>
    <Head title="Designation Create" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Designation Create
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.designations.index')"> Designation </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.designations.create')"> Create </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">New Designation</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.post(route('admin.designations.store'))
                                "
                                enctype="multipart/form-data"
                            >
                                <div class="form-group row mb-3">
                                    <label
                                        for="title"
                                        class="col-sm-2 col-form-label"
                                        >Title</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="title"
                                            placeholder="Title"
                                            v-model="form.title"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.title"
                                        >
                                            {{ form.errors.title }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="department_id"
                                        class="col-sm-2 col-form-label"
                                        >Department</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.department_id" id="department_id" class="form-control">
                                            <option v-for="(department, index) in departments" :key="index" :value="department.id">{{department.title}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.department_id"
                                        >
                                            {{ form.errors.department_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="tor"
                                        class="col-sm-2 col-form-label"
                                        >TOR</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="file"
                                            class="form-control"
                                            id="tor"
                                            placeholder="tor"
                                            @input="form.document = $event.target.files[0]"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.document"
                                        >
                                            {{ form.errors.document }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button
                                            type="submit"
                                            class="btn btn-outline-primary btn-sm"
                                        >
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
