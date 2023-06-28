<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    role: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({
    name: props.role.name
});

</script>
<template>
    <Head title="Role Edit" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Role Edit
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.roles.index')"> Role </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.roles.edit', role.id)"> Edit </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Update Role</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.put(route('admin.roles.update', role.id))
                                "
                            >
                                <div class="form-group row mb-3">
                                    <label
                                        for="inputName"
                                        class="col-sm-2 col-form-label"
                                        >Title/Name</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="inputName"
                                            placeholder="Role Title"
                                            v-model="form.name"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.name"
                                        >
                                            {{ form.errors.name }}
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
