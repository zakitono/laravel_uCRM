<script setup>
    import { Link } from '@inertiajs/vue3';
    import { router } from "@inertiajs/vue3";
    import { ref } from 'vue';

    const newTitle = ref('')
    const newContent = ref('')

    const saveToDB = () => {
        console.log("送信データ:", newTitle.value, newContent.value); // デバッグ
        router.post(route("inertia.store"), {
            title: newTitle.value,
            content: newContent.value
        });
    }
</script>




<template>
    Inertiaテストです。<br>
    <a href="/">aタグ経由です。</a><br>
    <Link href="/">Link経由です。</Link>
    <Link :href="route('inertia.index')">名前付きルートの確認！</Link><br>
    <Link :href="route('inertia.show', {id: 11})">ルートパラメータのテスト</Link>

    <div class="mb-8">
        <input type="text" name="newTitle" v-model="newTitle">{{newTitle}}<br>
        <input type="text" name="newContent" v-model="newContent">{{newContent}}<br>
        <button @click="saveToDB">DB保存</button>
    </div>
</template>


