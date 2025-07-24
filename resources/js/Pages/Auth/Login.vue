<script setup>
import { useForm, Head, usePage } from '@inertiajs/vue3'

const page = usePage();

const form = useForm({
    email: null,
    password: null,
    remember: false,
})

function submit(){
    form.post('/login', {
        onError: () => form.reset(),
    })
}
</script>

<template>
    <Head title="Login" />
    <v-container fluid class="d-flex justify-center align-center fill-height">
        <v-card class="pa-10" :elevation="8" max-width="450" width="100%" rounded="2xl">

        <!-- Logo added here -->
        <!-- <div class="mb-4">
            <v-img
                src="images/inmed-logo.png"
                alt="Logo"
                max-width="150"
                contain
                class="mx-auto"
            />
        </div> -->

        <v-card-subtitle class="text-h6 text-medium-emphasis text-center mb-2">Tele-Order</v-card-subtitle>

        <v-alert
          v-if="$page.props.flash.message"
          density="compact"
          type="error"
          class="mb-4"
          variant="outlined"
        >{{ $page.props.flash.message }}</v-alert>

        <v-form @submit.prevent="submit">
            <v-text-field
                v-model="form.email"
                :error-messages="form.errors.email"
                label="Email"
                prepend-inner-icon="mdi-email"
                variant="outlined"
                density="comfortable"
                class="mb-2"
            />

            <v-text-field
                v-model="form.password"
                :error-messages="form.errors.password"
                label="Password"
                prepend-inner-icon="mdi-lock"
                variant="outlined"
                type="password"
                density="comfortable"
            />

            <v-checkbox
                label="Remember me"
                color="amber-darken-4"
            ></v-checkbox>

            <v-btn
                type="submit"
                color="orange"
                block
                size="large"
                rounded="xl"
                :loading="form.processing"
            >
                Sign In
            </v-btn>
        </v-form>
    </v-card>
</v-container>
</template>
<style>
.fill-height {
    min-height: 100vh;
}

/* Card custom width (optional, already using max-width) */
.v-card {
    backdrop-filter: blur(10px); /* optional: glass effect */
    background-color: rgba(255, 255, 255, 0.85); /* slight transparency */
}

.v-card-foreground {
    transition: opacity 0.4s ease-in-out;
}

.v-card-foreground:not(.on-hover) {
    opacity: 0.6;
}

.show-btns {
    color: rgba(255, 255, 255, 1) !important;
}
</style>