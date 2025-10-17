const route = {
    path: "/training",
    meta: { requiredAuth: true },
    component: () =>
        import(
            /* webpackChunkName: "training" */ "@modules/module-training/frontend/pages/Base.vue"
        ),
    children: [
        {
            path: "",
            redirect: { name: "training-dashboard" },
        },

        {
            path: "dashboard",
            name: "training-dashboard",
            component: () =>
                import(
                    /* webpackChunkName: "training" */ "@modules/module-training/frontend/pages/dashboard/index.vue"
                ),
        },
    ],
};

export default route;
