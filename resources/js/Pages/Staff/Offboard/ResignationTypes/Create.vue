<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
})

const form = useForm({
    category: [{'title' : '', 'description': ''}],
});
function addCategory()
{
    form.category.push({'title' : '', 'description': ''});
}
function removeCategory(index)
{
    form.category.splice(index, 1)
}

</script>
<template>
    <Head title="ResignationType Create" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ResignationType Create
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.resignationtypes.index')"> ResignationType </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.resignationtypes.create')"> Create </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">New ResignationType</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.post(route('staffs.resignationtypes.store'))
                                "
                            >
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(st, index) in form.category" :key="index">
                                            <td>
                                                <input type="text" v-model="form.category[index].title" class="form-control" placeholder="Category title" required>
                                            </td>
                                            <td>
                                                <textarea rows="3" v-model="form.category[index].description" class="form-control" required></textarea>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-danger" @click="removeCategory(index)"><i class="bi bi-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2">
                                                <div  class="text-danger" v-for="(form) in form.errors">
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
