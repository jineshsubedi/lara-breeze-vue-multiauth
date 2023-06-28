<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Inertia } from "@inertiajs/inertia";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    designation: {
        type: Object,
        default: () => ({}),
    },
    departments: Object,
    tor_file: String
});

const form = useForm({
    title: props.designation.title,
    department_id: props.designation.department_id,
    document: null,
});
function submitForm()
{
    Inertia.post(route('admin.designations.update', props.designation.id), {
        _method: 'put',
        title: form.title,
        department_id: form.department_id,
        document: form.document,
    })
}
</script>
<template>
    <Head title="Designation Edit" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Designation Edit
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
                    <Link :href="route('admin.designations.edit', designation.id)"> Edit </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Update Designation</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    submitForm
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
                                        <div class="mt-3" v-if="tor_file != ''">
                                            <a :href="tor_file">
                                                <img src="/images/pdf_icon.png" style="width:100px;">
                                            </a>
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
