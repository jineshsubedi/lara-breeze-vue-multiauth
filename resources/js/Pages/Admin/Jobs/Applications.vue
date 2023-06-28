<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import LargeModal from "@/Components/LargeModal.vue";
import CenterModal from "@/Components/CenterModal.vue";
import { ref, watch } from "vue";
import { Inertia } from "@inertiajs/inertia";
import throttle from "lodash/throttle";

const form = useForm();

const props = defineProps({
    applications: {
        type: Object,
        default: () => ({}),
    },
    job: Object,
    data: Array,
    default_email_text: String,
    filters: {
        type: Object,
        default: () => ({}),
    },
    can: Array,
});
let SuperAdmin = props.can.includes("SuperAdmin");

let name = ref(props.filters.name);
let email = ref(props.filters.email);
let code = ref(props.filters.code);

watch(
    [name, email, code],
    throttle(function (value) {
        Inertia.get(
            route("admin.jobs.applicants.index", props.job.id),
            { name: name.value, email: email.value, code: code.value },
            {
                preserveState: true,
                replace: true,
            }
        );
    }, 500)
);

const processForm = useForm({
    title: null,
    email_text: props.default_email_text,
    sort_order: null,
});
let updateProcessUrl = ref(null);
function updateProcessApplication(process)
{
    updateProcessUrl.value = route('admin.jobs.applicants.process_update', [props.job.id, process.id]);
    processForm.title = process.title;
    processForm.email_text = process.email_text;
    processForm.sort_order = process.sort_order;
    $('#EditJobProcessModel').modal('show');
}
function closeEditProcessModel()
{
    updateProcessUrl.value = null;
    processForm.reset();
    $('#EditJobProcessModel').modal('hide');
}
function openProcessModel()
{
    $('#JobProcessModel').modal('show');
}
function submitProcessModel(id)
{
    processForm.post(route('admin.jobs.applicants.process_store', props.job.id), {
        preserveScroll: true,
        onSuccess: () => {
            closeProcessModel()
        }
    })
}
function closeProcessModel()
{
    processForm.reset();
    $('#JobProcessModel').modal('hide');
}
const pform = useForm({});
function destroyProcess(id)
{
    if (confirm("Are you sure you want to Delete")) {
        pform.delete(route("admin.jobs.applicants.delete_process", [props.job.id, id]));
    }
}
const selectedForm = useForm({
    candidate: [],
    process_id: null,
});
function approveCandidate() {
    selectedForm.post(route("admin.jobs.applicants.candidate_update"), {
        preserveScroll: true,
        onSuccess: () => {
            selectedForm.reset();
        },
    });
}
let isCheckAllViewAccess = ref(false);
function selectAllCandidate() {
    isCheckAllViewAccess.value = !isCheckAllViewAccess.value;
    selectedForm.candidate.splice(0);
    if (isCheckAllViewAccess.value) {
        for (var key in props.applications.data) {
            selectedForm.candidate.push(props.applications.data[key].id);
        }
    }
}
function openTransferApplicantModel()
{
    $('#openTransferApplicantModel').modal('show');
}
function closeTransferProcessModel()
{
    $('#openTransferApplicantModel').modal('hide');
    selectedForm.reset();
}
</script>
<template>
    <Head title="Job Applicants Page" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Job Applicants
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.jobs.index', job.id)">
                        Job
                    </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.jobs.applicants.index', job.id)">
                        Applicants
                    </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <span class="btn-group">
                    <a :href="data.cv" v-if="data.cv != null" class="btn btn-sm btn-success" target="_blank">CV <i class="bi bi-cloud-arrow-down"></i></a>
                    <a :href="data.cover" v-if="data.cover != null" class="btn btn-sm btn-success" target="_blank">Cover <i class="bi bi-cloud-arrow-down"></i></a>
                </span>&nbsp;
                <Link :href="route('admin.jobs.applicants.allcv', job.id)" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-file-zip"></i> Zip All CV
                </Link>&nbsp;
                <Link :href="route('admin.jobs.applicants.allcover', job.id)" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-file-zip"></i> Zip Cover Letter
                </Link>&nbsp;
                <button type="button" class="btn btn-sm btn-outline-primary" @click="openProcessModel()">
                    <i class="bi bi-plus"></i> Add Process
                </button>&nbsp;
                <button type="button" class="btn btn-sm btn-outline-success" @click="openTransferApplicantModel()">
                    <i class="bi bi-shift"></i> Transfer Applicant To Next Process
                </button>
            </div>
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <Link
                                class="nav-link active"
                                :href="route('admin.jobs.applicants.index', job.id)"
                                >All Applicants</Link
                            >
                        </li>
                        <li class="nav-item text-center" v-for="(pro, pindex) in job.applicant_process" :key="pindex">
                            <Link
                                class="nav-link"
                                :href="route('admin.jobs.applicants.processing', [job.id, pro.id])"
                                >{{pro.title}}</Link
                            >
                            <button type="button" class="text-warning" @click="updateProcessApplication(pro)"><i class="bi bi-pencil-square"></i></button> &nbsp;
                            <button type="button" class="text-danger" @click="destroyProcess(pro.id)"><i class="bi bi-trash"></i></button> &nbsp;
                            <i class="bi bi-person-check">{{pro.candidate.length}}</i>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        <input
                                            type="checkbox"
                                            @change="
                                                selectAllCandidate
                                            "
                                        />
                                        All
                                    </th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Track Code</th>
                                    <th scope="col">Apply Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th>
                                        <input
                                            type="text"
                                            v-model="name"
                                            placeholder="Name"
                                            class="form-control"
                                        />
                                    </th>
                                    <th>
                                        <input
                                            type="text"
                                            v-model="email"
                                            placeholder="email"
                                            class="form-control"
                                        />
                                    </th>
                                    <th>
                                        <input
                                            type="text"
                                            v-model="code"
                                            placeholder="code"
                                            class="form-control"
                                        />
                                    </th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(
                                        applicant, index
                                    ) in applications.data"
                                    :key="index"
                                >
                                    <th scope="row">
                                        <input
                                            type="checkbox"
                                            class="myAttendanceCheckbox"
                                            v-model="
                                                selectedForm.candidate
                                            "
                                            :value="applicant.id"
                                        />
                                    </th>
                                    <td scope="row">{{ applicant.name }}</td>
                                    <td scope="row">{{ applicant.email }}</td>
                                    <td scope="row">
                                        {{ applicant.tracking_code }}
                                    </td>
                                    <td scope="row">
                                        {{ applicant.apply_date }}
                                    </td>
                                    <td scope="row">
                                        <Link :href="route('admin.jobs.applicants.show', [job.id, applicant.id])"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </Link>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="8">
                                        <Pagination
                                            class="mt-6"
                                            :links="applications.links"
                                        />
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <LargeModal :id="'JobProcessModel'" title="New Job Process">
                <form
                    class="form-horizontal"
                    @submit.prevent="
                        submitProcessModel()
                    "
                >
                    <div class="form-group mb-3">
                        <label
                            for="title"
                            class="col-form-label"
                            >Title</label
                        >
                        <div class="">
                            <input
                                type="text"
                                class="form-control"
                                id="title"
                                v-model="processForm.title"
                            />
                            <div
                                class="text-red-400 text-sm"
                                v-if="processForm.errors.title"
                            >
                                {{ processForm.errors.title }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label
                            for="sort_order"
                            class="col-form-label"
                            >Sort Order</label
                        >
                        <div class="">
                            <input
                                type="number"
                                min="0"
                                class="form-control"
                                id="sort_order"
                                v-model="processForm.sort_order"
                            />
                            <div
                                class="text-red-400 text-sm"
                                v-if="processForm.errors.sort_order"
                            >
                                {{ processForm.errors.sort_order }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label
                            for="email_text"
                            class="col-form-label"
                            >Description (For Email Purpose)</label
                        >
                        <div class="">
                            <QuillEditor v-model:content="processForm.email_text" id="description" class="form-control" contentType="html" theme="snow" />
                            <div
                                class="text-red-400 text-sm"
                                v-if="processForm.errors.email_text"
                            >
                                {{ processForm.errors.email_text }}
                            </div>
                        </div>
                    </div>
                    <div class="offset-sm-2 col-sm-10">
                        <button
                            type="submit"
                            class="btn btn-outline-primary btn-sm"
                        >
                            Submit
                        </button>
                    </div>
                </form>
            </LargeModal>
            <LargeModal :id="'EditJobProcessModel'" title="Edit Job Process">
                <form
                    class="form-horizontal"
                    @submit.prevent="
                        processForm.put(updateProcessUrl, {
                            preserveScroll: true,
                            onSuccess: () => {
                                closeEditProcessModel()
                            }
                        })
                    "
                >
                    <div class="form-group mb-3">
                        <label
                            for="title"
                            class="col-form-label"
                            >Title</label
                        >
                        <div class="">
                            <input
                                type="text"
                                class="form-control"
                                id="title"
                                v-model="processForm.title"
                            />
                            <div
                                class="text-red-400 text-sm"
                                v-if="processForm.errors.title"
                            >
                                {{ processForm.errors.title }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label
                            for="sort_order"
                            class="col-form-label"
                            >Sort Order</label
                        >
                        <div class="">
                            <input
                                type="number"
                                min="0"
                                class="form-control"
                                id="sort_order"
                                v-model="processForm.sort_order"
                            />
                            <div
                                class="text-red-400 text-sm"
                                v-if="processForm.errors.sort_order"
                            >
                                {{ processForm.errors.sort_order }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label
                            for="email_text"
                            class="col-form-label"
                            >Description (For Email Purpose)</label
                        >
                        <div class="">
                            <QuillEditor v-model:content="processForm.email_text" id="description" class="form-control" contentType="html" theme="snow" />
                            <div
                                class="text-red-400 text-sm"
                                v-if="processForm.errors.email_text"
                            >
                                {{ processForm.errors.email_text }}
                            </div>
                        </div>
                    </div>
                    <div class="offset-sm-2 col-sm-10">
                        <button
                            type="submit"
                            class="btn btn-outline-primary btn-sm"
                        >
                            Submit
                        </button>
                    </div>
                </form>
            </LargeModal>
            <CenterModal :id="'openTransferApplicantModel'" title="Transfer Selected Applicants to Selected Process">
                <form
                    class="form-horizontal"
                    @submit.prevent="
                        selectedForm.post(route('admin.jobs.applicants.candidate_update', job.id), {
                            preserveScroll: true,
                            onSuccess: () => {
                                closeTransferProcessModel()
                            }
                        })
                    "
                >
                    <div class="form-group mb-3">
                        <label
                            for="process_id"
                            class="col-form-label"
                            >Application Process</label
                        >
                        <div class="">
                            <select v-model="selectedForm.process_id" id="process_id" class="form-control" required>
                                <option v-for="(process, pindex) in job.applicant_process" :key="pindex" :value="process.id">{{process.title}}</option>
                            </select>
                            <div
                                class="text-red-400 text-sm"
                                v-if="selectedForm.errors.process_id"
                            >
                                {{ selectedForm.errors.process_id }}
                            </div>
                        </div>
                    </div>
                    <div class="offset-sm-2 col-sm-10">
                        <button
                            type="submit"
                            class="btn btn-outline-primary btn-sm"
                        >
                            Submit
                        </button>
                    </div>
                </form>
            </CenterModal>
        </div>
    </AdminLayout>
</template>
