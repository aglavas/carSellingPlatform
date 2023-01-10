<template>
    <card class="flex flex-col flexible-height">
        <div class="px-6 py-4">
            <h1 class="text-3xl text-80 font-light pb-4">Instructions</h1>
            <div v-html="this.card.instruction.content">

            </div>
        </div>
    </card>
</template>

<script>
export default {
    props: [
        'card',

        // The following props are only available on resource detail cards...
        // 'resource',
        // 'resourceId',
        // 'resourceName',
    ],

    mounted() {
        //
    },
}
</script>
