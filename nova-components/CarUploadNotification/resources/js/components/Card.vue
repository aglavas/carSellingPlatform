<template>
    <card class="flex flex-col flexible-height">
        <div class="px-6 py-4">
            <h1 class="text-3xl text-80 font-light pb-4">Vehicle updates</h1>
            <div>
                <ul>
                    <li v-for="notification in this.card.carUploadNotification">
                        <b>{{notification.type}}</b> {{notification.label}}
                        <router-link
                            :to="{
                                name: 'index',
                                params: {
                                    resourceName: notification.uriKey
                                }
                            }" class="text-black text-justify no-underline dim">
                            <b>Show vehicles</b>
                        </router-link>
                    </li>
                </ul>
            </div>
        </div>
    </card>
</template>

<script>
//import Nova from './Nova'
export default {
    props: [
        'card',

        // The following props are only available on resource detail cards...
        // 'resource',
        // 'resourceId',
        // 'resourceName',
    ],

    mounted() {
        Nova.$emit('test-event')
    },
}
</script>
