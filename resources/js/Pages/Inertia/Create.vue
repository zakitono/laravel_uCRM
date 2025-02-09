<script setup>
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'
defineProps({ errors: Object })

const form = reactive({
    title: null,
    content: null
})
const submitFunction = () =>{
    Inertia.post('/inertia', form)
}

</script>

<template>
    <div class="m-2">
        <BreezeValidationErrors :errors="errors" />
        <form @submit.prevent="submitFunction">
            <input type="text" name="title" v-model="form.title"><br>
            <input type="text" name="content" v-model="form.content">
            <button>送信</button>
        </form>
    </div>

</template>
