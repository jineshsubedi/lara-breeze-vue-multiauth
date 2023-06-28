<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import { ref, watch } from "vue";
import { Inertia } from "@inertiajs/inertia";
import throttle from "lodash/throttle";

const form = useForm();
const props = defineProps({
    jobs: {
        type: Object,
        default: () => ({}),
    },
    branches: Object,
    processes: Object,
    statusss: Object,
    filters: {
        type: Object,
        default: () => ({}),
    },
    can: Array
});
let SuperAdmin = props.can.includes('SuperAdmin');

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("admin.jobs.destroy", id));
    }
}

let title = ref(props.filters.title);
let code = ref(props.filters.code);
let branch = ref(props.filters.branch);
let status = ref(props.filters.status);
let process = ref(props.filters.process);

watch(title, throttle(function (value){
    Inertia.get(
        route('admin.jobs.index'),
        { title: title.value, code: code.value, branch: branch.value, status: status.value, process: process.value },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    );
}, 500
));
watch(code, throttle(function (value){
    Inertia.get(
        route('admin.jobs.index'),
        { title: title.value, code: code.value, branch: branch.value, status: status.value, process: process.value },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    );
}, 500
));
function loadFilter()
{
    Inertia.get(
        route('admin.jobs.index'),
        { title: title.value, code: code.value, branch: branch.value, status: status.value, process: process.value },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    );
}
</script>
<template>
    <Head title="Jobs Page" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Jobs
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.jobs.index')" :only="['jobs']"> Jobs </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('admin.jobs.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> New Jobs
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Jobs</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col" v-if="SuperAdmin">Branch</th>
                                <th>Vacancy Code</th>
                                <th>Application Source</th>
                                <th>Status</th>
                                <th>Process Status</th>
                                <th scope="col">Action</th>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <input
                                        type="text"
                                        v-model="title"
                                        placeholder="Search Job By Title"
                                        class="form-control"
                                    />
                                </td>
                                <td v-if="SuperAdmin">
                                    <select v-model="branch" class="form-control" @change="loadFilter">
                                        <option v-for="(branch, bindex) in branches" :key="bindex" :value="branch.id">{{branch.name}}</option>
                                    </select>
                                </td>
                                <td>
                                    <input
                                        type="text"
                                        v-model="code"
                                        placeholder="Search Vacancy Code"
                                        class="form-control"
                                    />
                                </td>
                                <td></td>
                                <td>
                                    <select v-model="status" class="form-control" @change="loadFilter">
                                        <option v-for="(sta, stindex) in statusss" :key="stindex" :value="sta.value">{{sta.title}}</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="process" class="form-control" @change="loadFilter">
                                        <option v-for="(process, prindex) in processes" :key="prindex" :value="process.id">{{process.title}}</option>
                                    </select>
                                </td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(jobs, index) in jobs.data"
                                :key="jobs.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row">{{ jobs.title }}</td>
                                <td scope="row" v-if="SuperAdmin">{{ jobs.branch ? jobs.branch.name : '' }}</td>
                                <td scope="row">{{ jobs.vacancy_code }}</td>
                                <td scope="row">{{ jobs.setting }}</td>
                                <td scope="row">{{ jobs.status_label }}</td>
                                <td scope="row">{{ jobs.process ? jobs.process.title : '' }}</td>
                                <td scope="row">
                                    <button
                                        class="btn btn-sm btn-outline-secondary"
                                    >
                                        <a
                                            class="nav-link d-flex align-items-center pe-0"
                                            href="#"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                        >
                                            <span
                                                class="d-none d-md-block dropdown-toggle ps-2"
                                                >Actions</span
                                            > </a
                                        ><!-- End Profile Iamge Icon -->

                                        <ul
                                            class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile"
                                            style=""
                                        >
                                            <li>
                                                <Link
                                                    :href="
                                                        route(
                                                            'admin.jobs.show',
                                                            jobs.id
                                                        )
                                                    "
                                                    class="dropdown-item d-flex align-items-center"
                                                >
                                                    <i class="bi bi-eye"></i>
                                                    VIEW
                                                </Link>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider" />
                                            </li>

                                            <li>
                                                <Link
                                                    :href="
                                                        route(
                                                            'admin.jobs.edit',
                                                            jobs.id
                                                        )
                                                    "
                                                    class="dropdown-item d-flex align-items-center"
                                                >
                                                    <i
                                                        class="bi bi-pencil-square"
                                                    ></i>
                                                    EDIT
                                                </Link>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider" />
                                            </li>
                                            <li>
                                                <Link
                                                    :href="
                                                        route(
                                                            'admin.jobs.applicants.index',
                                                            jobs.id
                                                        )
                                                    "
                                                    class="dropdown-item d-flex align-items-center"
                                                >
                                                    <i
                                                        class="bi bi-person-lines-fill"
                                                    ></i>
                                                    APPLICATIONS &nbsp;
                                                    <span
                                                        class="badge bg-danger"
                                                        >{{
                                                            jobs.applications_count
                                                        }}
                                                        </span
                                                    >
                                                </Link>
                                            </li>
                                            <li>
                                                <button
                                                    class="dropdown-item d-flex align-items-center"
                                                    @click="
                                                        destroy(training.id)
                                                    "
                                                >
                                                    <i class="bi bi-trash"></i>
                                                    DELETE
                                                </button>
                                            </li>
                                        </ul>
                                        <!-- End Profile Dropdown Items -->
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="8">
                                    <Pagination class="mt-6" :links="jobs.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
