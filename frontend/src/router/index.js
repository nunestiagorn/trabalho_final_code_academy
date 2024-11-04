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
      path: "/company-login",
      name: "company-login",
      component: () => import("../views/CompanyAuth/CompanyLoginView.vue"),
    },
    {
      path: "/company-register",
      name: "company-register",
      component: () =>
        import("../views/CompanyAuth/CompanyRegisterView.vue"),
    },
    {
      path: "/:id/mainpage",
      name: "mainpage",
      component: () => import("../views/MainPages/UserMainPageView.vue"),
      beforeEnter: (to, from, next) => {
        const loggedUserId = localStorage.getItem("userId");

        if (!loggedUserId) {
          next({ name: "login" });
        } else if (to.params.id !== loggedUserId) {
          next({ name: "mainpage", params: { id: loggedUserId } });
        } else {
          next();
        }
      },
    },
    {
      path: "/:id/company-mainpage",
      name: "company-mainpage",
      component: () => import("../views/MainPages/CompanyMainPageView.vue"),
      beforeEnter: (to, from, next) => {
        const loggedCompanyId = localStorage.getItem("companyId");

        if (!loggedCompanyId) {
          next({ name: "company-login" });
        } else if (to.params.id !== loggedCompanyId) {
          next({ name: "company-mainpage", params: { id: loggedCompanyId } });
        } else {
          next();
        }
      },
    },
    {
      path: "/:catchAll(.*)",
      name: "NotFound",
      component: NotFoundError,
    },
  ],
});

export default router;
