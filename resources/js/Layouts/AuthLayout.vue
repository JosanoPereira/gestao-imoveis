<script>

export default {
    name: "AuthLayout"
}
</script>

<template>
    <div class="bg-body-tertiary min-vh-100 d-flex flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card-group d-block d-md-flex row">
                        <slot/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
