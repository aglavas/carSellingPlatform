<template>
    <card class="flex flex-col flexible-height">
        <div class="px-6 py-4">
            <h1 class="text-3xl text-80 font-light pb-4">Announcements</h1>
            <div v-for="announcement in this.card.latestAnnouncements">
                <hr class="border-b-2 border-40"/>

                <h2 class="font-semibold relative">{{ announcement.title }} <small class="text-sm text-70 absolute pin-r">{{ formatDate(announcement.created_at) }}</small></h2>
                <div class="py-4" v-html="announcement.content"></div>

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
    methods: {
      formatDate: function (date) {
        return moment(date).format('YYYY-MM-DD');
      }
    },

    mounted () {},
  }
</script>
