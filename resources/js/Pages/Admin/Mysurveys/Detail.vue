<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";

const form = useForm();
const props = defineProps({
    survey: {
        type: Object,
        default: () => ({}),
    },
});

</script>
<template>
    <Head title="My Survey Page" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
               My Survey
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link
                        :href="route('admin.mysurveys.index')"
                        :only="['survey']"
                    >
                        My Survey
                    </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Survey Information</h5>
                    <div class="form-group mt-3 question-box" v-for="(answer, index) in survey.answer" :key="index">
                        <p class="question" v-html="answer.question"></p>
                        <p class="answer"><i class="bi bi-arrow-right"></i> <span v-html="answer.answer"></span></p>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
<style scoped>
.question-box{
    border: 1px solid grey;
    padding: 10px;
}
.question-box .question{
    font-size: 20px;
    font-weight: 800px;
}
</style>