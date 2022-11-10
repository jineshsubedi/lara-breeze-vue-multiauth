<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
    branches: Object,
    departments: Object,
    document: Object,
})

const form = useForm({
    title: props.document.title,
    description: props.document.description,
    docfile: null,
    branch_id: props.document.branch_id,
    department_id: props.document.department_id,
});
function submitForm()
{
    Inertia.post(route('admin.documents.update', props.document.id), {
        _method: 'put',
        title: form.title,
        description: form.description,
        department_id: form.department_id,
        branch_id: form.branch_id,
        docfile: form.docfile,
    })
}
</script>
<template>
    <Head title="Document Edit" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Document Edit
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.documents.index')"> Document </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.documents.edit', document.id)"> Edit </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Edit Document</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    submitForm
                                "
                                enctype="multipart/form-data"
                            >
                                <div class="form-group row mb-3">
                                    <label
                                        for="inputTitle"
                                        class="col-sm-2 col-form-label"
                                        >Title</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="inputTitle"
                                            placeholder="Document Title"
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
                                        for="description"
                                        class="col-sm-2 col-form-label"
                                        >Description</label
                                    >
                                    <div class="col-sm-10">
                                        <textarea v-model="form.description" id="description" class="form-control" rows="5"></textarea>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.description"
                                        >
                                            {{ form.errors.description }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="document"
                                        class="col-sm-2 col-form-label"
                                        >Document/File</label
                                    >
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" id="document" @input="form.docfile = $event.target.files[0]" accept="application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.docfile"
                                        >
                                            {{ form.errors.docfile }}
                                        </div>
                                        <a :href="document.document" v-if="document.document != ''">
                                            <img src="/images/pdf_icon.png" style="width: 50px">
                                        </a>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="document"
                                        class="col-sm-2 col-form-label"
                                        >Branch Access</label
                                    >
                                    <div class="col-sm-10">
                                        <div>
                                            <span v-for="(branch, index) in branches" :key="index">
                                                <input type="checkbox" v-model="form.branch_id" :value="branch.id"> {{branch.name}} &nbsp; &nbsp;
                                            </span>
                                        </div>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.branch_id"
                                        >
                                            {{ form.errors.branch_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="document"
                                        class="col-sm-2 col-form-label"
                                        >Department Access</label
                                    >
                                    <div class="col-sm-10">
                                        <div>
                                            <span v-for="(department, index) in departments" :key="index">
                                                <input type="checkbox" v-model="form.department_id" :value="department.id"> {{department.title}} &nbsp; &nbsp;
                                            </span>
                                        </div>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.department_id"
                                        >
                                            {{ form.errors.department_id }}
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
