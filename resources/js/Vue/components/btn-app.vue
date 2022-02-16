<template>
    <div class="buttons_container">
        <div class="buttons_body" :style="stylesBtn" >
            <btn-plus></btn-plus>
            <div class="button_animals_bg" v-if="isButtonBgVisible">
                <div class="button_animals_wraper">
                    <!-- obj элемент массива где [0] ключ в map; [1] значение -->
                    <btn-animal  v-for="(obj) in getListKinds()" :key="obj[0]" :kind="obj[0]"></btn-animal>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import btnPlus from './btn-plus.vue';
import btnAnimal from './btn-animal.vue';
import { mapGetters } from 'vuex';

export default {
    components:{
        btnPlus, btnAnimal
    },
    data(){
        return {

        }
    },
    methods: {
        ...mapGetters(["getListKinds"]),
    },
    computed: {
        isButtonBgVisible(){
            return this.$store.getters.isListKindsNotNull;
        },
        stylesBtn(){
            let res = {
                'opacity': 1
            }
            if(this.$store.getters.isBlockButtons) {
                res = {
                    'opacity': 0.2,
                    'cursor' : "wait"
                }
            }
            return res;
        },
    }

}
</script>
