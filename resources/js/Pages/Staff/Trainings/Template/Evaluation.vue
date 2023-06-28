<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    training: Object,
    template: Object,
    questions: Object,
    muti_answer: Object,
})

const form = useForm({
    myanswer: []
});
selectAllQuestion()
function selectAllQuestion() {
    for (var key in props.questions) {
        form.myanswer.push({
            'question_id': props.questions[key].id,
            'question' : props.questions[key].question,
            'type' : props.questions[key].type,
            'answer' : props.questions[key].lmenus.length > 0 ? [] : '',
            'training_id': props.template.training_id,
            'training_template_id': props.template.id
        });
    }
}
</script>
<template>
    <Head title="Training Evaluation Form" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Training Evaluation Form
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.trainings.index')"> Training </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.trainings.template.index', training.id)" :only="['templates']"> Templates </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.trainings.getEvaluation', [training.id, template.id])"> Evaluation Form </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{template.title}} - Evaluation</h5>
                            <form 
                                class="form-horizontal"
                                @submit.prevent="
                                    form.post(route('staffs.trainings.saveEvaluation', [training.id, template.id]))
                                "
                            >
                                <div class="form-group row mb-3" v-for="(question, index) in questions" :key="index">
                                    <span >
                                        <label
                                            for="title"
                                            class="col-form-label"
                                            >{{question.question}}</label
                                        >
                                        <div class="col-sm-12">
                                            <span v-if="question.type == 'text'">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    :id="question.id"
                                                    :placeholder="question.label"
                                                    v-model="form.myanswer[index].answer"
                                                    :required = "question.mandatory == 1 ? true : false"
                                                />
                                            </span>
                                            <span v-if="question.type == 'multiple'">
                                                <select v-model="form.myanswer[index].answer" class="form-control" :id="question.id" :required = "question.mandatory == 1 ? true : false">
                                                    <option v-for="(mans, mindex) in muti_answer" :key="mindex" :value="mans.value">{{mans.title}}</option>
                                                </select>
                                            </span>
                                            <span v-if="question.type == 'email'">
                                                <input
                                                    type="email"
                                                    class="form-control"
                                                    :id="question.id"
                                                    :placeholder="question.label"
                                                    v-model="form.myanswer[index].answer"
                                                    :required = "question.mandatory == 1 ? true : false"
                                                />
                                            </span>
                                            <span v-if="question.type == 'select'">
                                                <select 
                                                    v-model="form.myanswer[index].answer"
                                                    :id="question.id" 
                                                    class="form-control"
                                                    :required = "question.mandatory == 1 ? true : false"
                                                >
                                                    <option v-for="(menu, min) in question.lmenus" :key="min" :value="menu">{{menu}}</option>
                                                </select>
                                                
                                            </span>
                                            <span v-if="question.type == 'date'">
                                                <input
                                                    type="date"
                                                    class="form-control"
                                                    v-model="form.myanswer[index].answer"
                                                    :id="question.id"
                                                    :placeholder="question.label"
                                                    :required = "question.mandatory == 1 ? true : false"
                                                />
                                            </span>
                                            <span v-if="question.type == 'radio'">
                                                <span v-for="(list, lin) in question.lmenus" :key="lin">
                                                    {{list}}
                                                    <input
                                                        type="radio"
                                                        :name="question.label"
                                                        v-model="form.myanswer[index].answer"
                                                        :id="question.id+lin"
                                                        :value="list"
                                                    /> &nbsp;&nbsp;
                                                </span>
                                            </span>
                                            <span v-if="question.type == 'checkbox'">
                                                <span v-for="(list, lin) in question.lmenus" :key="lin">
                                                    {{list}}
                                                
                                                    <input
                                                        type="checkbox"
                                                        class="myAttendanceCheckbox"
                                                        v-model="
                                                            form.myanswer[index].answer
                                                        "
                                                        :value="list"
                                                    />&nbsp;&nbsp;
                                                </span>
                                            </span>
                                            <span v-if="question.type == 'textarea'">
                                                <textarea 
                                                    class="form-control"
                                                    v-model="form.myanswer[index].answer"
                                                    :id="question.id" 
                                                    rows="3"
                                                    :required = "question.mandatory == 1 ? true : false"
                                                ></textarea>
                                            </span>
                                            <span v-if="question.type == 'file'">
                                                <input
                                                    type="file"
                                                    class="form-control"
                                                    @input="form.myanswer[index].answer = $event.target.files[0]"
                                                    :id="question.id"
                                                    :placeholder="question.label"
                                                    :required = "question.mandatory == 1 ? true : false"
                                                    :accept="question.extra == 'image' ? 'image/*' : '.doc,.pdf,.docx,.xlsx,.xls,.csv'"
                                                />
                                            </span>
                                        </div>
                                    </span>
                                </div>
                                <hr>
                                <div class="form-group text-center row mt-3 mb-3">
                                    <div class="">
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
