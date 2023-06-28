<script setup>
import SupervisorLayout from "@/Layouts/SupervisorLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    outsource: Object,
    types: Object
})

const form = useForm({
    type: '',
    title: '',
    attachment: '',
});

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("supervisor.outsources.documents.destroy", [props.outsource.id, id]));
    }
}

function submitDocumentForm()
{
    form.post(route("supervisor.outsources.documents.store", props.outsource.id), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
}
</script>
<template>
    <Head title="Outsource Documents" />

    <SupervisorLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Outsource Documents
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.outsources.index')"> Outsource </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.outsources.show', outsource.id)"> Information </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('supervisor.outsources.documents.index', outsource.id)"> Documents </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{outsource.project_name}} - Documents</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th>Document</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(document, dindex) in outsource.documents" :key="dindex">
                                        <td>{{document.title}}</td>
                                        <td>{{document.type_title}}</td>
                                        <td><a :href="document.attachment" v-if="document.file_name != ''" target="_blank" class="btn btn-sm btn-outline-success">Download</a></td>
                                        <td>
                                            <button
                                                    class="btn btn-sm btn-outline-danger"
                                                    @click="destroy(document.id)"
                                                >
                                                    <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>
                                            <input type="text" v-model="form.title" class="form-control">
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.title"
                                            >
                                                {{ form.errors.title }}
                                            </div>
                                        </td>
                                        <td>
                                            <select v-model="form.type" class="form-control">
                                                <option v-for="(type, tindex) in types" :key="tindex" :value="type.id">{{type.title}}</option>
                                            </select>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.type"
                                            >
                                                {{ form.errors.type }}
                                            </div>
                                        </td>
                                        <td>
                                            <input type="file" @input="form.attachment = $event.target.files[0]" class="form-control" accept="application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document, image/jpg, image/png">
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.attachment"
                                            >
                                                {{ form.errors.attachment }}
                                            </div>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-primary" @click="submitDocumentForm()">Submit</button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </SupervisorLayout>
</template>
