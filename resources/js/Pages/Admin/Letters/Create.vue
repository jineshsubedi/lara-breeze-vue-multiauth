<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import axios from "axios";
import { ref } from "vue";

const props = defineProps({
    defBranch: Number,
    branches: Object,
    types: Object,
    templates: Object
})

const form = useForm({
    branch_id: props.defBranch,
    letter_type_id: null,
    department_id: null,
    description: null,
    handler: null,
    signatureFile: null,

    template: null,
});
let departments = ref([]);
let staffs = ref([]);
loadDepartmentByBranch()

function loadDepartmentByBranch()
{
    axios.post(route('getDepartmentByBranch'), 
        {
            branch: form.branch_id
        }
    )
    .then(res => {
        departments.value = res.data
    }).catch(err => {
        console.log(err)
    })
}
function getStaffByDepartment()
{
    axios.post(route('getStaffByDepartment'), 
        {
            department: form.department_id
        }
    )
    .then(res => {
        staffs.value = res.data
    }).catch(err => {
        console.log(err)
    })
}
let quill = ref(null)
function selectTemplate(event)
{
    title.value = form.template
    var options = event.target.options
    if (options.selectedIndex > -1) {
        form.description = options[options.selectedIndex].getAttribute('description');
        quill.value.setHTML(form.description)
    }
}
</script>
<template>
    <Head title="Letter Create" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Letter Create
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.letters.index')"> Letter </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.letters.create')"> Create </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">New Letter</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.post(route('admin.letters.store'))
                                "
                                enctype="multipart/form-data"
                            >
                                <div class="form-group row mb-3">
                                    <label
                                        for="branch_id"
                                        class="col-sm-2 col-form-label"
                                        >Branch</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.branch_id" class="form-control" id="branch_id" @change="loadDepartmentByBranch()">
                                            <option v-for="(branch, bindex) in branches" :key="bindex" :value="branch.id">{{branch.name}}</option>
                                        </select>
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
                                        for="department_id"
                                        class="col-sm-2 col-form-label"
                                        >Department</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.department_id" class="form-control" id="department_id" @change="getStaffByDepartment">
                                            <option v-for="(department, dindex) in departments" :key="dindex" :value="department.id">{{department.title}}</option>
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
                                        for="letter_type_id"
                                        class="col-sm-2 col-form-label"
                                        >Letter Type</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.letter_type_id" class="form-control" id="letter_type_id" >
                                            <option v-for="(type, tindex) in types" :key="tindex" :value="type.id" >{{type.title}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.letter_type_id"
                                        >
                                            {{ form.errors.letter_type_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="letter_type_id"
                                        class="col-sm-2 col-form-label"
                                        >Letter Template</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.template"  class="form-control" id="letter_type_id" @change="selectTemplate($event)">
                                            <option v-for="(template, temindex) in templates" :key="temindex" :value="template.title" :description="template.description">{{template.title}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label
                                        for="descirption"
                                        class="col-sm-2 col-form-label"
                                        >Description</label
                                    >
                                    <div class="col-sm-10">
                                        <span id="editorInit">
                                            <QuillEditor v-model:content="form.description" id="description" class="form-control" contentType="html" theme="snow" toolbar="full" ref="quill"/>
                                        </span>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.descirption"
                                        >
                                            {{ form.errors.descirption }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3 mt-10">
                                    <label
                                        for="handler"
                                        class="col-sm-2 col-form-label"
                                        >Handler</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.handler" class="form-control" id="handler">
                                            <option v-for="(staff, dindex) in staffs" :key="dindex" :value="staff.id">{{staff.name}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.handler"
                                        >
                                            {{ form.errors.handler }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="handler"
                                        class="col-sm-2 col-form-label"
                                        >Signature/Stapmp</label
                                    >
                                    <div class="col-sm-10">
                                        <input type="file" @input="form.signatureFile = $event.target.files[0]" class="form-control">
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.handler"
                                        >
                                            {{ form.errors.handler }}
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
<style scoped>
.mt-10{margin-top: 80px;}
</style>