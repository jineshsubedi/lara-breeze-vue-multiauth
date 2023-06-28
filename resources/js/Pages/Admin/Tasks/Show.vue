<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import LargeModal from "@/Components/LargeModal.vue";

const props = defineProps({
    task : Object,
    data : Object,
})

const form = useForm({
    title: null,
    description: null,
    end_date: null,
    priority: 0,
    imageFile: null
});

function destroyJob(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("admin.taskjobs.delete", id));
    }
}
function submitNewTaskJob() {
    form.post(route('admin.taskjobs.save', props.task.id), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset(),
            $('#largeTaskJobModal').modal('hide')
        }
    })
}
</script>
<template>
    <Head title="Task Detail" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Task Detail
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.tasks.index')"> Task </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.tasks.show', task.id)"> Detail </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Task Detail Information</h5>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Title</th>
                                        <td>{{task.title}}</td>
                                    </tr>
                                    <tr>
                                        <th>Task From</th>
                                        <td>{{task.from_user ? task.from_user.name : ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Task To</th>
                                        <td>{{task.to_user ? task.to_user.name : ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>User KRA</th>
                                        <td>{{task.kra ? task.kra.title : ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Weightage</th>
                                        <td>{{task.weightage}}</td>
                                    </tr>
                                    <tr>
                                        <th>Start From</th>
                                        <td>{{task.start_time}}</td>
                                    </tr>
                                    <tr>
                                        <th>Accept Date</th>
                                        <td>{{task.accept_date}}</td>
                                    </tr>
                                    <tr>
                                        <th>Complete Date</th>
                                        <td>{{task.complete_date}}</td>
                                    </tr>
                                    <tr>
                                        <th>Deadline Date</th>
                                        <td>{{task.finish_time}}</td>
                                    </tr>
                                    <tr>
                                        <th>Priority</th>
                                        <td>{{task.priority_label}}</td>
                                    </tr>
                                    <tr>
                                        <th>Project</th>
                                        <td>{{task.project}}</td>
                                    </tr>
                                    <tr>
                                        <th>Personal</th>
                                        <td>{{task.personal == 1 ? 'Yes': 'No'}}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td><span v-html="task.complete_status[1]"></span></td>
                                    </tr>
                                    <tr>
                                        <th colspan="2">Description</th>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><p v-html="task.description"></p></td>
                                    </tr>
                                </tbody>
                                <tfoot v-if="task.complete_date != null">
                                    <tr>
                                        <th>Self Valuation</th>
                                        <td>
                                            <p>Point: {{task.self_mark}}</p>
                                            <p v-html="task.remarks"></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Manager Valuation</th>
                                        <td>
                                            <p>Point: {{task.supervisor_mark}}</p>
                                            <p v-html="task.s_remarks"></p>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="text-right" v-if="$page.props.auth.user.id == task.task_from && task.complete_date == null">
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#largeTaskJobModal"> <i class="bi bi-plus"></i> Add Task Job </button>
                            </div>
                            <LargeModal id="largeTaskJobModal" title="New Task Job Modal">
                                <form
                                    class="form-horizontal"
                                    @submit.prevent="
                                        submitNewTaskJob
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
                                                v-model="form.title"
                                            />
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.title"
                                            >
                                                {{ form.errors.title }}
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
                                                v-model="form.end_date"
                                            />
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.end_date"
                                            >
                                                {{ form.errors.end_date }}
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
                                            <select v-model="form.priority" id="priority" class="form-control">
                                                <option v-for="(priority,index) in data.priorities" :key="index" :value="priority.value">{{priority.title}}</option>
                                            </select>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.priority"
                                            >
                                                {{ form.errors.priority }}
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
                                                @input="form.imageFile = $event.target.files[0]"
                                                accept="image/*"
                                            />
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.imageFile"
                                            >
                                                {{ form.errors.imageFile }}
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
                                            <QuillEditor v-model:content="form.description" id="description" class="form-control" contentType="html" theme="snow" />
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.description"
                                            >
                                                {{ form.errors.description }}
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
                            <table class="table table-bordered" v-if="task.jobs_count > 0">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>End Date</th>
                                        <th>Priority</th>
                                        <th>Image</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(jtask, index) in task.jobs" :key="index">
                                        <td>{{jtask.title}}</td>
                                        <td><p v-html="jtask.description"></p></td>
                                        <td>{{jtask.end_date}}</td>
                                        <td>{{jtask.priority}}</td>
                                        <td>
                                            <img :src="jtask.image" style="width: 50px" v-if="jtask.image != null">
                                        </td>
                                        <td><p v-html="jtask.complete_status[1]"></p></td>
                                        <td>
                                            <Link :href="route('admin.taskjobs.acceptTask', jtask.id)" class="btn btn-sm btn-outline-success" v-if="$page.props.auth.user.id == task.task_to && jtask.complete_status[0] != 1">
                                                <i class="bi bi-check2-all"></i>
                                            </Link>
                                            <button
                                                class="btn btn-sm btn-outline-danger"
                                                @click="destroyJob(jtask.id)"
                                                v-if="$page.props.auth.user.id == task.task_from && jtask.complete_status[0] != 1"
                                            >
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
