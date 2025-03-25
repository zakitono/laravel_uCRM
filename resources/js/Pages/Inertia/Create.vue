<script setup>
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import {useForm} from "@inertiajs/vue3";
import { router } from '@inertiajs/vue3'

defineProps({ errors: Object })

// const form = useForm({
//     title: null,
//     content: null
// })

const form = reactive({
    title: null,
    content: null
})

// const submit = () => {
//     form.post('/inertia', {
//         preserveScroll: true,
//         onError: () => {
//             // エラー時の処理をここに追加できます
//             console.log('Validation failed')
//         },
//         onSuccess: () => {
//             // 成功時の処理をここに追加できます
//             console.log('Form submitted successfully')
//         },
//     })
// }

function submit(){
    router.post('/inertia', form)
}
</script>

<template>
    <div class="m-2">
        <form @submit.prevent="submit">
            <input type="text" name="title" v-model="form.title"><br>
            <div v-if="errors?.title">{{ errors.title}}</div>
            <input type="text" name="content" v-model="form.content"><br>
            <div v-if="errors?.content">{{ errors.content}}</div>
            <button>送信</button>
        </form>
    </div>
</template>
