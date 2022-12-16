<script setup>
import SupervisorLayout from "@/Layouts/SupervisorLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";

const form = useForm();
const props = defineProps({
    surveys: {
        type: Object,
        default: () => ({}),
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
    can: Array,
});

</script>
<template>
    <Head title="My Survey Page" />

    <SupervisorLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
               My Survey
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link
                        :href="route('supervisor.mysurveys.index')"
                        :only="['surveys']"
                    >
                        Survey
                    </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Survey</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">End Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(survey, index) in surveys.data"
                                :key="survey.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row">{{ survey.title }}</td>
                                <td scope="row">{{ survey.start_date }}</td>
                                <td scope="row">{{ survey.end_date }}</td>
                                <td scope="row">
                                    {{
                                        survey.answer_count > 0
                                            ? "Completed"
                                            : "Pending"
                                    }}
                                </td>
                                <td scope="row">
                                    <Link :href="route('supervisor.mysurveys.show', survey.id)"
                                        class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-eye"></i> VIEW
                                    </Link>
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
    </SupervisorLayout>
</template>
