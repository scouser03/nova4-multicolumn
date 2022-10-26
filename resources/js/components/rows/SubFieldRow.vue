<template>
    <div class="row" :class="formLayout">
        <div class="row-inputs flex-wrap" :class="formLayout">
            <h3 v-if="field.heading && field.display_stacked" class="mb-2">
                {{ field.heading + " #" + (index + 1) }}
            </h3>
            <component
                v-for="(subField, index) in field.sub_fields"
                :is="`${subField.type}-sub-field`"
                :key="index"
                :sub-field="subField"
                class="row-input"
                :value="modelValue[subField.name]"
                @input="set(subField.name, $event)"
                :class="getInputLayout(subField)"
            ></component>
            <button class="row-d" type="button" @click="deleteRow">
                <Icon type="trash" />
            </button>
        </div>
    </div>
</template>

<script>
import TextSubField from "../sub-fields/TextSubField.vue";
import EmailSubField from "../sub-fields/EmailSubField.vue";
import NumberSubField from "../sub-fields/NumberSubField.vue";
import SelectSubField from "../sub-fields/SelectSubField.vue";
import TextareaSubField from "../sub-fields/TextareaSubField.vue";

export default {
    components: {
        TextSubField,
        EmailSubField,
        NumberSubField,
        SelectSubField,
        TextareaSubField,
    },

    props: ["modelValue", "field", "index"],

    computed: {
        formLayout() {
            return this.field.display_stacked ? "-vertical" : "-horizontal";
        },
    },

    methods: {
        set(name, e) {
            if (e.target == undefined) {
                return;
            }
            this.modelValue[name] = e.target.value;
        },
        deleteRow() {
            this.$emit("delete-row", this.index);
        },
        getInputLayout(subField) {
            let width = subField.width ? subField.width : "flex-1";

            if (this.field.display_stacked) {
                return this.formLayout;
            }
            return `${this.formLayout} ${width} mb-2`;
        },
    },
};
</script>
