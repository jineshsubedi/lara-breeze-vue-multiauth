<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import { ref, watch } from "vue";
import { Inertia } from "@inertiajs/inertia";
import throttle from "lodash/throttle";
import NavLink from "@/Components/NavLink.vue";
import LargeModal from "@/Components/LargeModal.vue";
import CenterModal from "@/Components/CenterModal.vue";

const form = useForm();
const jobform = useForm({
    title: null,
    description: null,
    end_date: null,
    priority: 0,
    imageFile: null
});
const completeform1 = useForm({
    remarks: null,
    self_mark: null,
});
const completeform2 = useForm({
    s_remarks: null,
    supervisor_mark: null,
});

const props = defineProps({
    tasks: {
        type: Object,
        default: () => ({}),
    },
    staffs: Object,
    data: Object,
    filters: {
        type: Object,
        default: () => ({}),
    },
    can: Array
});
let title = ref(props.filters.title);
let project = ref(props.filters.project);
let from = ref(props.filters.task_from);
let to = ref(props.filters.task_to);
let finish_time = ref(props.filters.finish_time);
let type = ref(props.filters.type);
function loadFilter()
{
    Inertia.get(
        route('staffs.tasks.index'),
        { title: title.value, from: from.value, to: to.value, project: project.value, finish_time: finish_time.value, type: type.value },
        {
            preserveState: true,
            replace: true,
        }
    );
}
watch(title, throttle(function (value){
    Inertia.get(
        route('staffs.tasks.index'),
        { title: title.value, from: from.value, to: to.value, project: project.value, finish_time: finish_time.value, type: type.value },
        {
            preserveState: true,
            replace: true,
        }
    );
}, 500
));
watch(project, throttle(function (value){
    Inertia.get(
        route('staffs.tasks.index'),
        { title: title.value, from: from.value, to: to.value, project: project.value, finish_time: finish_time.value, type: type.value },
        {
            preserveState: true,
            replace: true,
        }
    );
}, 500
));
function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("staffs.tasks.destroy", id));
    }
}

