<template>
    <div id="app">
        <b-navbar class="header flex-md-row" fixed="top" toggleable="lg" type="dark" variant="info">
            <b-navbar-brand href="/">Home</b-navbar-brand>
        </b-navbar>
        <br/>
        <br/>
        <br/>
        <div class="container-fluid">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'App',
        data() {
            return {
                activeIndex: '1',
            };
        },
    }
</script>
<style>
    @import '~bootstrap-vue/dist/bootstrap-vue.css';
    @import '~bootstrap/dist/css/bootstrap.css';
</style>
