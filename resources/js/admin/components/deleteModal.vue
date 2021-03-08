<template>
    <div>
        <!-- DELETE ALERT MODAL -->
        <Modal 
            :value="getDeleteModalObj.showDeleteModal"
            :mask-closable="false"
            :closable="false">
            <p slot="header" style="color: #f60; text-align: center;">
                <Icon type="ios-information-circle"></Icon>
                <span>Delete Confirmation</span>
            </p>
            <div style="text-align:center;">
                <p>Are you sure you want to delete tag?</p>
            </div>
            <div slot="footer">
                <Button type="default" size="large" @click="closeModal">Close</Button>
                <Button type="error" size="large" @click="deleteTag" :disabled="isDeleting" :loading="isDeleting">Delete</Button>
            </div>
        </Modal>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
export default {
    data() {
        return {
            isDeleting: false,
        }
    },
    methods: {
        async deleteTag() {
            this.isDeleting = true
            const res = await this.callApi('post', this.getDeleteModalObj.deleteUrl, this.getDeleteModalObj.data)
            if(res.status === 200) { 
                this.s('Tag has been deleted successfully')
                this.$store.commit('setDeleteModal', true)
            } else {
                this.swr()
                this.$store.commit('setDeleteModal', false)
            }
            this.isDeleting = false
        },
        closeModal() {
            this.$store.commit('setDeleteModal', false)
        }
    },
    computed: {
        ...mapGetters(['getDeleteModalObj'])
    },
}
</script>

<style>

</style>