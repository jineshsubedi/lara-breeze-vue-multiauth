<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const form = useForm({
    myanswer: [],
});
const props = defineProps({
    survey: {
        type: Object,
        default: () => ({}),
    },
});
selectAllSurvey()
function selectAllSurvey() {
    for (var key in props.survey.question) {
        form.myanswer.push({
            'question' : props.survey.question[key].label,
            'type' : props.survey.question[key].type,
            'answer' : props.survey.question[key].list_menu.length > 0 ? [] : ''
        });
    }
}
function changeChildStatus(question, value)
{
    console.log(question.label);
    console.log(value);
    if(question.extra == value)
        $('.child'+question.id).show();
    else
        $('.child'+question.id).hide();

}
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
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{survey.title}} - Survey</h5>
                <p v-html="survey.description"></p>
                <div class="mt-5 form-container">
                    <form 
                        class="form-horizontal"
                        @submit.prevent="
                            form.post(route('admin.mysurveys.store', survey.id))
                        "
                    >
                        <div class="form-group row mb-3" v-for="(question, index) in survey.question" :key="index">
                            <span v-if="question.parent_id == 0" >
                                <label
                                    for="title"
                                    class="col-form-label"
                                    >{{question.label}}</label
                                >
                                <div class="col-sm-12">
                                    <span v-if="question.type == 'text'">
                                        <input
                                            type="text"
                                            class="form-control"
                                            :id="question.id"
                                            :placeholder="question.label"
                                            v-model="form.myanswer[index].answer"
                                            :required = "question.required == 1 ? true : false"
                                        />
                                    </span>
                                    <span v-if="question.type == 'email'">
                                        <input
                                            type="email"
                                            class="form-control"
                                            :id="question.id"
                                            :placeholder="question.label"
                                            v-model="form.myanswer[index].answer"
                                            :required = "question.required == 1 ? true : false"
                                        />
                                    </span>
                                    <span v-if="question.type == 'select'">
                                        <select 
                                            v-model="form.myanswer[index].answer"
                                            :id="question.id" 
                                            class="form-control"
                                            :required = "question.required == 1 ? true : false"
                                            @change="changeChildStatus(question, form.myanswer[index].answer)"
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
                                            :required = "question.required == 1 ? true : false"
                                            @change="changeChildStatus(question, form.myanswer[index].answer)"
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
                                                @change="changeChildStatus(question, form.myanswer[index].answer)"
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
                                            :required = "question.required == 1 ? true : false"
                                        ></textarea>
                                    </span>
                                    <span v-if="question.type == 'file'">
                                        <input
                                            type="file"
                                            class="form-control"
                                            @input="form.myanswer[index].answer = $event.target.files[0]"
                                            :id="question.id"
                                            :placeholder="question.label"
                                            :required = "question.required == 1 ? true : false"
                                            :accept="question.extra == 'image' ? 'image/*' : '.doc,.pdf,.docx,.xlsx,.xls,.csv'"
                                        />
                                    </span>
                                </div>
                            </span>
                            <span :class="'child'+question.parent_id" v-else style="display:none;">
                                <label
                                    for="title"
                                    class="col-form-label"
                                    >{{question.label}}</label
                                >
                                <div class="col-sm-12">
                                    <span v-if="question.type == 'text'">
                                        <input
                                            type="text"
                                            class="form-control"
                                            :id="question.id"
                                            :placeholder="question.label"
                                            v-model="form.myanswer[index].answer"
                                            :required = "question.required == 1 ? true : false"
                                        />
                                    </span>
                                    <span v-if="question.type == 'email'">
                                        <input
                                            type="email"
                                            class="form-control"
                                            :id="question.id"
                                            :placeholder="question.label"
                                            v-model="form.myanswer[index].answer"
                                            :required = "question.required == 1 ? true : false"
                                        />
                                    </span>
                                    <span v-if="question.type == 'select'">
                                        <select 
                                            v-model="form.myanswer[index].answer"
                                            :id="question.id" 
                                            class="form-control"
                                            :required = "question.required == 1 ? true : false"
                                            @change="changeChildStatus(question, form.myanswer[index].answer)"
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
                                            :required = "question.required == 1 ? true : false"
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
                                            :required = "question.required == 1 ? true : false"
                                        ></textarea>
                                    </span>
                                    <span v-if="question.type == 'file'">
                                        <input
                                            type="file"
                                            class="form-control"
                                            @input="form.myanswer[index].answer = $event.target.files[0]"
                                            :id="question.id"
                                            :placeholder="question.label"
                                            :required = "question.required == 1 ? true : false"
                                            :accept="question.extra == 'image' ? 'image/*' : '.doc,.pdf,.docx,.xlsx,.xls,.csv'"
                                        />
                                    </span>
                                </div>
                            </span>
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
    </AdminLayout>
</template>
<style scoped>
    .form-container{
        border: 1px solid #012970;
        padding: 20px 25px;
    }
</style>
