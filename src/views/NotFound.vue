<template>
    <div class="d-flex align-items-center justify-content-center h-75">
        <div class="text-center">
            <h1 class="display-1 fw-bold">404</h1>
            <p class="fs-3"> <span class="text-danger">Oops!</span> Page not found.</p>
            <p class="lead">
                The page you’re looking for doesn't exist.
            </p>
            <router-link class="btn btn-primary" to="/">Go back </router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: "NotFound"
}
</script>

<style scoped>

</style>