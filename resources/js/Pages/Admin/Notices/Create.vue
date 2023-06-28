<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
})

const form = useForm({
    title: null,
    description: null,
    start_date: null,
    end_date: null,
});

</script>
<template>
    <Head title="Notice Create" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Notice Create
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
                    <Link :href="route('admin.notices.create')"> Create </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">New Notice</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.post(route('admin.notices.store'))
                                "
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
                                        for="start_date"
                                        class="col-sm-2 col-form-label"
                                        >Start Date</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="date"
                                            class="form-control"
                                            id="start_date"
                                            placeholder="start_date"
                                            v-model="form.start_date"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.start_date"
                                        >
                                            {{ form.errors.start_date }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="end_date"
                                        class="col-sm-2 col-form-label"
                                        >End Date</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="date"
                                            class="form-control"
                                            id="end_date"
                                            placeholder="end_date"
                                            v-model="form.end_date"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.end_date"
                                        >
                                            {{ form.errors.end_date }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="description"
                                        class="col-sm-2 col-form-label"
                                        >Description</label
                                    >
                                    <div class="col-sm-10">
                                        <QuillEditor v-model:content="form.description" id="description" class="form-control" contentType="html" theme="snow" />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.description"
                                        >
                                            {{ form.errors.description }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3 mt-5">
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
