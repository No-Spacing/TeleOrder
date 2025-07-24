<template>
  <div>
    <!-- <v-img
      class="mx-auto my-6"
      max-width="228"
      src="https://cdn.vuetifyjs.com/docs/images/logos/vuetify-logo-v3-slim-text-light.svg"
    ></v-img> -->

    <v-card
      class="mx-auto pa-12 pb-8"
      elevation="8"
      max-width="448"
      rounded="lg"
    >
        <div class="text-subtitle-1 text-medium-emphasis">Account</div>
        <v-text-field
        density="compact"
        placeholder="Email address"
        prepend-inner-icon="mdi-email-outline"
        variant="outlined"
        ></v-text-field>

        <div class="text-subtitle-1 text-medium-emphasis">Password</div>
        <v-text-field
            type="password"
            density="compact"
            placeholder="Enter your password"
            prepend-inner-icon="mdi-lock-outline"
            variant="outlined"
        ></v-text-field>

        <v-btn
            class="mb-8"
            color="orange"
            size="large"
            variant="tonal"
            block
        >
            Log In
        </v-btn>
    </v-card>
  </div>
</template>