function TaskJobModal(id)
{
    $('#largeTaskJobModal'+id).modal('show')
}
function submitNewTaskJob(id) {
    jobform.post(route('staffs.taskjobs.save', id), {
        preserveScroll: false,
        onSuccess: () => {
            jobform.reset()
        }
    })
}
function TaskCompleteModal(id)
{
    $('#TaskCompleteModal'+id).modal('show')
}
function submitCompleteTask(id)
{
    completeform1.post(route('staffs.mytask.completeMyTask', id), {
        preserveScroll: true,
        onSuccess: () => {
            completeform1.reset();
            $('#TaskCompleteModal'+id).modal('hide');
        }
    })
}
function SupervisorTaskCompleteModal(id)
{
    $('#SupervisorTaskCompleteModal'+id).modal('show')
}
function submitSupervisorCompleteTask(id)
{
    completeform2.post(route('staffs.stask.completeTask', id), {
        preserveScroll: true,
        onSuccess: () => {
            completeform2.reset();
            $('#SupervisorTaskCompleteModal'+id).modal('hide');
        }
    })
}
</script>
<template>
    <Head title="Task Page" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Task
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.tasks.index')"> Task </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('staffs.tasks.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> Add New Task
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <NavLink :active="filters.type == 0 || filters.type == null" :href="route('staffs.tasks.index',{type: 0})">All</NavLink>
                        </li>
                        <li class="nav-item">
                            <NavLink :active="filters.type == 1" :href="route('staffs.tasks.index', {type:1})">TO DO Task</NavLink>
                        </li>
                        <li class="nav-item">
                            <NavLink :active="filters.type == 2" :href="route('staffs.tasks.index', {type:2})">My Task</NavLink>
                        </li>
                        <li class="nav-item">
                            <NavLink :active="filters.type == 3" :href="route('staffs.tasks.index', {type:3})">Task Given</NavLink>
                        </li>
                    </ul>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Task From</th>
                                    <th scope="col">Task To</th>
                                    <th scope="col">Weightage</th>
                                    <th scope="col">Project</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Deadline</th>
                                    <th scope="col">Action</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th>
                                        <input
                                            type="text"
                                            v-model="title"
                                            placeholder="Search Task By Title"
                                            class="form-control"
                                        />
                                    </th>
                                    <th>
                                        <select v-model="from" class="form-control" @change="loadFilter" >
                                            <option value="">Task Provider</option>
                                            <option v-for="(staff, bindex) in staffs" :key="bindex" :value="staff.id">{{staff.name}}</option>
                                        </select>
                                    </th>
                                    <th>
                                        <select v-model="to" class="form-control" @change="loadFilter" >
                                            <option value="">Task Assigned</option>
                                            <option v-for="(staff, bindex) in staffs" :key="bindex" :value="staff.id">{{staff.name}}</option>
                                        </select>
                                    </th>
                                    <th></th>
                                    <th>
                                        <input
                                            type="text"
                                            v-model="project"
                                            placeholder=""
                                            class="form-control"
                                        />
                                    </th>
                                    <th></th>
                                    <th>
                                        <input
                                            type="date"
                                            v-model="finish_time"
                                            placeholder=""
                                            class="form-control"
                                            @change="loadFilter"
                                        />
                                    </th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr 
                                    v-for="(task, index) in tasks.data"
                                    :key="task.id"
                                >
                                    <th scope="row">{{ ++index }}</th>
                                    <td scope="row">{{ task.title }} ({{task.kra ? task.kra.title : ''}})</td>
                                    <td scope="row">{{ task.from_user ? task.from_user.name : '' }}</td>
                                    <td scope="row">{{ task.to_user ? task.to_user.name : '' }}</td>
                                    <td scope="row">{{ task.weightage }}</td>
                                    <td scope="row">{{ task.project }}</td>
                                    <td scope="row"><span v-html="task.complete_status[1]"></span></td>
                                    <td scope="row">{{ task.finish_time }}</td>
                                    <td scope="row">
                                        <div class="btn-group">
                                            <Link :href="route('staffs.tasks.acceptTask', task.id)" class="btn btn-sm btn-outline-success" v-if="$page.props.auth.user.id == task.task_to && task.accept_date == null">
                                                <i class="bi bi-check-lg"></i> Accept
                                            </Link>
                                            <button type="button" class="btn btn-sm btn-outline-success" @click="TaskCompleteModal(task.id)" v-if="$page.props.auth.user.id == task.task_to && task.accept_date != null && task.complete_date == null">
                                                <i class="bi bi-check2-all"></i>
                                                Complete
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-success" @click="SupervisorTaskCompleteModal(task.id)" v-if="$page.props.auth.user.id == task.task_from && task.complete_date != null && task.complete_status[0] != 1">
                                                <i class="bi bi-check2-all"></i>
                                               Complete
                                            </button>
                                            <Link :href="route('staffs.tasks.show', task.id)"
                                                class="btn btn-sm btn-outline-info">
                                                <i class="bi bi-eye"></i> View
                                            </Link>
                                            <Link :href="route('staffs.tasks.edit', task.id)"
                                                class="btn btn-sm btn-outline-warning"
                                                v-if="$page.props.auth.user.id == task.task_from"
                                            >
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </Link>
                                            <button type="button" id="{{task.id}}" class="btn btn-sm btn-outline-info" @click="TaskJobModal(task.id)" v-if="$page.props.auth.user.id == task.task_from && task.complete_date == null">
                                                <i class="bi bi-plus"></i> Jobs<span class="badge bg-success badge-number">{{task.jobs_count}}</span>
                                            </button>
                                            <button
                                                class="btn btn-sm btn-outline-danger"
                                                @click="destroy(task.id)"
                                                v-if="$page.props.auth.user.id == task.task_from"
                                            >
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <CenterModal :id="'TaskCompleteModal'+task.id" title="Task Complete Model">
                                        <form
                                            class="form-horizontal"
                                            @submit.prevent="
                                                submitCompleteTask(task.id)
                                            "
                                            enctype="multipart/form-data"
                                        >
                                            <div class="form-group row mb-3">
                                                <label
                                                    for="self_mark"
                                                    class="col-sm-2 col-form-label"
                                                    >Self Rate</label
                                                >
                                                <div class="col-sm-10">
                                                    <input
                                                        type="number"
                                                        min="0"
                                                        max="10"
                                                        class="form-control"
                                                        id="self_mark"
                                                        v-model="completeform1.self_mark"
                                                    />
                                                    <div
                                                        class="text-red-400 text-sm"
                                                        v-if="completeform1.errors.self_mark"
                                                    >
                                                        {{ completeform1.errors.self_mark }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-3">
                                                <label
                                                    for="myremarks"
                                                    class="col-sm-2 col-form-label"
                                                    >Remarks</label
                                                >
                                                <div class="col-sm-10">
                                                    <textarea v-model="completeform1.remarks" id="myremarks" class="form-control" rows="5"></textarea>
                                                    <div
                                                        class="text-red-400 text-sm"
                                                        v-if="completeform1.errors.remarks"
                                                    >
                                                        {{ completeform1.errors.remarks }}
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
                                    <CenterModal :id="'SupervisorTaskCompleteModal'+task.id" title="Task Complete Model">
                                        <form
                                            class="form-horizontal"
                                            @submit.prevent="
                                                submitSupervisorCompleteTask(task.id)
                                            "
                                            enctype="multipart/form-data"
                                        >
                                            <div class="form-group row mb-3">
                                                <label
                                                    for="supervisor_mark"
                                                    class="col-sm-2 col-form-label"
                                                    >Rating</label
                                                >
                                                <div class="col-sm-10">
                                                    <input
                                                        type="number"
                                                        min="0"
                                                        max="10"
                                                        class="form-control"
                                                        id="supervisor_mark"
                                                        v-model="completeform2.supervisor_mark"
                                                    />
                                                    <div
                                                        class="text-red-400 text-sm"
                                                        v-if="completeform2.errors.supervisor_mark"
                                                    >
                                                        {{ completeform2.errors.supervisor_mark }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-3">
                                                <label
                                                    for="s_remarks"
                                                    class="col-sm-2 col-form-label"
                                                    >Remarks</label
                                                >
                                                <div class="col-sm-10">
                                                    <textarea v-model="completeform2.s_remarks" id="s_remarks" class="form-control" rows="5"></textarea>
                                                    <div
                                                        class="text-red-400 text-sm"
                                                        v-if="completeform2.errors.s_remarks"
                                                    >
                                                        {{ completeform2.errors.s_remarks }}
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
                                    <LargeModal :id="'largeTaskJobModal'+task.id" title="New Task Job Modal">
                                        <form
                                            class="form-horizontal"
                                            @submit.prevent="
                                                submitNewTaskJob(task.id)
                                            "
                                            enctype="multipart/form-data"
                                        >
                                            <div class="form-group row mb-3">
                                                <label
                                                    for="inputTitle"
                                                    class="col-sm-2 col-form-label"
                                                    >Title</label
                                                >
                                                <div class="col-sm-10">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="inputTitle"
                                                        placeholder="Job Title"
                                                        v-model="jobform.title"
                                                    />
                                                    <div
                                                        class="text-red-400 text-sm"
                                                        v-if="jobform.errors.title"
                                                    >
                                                        {{ jobform.errors.title }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-3">
                                                <label
                                                    for="end_date"
                                                    class="col-sm-2 col-form-label"
                                                    >Deadline</label
                                                >
                                                <div class="col-sm-10">
                                                    <input
                                                        type="date"
                                                        class="form-control"
                                                        id="end_date"
                                                        v-model="jobform.end_date"
                                                    />
                                                    <div
                                                        class="text-red-400 text-sm"
                                                        v-if="jobform.errors.end_date"
                                                    >
                                                        {{ jobform.errors.end_date }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-3">
                                                <label
                                                    for="priority"
                                                    class="col-sm-2 col-form-label"
                                                    >Priority</label
                                                >
                                                <div class="col-sm-10">
                                                    <select v-model="jobform.priority" id="priority" class="form-control">
                                                        <option v-for="(priority,index) in data.priorities" :key="index" :value="priority.value">{{priority.title}}</option>
                                                    </select>
                                                    <div
                                                        class="text-red-400 text-sm"
                                                        v-if="jobform.errors.priority"
                                                    >
                                                        {{ jobform.errors.priority }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-3">
                                                <label
                                                    for="ImageFile"
                                                    class="col-sm-2 col-form-label"
                                                    >Image</label
                                                >
                                                <div class="col-sm-10">
                                                    <input
                                                        type="file"
                                                        class="form-control"
                                                        id="ImageFile"
                                                        @input="jobform.imageFile = $event.target.files[0]"
                                                        accept="image/*"
                                                    />
                                                    <div
                                                        class="text-red-400 text-sm"
                                                        v-if="jobform.errors.imageFile"
                                                    >
                                                        {{ jobform.errors.imageFile }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-3">
                                                <label
                                                    for="description"
                                                    class="col-sm-2 col-form-label"
                                                    >Description</label
                                                >
                                                <div class="col-sm-10 mb-5">
                                                    <QuillEditor v-model:content="jobform.description" id="description" class="form-control" contentType="html" theme="snow" />
                                                    <div
                                                        class="text-red-400 text-sm"
                                                        v-if="jobform.errors.description"
                                                    >
                                                        {{ jobform.errors.description }}
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
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="8">
                                        <Pagination class="mt-6" :links="tasks.links" />
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    </StaffLayout>
</template>
