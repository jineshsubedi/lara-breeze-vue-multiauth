<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    faculty: Object,
    educations: Object,
})

const form = useForm({
    education_id: props.faculty.education_id,
    title: props.faculty.title,
});

</script>
<template>
    <Head title="Faculty Create" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Faculty Create
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.faculties.index')"> Faculty </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.faculties.edit', faculty.id)"> Edit </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Edit Faculty</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.put(route('staffs.faculties.update', faculty.id))
                                "
                            >
                            <div class="form-group row mb-3">
                                    <label
                                        for="Place"
                                        class="col-sm-2 col-form-label"
                                        >Education</label
                                    >
                                    <div class="col-sm-10">
                                        <select
                                            v-model="form.education_id"
                                            class="form-control"
                                        >
                                            <option
                                                v-for="(
                                                    p, pindex
                                                ) in educations"
                                                :key="pindex"
                                                :value="p.id"
                                            >
                                                {{ p.title }}
                                            </option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.education_id"
                                        >
                                            {{ form.errors.education_id }}
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
    </StaffLayout>
</template>
