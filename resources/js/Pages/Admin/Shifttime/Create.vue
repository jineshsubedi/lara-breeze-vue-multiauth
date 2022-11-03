<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    branches: Object
})
const form = useForm({
    branch_id: 0,
    shift_time: [{'title' : '', 'start_time': '', 'end_time': ''}],
});
function addShiftTime()
{
    form.shift_time.push({'title' : '', 'start_time' : '', 'end_time' : ''});
}
function removeShftTime(index)
{
    form.shift_time.splice(index, 1)
}
</script>
<template>
    <Head title="Shift Time Create" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Shift Time Create
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
                    <Link :href="route('admin.shift_times.create')"> Create </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">New Shift Time</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.post(route('admin.shift_times.store'))
                                "
                            >
                                <div class="form-group row mb-3">
                                    <label
                                        for="branch_id"
                                        class="col-sm-2 col-form-label"
                                        >Branch</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.branch_id" id="branch_id" class="form-control" required>
                                            <option v-for="(branch, index) in branches" :key="index" :value="branch.id">{{branch.name}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.branch_id"
                                        >
                                            {{ form.errors.branch_id }}
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Title</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(st, index) in form.shift_time" :key="index">
                                            <td>
                                                <input type="text" v-model="form.shift_time[index].title" class="form-control" placeholder="Shift title" required>
                                            </td>
                                            <td>
                                                <input type="time" v-model="form.shift_time[index].start_time" class="form-control" placeholder="Shift Start Time" required>
                                            </td>
                                            <td>
                                                <input type="time" v-model="form.shift_time[index].end_time" class="form-control" placeholder="Shift End Time" required>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-danger" @click="removeShftTime(index)"><i class="bi bi-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" class="text-right">
                                                <button type="button" class="btn btn-sm btn-outline-primary" @click="addShiftTime"><i class="bi bi-plus"></i>  Add More</button>
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
    </AdminLayout>
</template>
