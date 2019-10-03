<template>
    <div>
        <div class="add-to-compare" @click="addToCompareItems"><i class="fas fa-plus"></i> Compare</div>
    </div>
</template>

<script>
export default {
    name: "add-to-compare",
    props: {
        p_product: {}
    },

    data() {
        return {
            item: this.p_product
        }
    },

    methods: {
        addToCompareItems() {
            if(this.$store.state.compareItems.length < 10) {
                $('#list').modal('show');
                this.$store.commit('addToCompareItems', this.item);
            }
        }
    }
}
</script>

<style lang="scss">
    .add-to-compare {
    background: rgba(0, 0, 0, 0.8);
    color: #fff;
    border-radius: 5px;
        padding: 7px 15px;
        font-size: 0.9rem;
        width: 40%;
        line-height: 2rem;
        cursor: pointer;
    }
</style>