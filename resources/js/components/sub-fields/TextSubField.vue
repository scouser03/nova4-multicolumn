<template>
    <div>
        <input
            :name="subField.name"
            type="text"
            class="w-full form-control form-input form-input-bordered"
            v-model="value"
            v-bind="subField.attributes"
            :placeholder="subField.placeholder"
            @input="$emit('input', $event.target.value)"
        />
    </div>
</template>

<script>
export default {
    props: ["subField", "value"],
};
</script>
