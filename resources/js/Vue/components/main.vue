<template>
    <btn-app></btn-app>
    <div class="animals_container">
        <div class="animals_body">
            <animal-item v-for="(obj) in getListKinds()"
                :key="obj[0]"
                :kind="obj[0]"
            >
            </animal-item>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
import btnApp from './btn-app.vue'
import animalItem from './animal.vue'
export default {
    components:{
        btnApp,
        animalItem
    },
    methods: {
        //...mapGetters(["listActiveAnimals,getListKinds"]),
        ...mapGetters(["getListKinds"]),
    },
    computed: {
        stylesBtn(){
            let res = {
                'opacity': 1
            }
            if(this.$store.getters.isBlockRequestListKind) {
                res = {
                    'opacity': 0.2,
                    'cursor' : "wait"
                }
            }
            return res;
        }
    }
}
</script>
