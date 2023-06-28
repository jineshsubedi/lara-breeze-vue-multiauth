<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import axios from "axios";
import { ref } from "vue";

const props = defineProps({
    letter: Object,
    types: Object,
    branches: Object,
})

const form = useForm({
    branch_id: props.letter.branch_id,
    letter_type_id: props.letter.letter_type_id,
    department_id: props.letter.department_id,
    description: props.letter.description,
    handler: props.letter.handler,
    signatureFile: null,
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
        getStaffByDepartment()
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
function submitForm()
{
    Inertia.post(route('admin.letters.update', props.letter.id), {
        _method: 'put',
        branch_id: form.branch_id,
        letter_type_id: form.letter_type_id,
        department_id: form.department_id,
        description: form.description,
        handler: form.handler,
        signatureFile: form.signatureFile,
    })
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
                    <Link :href="route('admin.letters.edit', letter.id)"> Edit </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Edit Letter</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    submitForm()
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
                                        for="descirption"
                                        class="col-sm-2 col-form-label"
                                        >Description</label
                                    >
                                    <div class="col-sm-10">
                                        <QuillEditor v-model:content="form.description" id="description" class="form-control" contentType="html" theme="snow" />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.descirption"
                                        >
                                            {{ form.errors.descirption }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3 mt-5">
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
                                        <div v-if="letter.signature_path != ''">
                                            <img :src="letter.signature_path" style="width: 80px;">
                                        </div>
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
