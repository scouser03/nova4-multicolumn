<template>
    <div>
        <select
            :name="subField.name"
            :disabled="readonly"
            class="w-full form-control form-select form-select-bordered"
            :value="value"
            v-bind="subField.attributes"
            @change="$emit('input', $event.target.value)"
        >
            <option value="" v-text="placeholder" selected disabled></option>
            <option
                v-for="(label, name) in subField.options"
                :value="name"
                :selected="name == value"
                v-text="label"
            ></option>
        </select>
    </div>
</template>

<script>
export default {
    props: ["subField", "value", "readonly"],

    computed: {
        placeholder() {
            return this.subField.placeholder === this.subField.label
                ? this.__("Choose an option")
                : this.subField.placeholder;
        },
    },
};
</script>
