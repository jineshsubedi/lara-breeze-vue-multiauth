<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    department: {
        type: Object,
        default: () => ({}),
    },
    staffs: Object
});

const form = useForm({
    title: props.department.title,
    department_head: props.department.department_head,
    minimum_leave: props.department.minimum_leave,
    maximum_leave: props.department.maximum_leave,
});

</script>
<template>
    <Head title="Department Edit" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Department Edit
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
                    <Link :href="route('admin.departments.edit', department.id)"> Edit </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Update Department</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.put(route('admin.departments.update', department.id))
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
                                        >department_head</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.department_head" id="department_head" class="form-control">
                                            <option v-for="(staff, index) in staffs" :key="index" :value="staff.id">{{staff.name}}</option>
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
