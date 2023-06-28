<script setup>
import SupervisorLayout from "@/Layouts/SupervisorLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
})

const form = useForm({
    category: [{'title' : ''}],
});
function addCategory()
{
    form.category.push({'title' : ''});
}
function removeCategory(index)
{
    form.category.splice(index, 1)
}

</script>
<template>
    <Head title="AssignmentCategory Create" />

    <SupervisorLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                AssignmentCategory Create
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.assignmentcategories.index')"> AssignmentCategory </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('supervisor.assignmentcategories.create')"> Create </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">New AssignmentCategory</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.post(route('supervisor.assignmentcategories.store'))
                                "
                            >
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(st, index) in form.category" :key="index">
                                            <td>
                                                <input type="text" v-model="form.category[index].title" class="form-control" placeholder="Category title" required>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-danger" @click="removeCategory(index)"><i class="bi bi-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>
                                                <div colspan="3" class="text-danger" v-for="(form) in form.errors">
                                                    {{form}}
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <button type="button" class="btn btn-sm btn-outline-primary" @click="addCategory"><i class="bi bi-plus"></i>  Add More</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
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
