<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import { ref, watch } from "vue";
import { Inertia } from "@inertiajs/inertia";
import throttle from "lodash/throttle";

const form = useForm();
const props = defineProps({
    surveys: {
        type: Object,
        default: () => ({}),
    },
    branches: Object,
    filters: {
        type: Object,
        default: () => ({}),
    },
    can: Array,
});
let SuperAdmin = props.can.includes("SuperAdmin");

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("admin.surveys.destroy", id));
    }
}

let branch = ref(props.filters.branch);
let title = ref(props.filters.title);
let from = ref(props.filters.from);
let to = ref(props.filters.to);
function loadFilter() {
    Inertia.get(
        route("admin.surveys.index"),
        {
            branch: branch.value,
            title: title.value,
            from: from.value,
            to: to.value,
        },
        {
            preserveState: true,
            replace: true,
        }
    );
}
watch(
    title,
    throttle(function (value) {
        Inertia.get(
            route("admin.surveys.index"),
            {
                branch: branch.value,
                title: title.value,
                from: from.value,
                to: to.value,
            },
            {
                preserveState: true,
                replace: true,
            }
        );
    }, 500)
);
</script>
<template>
    <Head title="Survey Page" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Survey
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link
                        :href="route('admin.surveys.index')"
                        :only="['surveys', 'filters']"
                    >
                        Survey
                    </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link
                    :href="route('admin.surveys.create')"
                    class="btn btn-sm btn-outline-info"
                >
                    <i class="bi bi-plus"></i> New Survey
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Survey</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col" v-if="SuperAdmin">Branch</th>
                                <th scope="col">Title</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">End Date</th>
                                <th scope="col">Publish</th>
                                <th scope="col">Action</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th v-if="SuperAdmin">
                                    <select
                                        v-model="branch"
                                        class="form-control"
                                        @change="loadFilter"
                                    >
                                        <option value="">Select Branch</option>
                                        <option
                                            v-for="(branch, bindex) in branches"
                                            :key="bindex"
                                            :value="branch.id"
                                        >
                                            {{ branch.name }}
                                        </option>
                                    </select>
                                </th>
                                <th>
                                    <input
                                        type="text"
                                        v-model="title"
                                        placeholder="Search Survey By Title"
                                        class="form-control"
                                    />
                                </th>
                                <th>
                                    <input
                                        type="date"
                                        v-model="from"
                                        class="form-control"
                                        @change="loadFilter"
                                    />
                                </th>
                                <th>
                                    <input
                                        type="date"
                                        v-model="to"
                                        class="form-control"
                                        @change="loadFilter"
                                    />
                                </th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(survey, index) in surveys.data"
                                :key="survey.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row">
                                    {{
                                        survey.branch ? survey.branch.name : ""
                                    }}
                                </td>
                                <td scope="row">{{ survey.title }}</td>
                                <td scope="row">{{ survey.start_date }}</td>
                                <td scope="row">{{ survey.end_date }}</td>
                                <td scope="row">
                                    {{
                                        survey.status == 1
                                            ? "Published"
                                            : "UnPublished"
                                    }}
                                </td>
                                <td scope="row">
                                    <button class="btn btn-sm btn-outline-secondary">
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
                                                <Link :href="route('admin.surveys.show', survey.id)"
                                                    class="dropdown-item d-flex align-items-center">
                                                    <i class="bi bi-eye"></i> VIEW
                                                </Link>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider" />
                                            </li>

                                            <li>
                                                <Link :href="route('admin.surveys.edit', survey.id)"
                                                    class="dropdown-item d-flex align-items-center">
                                                    <i class="bi bi-pencil-square"></i> EDIT
                                                </Link>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider" />
                                            </li>
                                            <li>
                                                <Link :href="route('admin.surveys.getQuestion', survey.id)"
                                                    class="dropdown-item d-flex align-items-center">
                                                    <i class="bi bi-question-octagon"></i> QUESTIONS &nbsp; <span class="badge bg-danger">{{survey.question_count}}</span>
                                                </Link>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider" />
                                            </li>
                                            <li>
                                                <Link :href="route('admin.surveys.participants', survey.id)"
                                                    class="dropdown-item d-flex align-items-center">
                                                    <i class="bi bi-person-lines-fill"></i> PARTICIPANTS &nbsp; <span class="badge bg-danger">{{survey.answer.length}}</span>
                                                </Link>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider" />
                                            </li>

                                            <li>
                                                <button
                                                    class="dropdown-item d-flex align-items-center"
                                                    @click="destroy(survey.id)"
                                                >
                                                    <i class="bi bi-trash"></i> DELETE
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
                                    <Pagination
                                        class="mt-6"
                                        :links="surveys.links"
                                    />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
