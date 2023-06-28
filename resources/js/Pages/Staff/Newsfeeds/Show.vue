<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import { ref, watch } from "vue";
import { Inertia } from "@inertiajs/inertia";
import moment from 'moment';

const form = useForm({});

const props = defineProps({
    newsfeed: {
        type: Object,
        default: () => ({}),
    },
    can: Array,
});
let SuperAdmin = props.can.includes("SuperAdmin");
let HrHandler = props.can.includes("HrHandler");

const commentForm = useForm({
    description: ''
});

function humanTime(value)
{
    return moment(value).fromNow();
}

function toggleUserLike(id)
{
    Inertia.get(
        route("staffs.newsfeeds.hitlike", id),
        { page: 1 },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    );
}
function toggleCommentBox(id)
{
    $('#commentSection-'+id).toggle();
    $('.commentSection').not('#commentSection-'+id).hide();
}
function resetCommentForm()
{
    commentForm.reset();
}
function destroy(id, index)
{
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("staffs.newsfeeds.destroy", id), {
            preserveScroll: true,
        });
    }
}
function destroyComment(id, cindex, fid)
{
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("staffs.newsfeeds.deleteComment", id), {
            preserveScroll: true,
        });
    }
}
</script>
<template>
    <Head title="Newsfeed Post" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Newsfeed Post
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link
                        :href="route('staffs.newsfeeds.index')"
                    >
                        Newsfeed
                    </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link
                        :href="route('staffs.newsfeeds.show', newsfeed.id)"
                    >
                        Post Information
                    </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="col-sm-6 col-md-6">
                <div class="mt-3 mb-3">
                    <div class="post" >
                        <div class="post-header">
                            <div class="post-tool" v-if="newsfeed.user.id == $page.props.auth.user.id" @click="destroy(newsfeed.id, findex)">
                                <i class="bi bi-x-lg"></i>
                            </div>
                            <div class="d-flex">
                                <img :src="newsfeed.user.avatar_path" :alt="newsfeed.user.name" />
                                <div class="post-header-info">
                                    <h3>{{newsfeed.user.name}}</h3>
                                    <p>
                                        <span class="post-date">{{humanTime(newsfeed.created_at)}}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 post-body" v-if="newsfeed.event == null">
                            <p class="text-justify" v-if="newsfeed.description" v-html="newsfeed.description"></p>
                            <img v-if="newsfeed.image" :src="newsfeed.image" :alt="newsfeed.user.name" style="width:100%" />
                            <div class="mt-3" v-if="newsfeed.video">
                                <iframe width="100%" height="300px" :src="newsfeed.video" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                        <div class="mb-3 post-body" v-else>
                            <span v-html="newsfeed.event"></span>
                        </div>
                        <div class="post-footer">
                            <button class="like-button" @click="toggleUserLike(newsfeed.id)"><span>{{newsfeed.like_count}}</span> Like</button>
                            <button class="comment-button" @click="toggleCommentBox(newsfeed.id)"><span>{{newsfeed.comment_count}}</span> Comment</button>
                            <div class="mt-3 commentSection" :id="'commentSection-'+newsfeed.id" style="display:none;">
                                <div class="comments-list">
                                    <div class="comment" v-for="(comment, cindex) in newsfeed.comment" :key="cindex">
                                        <div class="post-tool" v-if="newsfeed.user.id == $page.props.auth.user.id" @click="destroyComment(comment.id, cindex, newsfeed.id)">
                                            <i class="bi bi-x-lg"></i>
                                        </div>
                                        <div class="comment-author">
                                            <img :src="comment.user.avatar_path" :alt="comment.user.name">
                                            <h4>{{comment.user.name}} <br> 
                                                <span class="text-muted">{{humanTime(comment.created_at)}}</span>
                                            </h4>
                                        </div>
                                        <p class="comment-text" v-html="comment.description"></p>
                                    </div>
                                </div>

                                <div class="comment-reply-box">
                                    <form
                                        class="form-horizontal"
                                        @submit.prevent="
                                            commentForm.post(route('staffs.newsfeeds.comment', newsfeed.id), {
                                                preserveScroll: true,
                                                onSuccess: () => resetCommentForm()
                                            })
                                        "
                                    >
                                        <textarea v-model="commentForm.description" placeholder="Write a reply..."></textarea>
                                        <button type="submit">Reply</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </StaffLayout>
</template>
<style>
.post {
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 10px;
    background-color: #fff;
}

.post-header img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-right: 10px;
}

.post-header h3 {
    margin: 0;
    font-size: 18px;
}

.post-header p {
    margin: 0;
    font-size: 14px;
    color: #999;
}

.post-header .post-date {
    color: #333;
}

.post-body img {
    width: 100%;
    max-height: 500px;
    margin-top: 10px;
}

.post-footer button {
    border: none;
    background-color: transparent;
    color: #999;
    margin-right: 10px;
    font-size: 14px;
    cursor: pointer;
}

.post-footer button:hover {
    color: #333;
}
.post-tool{
    float:right;
}
.post-tool:hover{
    color: red;
    font-size: 20px;
    cursor: pointer;
}

<!-- comment  -->
.comment-reply-box {
  margin-top: 16px;
}

.comment-reply-box form {
  display: flex;
  flex-direction: column;
}

.comment-reply-box textarea {
  height: 64px;
  margin-bottom: 8px;
  padding: 8px;
  font-size: 16px;
  line-height: 1.5;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.comment-reply-box button {
  align-self: flex-end;
  padding: 6px 12px;
  font-weight: bold;
  text-transform: uppercase;
  color: #fff;
  background-color: #4267b2;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.comment-reply-box button:hover {
  background-color: #385898;
}

.comments-list {
  margin-top: 16px;
}

.comment {
    flex-direction: column;
    padding: 6px;
    border-bottom: 1px solid #e5e5e5;
    background-color: #f5f5f5;
    border-radius: 4px;
}

.comment-author {
  display: flex;
  align-items: center;
  margin-bottom: 8px;
}

.comment-author img {
  width: 48px;
  height: 48px;
  margin-right: 8px;
  border-radius: 50%;
}

.comment-author h4 {
  margin: 0;
  font-size: 16px;
  font-weight: bold;
}

.comment-text {
  margin: 8px 0;
  font-size: 16px;
  line-height: 1.5;
}

.comment-reply-link {
  margin-top: 8px;
  font-size: 16px;
  font-weight: bold;
  text-transform: uppercase;
  color: #4267b2;
  text-decoration: none;
  cursor: pointer;
}

.comment-reply-link:hover {
  text-decoration: underline;
}

</style>
