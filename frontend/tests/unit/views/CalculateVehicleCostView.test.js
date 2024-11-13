import { mount } from "@vue/test-utils";
import CalculateVehicleCostView from "@/views/CalculateVehicleCostView.vue";
import FormComponent from "@/components/FormComponent.vue";
import ResultComponent from "@/components/ResultComponent.vue";
import { router, vuetify } from "../shared/test-plugin";

describe("CalculateVehicleCostView", () => {
    const ResultComponentStub = {
        template: "<div></div>",
        props: ["result"],
    };
    const FormComponentStub = {
        template: "<div></div>",
        mounted() {
            this.$emit("on-api-res", "test data");
        },
    };
    let wrapper = mount(CalculateVehicleCostView, {
        global: {
            plugins: [router, vuetify],
            stubs: {
                FormComponent: FormComponentStub,
                ResultComponent: ResultComponentStub,
            },
        },
    });

    it("has a back link to the home page", async () => {
        const backLink = wrapper.find('a[href="/"]');
        expect(backLink.exists()).toBe(true);

        await router.push(backLink.attributes("href"));
        await router.isReady();

        expect(router.currentRoute.value.path).toBe("/");
    });

    it("updates the result prop when the form component emits on-api-res", async () => {
        await wrapper
            .findComponent(FormComponent)
            .vm.$emit("on-api-res", "test data");

        expect(wrapper.vm.apiResult).toBe("test data");

        const resultComponent = wrapper.findComponent(ResultComponent);
        expect(resultComponent.props("result")).toBe("test data");
    });
});
