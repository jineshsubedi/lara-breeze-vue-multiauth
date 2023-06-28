<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import axios from "axios";
import { ref } from "vue";


const props = defineProps({
    data : Object,
    defBranch: Number, 
})

const form = useForm({
    title: null,
    task_to: 0,
    branch_id: props.defBranch,
    kra_id: 0,
    finish_time: null,
    priority: 1,
    description: null
});
let staffs = ref([]);
let kras = ref([]);
function getStaffs()
{
    axios.post(route('getStaffsByBranch'), 
        {
            branch: form.branch_id
        }
    )
    .then(res => {
        staffs.value = ref(res.data)
    }).catch(err => {
        console.log(err)
    })
}
function getStaffKra()
{
    axios.post(route('getStaffsKra'), 
        {
            staff: form.task_to
        }
    )
    .then(res => {
        kras.value = ref(res.data)
    }).catch(err => {
        console.log(err)
    })
}
getStaffs()
getStaffKra()
</script>
<template>
    <Head title="Help Desk Create" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Help Desk Create
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.helpdesks.index')"> Help Desk </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.helpdesks.create')"> Create </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">New Help Desk</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.post(route('staffs.helpdesks.store'))
                                "
                            >
                                <div class="form-group row mb-3">
                                    <label
                                        for="branch_id"
                                        class="col-sm-2 col-form-label"
                                        >Branch</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.branch_id" id="branch_id" class="form-control" @change="getStaffs">
                                            <option v-for="(branch, index) in data.branches" :key="index" :value="branch.id">{{branch.name}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.branch_id"
                                        >
                                            {{ form.errors.branch_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="task_to"
                                        class="col-sm-2 col-form-label"
                                        >Task To</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.task_to" id="task_to" class="form-control" @change="getStaffKra">
                                            <option v-for="(staff, index) in staffs.value" :key="index" :value="staff.id">{{staff.name}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.task_to"
                                        >
                                            {{ form.errors.task_to }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="kra_id"
                                        class="col-sm-2 col-form-label"
                                        >KRA</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.kra_id" id="kra_id" class="form-control">
                                            <option v-for="(kra, index) in kras.value" :key="index" :value="kra.id">{{kra.title}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.kra_id"
                                        >
                                            {{ form.errors.kra_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="title"
                                        class="col-sm-2 col-form-label"
                                        >Title</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="title"
                                            placeholder="Title"
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
                                        for="finish_time"
                                        class="col-sm-2 col-form-label"
                                        >Finish Date</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="date"
                                            class="form-control"
                                            id="finish_time"
                                            placeholder="finish_time"
                                            v-model="form.finish_time"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.finish_time"
                                        >
                                            {{ form.errors.finish_time }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="priority"
                                        class="col-sm-2 col-form-label"
                                        >priority</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.priority" id="priority" class="form-control">
                                            <option v-for="(priority, index) in data.priorities" :key="index" :value="priority.value">{{priority.title}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.priority"
                                        >
                                            {{ form.errors.personal }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="description"
                                        class="col-sm-2 mb-3 col-form-label"
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
                                <div class="form-group row mb-3">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button
                                            type="submit"
                                            class="btn btn-outline-primary btn-sm"
                                        >
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </StaffLayout>
</template>
