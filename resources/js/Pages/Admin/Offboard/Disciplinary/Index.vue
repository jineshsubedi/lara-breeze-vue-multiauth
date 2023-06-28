<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";

const form = useForm();
const props = defineProps({
    disciplinaryactions: {
        type: Object,
        default: () => ({}),
    },
    can: Array
});
let SuperAdmin = props.can.includes('SuperAdmin');

</script>
<template>
    <Head title="Disciplinary Page" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Disciplinary
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.disciplinary.index')" :only="['disciplinaryactions']"> Disciplinary </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Disciplinary</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Staff</th>
                                <th scope="col">Disciplinary Ground</th>
                                <th scope="col">Issued By</th>
                                <th scope="col">Issued Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(disciplinaryaction, index) in disciplinaryactions.data"
                                :key="disciplinaryaction.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row">{{ disciplinaryaction.user ? disciplinaryaction.user.name : '' }}</td>
                                <td scope="row">{{ disciplinaryaction.grounds ? disciplinaryaction.grounds.title : '' }}</td>
                                <td scope="row">{{ disciplinaryaction.isseudby ? disciplinaryaction.isseudby.name : '' }}</td>
                                <td scope="row">{{ disciplinaryaction.issued_date }}</td>
                                <td scope="row">
                                    <span v-html="disciplinaryaction.status" v-if="disciplinaryaction.termination === 0"></span>
                                            <span v-else-if="disciplinaryaction.termination === 1" class="badge bg-danger">Terminated</span>
                                            <span v-else class="badge bg-success">Hold</span>
                                </td>
                                <td scope="row">
                                    <div class="btn btn-group">
                                        <Link :href="route('admin.disciplinary.show', disciplinaryaction.id)"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </Link>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="8">
                                    <Pagination class="mt-6" :links="disciplinaryactions.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
