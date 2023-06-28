<script setup>
import SupervisorLayout from "@/Layouts/SupervisorLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    dailytask: {
        type: Object,
        default: () => ({}),
    },
    kras: Array
})

const form = useForm({
    work_date: props.dailytask.work_date,
    start_time: props.dailytask.start_time,
    end_time: props.dailytask.end_time,
    kra: props.dailytask.kra,
    description: props.dailytask.description,
});

function submitTodayTask() {
    form.put(route('supervisor.dailytasks.update', props.dailytask.id))
}
</script>

<template>
    <Head title="DailyTask Edit" />

    <SupervisorLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                DailyTask Edit
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.dailytasks.index')"> Daily Task </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('supervisor.dailytasks.edit', dailytask.id)"> Edit </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <form class="needs-validation" @submit.prevent="submitTodayTask" >
                            <div class="card-body">
                                <h5 class="card-title">Daily Task Update Form</h5>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="workdate" class="form-label">Work Date</label>
                                        <input type="date" class="form-control" id="workdate" max="" v-model="form.work_date" >
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.work_date"
                                        >
                                            {{ form.errors.work_date }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="startTime" class="form-label">Start Time</label>
                                        <input type="time" class="form-control" id="startTime" v-model="form.start_time" >
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.start_time"
                                        >
                                            {{ form.errors.start_time }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="endTime" class="form-label">End Time</label>
                                        <input type="time" class="form-control" id="endTime" v-model="form.end_time" >
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.end_time"
                                        >
                                            {{ form.errors.end_time }}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="validationCustomUsername" class="form-label">KRA</label>
                                        <select class="form-control" id="kra" v-model="form.kra" >
                                            <option v-for="(kra, indx) in kras" :key="indx" :value="kra.id">{{kra.title}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.kra"
                                        >
                                            {{ form.errors.kra }}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" id="description" rows="5" v-model="form.description"></textarea>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.description"
                                        >
                                            {{ form.errors.description }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" :disabled="form.processing" class="btn btn-outline-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </SupervisorLayout>
</template>