import { mount } from "@vue/test-utils";
import InfoRow from "@/customized/data/InfoRow.vue";
import { vuetify } from "../../shared/test-plugin";

describe("InfoRow", () => {
    it("renders label and info props correctly", () => {
        const wrapper = mount(InfoRow, {
            props: {
                label: "Username",
                info: "john_doe",
            },
            global: {
                plugins: [vuetify],
            },
        });

        expect(wrapper.text()).toContain("Username:");
        expect(wrapper.text()).toContain("john_doe");
    });

    it("applies default props correctly", () => {
        const wrapper = mount(InfoRow, {
            props: {
                label: "Username",
                info: "john_doe",
            },
            global: {
                plugins: [vuetify],
            },
        });
        const cols = wrapper.findAll(".v-col");
        expect(cols.length).toBe(2);
        const labelCol = cols.at(0);
        expect(labelCol.classes()).toContain("text-right");
        expect(labelCol.classes()).toContain("font-weight-bold");
        expect(labelCol.classes()).toContain("text-uppercase");
        expect(labelCol.classes()).toContain("v-col-6");

        const infoCol = cols.at(1);
        expect(infoCol.classes()).toContain("text-left");
        expect(infoCol.classes()).toContain("v-col-6");
    });

    it("applies custom props correctly", () => {
        const wrapper = mount(InfoRow, {
            props: {
                label: "Email",
                info: "john@example.com",
                labelCols: "4",
                infoCols: "8",
                labelClass: "custom-label-class",
                infoClass: "custom-info-class",
            },
            global: {
                plugins: [vuetify],
            },
        });

        const cols = wrapper.findAll(".v-col");
        const labelCol = cols.at(0);
        expect(labelCol.classes()).toContain("custom-label-class");
        expect(labelCol.classes()).toContain("v-col-4");

        const infoCol = cols.at(1);
        expect(infoCol.classes()).toContain("custom-info-class");
        expect(infoCol.classes()).toContain("v-col-8");
    });
});
