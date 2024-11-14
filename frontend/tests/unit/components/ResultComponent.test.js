import { mount } from "@vue/test-utils";
import { vuetify } from "../shared/test-plugin";
import ResultComponent from "@/components/ResultComponent.vue";

describe("ResultComponent", () => {
    // Mocking the InfoRow component for avoiding any side effects
    const infoRowStub = {
        template: "<div>{{ label }}: {{ info }}</div>",
        props: ["label", "info"],
    };
    const typicalResult = {
        basePrice: 10000,
        vehicleType: "Luxury",
        fees: {
            basicBuyerFee: 500,
            sellerSpecialFee: 300,
            associationFee: 100,
            storageFee: 200,
        },
        totalFees: 1100,
        totalPrice: 11100,
    };
    const wrapper = mount(ResultComponent, {
        global: {
            stubs: {
                InfoRow: infoRowStub,
            },
            plugins: [vuetify],
        },
    });

    it.only("renders correctly when result prop is provided", async () => {
        await wrapper.setProps({ result: typicalResult });
        // Vehicle Data check
        expect(wrapper.text()).toContain("Vehicle Base Price: 10 000.00 $");
        expect(wrapper.text()).toContain("Vehicle Type: Luxury");
        // Fees check
        expect(wrapper.text()).toContain("Basic Buyer Fee: 500.00 $");
        expect(wrapper.text()).toContain("Seller Special Fee: 300.00 $");
        expect(wrapper.text()).toContain("Association Fee: 100.00 $");
        expect(wrapper.text()).toContain("Storage Fee: 200.00 $");
        // Costs details check
        expect(wrapper.text()).toContain("Total Fees cost: 1 100.00 $");
        expect(wrapper.text()).toContain(
            "Total Vehicle cost with fees: 11 100.00 $"
        );
    });

    it.only("does not render anything if result is undefined or basePrice is missing", async () => {
        await wrapper.setProps({ result: undefined });
        expect(wrapper.text()).toBe("");

        await wrapper.setProps({
            result: { ...typicalResult, basePrice: undefined },
        });
        expect(wrapper.text()).toBe("");
    });

    it.only("displays '--' when a fee is missing", async () => {
        const result = {
            ...typicalResult,
            totalFees: undefined,
        };
        await wrapper.setProps({ result });
        expect(wrapper.text()).toContain("Total Fees cost: -- $");
    });

    it.only("computes isResultValid correctly based on result prop", async () => {
        const resultValid = { basePrice: 10000 };
        const resultInvalid = { vehicleType: "Luxury" }; // Missing basePrice
        await wrapper.setProps({ result: resultValid });
        expect(wrapper.vm.isResultValid).toBe(true);
        await wrapper.setProps({ result: resultInvalid });
        expect(wrapper.vm.isResultValid).toBe(false);
    });
});
