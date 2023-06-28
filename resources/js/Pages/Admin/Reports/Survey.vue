<script setup>
import { Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    surveys: Object,
    auth: Boolean,
    userId: Number
});
const form = useForm();
</script>

<template>
    <div>
        <div class="mt-3 row">
            <div class="col-xl-12">
                <div class="box">
                    <div class="box-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(survey, surveyindex) in surveys" :key="surveyindex">
                                    <th>{{++surveyindex}}</th>
                                    <th>{{survey.title}}</th>
                                    <th>{{survey.start_date}}</th>
                                    <th>{{survey.end_date}}</th>
                                    <th>
                                        <Link :href="route('admin.surveys.participants_detail', [survey.id, userId])"
                                                    class="btn btn-sm btn-outline-info">
                                                <i class="bi bi-eye"></i> VIEW 
                                            </Link>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
thead,
tbody {
    font-size: 13px;
}
.box{border: 1px solid #ededed; margin:0px; padding:0px;}
.box-header{
    background-color: #8484b3;
    color: #fff;
    padding: 4px 5px;
}
</style>