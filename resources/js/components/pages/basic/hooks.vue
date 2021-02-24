<template>
    <div>
        <h1 ref="myRef">Hooks tutorial</h1>
        <h3>My name is : {{ name }}</h3>
    </div>
</template>

<script>
export default {
    data() {
        return {
            name: 'Maxwell'
        }
    },
    beforeCreate() {
        console.log("Before the vue is excecuted: "+this.name);
    },
    created() {
        console.log("Data and other function is available but not HTML: "+this.name);
    },
    mounted() {
        console.log("You can access all of the content iincluding HTML and variables: "+this.$refs.myRef);
    }
}
</script>

<style>

</style>