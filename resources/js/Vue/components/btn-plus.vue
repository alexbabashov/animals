<template>
    <div class="button_plus noselect" @click="clickBtn">+</div>
</template>

<script>
//import { mapActions } from 'vuex';
export default {
    name: "plusButton",
    methods: {
        //...mapActions(["updateListKinds"]),
        clickBtn()
        {
            this.$store.dispatch('deleteAllAnimal');
            this.$store.dispatch('updateListKinds');
        }
    },
    computed: {

    }
}

</script>
