<script setup>
import SupervisorLayout from "@/Layouts/SupervisorLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import { ref, watch } from "vue";
import { Inertia } from "@inertiajs/inertia";
import throttle from "lodash/throttle";

const form = useForm();
const props = defineProps({
    outsources: {
        type: Object,
        default: () => ({}),
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
    datas: Object,
    can: Array
});
let SuperAdmin = props.can.includes('SuperAdmin');
let OutSourceHandler = props.can.includes('OutSourceHandler');

let project = ref(props.filters.project);
let client = ref(props.filters.client);
let from = ref(props.filters.from);
let to = ref(props.filters.to);
let status = ref(props.filters.status);

watch(project, throttle(function (value){
    Inertia.get(
        route('supervisor.outsources.index'),
        { project: project.value, client: client.value, from: from.value, to: to.value, status: status.value },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    );
}, 500
));
watch(client, throttle(function (value){
    Inertia.get(
        route('supervisor.outsources.index'),
        { project: project.value, client: client.value, from: from.value, to: to.value, status: status.value },
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
        route('supervisor.outsources.index'),
        { project: project.value, client: client.value, from: from.value, to: to.value, status: status.value },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    );
}
function exportOutsource()
{
    Inertia.get(
        route('supervisor.outsources.export'),
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    );
}
function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("supervisor.outsources.destroy", id));
    }
}
</script>
<template>
    <Head title="Outsource Page" />

    <SupervisorLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Outsource
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('supervisor.outsources.index')" :only="['outsources']"> Outsource </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                
                <button type="button" class="btn btn-sm btn-outline-success" @click="exportOutsource">Export</button>
                <a :href="datas.excel" v-if="datas.excel != ''" class="btn btn-sm btn-success"><i class="bi bi-download"></i></a>
                &nbsp;
                <Link :href="route('supervisor.outsources.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> New Outsource
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Outsource</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Action</th>
                                    <th scope="col">Project Name</th>
                                    <th scope="col">Client Name</th>
                                    <th scope="col">Contract Start</th>
                                    <th scope="col">Contract End</th>
                                    <th scope="col">Staffs</th>
                                    <th scope="col">Manager</th>
                                    <th scope="col">Supervisor</th>
                                    <th scope="col">Status</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th>
                                        <input
                                            type="text"
                                            v-model="project"
                                            placeholder=""
                                            class="form-control"
                                        />
                                    </th>
                                    <th>
                                        <input
                                            type="text"
                                            v-model="client"
                                            placeholder=""
                                            class="form-control"
                                        />
                                    </th>
                                    <th>
                                        <input
                                            type="date"
                                            v-model="from"
                                            placeholder=""
                                            class="form-control"
                                            @change="loadFilter()"
                                        />
                                    </th>
                                    <th>
                                        <input
                                            type="date"
                                            v-model="to"
                                            placeholder=""
                                            class="form-control"
                                            @change="loadFilter()"
                                        />
                                    </th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>
                                        <select v-model="status" class="form-control" @change="loadFilter()">
                                            <option v-for="(stat, staindex) in datas.status" :key="staindex" :value="stat">{{stat}}</option>
                                        </select>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr 
                                    v-for="(outsource, index) in outsources.data"
                                    :key="outsource.id"
                                >
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
                                                    <Link :href="route('supervisor.outsources.show', outsource.id)"
                                                        class="dropdown-item d-flex align-items-center">
                                                        <i class="bi bi-eye"></i> VIEW
                                                    </Link>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider" />
                                                </li>
                                                <li>
                                                    <Link :href="route('supervisor.outsources.documents.index', outsource.id)"
                                                        class="dropdown-item d-flex align-items-center">
                                                        <i class="bi bi-file-earmark-pdf"></i> Documents
                                                    </Link>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider" />
                                                </li>
                                                <li>
                                                    <Link :href="route('supervisor.outsources.purchase.index', outsource.id)"
                                                        class="dropdown-item d-flex align-items-center">
                                                        <i class="bi bi-exclamation-square"></i> Purchase Orders
                                                    </Link>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider" />
                                                </li>
                                                <li>
                                                    <Link :href="route('supervisor.outsources.staffs.index', outsource.id)"
                                                        class="dropdown-item d-flex align-items-center">
                                                        <i class="bi bi-person-badge"></i> Staffs
                                                    </Link>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider" />
                                                </li>
                                                <li>
                                                    <Link :href="route('supervisor.outsources.edit', outsource.id)"
                                                        class="dropdown-item d-flex align-items-center">
                                                        <i class="bi bi-pencil-square"></i> EDIT
                                                    </Link>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider" />
                                                </li>
                                                <li>
                                                    <button
                                                        class="dropdown-item d-flex align-items-center"
                                                        @click="destroy(outsource.id)"
                                                    >
                                                        <i class="bi bi-trash"></i> DELETE
                                                    </button>
                                                </li>
                                            </ul>
                                            <!-- End Profile Dropdown Items -->
                                        </button>
                                    </td>
                                    <td scope="row">{{ outsource.project_name }}</td>
                                    <td scope="row">{{ outsource.client_name }}</td>
                                    <td scope="row">{{ outsource.contract_start }}</td>
                                    <td scope="row">{{ outsource.contract_end }}</td>
                                    <td scope="row">
                                        <div class="btn-group">
                                            
                                            <span class="badge bg-primary"><i class="bi bi-person"></i>{{outsource.active_staff}}</span>
                                            <span class="badge bg-danger"><i class="bi bi-person"></i>{{outsource.resigned_staff}}</span>
                                            <span class="badge bg-success"><i class="bi bi-person"></i>{{outsource.active_staff}}</span>
                                            <span class="badge bg-secondary"><i class="bi bi-person"></i>{{outsource.abscond_staff}}</span>
                                        </div>
                                    </td>
                                    <td scope="row">{{ outsource.manager_person ? outsource.manager_person.name : '' }}</td>
                                    <td scope="row">{{ outsource.supervisor_person ? outsource.supervisor_person.name : '' }}</td>
                                    <td scope="row">{{ outsource.status }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="10">
                                        <Pagination class="mt-6" :links="outsources.links" />
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </SupervisorLayout>
</template>
