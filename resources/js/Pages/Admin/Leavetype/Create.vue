<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    branches: Object,
    datas: Object
})
const form = useForm({
    branch_id: 0,
    leave_type: [{'title' : '', 'days': '0', 'apply_before': '0', 'eligible': '0', 'continuous': '0', 'accrual': '0', 'accrual_basis': '0', 'is_extra' : ''}],
});
function addLeaveType()
{
    form.leave_type.push({'title' : '', 'days': '0', 'apply_before': '0', 'eligible': '0', 'continuous': '0', 'accrual': '0', 'accrual_basis': '0', 'is_extra' : ''});
}
function removeLeaveType(index)
{
    form.leave_type.splice(index, 1)
}
</script>
<template>
    <Head title="Leave Type Create" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Leave Type Create
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.leave_types.index')"> Leave Type </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.leave_types.create')"> Create </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">New Leave Type</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.post(route('admin.leave_types.store'))
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
                                            <th>Days</th>
                                            <th>Apply Before (days)</th>
                                            <th>Eligible (Months)</th>
                                            <th>Continious (days)</th>
                                            <th>Accrual</th>
                                            <th>Accrual Basis</th>
                                            <th>Extra</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(st, index) in form.leave_type" :key="index">
                                            <td>
                                                <input type="text" v-model="form.leave_type[index].title" class="form-control" placeholder="Type title" required>
                                            </td>
                                            <td>
                                                <input type="number" min="0" v-model="form.leave_type[index].days" class="form-control" placeholder="Number of days" required>
                                            </td>
                                            <td>
                                                <input type="number" min="0" v-model="form.leave_type[index].apply_before" class="form-control" placeholder="Apply Before" required>
                                            </td>
                                            <td>
                                                <input type="number" min="0" v-model="form.leave_type[index].eligible" class="form-control" placeholder="Eligible month" required>
                                            </td>
                                            <td>
                                                <input type="number" min="0" v-model="form.leave_type[index].continuous" class="form-control" placeholder="continious" required>
                                            </td>
                                            <td>
                                                <input type="number" min="0" v-model="form.leave_type[index].accrual" class="form-control" placeholder="accrual" required>
                                            </td>
                                            <td>
                                                <select v-model="form.leave_type[index].accrual_basis" id="accrual_basis" class="form-control" required>
                                                    <option v-for="(accrual, index) in datas.accrual" :key="index" :value="accrual.value">{{accrual.title}}</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select v-model="form.leave_type[index].is_extra" id="is_extra" class="form-control">
                                                    <option value="">Default</option>
                                                    <option v-for="(extra, index) in datas.extra" :key="index" :value="extra.value">{{extra.title}}</option>
                                                </select>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-danger" @click="removeLeaveType(index)"><i class="bi bi-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="7" class="text-right">
                                                <button type="button" class="btn btn-sm btn-outline-primary" @click="addLeaveType"><i class="bi bi-plus"></i>  Add More</button>
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
