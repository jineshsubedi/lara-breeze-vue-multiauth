<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";

const form = useForm();
const props = defineProps({
    branches: {
        type: Object,
        default: () => ({}),
    },
    provinces: {
        type: Object,
        default: () => ({}),
    },
    districts: {
        type: Object,
        default: () => ({}),
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
    can: Array
});
function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("admin.branches.destroy", id));
    }
}
let province = ref(props.filters.province);
let district = ref(props.filters.district);


function loadFilter()
{
    Inertia.get(
        route('admin.branches.index'),
        { province: province.value, district: district.value },
        {
            preserveState: true,
            replace: true,
        }
    );
}

</script>
<template>
    <Head title="Branches Page" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Branches
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.branches.index')" :only="['branches']"> Branches </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right" v-if="$page.props.can.includes('SuperAdmin')">
                <Link :href="route('admin.branches.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> Add New Branch
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Branches</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Province</th>
                                <th scope="col">District</th>
                                <th scope="col">Action</th>
                            </tr>
                            <tr v-if="$page.props.can.includes('SuperAdmin')">
                                <td></td>
                                <td></td>
                                <td>
                                    <select v-model="province" class="form-control" @change="loadFilter">
                                        <option value="">Select Province</option>
                                        <option v-for="(province, index) in provinces" :key="index" :value="province.id">{{province.title}}</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="district" class="form-control" @change="loadFilter">
                                        <option value="">Select District</option>
                                        <option v-for="(district, index) in districts" :key="index" :value="district.id">{{district.title}}</option>
                                    </select>
                                </td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(branch, index) in branches.data"
                                :key="index"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row">{{ branch.name }}</td>
                                <td scope="row">{{ branch.province.title ? branch.province.title : '' }}</td>
                                <td scope="row">{{ branch.district.title ? branch.district.title : '' }}</td>
                                <td scope="row">
                                    <div class="btn-group">
                                        <Link :href="route('admin.branch.getSetting', branch.id)"
                                            class="btn btn-sm btn-outline-info" v-if="can.includes('SuperAdmin')">
                                            <i class="bi bi-gear-wide"></i>
                                        </Link>
                                        <Link :href="route('admin.branches.edit', branch.id)"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </Link>
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="destroy(branch.id)"
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
                                    <Pagination class="mt-6" :links="branches.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
