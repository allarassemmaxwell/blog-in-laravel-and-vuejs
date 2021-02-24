<template>
    <div>
        <h1>The number is {{ views }}</h1>
        <button @click="updateCounter(1)">Increase</button>
        <button @click="updateCounter(-1)">Decrease</button>

        <br><br><br>
        <div v-for="(blog, i) in blogs" :key="i" v-if="blogs.length">
            <h3>{{ blog.title }}</h3>
            <p>{{ blog.post }}</p>
        </div>

        <br><br><br>
        <div>
            <h3 v-if="showItem">Show this item if "showItem" is TRUE</h3>
            <h3 v-else>Show this item if "showItem" is FALSE</h3>
        </div>
        <button @click="showItem=!showItem">Change Show Item</button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            views: 0,
            blogs: [],
            showItem: false,
        }
    },
    methods: {
        updateCounter(number) {
            this.views += number
        },
        changeShowItem() {
            this.showItem = !this.showItem
        }
    },
    created() {
        this.views = 100
        let post = [
            {title: 'This is bog title 1', 'post': 'this is the blog post 1', id: 1},
            {title: 'This is bog title 2', 'post': 'this is the blog post 2', id: 2},
            {title: 'This is bog title 3', 'post': 'this is the blog post 3', id: 3},
            {title: 'This is bog title 4', 'post': 'this is the blog post 4', id: 4}
        ]
        this.blogs = post
    }
}
</script>

<style>

</style>