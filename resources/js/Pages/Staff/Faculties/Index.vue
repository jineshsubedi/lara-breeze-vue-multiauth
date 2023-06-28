<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import { ref, watch } from "vue";
import { Inertia } from "@inertiajs/inertia";
import throttle from "lodash/throttle";

const form = useForm();
const props = defineProps({
    faculties: {
        type: Object,
        default: () => ({}),
    },
    educations: Object,
    filters: {
        type: Object,
        default: () => ({}),
    },
    can: Array
});
let SuperAdmin = props.can.includes('SuperAdmin');
let education = ref(props.filters.education)
let title = ref(props.filters.title)

function loadFilter()
{
    Inertia.get(
        route('staffs.faculties.index'),
        { education: education.value, title: title.value},
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    );
}
watch(title, throttle(function (value){
    Inertia.get(
        route('staffs.faculties.index'),
        { education: education.value, title: title.value },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    );
}, 500
));

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("staffs.faculties.destroy", id));
    }
}
</script>
<template>
    <Head title="Faculty Page" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Faculty
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.faculties.index')" :only="['faculties']"> Faculty </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('staffs.faculties.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> New Faculty
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Faculty</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Education</th>
                                <th scope="col">Title</th>
                                <th scope="col">Action</th>
                            </tr>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">
                                    <select v-model="education" class="form-control" @change="loadFilter">
                                        <option value="">Select Education</option>
                                        <option v-for="(p, pindex) in educations" :key="pindex" :value="p.id">{{p.title}}</option>
                                    </select>
                                </th>
                                <th scope="col">
                                    <input type="text" v-model="title" class="form-control">
                                </th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(faculty, index) in faculties.data"
                                :key="faculty.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row">{{ faculty.education ? faculty.education.title : '' }}</td>
                                <td scope="row">{{ faculty.title }}</td>
                                <td scope="row">
                                    <div class="btn-group">
                                        <Link :href="route('staffs.faculties.edit', faculty.id)"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </Link>
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="destroy(faculty.id)"
                                            v-if="SuperAdmin"
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
                                    <Pagination class="mt-6" :links="faculties.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </StaffLayout>
</template>
