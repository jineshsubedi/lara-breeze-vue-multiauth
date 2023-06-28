<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    joblevel: Object
})

const form = useForm({
    name: props.joblevel.name,
    order: props.joblevel.order,
});

</script>
<template>
    <Head title="JobLevel Edit" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                JobLevel Edit
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.joblevels.index')"> JobLevel </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.joblevels.edit', joblevel.id)"> Edit </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Edit JobLevel</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.put(route('admin.joblevels.update', joblevel.id))
                                "
                            >
                                <div class="form-group row mb-3">
                                    <label
                                        for="name"
                                        class="col-sm-2 col-form-label"
                                        >Title</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="title"
                                            placeholder="Title"
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
                                    <label
                                        for="order"
                                        class="col-sm-2 col-form-label"
                                        >Order</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="title"
                                            placeholder="Title"
                                            v-model="form.order"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.order"
                                        >
                                            {{ form.errors.order }}
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
