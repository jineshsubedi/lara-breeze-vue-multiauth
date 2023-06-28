<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    subordinate: Object
})

const form = useForm({
    rating: props.subordinate.rating,
    comment: props.subordinate.comment,
});

</script>
<template>
    <Head title="Subordinate Edit" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Subordinate Edit
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.subordinates.index')"> Subordinate </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.subordinates.edit', subordinate.id)"> Edit </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Edit Subordinate Note</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.put(route('admin.subordinates.update', subordinate.id))
                                "
                            >
                                <div class="form-group row mb-3">
                                    <label
                                        for="rating"
                                        class="col-sm-2 col-form-label"
                                        >Rating</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="number"
                                            min="1"
                                            max="10"
                                            class="form-control"
                                            id="rating"
                                            placeholder="rating"
                                            v-model="form.rating"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.rating"
                                        >
                                            {{ form.errors.rating }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="comment"
                                        class="col-sm-2 col-form-label"
                                        >Comment</label
                                    >
                                    <div class="col-sm-10">
                                        <textarea v-model="form.comment" class="form-control" id="comment" rows="3"></textarea>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.comment"
                                        >
                                            {{ form.errors.comment }}
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
