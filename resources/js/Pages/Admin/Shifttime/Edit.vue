<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    shiftTime: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({
    title: props.shiftTime.title,
    start_time: props.shiftTime.start_time,
    end_time: props.shiftTime.end_time
});

</script>
<template>
    <Head title="Shift Time Edit" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Shift Time Edit
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.shift_times.index')"> Shift Time </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.shift_times.edit', shiftTime.id)"> Edit </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Update Shift Times</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.put(route('admin.shift_times.update', shiftTime.id))
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
                                            placeholder="Role Title"
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
                                        for="start_time"
                                        class="col-sm-2 col-form-label"
                                        >Start Time</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="time"
                                            class="form-control"
                                            id="start_time"
                                            placeholder="Start Time"
                                            v-model="form.start_time"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.start_time"
                                        >
                                            {{ form.errors.start_time }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="end_time"
                                        class="col-sm-2 col-form-label"
                                        >End Time</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="time"
                                            class="form-control"
                                            id="end_time"
                                            placeholder="End Time"
                                            v-model="form.end_time"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.end_time"
                                        >
                                            {{ form.errors.end_time }}
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
