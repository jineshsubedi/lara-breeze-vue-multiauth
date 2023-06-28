<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";

const form = useForm();
const props = defineProps({
    revenues: {
        type: Object,
        default: () => ({}),
    },
    divisions: Object,
    branches: Object,
    filters: {
        type: Object,
        default: () => ({}),
    },
    can: Array
});
let SuperAdmin = props.can.includes('SuperAdmin');
let RevenueHandler = props.can.includes('RevenueHandler');

let division = ref(props.filters.division)
let branch = ref(props.filters.branch)
function loadFilter()
{
    Inertia.get(
        route('admin.revenues.index'),
        { branch: branch.value, division: division.value },
        {
            preserveState: true,
            replace: true,
        }
    );
}

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("admin.revenues.destroy", id));
    }
}
</script>
<template>
    <Head title="Revenue Page" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Revenue
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.revenues.index')" :only="['revenues']"> Revenue </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right" v-if="RevenueHandler">
                <Link :href="route('admin.revenues.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> New Revenue
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Revenue</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col" v-if="SuperAdmin">Branch</th>
                                <th scope="col">Division</th>
                                <th scope="col">Revenue</th>
                                <th scope="col">Direct Expense</th>
                                <th scope="col">Indirect Expense</th>
                                <th scope="col">Net Profit</th>
                                <th scope="col">Update Date</th>
                                <th scope="col">Action</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th v-if="SuperAdmin">
                                    <select v-model="branch" class="form-control" @change="loadFilter" >
                                        <option value="">Select Branch</option>
                                        <option v-for="(branch, bindex) in branches" :key="bindex" :value="branch.id">{{branch.name}}</option>
                                    </select>
                                </th>
                                <th>
                                    <select v-model="division" class="form-control" @change="loadFilter" >
                                        <option value="">Select Division</option>
                                        <option v-for="(division, dindex) in divisions" :key="dindex" :value="division.id">{{division.title}}</option>
                                    </select>
                                </th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(revenue, index) in revenues.data"
                                :key="revenue.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row" v-if="SuperAdmin">{{ revenue.branch ? revenue.branch.name : '' }}</td>
                                <td scope="row">{{ revenue.division ? revenue.division.title : '' }}</td>
                                <td scope="row">{{ revenue.revenue }}</td>
                                <td scope="row">{{ revenue.direct_expenses }}</td>
                                <td scope="row">{{ revenue.indirect_expenses }}</td>
                                <td scope="row">{{ revenue.net_profit }}</td>
                                <td scope="row">{{ revenue.add_date }}</td>
                                <td scope="row">
                                    <div class="btn-group">
                                        <Link :href="route('admin.revenues.edit', revenue.id)"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </Link>
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="destroy(revenue.id)"
                                            v-if="RevenueHandler || SuperAdmin"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="8">
                                    <Pagination class="mt-6" :links="revenues.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
