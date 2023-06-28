<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";

const form = useForm();
const props = defineProps({
    trainings: {
        type: Object,
        default: () => ({}),
    },
    datas: Object,
    filters: {
        type: Object,
        default: () => ({}),
    },
    can: Array,
});
let SuperAdmin = props.can.includes("SuperAdmin");

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("admin.trainings.destroy", id));
    }
}

let branch = ref(props.filters.branch);
let program = ref(props.filters.program);
let trainer = ref(props.filters.trainer);
let status = ref(props.filters.status);
let from = ref(props.filters.from);
let to = ref(props.filters.to);
function loadFilter() {
    Inertia.get(
        route("admin.trainings.index"),
        {
            program: program.value,
            trainer: trainer.value,
            status: status.value,
            from: from.value,
            to: to.value,
            branch: branch.value,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    );
}
</script>
<template>
    <Head title="Training Page" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Training
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link
                        :href="route('admin.trainings.index')"
                        :only="['trainings']"
                    >
                        Training
                    </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link
                    :href="route('admin.trainings.create')"
                    class="btn btn-sm btn-outline-info"
                >
                    <i class="bi bi-plus"></i> New Training
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Training</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col" v-if="SuperAdmin">Branch</th>
                                <th scope="col">Program</th>
                                <th scope="col">Trainer</th>
                                <th scope="col">From</th>
                                <th scope="col">To</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col" v-if="SuperAdmin">
                                    <select
                                        class="form-control"
                                        v-model="branch"
                                    >
                                        <option
                                            v-for="(
                                                branch, pindex
                                            ) in datas.branchs"
                                            :key="pindex"
                                            :value="branch.id"
                                        >
                                            {{ branch.name }}
                                        </option>
                                    </select>
                                </th>
                                <th scope="col">
                                    <select
                                        class="form-control"
                                        v-model="program"
                                    >
                                        <option
                                            v-for="(
                                                program, pindex
                                            ) in datas.programs"
                                            :key="pindex"
                                            :value="program.id"
                                        >
                                            {{ program.title }}
                                        </option>
                                    </select>
                                </th>
                                <th scope="col">
                                    <select
                                        class="form-control"
                                        v-model="trainer"
                                    >
                                        <option
                                            v-for="(
                                                trainer, tindex
                                            ) in datas.trainers"
                                            :key="tindex"
                                            :value="trainer.id"
                                        >
                                            {{ trainer.name }}
                                        </option>
                                    </select>
                                </th>
                                <th scope="col">
                                    <input
                                        type="date"
                                        v-model="from"
                                        class="form-control"
                                    />
                                </th>
                                <th scope="col">
                                    <input
                                        type="date"
                                        v-model="to"
                                        class="form-control"
                                    />
                                </th>
                                <th scope="col">
                                    <select
                                        class="form-control"
                                        v-model="status"
                                    >
                                        <option
                                            v-for="(
                                                status, sindex
                                            ) in datas.status"
                                            :key="sindex"
                                            :value="status.value"
                                        >
                                            {{ status.title }}
                                        </option>
                                    </select>
                                </th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(training, index) in trainings.data"
                                :key="training.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row" v-if="SuperAdmin">
                                    {{
                                        training.branch
                                            ? training.branch.name
                                            : ""
                                    }}
                                </td>
                                <td scope="row">
                                    {{
                                        training.program
                                            ? training.program.title
                                            : ""
                                    }}
                                </td>
                                <td scope="row">
                                    {{
                                        training.trainer
                                            ? training.trainer.name
                                            : ""
                                    }}
                                </td>
                                <td scope="row">{{ training.from }}</td>
                                <td scope="row">{{ training.to }}</td>
                                <td scope="row">
                                    <span v-html="training.status_label"></span>
                                </td>
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
                                                            'admin.trainings.show',
                                                            training.id
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
                                                            'admin.trainings.edit',
                                                            training.id
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
                                                            'admin.trainings.participants',
                                                            training.id
                                                        )
                                                    "
                                                    class="dropdown-item d-flex align-items-center"
                                                >
                                                    <i
                                                        class="bi bi-person-lines-fill"
                                                    ></i>
                                                    PARTICIPANTS &nbsp;
                                                    <span
                                                        class="badge bg-danger"
                                                        >{{
                                                            training.active_participant
                                                        }}
                                                        /
                                                        {{
                                                            training.total_participant
                                                        }}</span
                                                    >
                                                </Link>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider" />
                                            </li>
                                            <li>
                                                <Link
                                                    :href="
                                                        route(
                                                            'admin.trainings.getMaterials',
                                                            training.id
                                                        )
                                                    "
                                                    class="dropdown-item d-flex align-items-center"
                                                >
                                                    <i
                                                        class="bi bi-file-pdf-fill"
                                                    ></i>
                                                    Attachments
                                                </Link>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider" />
                                            </li>
                                            <li>
                                                <Link
                                                    :href="
                                                        route(
                                                            'admin.trainings.getCosts',
                                                            training.id
                                                        )
                                                    "
                                                    class="dropdown-item d-flex align-items-center"
                                                >
                                                    <i
                                                        class="bi bi-cash-coin"
                                                    ></i>
                                                    Costs
                                                </Link>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider" />
                                            </li>
                                            <li>
                                                <Link
                                                    :href="
                                                        route(
                                                            'admin.trainings.template.index',
                                                            training.id
                                                        )
                                                    "
                                                    class="dropdown-item d-flex align-items-center"
                                                >
                                                    <i class="bi bi-border"></i>
                                                    Template
                                                </Link>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider" />
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
                                    <Pagination
                                        class="mt-6"
                                        :links="trainings.links"
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
