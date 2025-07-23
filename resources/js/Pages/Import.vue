<script setup>
import Layout from '../Layout/Main.vue'
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    file: null
})

function submit(value){
    if(value == 'product')
    {
        form.post('/submit-import-product')
    }

    if(value == 'code')
    {
        form.post('/submit-import-code')
    }

    if(value == 'customer')
    {
        form.post('/submit-import-customer')
    }
}

</script>
<template>
    <Layout>
        <v-container>
            <form @submit.prevent>
                <v-file-input v-model="form.file" label="File input"></v-file-input>
                <v-btn type="submit" @click="submit('product')">Product</v-btn>
                <v-btn type="submit" @click="submit('code')">Code</v-btn>
                <v-btn type="submit" @click="submit('customer')">Customer</v-btn>
            </form>
        </v-container>
    </Layout>
</template>