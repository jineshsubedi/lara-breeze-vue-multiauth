<script setup>
    import { useForm } from '@inertiajs/inertia-vue3';
    import LargeModal from "@/Components/LargeModal.vue";
    
    const props = defineProps({
        subordinate_rating: Boolean,
        url: String,
    });
    const form = useForm({
        supervisory: null,
        supervisory_detail: null,
        leadership: null,
        leadership_detail: null,
        quality: null,
        quality_detail: null,
        communication: null,
        communication_detail: null,
        consistency: null,
        consistency_detail: null,
        independent: null,
        independent_detail: null,
        proactiveness: null,
        proactiveness_detail: null,
        creativity: null,
        creativity_detail: null,
    });
    $(document).ready(function(){
        openSupervisorRating()
    })
    function openSupervisorRating()
    {
        $('#supervisor_rating').modal('show');
    }
    function closeSupervisorRating()
    {
        form.reset()
        $('#supervisor_rating').modal('hide');
    }
    function submitSupervisorRating()
    {
        form.post(props.url), {
            preserveScroll: true,
            onSuccess: () => {
                closeSupervisorRating();
            }
        }
    }
</script>
<template>
    <div>
        <LargeModal id="supervisor_rating" title="Rate your supervisor">
            <form
                class="form-horizontal"
                @submit.prevent="
                    submitSupervisorRating()
                "
            >
                <div class="form-group row mb-3">
                    <label
                        for="supervisory"
                        class="col-sm-2 col-form-label"
                        >Supervisory</label
                    >
                    <div class="col-sm-5">
                        <input
                            type="number"
                            class="form-control"
                            id="supervisory"
                            min="1"
                            max="10"
                            v-model="form.supervisory"
                        />
                        <div
                            class="text-red-400 text-sm"
                            v-if="form.errors.supervisory"
                        >
                            {{ form.errors.supervisory }}
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <textarea v-model="form.supervisory_detail" class="form-control" rows="2"></textarea>
                        <div
                            class="text-red-400 text-sm"
                            v-if="form.errors.supervisory_detail"
                        >
                            {{ form.errors.supervisory_detail }}
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label
                        for="communication"
                        class="col-sm-2 col-form-label"
                        >Communication</label
                    >
                    <div class="col-sm-5">
                        <input
                            type="number"
                            class="form-control"
                            id="communication"
                            min="1"
                            max="10"
                            v-model="form.communication"
                        />
                        <div
                            class="text-red-400 text-sm"
                            v-if="form.errors.communication"
                        >
                            {{ form.errors.communication }}
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <textarea v-model="form.communication_detail" class="form-control" rows="2"></textarea>
                        <div
                            class="text-red-400 text-sm"
                            v-if="form.errors.communication_detail"
                        >
                            {{ form.errors.communication_detail }}
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label
                        for="quality"
                        class="col-sm-2 col-form-label"
                        >Quality</label
                    >
                    <div class="col-sm-5">
                        <input
                            type="number"
                            class="form-control"
                            id="quality"
                            min="1"
                            max="10"
                            v-model="form.quality"
                        />
                        <div
                            class="text-red-400 text-sm"
                            v-if="form.errors.quality"
                        >
                            {{ form.errors.quality }}
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <textarea v-model="form.quality_detail" class="form-control" rows="2"></textarea>
                        <div
                            class="text-red-400 text-sm"
                            v-if="form.errors.quality_detail"
                        >
                            {{ form.errors.quality_detail }}
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label
                        for="consistency"
                        class="col-sm-2 col-form-label"
                        >Consistency</label
                    >
                    <div class="col-sm-5">
                        <input
                            type="number"
                            class="form-control"
                            id="consistency"
                            min="1"
                            max="10"
                            v-model="form.consistency"
                        />
                        <div
                            class="text-red-400 text-sm"
                            v-if="form.errors.consistency"
                        >
                            {{ form.errors.consistency }}
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <textarea v-model="form.consistency_detail" class="form-control" rows="2"></textarea>
                        <div
                            class="text-red-400 text-sm"
                            v-if="form.errors.consistency_detail"
                        >
                            {{ form.errors.consistency_detail }}
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label
                        for="independent"
                        class="col-sm-2 col-form-label"
                        >Independent</label
                    >
                    <div class="col-sm-5">
                        <input
                            type="number"
                            class="form-control"
                            id="independent"
                            min="1"
                            max="10"
                            v-model="form.independent"
                        />
                        <div
                            class="text-red-400 text-sm"
                            v-if="form.errors.independent"
                        >
                            {{ form.errors.independent }}
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <textarea v-model="form.independent_detail" class="form-control" rows="2"></textarea>
                        <div
                            class="text-red-400 text-sm"
                            v-if="form.errors.independent_detail"
                        >
                            {{ form.errors.independent_detail }}
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label
                        for="proactiveness"
                        class="col-sm-2 col-form-label"
                        >Proactiveness</label
                    >
                    <div class="col-sm-5">
                        <input
                            type="number"
                            class="form-control"
                            id="proactiveness"
                            min="1"
                            max="10"
                            v-model="form.proactiveness"
                        />
                        <div
                            class="text-red-400 text-sm"
                            v-if="form.errors.proactiveness"
                        >
                            {{ form.errors.proactiveness }}
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <textarea v-model="form.proactiveness_detail" class="form-control" rows="2"></textarea>
                        <div
                            class="text-red-400 text-sm"
                            v-if="form.errors.proactiveness_detail"
                        >
                            {{ form.errors.proactiveness_detail }}
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label
                        for="creativity"
                        class="col-sm-2 col-form-label"
                        >Creativity</label
                    >
                    <div class="col-sm-5">
                        <input
                            type="number"
                            class="form-control"
                            id="creativity"
                            min="1"
                            max="10"
                            v-model="form.creativity"
                        />
                        <div
                            class="text-red-400 text-sm"
                            v-if="form.errors.creativity"
                        >
                            {{ form.errors.creativity }}
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <textarea v-model="form.creativity_detail" class="form-control" rows="2"></textarea>
                        <div
                            class="text-red-400 text-sm"
                            v-if="form.errors.creativity_detail"
                        >
                            {{ form.errors.creativity_detail }}
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label
                        for="leadership"
                        class="col-sm-2 col-form-label"
                        >Leadership</label
                    >
                    <div class="col-sm-5">
                        <input
                            type="number"
                            class="form-control"
                            id="leadership"
                            min="1"
                            max="10"
                            v-model="form.leadership"
                        />
                        <div
                            class="text-red-400 text-sm"
                            v-if="form.errors.leadership"
                        >
                            {{ form.errors.leadership }}
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <textarea v-model="form.leadership_detail" class="form-control" rows="2"></textarea>
                        <div
                            class="text-red-400 text-sm"
                            v-if="form.errors.leadership_detail"
                        >
                            {{ form.errors.leadership_detail }}
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
        </LargeModal>
    </div>
</template>