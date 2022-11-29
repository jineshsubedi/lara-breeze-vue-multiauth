<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    staffs : Object,
})

const form = useForm({
    branch_id: props.defBranch,
    leave_type_id: 0,
    type: null,
    start_date: null,
    end_date: null,
    contact_no: null,
    description: null,
});

</script>
<template>
    <Head title="Leave Request" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Leave Request
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.leaves.index')"> Leave </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.leaves.create')"> Request </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">New Request</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.post(route('admin.leaves.store'))
                                "
                            >
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
                                            min="0"
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
                                            min="0"
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
                                        <textarea v-model="form.description" class="form-control" id="description" rows="3"></textarea>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.description"
                                        >
                                            {{ form.errors.description }}
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
