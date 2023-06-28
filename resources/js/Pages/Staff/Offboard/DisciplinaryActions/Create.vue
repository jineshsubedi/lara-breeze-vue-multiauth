<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    datas:Object,
})

const form = useForm({
    user_id: null,
    disciplinary_ground_id: null,
    issued_date: null,
    previous_action: 0,
    justification_required: 0,
    justification_deadline: null,
    action: 1,
    action_type: null,
    suspension_days: null,
    penalty_charge: null,
    description: null,
});

</script>
<template>
    <Head title="DisciplinaryAction Create" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                DisciplinaryAction Create
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.disciplinaryactions.index')"> DisciplinaryAction </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.disciplinaryactions.create')"> Create </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">New DisciplinaryAction</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.post(route('staffs.disciplinaryactions.store'))
                                "
                            >
                                <div class="form-group row mb-3">
                                    <label
                                        for="user_id"
                                        class="col-sm-2 col-form-label"
                                        >Staff</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.user_id" id="user_id" class="form-control">
                                        <option v-for="(staff, sindex) in datas.staffs" :key="sindex" :value="staff.id">{{staff.name}}</option>
                                            
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.user_id"
                                        >
                                            {{ form.errors.user_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="disciplinary_ground_id"
                                        class="col-sm-2 col-form-label"
                                        >Disciplinary Ground</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.disciplinary_ground_id" id="disciplinary_ground_id" class="form-control">
                                        <option v-for="(ground, gindex) in datas.grounds" :key="gindex" :value="ground.id">{{ground.title}}</option>
                                            
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.disciplinary_ground_id"
                                        >
                                            {{ form.errors.disciplinary_ground_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="issued_date"
                                        class="col-sm-2 col-form-label"
                                        >Issued Date</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="date"
                                            class="form-control"
                                            id="issued_date"
                                            placeholder="issued_date"
                                            v-model="form.issued_date"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.issued_date"
                                        >
                                            {{ form.errors.issued_date }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="previous_action"
                                        class="col-sm-2 col-form-label"
                                        >Previous Action (If Anny)</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.previous_action" id="previous_action" class="form-control">
                                        <option v-for="(act, aindex) in datas.actions" :key="aindex" :value="act.value">{{act.title}}</option>
                                            
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.previous_action"
                                        >
                                            {{ form.errors.previous_action }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="justification_required"
                                        class="col-sm-2 col-form-label"
                                        >Justification Required?</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.justification_required" id="justification_required" class="form-control">
                                        <option v-for="(req, reqindex) in datas.required" :key="reqindex" :value="req.value">{{req.title}}</option>
                                            
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.justification_required"
                                        >
                                            {{ form.errors.justification_required }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3" v-if="form.justification_required == 1">
                                    <label
                                        for="justification_deadline"
                                        class="col-sm-2 col-form-label"
                                        >Justification Deadline</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="date"
                                            class="form-control"
                                            id="justification_deadline"
                                            placeholder="justification_deadline"
                                            v-model="form.justification_deadline"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.justification_deadline"
                                        >
                                            {{ form.errors.justification_deadline }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="action"
                                        class="col-sm-2 col-form-label"
                                        >Action</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.action" id="action" class="form-control">
                                        <option v-for="(act, aindex) in datas.actions" :key="aindex" :value="act.value">{{act.title}}</option>
                                            
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.action"
                                        >
                                            {{ form.errors.action }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="action_type"
                                        class="col-sm-2 col-form-label"
                                        >Action</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.action_type" id="action_type" class="form-control">
                                        <option v-for="(act, aindex) in datas.action_types" :key="aindex" :value="act.value">{{act.title}}</option>
                                            
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.action_type"
                                        >
                                            {{ form.errors.action_type }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3" v-if="form.action_type == 1">
                                    <label
                                        for="suspension_days"
                                        class="col-sm-2 col-form-label"
                                        >Suspension Days</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="number"
                                            class="form-control"
                                            id="suspension_days"
                                            placeholder="suspension_days"
                                            v-model="form.suspension_days"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.suspension_days"
                                        >
                                            {{ form.errors.suspension_days }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3" v-if="form.action_type == 2">
                                    <label
                                        for="penalty_charge"
                                        class="col-sm-2 col-form-label"
                                        >Penalty Charge</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="number"
                                            any="2"
                                            class="form-control"
                                            id="penalty_charge"
                                            placeholder="penalty_charge"
                                            v-model="form.penalty_charge"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.penalty_charge"
                                        >
                                            {{ form.errors.penalty_charge }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="description"
                                        class="col-sm-2 col-form-label"
                                        >Description</label
                                    >
                                    <div class="col-sm-10">
                                        <textarea rows="5" v-model="form.description" class="form-control" id="description"></textarea>
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
