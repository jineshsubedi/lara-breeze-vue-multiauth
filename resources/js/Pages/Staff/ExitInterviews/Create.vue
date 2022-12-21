<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    descriptions: Object,
    staffs: Object,
    admins: Object
})

const form = useForm({
    user_id: null,
    received_by: null,
    interview_date: null,
    service_tenure: null,
    description: props.descriptions,
});

function addInterviewQuestion()
{
    form.description.push({'question' : '', 'answer': ''});
}
function removeInterviewQuestion(index)
{
    form.description.splice(index, 1)
}
</script>
<template>
    <Head title="ExitInterview Create" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ExitInterview Create
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.exitinterviews.index')"> ExitInterview </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.exitinterviews.create')"> Create </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">New ExitInterview</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.post(route('staffs.exitinterviews.store'))
                                "
                            >
                                <div class="row">
                                    <div class="form-group col-md-3 mb-3">
                                        <label
                                            for="user_id"
                                            class="col-form-label"
                                            >Staff</label
                                        >
                                        <select v-model="form.user_id" id="user_id" class="form-control">
                                            <option v-for="(staff, sin) in staffs" :key="sin" :value="staff.id">{{ staff.name }}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.user_id"
                                        >
                                            {{ form.errors.user_id }}
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3 mb-3">
                                        <label
                                            for="interview_date"
                                            class="col-form-label"
                                            >Interview Date</label
                                        >
                                        <input
                                            type="date"
                                            class="form-control"
                                            id="interview_date"
                                            placeholder="interview_date"
                                            v-model="form.interview_date"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.interview_date"
                                        >
                                            {{ form.errors.interview_date }}
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3 mb-3">
                                        <label
                                            for="service_tenure"
                                            class="col-form-label"
                                            >Service Tenure</label
                                        >
                                        <input
                                            type="date"
                                            class="form-control"
                                            id="service_tenure"
                                            placeholder="service_tenure"
                                            v-model="form.service_tenure"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.service_tenure"
                                        >
                                            {{ form.errors.service_tenure }}
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3 mb-3">
                                        <label
                                            for="received_by"
                                            class="col-form-label"
                                            >Receved By</label
                                        >
                                        <select v-model="form.received_by" id="received_by" class="form-control">
                                            <option v-for="(admin, sin) in admins" :key="sin" :value="staffs.id">{{ staffs.name }}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.received_by"
                                        >
                                            {{ form.errors.received_by }}
                                        </div>
                                    </div>
                                </div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Question</th>
                                            <th>Answer</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(description, index) in form.description" :key="index">
                                            <td style="width:40%">
                                                <span>
                                                    <textarea v-model="form.description[index].question" class="form-control" rows="3"></textarea>
                                                </span>
                                            </td>
                                            <td>
                                                <textarea v-model="form.description[index].answer" class="form-control" rows="3"></textarea>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-danger" @click="removeInterviewQuestion(index)"><i class="bi bi-x-lg"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-right">
                                                <button type="button" class="btn btn-sm btn-outline-primary" @click="addInterviewQuestion()"><i class="bi bi-plus"></i> Add More Question</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
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
