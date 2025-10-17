<template>
    <page-home
        slug="dashboard"
        @initialize="initialize"
    >
        <template v-slot:default="{ theme }">
            {{ theme }}
        </template>
    </page-home>
</template>

<script>
export default {
    name: "training-dashboard",
    
    methods: {
        initialize(response) {
            console.log(response);
        }
    }
}
</script>