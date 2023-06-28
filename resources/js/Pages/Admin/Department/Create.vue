<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import axios from "axios";
import { ref } from "vue";

const props = defineProps({
    branches : Object,
})

const form = useForm({
    branch_id: 0,
    title: null,
    department_head: 0,
    minimum_leave: null,
    maximum_leave: null,
});
let staffs = ref([]);
function getStaffs()
{
    axios.post(route('getStaffsByBranch'), 
        {
            branch: form.branch_id
        }
    )
    .then(res => {
        staffs.value = ref(res.data)
    }).catch(err => {
        console.log(err)
    })
}
</script>
<template>
    <Head title="Department Create" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Department Create
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.departments.index')"> Department </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.departments.create')"> Create </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">New Department</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.post(route('admin.departments.store'))
                                "
                            >
                            <div class="form-group row mb-3">
                                    <label
                                        for="branch_id"
                                        class="col-sm-2 col-form-label"
                                        >Branch</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.branch_id" id="branch_id" class="form-control" @change="getStaffs" required>
                                            <option v-for="(branch, index) in branches" :key="index" :value="branch.id">{{branch.name}}</option>
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
                                        for="minimum_leave"
                                        class="col-sm-2 col-form-label"
                                        >Minimum Leave</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="number"
                                            class="form-control"
                                            id="minimum_leave"
                                            placeholder="minimum_leave"
                                            v-model="form.minimum_leave"
                                            min="0"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.minimum_leave"
                                        >
                                            {{ form.errors.minimum_leave }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="maximum_leave"
                                        class="col-sm-2 col-form-label"
                                        >Maximum Leave</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="number"
                                            class="form-control"
                                            id="maximum_leave"
                                            placeholder="maximum_leave"
                                            v-model="form.maximum_leave"
                                            min="0"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.maximum_leave"
                                        >
                                            {{ form.errors.maximum_leave }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="department_head"
                                        class="col-sm-2 col-form-label"
                                        >Department Head</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.department_head" id="department_head" class="form-control">
                                            <option v-for="(staff, index) in staffs.value" :key="index" :value="staff.id">{{staff.name}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.department_head"
                                        >
                                            {{ form.errors.department_head }}
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
