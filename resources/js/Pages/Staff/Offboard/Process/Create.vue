<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    departments: Object
})

const form = useForm({
    department_id: null,
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
    <Head title="OffboardProcess Create" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                OffboardProcess Create
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.offboardprocesses.index')"> OffboardProcess </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.offboardprocesses.create')"> Create </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">New OffboardProcess</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.post(route('staffs.offboardprocesses.store'))
                                "
                            >
                                <div class="form-group row mb-3">
                                    <label
                                        for="department_id"
                                        class="col-sm-2 col-form-label"
                                        >Department</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.department_id" id="department_id" class="form-control">
                                            <option v-for="(department, dindex) in departments" :key="dindex" :value="department.id">{{department.title}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.department_id"
                                        >
                                            {{ form.errors.department_id }}
                                        </div>
                                    </div>
                                </div>
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
    </StaffLayout>
</template>
