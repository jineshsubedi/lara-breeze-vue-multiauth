<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    outsource: Object,
    departments: Object
})

const form = useForm({
    number: '',
    department_id: '',
    from: '',
    to: '',
});

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("admin.outsources.purchase.destroy", [props.outsource.id, id]));
    }
}

function submitOrderForm()
{
    form.post(route("admin.outsources.purchase.store", props.outsource.id), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
}
</script>
<template>
    <Head title="Outsource Purchase Order" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Outsource Purchase Order
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.outsources.index')"> Outsource </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.outsources.show', outsource.id)"> Information </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.outsources.purchase.index', outsource.id)"> Purchase Orders </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{outsource.project_name}} - Purchase Order</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Purchase Order Number</th>
                                        <th>Department</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(purchase, pindex) in outsource.purchase" :key="pindex">
                                        <td>{{purchase.number}}</td>
                                        <td>{{purchase.department ? purchase.department.title : ''}}</td>
                                        <td>{{purchase.from}}</td>
                                        <td>{{purchase.to}}</td>
                                        <td>
                                            <button
                                                    class="btn btn-sm btn-outline-danger"
                                                    @click="destroy(purchase.id)"
                                                >
                                                    <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>
                                            <input type="text" v-model="form.number" class="form-control">
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.number"
                                            >
                                                {{ form.errors.number }}
                                            </div>
                                        </td>
                                        <td>
                                            <select v-model="form.department_id" class="form-control">
                                                <option v-for="(department, dindex) in departments" :key="dindex" :value="department.id">{{department.title}}</option>
                                            </select>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.department_id"
                                            >
                                                {{ form.errors.department_id }}
                                            </div>
                                        </td>
                                        <td>
                                            <input type="date" v-model="form.from" class="form-control">
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.from"
                                            >
                                                {{ form.errors.from }}
                                            </div>
                                        </td>
                                        <td>
                                            <input type="date" v-model="form.to" class="form-control">
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.to"
                                            >
                                                {{ form.errors.to }}
                                            </div>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-primary" @click="submitOrderForm()">Submit</button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
