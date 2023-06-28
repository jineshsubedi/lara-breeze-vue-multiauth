<script setup>
import SupervisorLayout from "@/Layouts/SupervisorLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    categories : Object,
    options : Object,
})

const form = useForm({
    description: null,
    hide_name: 0,
    suggestion_for_id: null,
});

</script>
<template>
    <Head title="Suggestion Create" />

    <SupervisorLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Suggestion Create
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.suggestions.index')"> Suggestion </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('supervisor.suggestions.create')"> Create </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">New Suggestion</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.post(route('supervisor.suggestions.store'))
                                "
                            >
                                <div class="form-group row mb-3">
                                    <label
                                        for="suggestion_for_id"
                                        class="col-sm-2 col-form-label"
                                        >Cateogy</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.suggestion_for_id" id="suggestion_for_id" class="form-control">
                                            <option v-for="(category, index) in categories" :key="index" :value="category.id">{{category.title}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.suggestion_for_id"
                                        >
                                            {{ form.errors.suggestion_for_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="hide_name"
                                        class="col-sm-2 col-form-label"
                                        >Hide Name</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.hide_name" id="hide_name" class="form-control" required>
                                            <option v-for="(option, index) in options" :key="index" :value="option.value">{{option.title}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.hide_name"
                                        >
                                            {{ form.errors.hide_name }}
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
                                        <textarea v-model="form.description" id="description" class="form-control" rows="3"></textarea>
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
    </SupervisorLayout>
</template>
