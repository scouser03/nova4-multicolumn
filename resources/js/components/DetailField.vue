<template>
    <div
        class="flex flex-col md:flex-row -mx-6 px-6 py-2 md:py-0 space-y-2 md:space-y-0"
    >
        <div class="md:w-1/4 md:py-3">
            <slot>
                <h4 class="font-bold md:font-normal">{{ field.name }}</h4>
            </slot>
        </div>
        <div class="w-3/4 py-4 break-words">
            <slot name="value">
                <p class="mb-4"><strong v-text="summaryText"></strong></p>
                <ul v-show="detailVisible" class="list-reset">
                    <li v-for="row in rows">
                        <ul class="list-reset mb-4">
                            <li
                                class="flex items-top mb-1"
                                v-for="subRow in row"
                            >
                                <span class="block w-1/6 mr-2"
                                    >{{ subRow.label }}:</span
                                >
                                <span class="block"
                                    ><strong>{{ subRow.value }}</strong></span
                                >
                            </li>
                        </ul>
                    </li>
                </ul>
                <a
                    @click.prevent="toggleDetail"
                    aria-role="button"
                    class="cursor-pointer dim inline-block text-primary font-bold"
                    v-text="toggleText"
                ></a>
            </slot>
        </div>
    </div>
</template>
<script>
import RepeaterDisplay from "../mixins/RepeaterDisplay";
export default {
    mixins: [RepeaterDisplay],
    props: ["resource", "resourceName", "resourceId", "field"],
};
</script>
