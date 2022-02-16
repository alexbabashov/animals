<template>
    <div class="animal_wrap">
        <div class="animal_item" :style="stylesImg">
        </div>
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
    data(){
        return {
            kindSettings: '',
            timer: null,
            name: '',
            width: 0,
        }
    },
    methods: {
        startTimer() {
            if (this.timer == null) {
                if (this.$store.getters.isPossiblyIncreaseAge(this.name)) {
                    this.timer = setInterval(
                        () => {
                            if ( this.$store.getters.isPossiblyIncreaseAge(this.name) )
                            {
                                this.$store.dispatch('increaseAgeAnimal',this.name);
                            } else {
                                this.stopTimer();
                            }
                        },
                        1000
                        );
                } else {
                    this.stopTimer();
                }
            }
        },
        stopTimer() {
            clearInterval(this.timer);
            this.timer =  null;
        },
    },
    computed: {
        stylesImg(){
            this.width = this.$store.getters.getWidthAnimalByName(this.name);
            return {
                        'background-image': "url('" + this.kindSettings.avatar + "')",
                        'width': this.width + '%',
                    }
        },
    },
    watch: {
        width(newValue, oldValur){
            if (newValue != oldValur) {
                this.startTimer();
            } else {
                this.stopTimer();
            }
        }
    },
    created: function() {
        this.name = this.$store.getters.getNameByKind(this.kind);
        this.kindSettings = this.$store.getters.getKind(this.kind);
    },
    beforeUnmount() {
        this.stopTimer()
    },
}
</script>
