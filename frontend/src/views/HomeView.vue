<template>
    <v-container>
        <h1 class="text-h2 text-center my-5">Welcome to Progi services</h1>
        <v-row justify="center" class="my-10 py-10">
            <v-col cols="12" md="8">
                <router-link to="/calculate-vehicle-cost" class="text-decoration-none">
                    <v-card class="pa-5" outlined>
                        <v-card-text class="text-center text-h4">
                            Vehicle cost simulator Service
                        </v-card-text>
                    </v-card>
                </router-link>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    name: "HomeView",
};
</script>
