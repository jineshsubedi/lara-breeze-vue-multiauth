<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import CenterModal from "@/Components/CenterModal.vue";
import axios from "axios";
import { ref } from "vue";

const props = defineProps({
    questions : Object,
    survey : Object,
    data : Object
})
const qform = useForm();

const bulkForm = useForm({
    document: null
});

const form = useForm({
    parent_id: 0,
    label: null,
    type: 'text',
    list_menu: null,
    required: 1,
    extra: null,
    sort: props.questions.length+1,
});
function copyAndDelete(question)
{
    form.parent_id = question.parent_id
    form.label = question.label
    form.list_menu = question.list_menu
    form.type = question.type
    form.required = question.required
    form.extra = question.extra
    form.sort = question.sort
    term.value = question.parent_label
}

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        qform.delete(route("staffs.surveys.deleteQuestion", id));
    }
}

let label_options = ref([]);
let term = ref('');
let isOpen = ref(false);
function getSuggestionList()
{
    axios.post(route('staffs.surveys.autocomplete', props.survey.id), 
        {
            term: term.value
        }
    )
    .then(res => {
        isOpen = true
        label_options = ref(res.data)
    }).catch(err => {
        isOpen = false
        console.log(err)
    })
}
function setResult(label)
{
    console.log(label);
    form.parent_id = label.id
    term.value = label.value
    isOpen = false
} 
function resetForm()
{
    qform.reset();
    form.parent_id = 0
    form.label = null
    form.list_menu = null
    form.extra = null
    form.sort = 1
    term.value = ''
}
function submitQuestion()
{
    form.post(route('staffs.surveys.postQuestion', props.survey.id))
}
function surveyQuestionModal()
{
    $('#surveyQuestionModal').modal('show')
}
function submitBulkImport(id)
{
    bulkForm.post(route('staffs.surveys.bulkimport', id), {
        preserveScroll: true,
        onSuccess: () => {
            $('#surveyQuestionModal').modal('hide');
        }
    })
}
</script>
<template>
    <Head title="Survey Question" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Survey Question
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.surveys.index')"> Survey </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.surveys.getQuestion', survey.id)" :only="['questions']"> Questions </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                {{survey.title}} - Questions
                                <span class="pull-right">
                                    <a :href="data.sample" class="btn btn-sm btn-outline-info" target="_blank"><i class="bi bi-file-earmark-excel"></i> Sample</a> &nbsp;
                                    <button type="button" class="btn btn-sm btn-outline-success" @click="surveyQuestionModal"><i class="bi bi-file-earmark-excel"></i> Bulk Import</button>
                                </span>
                            </h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#sort</th>
                                        <th>Parent</th>
                                        <th>Question</th>
                                        <th>Type</th>
                                        <th>List Menu</th>
                                        <th>Required</th>
                                        <th>Extra</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(question, index) in questions" :key="index">
                                        <td>{{question.sort}}</td>
                                        <td>{{question.parent_id == 0 ? '' : question.parent_label}}</td>
                                        <td>{{question.label}}</td>
                                        <td>{{question.type}}</td>
                                        <td>{{question.list_menu}}</td>
                                        <td>{{question.required == 1 ? 'Yes' : 'No'}}</td>
                                        <td>{{question.extra}}</td>
                                        <td>
                                            <button
                                                class="btn btn-sm btn-outline-warning"
                                                @click="copyAndDelete(question)"
                                            >
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <button
                                                class="btn btn-sm btn-outline-danger"
                                                @click="destroy(question.id)"
                                            >
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <form
                                class="form-horizontal"
                                @submit.prevent="submitQuestion"
                            >
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td>
                                            <label for="">Parent</label>
                                            <input 
                                                type="text" 
                                                v-model="term" 
                                                class="form-control"
                                                @input="getSuggestionList"
                                            >
                                            <ul
                                                id="autocomplete-results"
                                                v-show="isOpen"
                                                class="autocomplete-results"
                                            >
                                                <li
                                                v-for="(label, i) in label_options"
                                                :key="i"
                                                @click="setResult(label)"
                                                class="autocomplete-result"
                                                >
                                                {{ label.value }}
                                                </li>
                                            </ul>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.parent_id"
                                            >
                                                {{ form.errors.parent_id }}
                                            </div>
                                        </td>
                                        <td>
                                            <label for="">Question</label>
                                            <input type="text" v-model="form.label" class="form-control">
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.label"
                                            >
                                                {{ form.errors.label }}
                                            </div>
                                        </td>
                                        <td>
                                            <label for="">Type</label>
                                            <select v-model="form.type" class="form-control">
                                                <option v-for="(type, tindex) in data.type" :key="tindex" :value="type.value">{{type.title}}</option>
                                            </select>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.type"
                                            >
                                                {{ form.errors.type }}
                                            </div>
                                        </td>
                                        <td>
                                            <label for="">List Menu</label>
                                            <input type="text" v-model="form.list_menu" class="form-control">
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.list_menu"
                                            >
                                                {{ form.errors.list_menu }}
                                            </div>
                                        </td>
                                        <td>
                                            <label for="">Required</label>
                                            <select v-model="form.required" class="form-control">
                                                <option v-for="(required, rindex) in data.required" :key="rindex" :value="required.value">{{required.title}}</option>
                                            </select>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.required"
                                            >
                                                {{ form.errors.required }}
                                            </div>
                                        </td>
                                        <td>
                                            <label for="">Extra</label>
                                            <input type="text" v-model="form.extra" class="form-control">
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.extra"
                                            >
                                                {{ form.errors.extra }}
                                            </div>
                                        </td>
                                        <td>
                                            <label for="">Order</label>
                                            <input type="number" min="1" max="100" v-model="form.sort" class="form-control">
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.sort"
                                            >
                                                {{ form.errors.sort }}
                                            </div>
                                        </td>
                                        <td>
                                            <br>
                                            <button type="button" @click="resetForm" class="btn btn-outline-warning"><i class="bi bi-arrow-clockwise"></i></button>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" class="text-right">
                                            <button type="submit" class="btn btn-outline-success">Submit</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <CenterModal :id="'surveyQuestionModal'" title="Survey Bulk Question Upload Model">
            <form
                class="form-horizontal"
                @submit.prevent="
                    submitBulkImport(survey.id)
                "
                enctype="multipart/form-data"
            >
                <div class="form-group row mb-3">
                    <label
                        for="document"
                        class="col-sm-4 col-form-label"
                        >Bulk File</label
                    >
                    <div class="col-sm-8">
                        <input
                            type="file"
                            class="form-control"
                            id="document"
                            @input="bulkForm.document = $event.target.files[0]"
                            accept=".xls,.xlsx" 
                        />
                        <div
                            class="text-red-400 text-sm"
                            v-if="bulkForm.errors.document"
                        >
                            {{ bulkForm.errors.document }}
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
        </CenterModal>
    </StaffLayout>
</template>
<style scoped>
.image-thumbnails {
  border: 1px solid #3498db;
  margin: 5px;
  width: 150px;
  height: 150px;
  object-fit: contain;
}
.autocomplete {
  position: relative;
}

.autocomplete-results {
  padding: 0;
  margin: 0;
  border: 1px solid #eeeeee;
  max-height: 200px;
  overflow: auto;
  position: absolute;
  background: #fff;
  z-index: 200;
}

.autocomplete-result {
  list-style: none;
  text-align: left;
  padding: 4px 2px;
  cursor: pointer;
}

.autocomplete-result.is-active,
.autocomplete-result:hover {
  background-color: #4aae9b;
  color: white;
}
</style>