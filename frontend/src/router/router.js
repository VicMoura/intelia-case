import Vue from "vue";
import Router from "vue-router";
import UserLogin from "@/views/user/UserLogin.vue"; 
import UserRegister from "@/views/user/UserRegister.vue";

Vue.use(Router);

export default new Router({
  mode: "history", 
  routes: [
    {
      path: "/",
      redirect: "/login"
    },
    {
      path: "/login",
      name: "Login",
      component: UserLogin
    },
    {
      path: "/register",
      name: "UserRegister",
      component: UserRegister
    }
  ]
});
