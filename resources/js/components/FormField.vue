<template>
    <DefaultField
        :field="field"
        :errors="errors"
        :show-help-text="showHelpText"
        :full-width-content="fullWidthContent"
    >
        <template #field>
            <div>
                <sub-field-row
                    v-for="(row, index) in rows"
                    v-model="rows[index]"
                    :key="index"
                    :index="index"
                    :field="field"
                    @delete-row="deleteRow"
                ></sub-field-row>
            </div>

            <button
                class="shadow relative bg-primary-500 hover:bg-primary-400 text-white dark:text-gray-900 cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 inline-flex items-center justify-center h-9 px-3 shadow relative bg-primary-500 hover:bg-primary-400 text-white dark:text-gray-900"
                @click.prevent="addNewRow"
                v-text="addButtonText"
                :class="{
                    'cursor-not-allowed opacity-50': hasReachedMaximumRows,
                }"
            ></button>

            <p v-if="hasError" class="my-2 text-danger">
                {{ firstError }}
            </p>
        </template>
    </DefaultField>
</template>

<script>
import { FormField, HandlesValidationErrors } from "laravel-nova";
import SubFieldRow from "./rows/SubFieldRow.vue";
// import draggable from "vuedraggable";

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ["resourceName", "resourceId", "field"],

    components: {
        // draggable,
        SubFieldRow,
    },

    data: () => ({
        value: "",
        rows: [],
    }),

    computed: {
        addButtonText() {
            return this.field.add_button_text
                ? this.field.add_button_text
                : "Add row";
        },

        hasReachedMaximumRows() {
            if (this.field.maximum_rows) {
                return this.rows.length >= this.field.maximum_rows;
            }

            return false;
        },
        shouldAddInitialRows() {
            return (
                this.field.initial_rows &&
                this.field.initial_rows > this.rows.length
            );
        },
    },

    methods: {
        setInitialValue() {
            this.value = this.field.value || "";
            this.$nextTick(() => {
                this.rows = this.value ? JSON.parse(this.value) : [];

                if (this.shouldAddInitialRows) {
                    let count = this.field.initial_rows - this.rows.length;
                    for (let i = 1; i <= count; i++) {
                        this.addNewRow();
                    }
                }
            });
        },

        fill(formData) {
            formData.append(this.field.attribute, this.value || "");
        },

        addNewRow() {
            if (!this.hasReachedMaximumRows) {
                let newRow = this.field.sub_fields
                    .map((subField) => subField.name)
                    .reduce((o, key) => ({ ...o, [key]: null }), {});

                this.rows.push(newRow);
            }
        },

        deleteRow(index) {
            this.rows.splice(index, 1);
        },
    },

    watch: {
        rows: {
            handler: function (newRows) {
                this.value = JSON.stringify(newRows);
            },
            deep: true,
        },
    },
};
</script>
