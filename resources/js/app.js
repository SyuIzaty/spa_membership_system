// The order of imported files are important!
import "primevue/resources/themes/saga-blue/theme.css";
import "primevue/resources/primevue.min.css";
import "primeicons/primeicons.css";
import PrimeVue from "primevue/config";
import Vue from "vue";
import { routes } from "./routes";
import VueRouter from "vue-router";
import { ValidationProvider, ValidationObserver } from "vee-validate";
import ConfirmationService from "primevue/confirmationservice";
import ToastService from "primevue/toastservice";
import Toast from "primevue/toast";

require("./bootstrap");

Vue.use(PrimeVue);
Vue.use(ToastService);
Vue.use(ConfirmationService);
Vue.component("ValidationProvider", ValidationProvider);
Vue.component("ValidationObserver", ValidationObserver);
Vue.component("Toast", Toast);

Vue.use(VueRouter);

const router = new VueRouter({
    routes, // short for `routes: routes`
    mode: "history",
});

Vue.config.productionTip = false;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component(
    "example-component",
    require("./components/ExampleComponent.vue").default
);

const app = new Vue({
    el: "#app",
    router,
});
