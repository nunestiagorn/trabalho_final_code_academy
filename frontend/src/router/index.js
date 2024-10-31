import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import NotFoundError from "@/views/NotFoundError.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "Home",
      component: HomeView,
    },
    {
      path: "/about",
      name: "about",
      component: () => import("../views/ComplementViews/AboutView.vue"),
    },
    {
      path: "/login",
      name: "login",
      component: () => import("../views/UserAuth/UserLoginView.vue"),
    },
    {
      path: "/register",
      name: "register",
      component: () => import("../views/UserAuth/UserRegisterView.vue"),
    },
    {
      path: "/recruiter-login",
      name: "recruiter-login",
      component: () => import("../views/RecruiterAuth/RecruiterLoginView.vue"),
    },
    {
      path: "/recruiter-register",
      name: "recruiter-register",
      component: () => import("../views/RecruiterAuth/RecruiterRegisterView.vue"),
    },
    {
      path: "/:id/mainpage",
      name: "mainpage",
      component: () => import("../views/MainPages/UserMainPageView.vue"),
    },
    // relizar redirecionamento para erro caso o usuário acesse um mainPage com o id que não lhe pertence
    {
      path: "/:catchAll(.*)",
      name: "NotFound",
      component: NotFoundError,
    },
  ],
});

export default router;
