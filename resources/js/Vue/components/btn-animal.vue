<template>
    <div class="button_animal_item" :style="stylesDisable">
        <div class="button_animal_img" :style="stylesImg" @click="createAnimal"></div>
    </div>
</template>

<script>
export default {
    props: {
        kind: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            stylesImg: "",
        }
    },
    methods: {
       createAnimal() {
           this.$store.dispatch('createAnimal',this.kind);
       }
    },
    computed: {
        stylesDisable(){
            let res = {
                'opacity': 1
            }
            if(this.$store.getters.isKindCreated(this.kind)){
                res = {
                    'opacity': 0.2,
                    'cursor' : "wait"
                }
            }
            return res;
        }
    },
    created: function() {
        this.disable = false;
        this.stylesImg = { 'background-image': "url('" + this.$store.getters.urlAvatarOfKind(this.kind) + "')" };
    },
    updated: function() {
    }
}
</script>
