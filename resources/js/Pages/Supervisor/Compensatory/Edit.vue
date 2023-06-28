<script setup>
import SupervisorLayout from "@/Layouts/SupervisorLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    datas: Object,
    compensatoryoff: Object
})

const form = useForm({
    work_day: props.compensatoryoff.work_day,
    reason: props.compensatoryoff.reason,
    inform_to: props.compensatoryoff.inform_to,
});

</script>
<template>
    <Head title="Compensatory Edit" />

    <SupervisorLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Compensatory Edit
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.compensatory.index')"> Compensatory </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('supervisor.compensatory.edit', compensatoryoff.id)"> Edit </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">New Compensatory</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.put(route('supervisor.compensatory.update', compensatoryoff.id))
                                "
                            >
                                <div class="form-group row mb-3">
                                    <label
                                        for="work_day"
                                        class="col-sm-2 col-form-label"
                                        >Work Date</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.work_day" id="work_day" class="form-control">
                                            <option v-for="(holiday, index) in datas.holidays" :key="index" :value="holiday">{{holiday}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.work_day"
                                        >
                                            {{ form.errors.work_day }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="reason"
                                        class="col-sm-2 col-form-label"
                                        >Reason</label
                                    >
                                    <div class="col-sm-10">
                                        <textarea v-model="form.reason" id="reason" class="form-control" rows="3"></textarea>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.reason"
                                        >
                                            {{ form.errors.reason }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="inform_to"
                                        class="col-sm-2 col-form-label"
                                        >Inform To</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.inform_to" id="inform_to" class="form-control">
                                            <option v-for="(user, yin) in datas.users" :key="yin" :value="user.id">{{user.name}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.inform_to"
                                        >
                                            {{ form.errors.inform_to }}
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
    </SupervisorLayout>
</template>
