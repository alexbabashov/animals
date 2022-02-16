import {createApp} from 'vue'
import {store} from './store/vueStore.js'

import main from './components/main.vue'

class AppVueCore {

    instance = null;

    init() {
        this.instance = createApp(main);
        this.instance.use(store);
        this.instance.mount('#vueapp')
    }

    constructor() {
        this.init();
    }
}

new AppVueCore();
