<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    types: Object
})

const form = useForm({
    name: null,
    email: null,
    designation: null,
    rate: 0.0,
    charge_type: 1,
    docfile: null,
});

</script>
<template>
    <Head title="Trainer Create" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Trainer Create
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.trainers.index')"> Trainer </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.trainers.create')"> Create </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">New Trainer</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.post(route('staffs.trainers.store'))
                                "
                            >
                                <div class="form-group row mb-3">
                                    <label
                                        for="name"
                                        class="col-sm-2 col-form-label"
                                        >Name</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="name"
                                            placeholder="name"
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
                                        for="email"
                                        class="col-sm-2 col-form-label"
                                        >Email</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="email"
                                            class="form-control"
                                            id="email"
                                            placeholder="email"
                                            v-model="form.email"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.email"
                                        >
                                            {{ form.errors.email }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="designation"
                                        class="col-sm-2 col-form-label"
                                        >Designation</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="designation"
                                            placeholder="designation"
                                            v-model="form.designation"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.designation"
                                        >
                                            {{ form.errors.designation }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="rate"
                                        class="col-sm-2 col-form-label"
                                        >Rate</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="number"
                                            step="any"
                                            min="0.0"
                                            class="form-control"
                                            id="rate"
                                            placeholder="rate"
                                            v-model="form.rate"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.rate"
                                        >
                                            {{ form.errors.rate }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="charge_type"
                                        class="col-sm-2 col-form-label"
                                        >Charge Type</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.charge_type" class="form-control" id="charge_type">
                                            <option v-for="(type, tindex) in types" :key="tindex" :value="type.id">{{type.title}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.charge_type"
                                        >
                                            {{ form.errors.charge_type }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="docfile"
                                        class="col-sm-2 col-form-label"
                                        >CV</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="file"
                                            class="form-control"
                                            id="docfile"
                                            placeholder="docfile"
                                            @input="form.docfile = $event.target.files[0]"
                                            accept="application/pdf,application/doc,application/docx"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.docfile"
                                        >
                                            {{ form.errors.docfile }}
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
