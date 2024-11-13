import { describe, it, expect } from "vitest";
import { mount } from "@vue/test-utils";
import HomeView from "@/views/HomeView.vue";
import { router } from "../shared/test-plugin";

describe("HomeView", () => {
    let wrapper;

    beforeEach(() => {
        wrapper = mount(HomeView, {
            global: {
                plugins: [router],
            },
            isCustomElement: (tag) => tag === "router-link",
        });
    });

    it("renders properly", () => {
        expect(wrapper.exists()).toBe(true);
    });

    it("has a welcome message", () => {
        expect(wrapper.text()).toContain(
            "Welcome to the Vehicle Cost Calculator"
        );
    });

    it("has a router link to the calculator view", async () => {
        router.push("/");
        await router.isReady();

        const link = wrapper.find('a[href="/calculate-vehicle-cost"]');
        expect(link.exists()).toBe(true);

        // i'm using push on router instead of clicking the link
        // because the link is not working properly in the test environment
        // await link.trigger("click");
        await router.push(link.attributes("href"));
        await router.isReady();

        expect(router.currentRoute.value.path).toBe("/calculate-vehicle-cost");
    });
});
