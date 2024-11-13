import { mount } from "@vue/test-utils";
import FormComponent from "@/components/FormComponent.vue";
import vehicleApi from "@/apis/vehicleApi";
import { vi } from "vitest";
import { vuetify } from "../shared/test-plugin";

vi.mock("@/apis/vehicleApi", () => ({
    default: {
        cost: vi.fn(),
    },
}));

describe("FormComponent", () => {
    let wrapper;
    const mockApiResponse = {
        vehicleType: "common",
        basePrice: "1000",
        fees: {
            basicBuyerFee: 100,
            sellerSpecialFee: 20,
            associationFee: 15,
            storageFee: 100,
        },
        totalPrice: 1235,
        totalFees: 235,
    };

    beforeEach(() => {
        wrapper = mount(FormComponent, {
            global: {
                plugins: [vuetify],
            },
        });
    });

    afterEach(() => {
        vi.clearAllMocks();
    });

    it("renders correctly with default data", () => {
        const h1 = wrapper.find("h1");
        const basePriceInput = wrapper.find('input[type="number"]');
        // v-select is rendered as input[type="text"]
        const vehicleTypeSelect = wrapper.find('input[name="vehicleType"]');
        const submitButton = wrapper.find('button[type="submit"]');
        const basePriceErrors = wrapper.find("#basePrice-messages");

        expect(h1.text()).toBe("Vehicle Cost Simulator");
        expect(basePriceInput.exists()).toBe(true);
        expect(vehicleTypeSelect.exists()).toBe(true);
        expect(submitButton.exists()).toBe(true);
        expect(basePriceErrors.exists()).toBe(true);
        expect(wrapper.vm.basePrice).toBe("398");
        expect(wrapper.vm.vehicleType).toBe("common");
        expect(wrapper.vm.apiError).toBeNull();
    });

    it("displays error for invalid base price", async () => {
        await wrapper.setData({ basePrice: -100 });
        expect(wrapper.vm.isValidForm).toBe(false);
        expect(
            wrapper.find("#submit-vehicle-data").attributes("disabled")
        ).toBeDefined();
        expect(wrapper.find("#basePrice-messages").text()).toBe(
            "Invalid price"
        );
    });

    it("enables submit button when form is valid", async () => {
        await wrapper.setData({ basePrice: 500, vehicleType: "luxury" });
        expect(wrapper.vm.isValidForm).toBe(true);
        expect(
            wrapper.find("#submit-vehicle-data").attributes("disabled")
        ).toBeUndefined();
    });

    it('calls cost on valid form submission and emits "on-api-res" event on success', async () => {
        vehicleApi.cost.mockResolvedValueOnce({
            isOk: true,
            data: mockApiResponse,
        });

        await wrapper.setData({ basePrice: "1000", vehicleType: "common" });
        expect(wrapper.vm.isValidForm).toBe(true);
        await wrapper.find("form").trigger("submit.prevent");
        expect(vehicleApi.cost).toHaveBeenCalledWith({
            basePrice: "1000",
            vehicleType: "common",
        });
        expect(wrapper.vm.apiError).toBeNull();
        expect(wrapper.emitted("on-api-res")).toBeTruthy();
        expect(wrapper.emitted("on-api-res")[0]).toEqual([mockApiResponse]);
    });

    it("displays error alert on API call failure", async () => {
        const mockApiError = { isOk: false, error: "Network Error" };
        vehicleApi.cost.mockResolvedValueOnce(mockApiError);

        await wrapper.setData({ basePrice: "800", vehicleType: "luxury" });
        await wrapper.vm.submitForm();

        expect(vehicleApi.cost).toHaveBeenCalled();
        expect(wrapper.vm.apiError).toBe("Network Error");
        await wrapper.vm.$nextTick();
        expect(wrapper.find(".v-alert").text()).toBe("Network Error");
    });

    it("calls cost on basePrice or vehicleType change if form is valid", async () => {
        vehicleApi.cost.mockResolvedValue({
            isOk: true,
            data: mockApiResponse,
        });

        await wrapper.setData({ basePrice: "500", vehicleType: "luxury" });
        // trigger submitForm for the first time
        await wrapper.vm.submitForm();
        expect(vehicleApi.cost).toHaveBeenCalledWith({
            basePrice: "500",
            vehicleType: "luxury",
        });
        // changing basePrice should call cost again
        await wrapper.setData({ basePrice: "600" });

        expect(vehicleApi.cost).toHaveBeenCalledWith({
            basePrice: "600",
            vehicleType: "luxury",
        });
        // changing vehicleType should call cost again
        await wrapper.setData({ vehicleType: "common" });
        expect(vehicleApi.cost).toHaveBeenCalledWith({
            basePrice: "600",
            vehicleType: "common",
        });
    });
});
