<script setup>
    import { Link, useForm } from "@inertiajs/inertia-vue3";
    import CenterModal2 from "@/Components/LargeModal.vue";

    const props = defineProps({
        replies: Object,
        count: Number,
        travel_id: Number
    })

    const replyForm = useForm({
        description: null
    });

    function openChatModal()
    {
        $('#openChatModal').modal('show');
    }
    function successReplyForm()
    {
        replyForm.reset()
    }
</script>
<template>
    <div>
        <button type="button" class="btn btn-sm btn-outline-success pull-right" @click="openChatModal()"><i class="bi bi-chat"></i> Reply <span class="badge bg-danger">{{count}}</span></button>


        <CenterModal2
                id="openChatModal"
                title="Travel Chat"
            >
                <div class="row">
                    <div class="col-md-12 mb-5 mt-3" style="max-height:300px; overflow-y:scroll">
                        <div class=" mt-3 row" v-for="(reply, rindex) in replies" :key="rindex">
                            <div class="col-md-4">
                                <a class="d-flex align-items-center" href="#" data-bs-toggle="dropdown"><img  :src="reply.user.avatar_path" :alt="reply.user.name" class="rounded-circle" style="width:50px">{{reply.user.name}}</a> <span class="text-muted">{{reply.chat_at}}</span>
                            </div>
                            <div class="col-md-8" style="background-color:#4a4a64b8;color:white;  border-radius: 10px;" v-html="reply.description"></div>
                        </div>
                    </div>
                    <form
                        class="form-horizontal"
                        @submit.prevent="
                            replyForm.post(route('staffs.travels.saveReply', travel_id, {
                                preserveScroll: true,
                                onSuccess: () => successReplyForm()
                            }))
                        "
                    >
                    <div class="col-md-12 row">
                        <div class="col-md-10">
                            <textarea rows="3" v-model="replyForm.description" class="form-control"></textarea>
                            <div
                                class="text-red-400 text-sm"
                                v-if="replyForm.errors.description"
                            >
                                {{ replyForm.errors.description }}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-sm btn-outline-success">Send</button>
                        </div>
                    </div>
                    </form>
                </div>
            </CenterModal2>
    </div>
</template>