<template>
    <div class="body-bg">
        <!--<h1>Vue Router Demo App</h1>-->

        <!--<p>-->
            <!--<router-link :to="{ name: 'hello' }">Home</router-link> |-->
            <!--<router-link :to="{ name: 'hello2' }">Hello World</router-link>-->
        <!--</p>-->


            <router-view></router-view>

    </div>
</template>
<script>
    export default {}
</script>
<style scoped>
    .body-bg {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        overflow-y: auto;
        /*background-color: #1ab4ff;*/
        /*渐变*/
        background-image: linear-gradient(to right , #2f77e3, #6baee6);
    }
</style>