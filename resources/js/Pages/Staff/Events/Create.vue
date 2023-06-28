<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    branches: Object,
    defBranch: Number,
    can: Object,
})
let SuperAdmin = props.can.includes('SuperAdmin');

const form = useForm({
    title: null,
    start_date: null,
    end_date: null,
    description: null,
    bannerFile: null,
    docFile: null,
    branch: []
});
form.branch.push(props.defBranch);
</script>
<template>
    <Head title="Event Create" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Event Create
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.events.index')"> Event </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.events.create')"> Create </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">New Event</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.post(route('staffs.events.store'))
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
                                        for="start_date"
                                        class="col-sm-2 col-form-label"
                                        >Start Date</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="datetime-local"
                                            class="form-control"
                                            id="start_date"
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
                                            type="datetime-local"
                                            class="form-control"
                                            id="end_date"
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
                                        for="docFile"
                                        class="col-sm-2 col-form-label"
                                        >Attachment</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="file"
                                            class="form-control"
                                            id="docFile"
                                            @input="form.docFile = $event.target.files[0]"
                                            accept=".doc,.pdf,.docx,.xlsx,.xls,.csv'"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.docFile"
                                        >
                                            {{ form.errors.docFile }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="bannerFile"
                                        class="col-sm-2 col-form-label"
                                        >Banner</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="file"
                                            class="form-control"
                                            id="bannerFile"
                                            @input="form.bannerFile = $event.target.files[0]"
                                            accept="image/*"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.bannerFile"
                                        >
                                            {{ form.errors.bannerFile }}
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
                                <div class="form-group row mt-5 mb-3" v-if="SuperAdmin">
                                    <label
                                        for="branch"
                                        class="col-sm-2 col-form-label"
                                        >Branch Options</label
                                    >
                                    <div class="col-sm-10">
                                        <span v-for="(branch, bin) in branches" :key="bin">
                                            <input type="checkbox" v-model="form.branch" :value="branch.id"> {{ branch.name }}  &nbsp;&nbsp;
                                        </span>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.branch"
                                        >
                                            {{ form.errors.branch }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mt-5 mb-3">
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
    </StaffLayout>
</template>
